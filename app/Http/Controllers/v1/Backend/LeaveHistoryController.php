<?php

namespace App\Http\Controllers\v1\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\LeaveType;
use App\Models\LeaveList;
use Carbon\Carbon;
use URL;
use DateTime;
use App\Models\Employee;

class LeaveHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total = LeaveList::where('id',Auth::id())->sum('tota_days');
        $leaveType = LeaveType::all();        
        return view('leave-management.my-history.index',compact('total','leaveType'));
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
        $url = '';
        $leave = LeaveList::find($id);
        $start_date = date('m/d/Y',strtotime($leave->start_date));
        $end_date = date('m/d/Y',strtotime($leave->end_date));
        if($leave->attachment != ''){
            $url = URL::to('/').'/storage/leave/'.''.$leave->attachment;
        }
        $balance = LeaveList::where('employee_id',Auth::id())->where('status','ALLOTED')->where('leave_type_id',$leave->leave_type_id)->count();
        return response()->json(['status' => true,'data' => $leave,'start_date'=>$start_date,'end_date'=>$end_date,'url'=>$url,'balance'=>$balance]);
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
        try{
            $leave = LeaveList::find($request->leave_id);
            $leave->employee_id = Auth::id();
            $leave->start_date = ($request->start_date) ?date('Y-m-d',strtotime($request->start_date)) : NULL;
            $leave->start_leave_period = @$request->start_date_period;
            $leave->end_date = ($request->end_date) ?date('Y-m-d',strtotime($request->end_date)) : NULL;
            $leave->end_leave_period = ($request->end_date_period)?$request->end_date_period:'FULL DAY';
            if($request->file != ""){
                if($leave->attachment != ""){
                    $url = storage_path('app/public/leave/').''.$leave->attachment;
                    if(file_exists($url)){
                        unlink($url);
                    }                    
                }                

                $filepath  = $request->file;
                $filepathName = 'Leave-'.time().'.'. $filepath->getClientOriginalExtension();
                $filepath->move(storage_path('app/public/leave/'), $filepathName); 
                $leave->attachment = $filepathName;
            }
            $leave->leave_applied_reason = @$request->leave_reason;
            $leave->status = 'PENDING';
            $leave->updated_by = Auth::id();

            $start_date = new DateTime($request->start_date);
            $end_date = new DateTime($request->end_date);
            $interval = $start_date->diff($end_date);
            $days = $interval->format('%a') + 1;//now do whatever you like with $days
            if($start_date == $end_date){
                
                if($request->start_date_period == 'FIRST HALF' || $request->start_date_period == 'SECOND HALF'){
                    $days = '0.5';
                }
            }else{
                if($request->start_date_period == 'FIRST HALF' || $request->start_date_period == 'SECOND HALF'){
                    $days = $days - 0.5;
                }
                if($request->end_date_period == 'FIRST HALF' || $request->end_date_period == 'SECOND HALF'){
                    $days = $days - 0.5;
                }
            }               

            $leave->tota_days = $days;
            $leave->save();
            return response()->json(['status' => true,'message' => 'leave updated successfully!']);
        }catch(Exception $e){
            session()->flash('error',$e->getMessage());
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $leave = LeaveList::find($id);
        $leave->cancelled_by = Auth::id();
        $leave->status = 'CANCELLED';
        $leave->save();
        return response()->json(['status' => true,'message' => 'Leave cancelled successfully!']);
    }

    public function getAllLeaveHistory(Request $request){
        $user = Employee::find(Auth::id());
        $data = LeaveList::with("employee","LeaveType","employee.work")->where('employee_id',Auth::id());

        $data->whereHas('employee.work', function($q1) use ($user) {
            $q1->where('base_site_id',$user->selected_site_id);
        });

        if($request->filter_search != ""){
            $data->where(function($q) use ($request) {               

                $q->orwhereHas('employee', function($q1) use ($request) {
                    $q1->where('name','LIKE',"%".$request->filter_search."%");
                });

                $q->orwhereHas('LeaveType', function($q2) use ($request) {
                    $q2->where('name','LIKE',"%".$request->filter_search."%");
                });

                $q->orwhere('start_date','LIKE',"%".date('Y-m-d',strtotime($request->filter_search))."%");
                $q->orwhere('end_date','LIKE',"%".date('Y-m-d',strtotime($request->filter_search))."%");
                $q->orwhere('tota_days','LIKE',"%".$request->filter_search."%");
                $q->orwhere('leave_applied_reason','LIKE',"%".$request->filter_search."%");
                $q->orwhere('status','LIKE',"%".$request->filter_search."%");
            });
        }
        if($request->filter_duration != ""){
            if($request->filter_duration == 'This week'){
                $data->where(function($q1) use ($request) {
                    $q1->whereBetween('start_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    $q1->orWhere('status','ALLOTED');
                });
            }else if($request->filter_duration == 'This month'){
                $data->where(function($q2) use ($request) {
                    $q2->whereMonth('start_date', date('m'));
                    $q2->orWhere('status','ALLOTED');
                });
            }else if($request->filter_duration == 'This year'){
                $data->where(function($q3) use ($request) {
                    $q3->whereMonth('start_date', date('Y'));
                    $q3->orWhere('status','ALLOTED');
                });
            }else if($request->filter_duration = 'date range'){
                $data->where(function($q4) use ($request) {
                    $from = date('Y-m-d',strtotime($request->from_date));
                    $to = date('Y-m-d',strtotime($request->to_date));
                    $q4->whereBetween('start_date', [$from,$to]);
                });
            }
        }

        if($request->status != ""){
            $data->where(function($q1) use ($request) {
                $q1->whereIn('status',$request->status);
            });
        } 

        $data->when(!isset($request->order), function ($q) {
            $q->orderBy('id', 'desc');
        });
        return DataTables::of($data)       
            ->addIndexColumn() 
            
            ->addColumn('name',function($row){
                return @$row->employee->name;
            })
            ->addColumn('leave_type_id',function($row){
                return @$row->LeaveType->name;
            })            
            ->addColumn('start_date', function($row) {
                return ($row->start_date)?date('d-M-Y',strtotime($row->start_date)) : '-';
            }) 
            ->addColumn('end_date', function($row) {
                return ($row->end_date)?date('d-M-Y',strtotime($row->end_date)) : '-';
            }) 
            ->addColumn('document', function($row) {
                if($row->attachment != ""){
                    $url = URL::to('/').'/storage/leave/'.''.$row->attachment;
                    return '<a href="'.$url.'" target="_blank">View Attachment</a>';
                }else{
                    return " ";
                }
            })           
            ->addColumn('action', function($row) {
                if($row->status == 'PENDING'){
                    $class = '';
                }
                else{
                    $class = 'disabled';
                }
                $btn = "";
                $btn .= '<button type="button" class="btn btn-link hidden-arrow btn-sm px-2 text-body '.$class.'"
                          data-mdb-toggle="dropdown" aria-expanded="false">
                          <mat-icon class="mat-icon material-icons" aria-hidden="true">more_vert</mat-icon>
                        </button>
                        <ul class="dropdown-menu">
                          <li>
                            <a class="dropdown-item d-flex align-items-center edit_leave" data-mdb-toggle="modal" data-mdb-target="#edit-leave" data-id="' . $row->id . '">
                              <mat-icon role="img" class="mat-icon material-icons" aria-hidden="true">edit</mat-icon>
                              <span class="ms-3">Edit</span>
                            </a>
                          </li>';                
                $btn  .= '<li>
                            <a class="dropdown-item d-flex align-items-center delete" href="javascript:void(0)" data-id="' . $row->id . '" data-mdb-toggle="modal" data-mdb-target="#delete_employee" data-url="'.route('my-history.destroy',$row->id).'">
                              <mat-icon role="img" class="mat-icon material-icons" aria-hidden="true">delete</mat-icon>
                              <span class="ms-3">Cancel</span>
                            </a>
                          </li>';
                $btn .='</ul>';
                return $btn;
            })
            ->orderColumn('id', function ($query, $order) {
                $query->orderBy('id', $order);
            })
            ->rawColumns(['document','action'])
            ->make(true);
    }
}
