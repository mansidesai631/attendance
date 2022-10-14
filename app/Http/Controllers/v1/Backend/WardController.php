<?php

namespace App\Http\Controllers\v1\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ward;
use DataTables;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Site;

class WardController extends Controller
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
        $ward  = new Ward();
        $ward->site_id = @$request->site_ward_id;
        $ward->ward_name = @$request->ward_name;
        $ward->address = @$request->ward_address;
        $ward->created_by = Auth::id();
        $ward->save();
        
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
        $ward = Ward::with('site')->find($id);
        return response()->json(['status' => true,'data'=>$ward]);
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
        $ward  = Ward::find($request->ward_id);
        $ward->site_id = @$request->edit_site_ward_id;
        $ward->ward_name = @$request->edit_ward_name;
        $ward->address = @$request->edit_ward_address;
        $ward->updated_by = Auth::id();
        $ward->save();
        
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
        $delete = Ward::where('id',$request->id)->delete();
        return response()->json(['status' => true,'message' => 'Successfully deleted!']);
    }

    public function getAllWard(Request $request){
        $data = Ward::with('site');

        if($request->filter_search != ""){
            $data->where(function($q) use ($request) {
                $q->orwhere('site_id','LIKE',"%".$request->filter_search."%");
                $q->orwhere('ward_name','LIKE',"%".$request->filter_search."%");
                $q->orwhere('address','LIKE',"%".$request->filter_search."%");
            });
        }

        $data->when(!isset($request->order), function ($q) {
            $q->orderBy('id', 'desc');
        });
        return DataTables::of($data)
            ->addIndexColumn() 
            ->addColumn('site',function($row){
                return @$row->site->name;
            })
            ->addColumn('action', function($row) {
                $btn = "";
                $btn .= '<button type="button" class="btn btn-link hidden-arrow btn-sm px-2 text-body"
                          data-mdb-toggle="dropdown" aria-expanded="false">
                          <mat-icon class="mat-icon material-icons" aria-hidden="true">more_vert</mat-icon>
                        </button>
                        <ul class="dropdown-menu">
                          <li>
                            <a class="dropdown-item d-flex align-items-center ward_edit" data-mdb-toggle="modal" data-mdb-target="#edit-ward" data-id="'.$row->id.'">
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
            ->rawColumns(['site','action'])
            ->make(true);
    }

    public function getSites(){
        $sites = Site::all();
        return response()->json(['status' => true,'data' => $sites]);
    }
}
