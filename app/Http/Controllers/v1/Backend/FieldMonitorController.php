<?php

namespace App\Http\Controllers\v1\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FieldMonitoring;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use DataTables;
use App\Models\Inspection;
use App\Models\InspectionImage;
use App\Models\InspectionRemark;
use App\Models\Employee;
use App\Models\Site;

class FieldMonitorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staff = Employee::all();
        $sites = Site::all();
        return view('field-monitoring.index', compact('staff','sites'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $report = FieldMonitoring::with('inspection','inspection.inspectionImages','inspection.inspectionRemarks','Employee','department')->where('id',$id)->first();
        //echo "<pre>";
        //print_r($report);exit();
        return view('field-monitoring.view',compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getAllFieldReport(Request $request){
        $data = FieldMonitoring::with('Employee', 'site','circles');

        if($request->filter_search != ""){
            $data->where(function($q) use ($request) {
                $q->orwhere('title','LIKE',"%".$request->filter_search."%");
                $q->orwhereHas('Employee', function($q2) use ($request) {
                    $q2->where('name','LIKE',"%".$request->filter_search."%");
                });  

                $q->orwhereHas('site', function($q3) use ($request) {
                    $q3->where('name','LIKE',"%".$request->filter_search."%");
                });  
                
                $q->orwhereHas('circles', function($q3) use ($request) {
                    $q3->where('circle_name','LIKE',"%".$request->filter_search."%");
                });
            });
        } 

        if($request->to_rang_date !="" && $request->from_rang_date != ""){            

            $data->where(function($q1) use ($request) {  
                $from = date('Y-m-d H:i:s',strtotime($request->from_rang_date));
                $to = date('Y-m-d H:i:s',strtotime($request->to_rang_date . ' +1 day'));              
                $q1->whereBetween('created_at', [$from, $to]);
            });
        }
        
        if($request->filter_officer != ""){
            $data->where(function($q1) use ($request) {
                $q1->whereHas('employee', function($q2) use ($request) {
                    $q2->where('id',$request->filter_officer);
                });
            });
        }

        if($request->filter_zone != ""){
            $data->where(function($q1) use ($request) {
                $q1->whereHas('site', function($q2) use ($request) {
                    $q2->where('id',$request->filter_zone);
                });
            });
        }

        $data->when(!isset($request->order), function ($q) {
            $q->orderBy('id', 'desc');
        });
        return DataTables::of($data)
            ->addIndexColumn() 
            ->addColumn('zone',function($row){
                return @$row->site->name;
            })
            ->addColumn('circle',function($row){
                return @$row->circles->circle_name;
            })
            ->addColumn('officer',function($row){
                return @$row->Employee->name;
            })
            ->addColumn('action', function($row) {
                $btn = "";
                $btn .= '<button type="button" class="btn btn-link hidden-arrow btn-sm px-2 text-body"
                          data-mdb-toggle="dropdown" aria-expanded="false">
                          <mat-icon class="mat-icon material-icons" aria-hidden="true">more_vert</mat-icon>
                        </button>
                        <ul class="dropdown-menu">
                          <li>
                            <a href="'.route('field-report.show',($row->id)).'" class="dropdown-item d-flex align-items-center leave_edit" data-id="'.$row->id.'">
                              <mat-icon role="img" class="mat-icon material-icons" aria-hidden="true">remove_red_eye</mat-icon>
                              <span class="ms-3">View</span>
                            </a>
                          </li>';
                
                $btn .='</ul>';
                return $btn;
            })            
            
            ->orderColumn('id', function ($query, $order) {
                $query->orderBy('id', $order);
            })
            ->rawColumns(['officer','action'])
            ->make(true);
    }

    public function saveRemark(Request $request){
        $id = $request->id;
        $inspectionRemark = new InspectionRemark();
        $inspectionRemark->inspection_id = $id;
        $inspectionRemark->remark = $request->remark;
        $inspectionRemark->created_by = Auth::id();
        $inspectionRemark->save();
        return response()->json(['status' => true,'message' => 'Remark stored successfully!']);
    }

    public function getBeforeImages(Request $request)
    {        
        $report = InspectionImage::where('inspection_id',$request->id)->where('image_type','Before')->get();
        return response()->json(['status' => true,'data' => $report]);
    }

    public function getAfterImages(Request $request)
    {        
        $report = InspectionImage::where('inspection_id',$request->id)->where('image_type','After')->get();
        return response()->json(['status' => true,'data' => $report]);
    }
}
