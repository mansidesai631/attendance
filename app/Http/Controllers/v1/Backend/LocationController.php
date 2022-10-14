<?php

namespace App\Http\Controllers\v1\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Location;
use Carbon\Carbon;
use URL;
use DateTime;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LocationExport;
use App\Models\Employee;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $lat = number_format((float)$request->location_latitude, 6, '.', '');
        $long = number_format((float)$request->location_longitude, 6, '.', '');
        $location = Location::where(['latitude'=>$lat,'longitude'=>$long])->first();
        if($location){
          return response()->json(['status' => true,'message' => 'Location already added!']);
        }
        $location  = new Location();
        $location->address_type = @$request->address_type;
        $location->address = @$request->location_address;
        $location->latitude = @$request->location_latitude;
        $location->longitude = @$request->location_longitude;
        $location->location_name = @$request->location_name;
        $location->radius = @$request->location_radius;
        $location->created_by = Auth::id();
        $location->save();
        return response()->json(['status' => true,'message' => 'Successfully added!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $location = Location::find($id);
        return response()->json(['status' => true,'data'=>$location]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $lat = number_format((float)$request->edit_location_latitude, 6, '.', '');
        $long = number_format((float)$request->edit_location_longitude, 6, '.', '');
        $location = Location::where(['latitude'=>$lat,'longitude'=>$long])->where('id','!=',$request->location_id)->first();
        if($location){
          return response()->json(['status' => false,'message' => 'Location already added!']);
        }

        $location  = Location::find($request->location_id);
        $location->address_type = @$request->edit_address_type;
        $location->address = @$request->edit_location_address;
        $location->latitude = @$request->edit_location_latitude;
        $location->longitude = @$request->edit_location_longitude;
        $location->location_name = @$request->edit_location_name;
        $location->radius = @$request->edit_location_radius;
        $location->updated_by = Auth::id();
        $location->save();

        return response()->json(['status' => true,'message' => 'Successfully updated!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $delete = Location::where('id',$request->id)->delete();
        return response()->json(['status' => true,'message' => 'Successfully deleted!']);
    }

    public function getAllLocation(Request $request){
        $user = Employee::find(Auth::id());
        $data = Location::with('employee','employee.work');

        $data->whereHas('employee.work', function($q1) use ($user) {
            $q1->where('base_site_id',$user->selected_site_id);
        });

        if($request->filter_search != ""){
            $data->where(function($q) use ($request) {
                $q->orwhere('address','LIKE',"%".$request->filter_search."%");
                $q->orwhere('latitude','LIKE',"%".$request->filter_search."%");
                $q->orwhere('longitude','LIKE',"%".$request->filter_search."%");
                $q->orwhere('location_name','LIKE',"%".$request->filter_search."%");
                $q->orwhere('radius','LIKE',"%".$request->filter_search."%");

                $q->orwhereHas('employee', function($q1) use ($request) {
                    $q1->where('name','LIKE',"%".$request->filter_search."%");
                });
            });
        }



        $data->when(!isset($request->order), function ($q) {
            $q->orderBy('id', 'desc');
        });
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('added_by',function($row){
                return @$row->employee->name;
            })
            ->addColumn('action', function($row) {
                $btn = "";
                $btn .= '<button type="button" class="btn btn-link hidden-arrow btn-sm px-2 text-body"
                          data-mdb-toggle="dropdown" aria-expanded="false">
                          <mat-icon class="mat-icon material-icons" aria-hidden="true">more_vert</mat-icon>
                        </button>
                        <ul class="dropdown-menu">
                          <li>
                            <a class="dropdown-item d-flex align-items-center location_edit" data-mdb-toggle="modal" data-mdb-target="#edit-location" data-id="'.$row->id.'">
                              <mat-icon role="img" class="mat-icon material-icons" aria-hidden="true">edit</mat-icon>
                              <span class="ms-3">Edit</span>
                            </a>
                          </li>';

                $btn .='</ul>';
                return $btn;
            })
            ->orderColumn('id', function ($query, $order) {
                $query->orderBy('id', $order);
            })
            ->rawColumns(['added_by','action'])
            ->make(true);
    }

    public function locationExport(Request $request){
        try{

            $data = Location::with('employee');

            if($request->filter_search_export != ""){
                $data->where(function($q) use ($request) {
                    $q->orwhere('address','LIKE',"%".$request->filter_search_export."%");
                    $q->orwhere('latitude','LIKE',"%".$request->filter_search_export."%");
                    $q->orwhere('longitude','LIKE',"%".$request->filter_search_export."%");
                    $q->orwhere('location_name','LIKE',"%".$request->filter_search_export."%");
                    $q->orwhere('radius','LIKE',"%".$request->filter_search_export."%");

                    $q->orwhereHas('employee', function($q1) use ($request) {
                        $q1->where('name','LIKE',"%".$request->filter_search_export."%");
                    });
                });
            }

            $data = $data->get();
            $exportData = array();
            if(count($data) > 0){

                $count = 0;
                foreach($data as $ke=>$value){
                    $exportData[$count]['location_name'] = @$value->location_name;
                    $exportData[$count]['address'] = @$value->address;
                    $exportData[$count]['latitude'] = @$value->latitude;
                    $exportData[$count]['longitude'] = @$value->longitude;
                    $exportData[$count]['radius'] = @$value->radius;
                    $exportData[$count]['added_by_name'] = @$value->employee->name;
                    $exportData[$count]['added_by_id'] = @$value->created_by;
                    $exportData[$count]['added_date'] = date('m-d-Y',strtotime(@$value->created_at));
                    $count++;
                }

                $name = 'location_'.date('d_m_Y_H_i_s').'.xlsx';
                return Excel::download(new LocationExport($exportData), 'export.csv');
            }else{
                return false;
            }
        }catch (\Exception $ex){
            return redirect()->route('location.index')->with('error',$ex->getMessage());
        }

    }
}
