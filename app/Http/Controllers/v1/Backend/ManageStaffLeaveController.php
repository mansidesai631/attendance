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
use App\Models\Department;
use App\Models\StaffCategory;
use DateTime;
use DB;
use App\Models\Employee;

class ManageStaffLeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Employee::find(Auth::id());       
        $employee = Employee::with('work');
        $employee->whereHas('work', function($q1) use ($user) {
            $q1->where('base_site_id',$user->selected_site_id);
        });
        $employee = $employee->get();
        $leave = LeaveList::with('employee','employee.work.department','employee.work.category','employee.work')
                        ->select("*", DB::raw('SUM(tota_days) as total'));

        $leave->whereHas('employee.work', function($q1) use ($user) {
            $q1->where('base_site_id',$user->selected_site_id);
        });
          
        $leave = $leave->groupBy("employee_id")
                        ->get();
        $leaveType = LeaveType::all();
        $department = Department::all();
        $category = StaffCategory::all();
        return view('leave-management.manage-staff-leave.index',compact('leaveType','leave','department','category','employee'));
    }
    
    public function empLeaveHistory(Request $request){
        $id = $request->id;
        $details = LeaveList::with('employee','LeaveType','employee.work.designation')->where('employee_id',$request->id)->first();
        if($details) {
            // Leave Deatils Table
            $leaveDetails = LeaveList::with('employee','LeaveType')->where('employee_id',$request->id)->get();
            $details->leave_details = view('leave-management.manage-staff-leave.leaveDetails', compact('leaveDetails'))->render();
            //Leave Count Box
            $alloted = LeaveList::where('employee_id',$request->id)->where('status','ALLOTED')->sum('tota_days');
            $used = LeaveList::where('employee_id',$request->id)->where('status','APPROVED')->sum('tota_days');
            $balance  = $alloted - $used;
            $leaveType = LeaveType::all();
            $details->leaveCount = view('leave-management.manage-staff-leave.leaveCount',compact('balance','leaveType','id'))->render();

            // Personal Details
            $personalDetails = $details->employee;
            $details->personaldetails = view('leave-management.manage-staff-leave.employeePersonalDetails',compact('personalDetails'))->render();

            $response = ['status'=>true,'data'=>$details];
        } else {
            $response = ['status'=>false,'message'=>'Record not found !'];
        }
        return $response;
    }

    public function store(Request $request)
    {
        try{
            
            $leave = new LeaveList();
            $leave->leave_type_id = @$request->emp_leave_type;
            $leave->employee_id = @$request->employee_allot_id;
            $leave->status = 'ALLOTED';  
            $leave->tota_days = $request->total_days; 
            $leave->comment = @$request->allot_comment;
            $leave->save();
            return response()->json(['status' => true,'message' => 'Success!']);
        }catch(Exception $e){
            session()->flash('error',$e->getMessage());
            return back()->withInput();
        }
    }
}
