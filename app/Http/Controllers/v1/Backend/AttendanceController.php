<?php

namespace App\Http\Controllers\v1\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Site;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Employee::find(Auth::id());       
        $employee = Employee::with('work', 'site');
        $employee->whereHas('work', function($q1) use ($user) {
            $q1->where('base_site_id',$user->selected_site_id);
        });
        $employee = $employee->get();
        $department = Department::all();
        $sites = Site::all();
        $date = '';
        
        return view('leave-management.attendance.index',compact('employee', 'department','date', 'sites'));
    }

    public function dateFilter(Request $request){

        $user = Employee::find(Auth::id());
        $date = $request->datepicker;
        $employee = Employee::with('work', 'site');
        $employee->whereHas('work', function($q1) use ($user) {
            $q1->where('base_site_id',$user->selected_site_id);
        });
        $employee = $employee->get();
        $department = Department::all();
        $sites = Site::all();

        return view('leave-management.attendance.index',compact('employee', 'department','date', 'sites'));

    }
}
