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
use DateTime;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leaveType = LeaveType::all();
        return view('leave-management.index',compact('leaveType'));
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
        try{
           $start_date = date('Y-m-d',strtotime($request->start_date));
           $end_date = date('Y-m-d',strtotime($request->end_date));            

            if($request->employee_id != ""){
                $checkBalance = LeaveList::where('employee_id',$request->employee_id)->where('status','ALLOTED')->where('leave_type_id',$request->leave_type)->count();
                if($checkBalance <= 0){
                    return response()->json(['status' => false,'message' => 'Leave not alloted, please check with your admin!']);
                }

                $check = LeaveList::where('employee_id',Auth::id())
                            ->whereBetween('start_date',[$start_date,$end_date])
                            ->whereBetween('end_date',[$start_date,$end_date])
                            ->first();

                if($check){
                    return response()->json(['status' => false,'message' => 'Leave already applied for selected dates!']);
                }   
            }else{
                $check = LeaveList::where('employee_id',Auth::id())
                            ->whereBetween('start_date',[$start_date,$end_date])
                            ->whereBetween('end_date',[$start_date,$end_date])
                            ->first();

                if($check){
                    return response()->json(['status' => false,'message' => 'Leave already applied for selected dates!']);
                }
            }

            $leave = new LeaveList();
            $leave->leave_type_id = @$request->leave_type;
            $leave->employee_id = ($request->employee_id)?($request->employee_id):Auth::id();
            $leave->start_date = ($request->start_date) ?date('Y-m-d',strtotime($request->start_date)) : NULL;
            $leave->start_leave_period = @$request->start_date_period;
            $leave->end_date = ($request->end_date) ?date('Y-m-d',strtotime($request->end_date)) : NULL;
            $leave->end_leave_period = ($request->end_date_period)?$request->end_date_period:'FULL DAY';
            if($request->file != ""){
                $filepath  = $request->file;
                $filepathName = 'Leave-'.time().'.'. $filepath->getClientOriginalExtension();
                $filepath->move(storage_path('app/public/leave/'), $filepathName); 
                $leave->attachment = $filepathName;
            }
            $leave->leave_applied_reason = @$request->leave_reason;
            $leave->status = 'PENDING';
            $leave->created_by = Auth::id();

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
            $leave->comment = @$request->comment;
            $leave->save();
            return response()->json(['status' => true,'message' => 'leave added successfully!']);
        }catch(Exception $e){
            session()->flash('error',$e->getMessage());
            return back()->withInput();
        }
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

    public function checkLeaveBalance(Request $request){
        if($request->employee_id != ""){
            $id = Auth::id();
        }else{
            $id = $request->employee_id;
        }
        $leave = LeaveList::where('employee_id',$id)->where('status','ALLOTED')->where('leave_type_id',$request->leave_type)->sum('tota_days');
        return response()->json(['status' => true,'data' => $leave]);
    }
}
