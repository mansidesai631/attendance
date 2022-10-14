<?php

namespace App\Http\Controllers\v1\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EmployeeWork;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\LeaveList;
use Illuminate\Support\Carbon;
use App\Helpers\Helper;
use App\Models\MChallan;
use App\Models\FieldMonitoring;

class DashboardController extends Controller
{
    public function index(){

		$today = Carbon::now();
		$month = $today->month; // retrieve the month
		$year = $today->year; // retrieve the year of the date

		//get current month for example
		$beginday = date("Y-m-01");
		$lastday  = date($today->format("Y-m-d"));

		$user = Employee::find(Auth::id());

		$emp = Employee::with('work');

        $emp->whereHas('work', function($q1) use ($user) {
            $q1->where('base_site_id',$user->selected_site_id);
        });


		$emp_ids = $emp->pluck('id')->toArray();

		$att = Attendance::whereIn('employee_id', $emp_ids)->where('created_at','>=',Carbon::now()->startOfDay())
			->where('created_at','<=',Carbon::now()->endOfDay());

		$leave = LeaveList::whereIn('employee_id', $emp_ids)->where('status', 'APPROVED')
			->whereBetween('start_date',[$beginday,$lastday])
			->whereBetween('end_date',[$beginday,$lastday]);

		$m_challan = MChallan::sum('amount_of_fine');
		$field = FieldMonitoring::all();


		//data for employee count
		$employeeCount = [];
		$employeeCount['total'] = $emp->count();
		$employeeCount['totalPresent'] = $att->count();
		$absent = $emp->count() - $att->count();
		$employeeCount['totalAbsent'] = $absent;
		$employeeCount['totalLeave'] = $leave->count();
		$lwi = $employeeCount['totalAbsent'] - $employeeCount['totalLeave'];
		$employeeCount['totalLeaveWithoutInfo'] = $lwi;
		$employeeCount['m_challan'] = number_format($m_challan,2);
		$employeeCount['field'] = $field->count();

		// employee day count
		$employee = Employee::with('work', 'attendances', 'leaveList');

        $employee->whereHas('work', function($q1) use ($user) {
            $q1->where('base_site_id',$user->selected_site_id);
        });

		$employee->withCount([
			'attendances' => function ($query) use ($beginday, $lastday){
				$query->whereBetween('created_at',[$beginday,$lastday]);
			},      
	
			'leaveList' => function ($query) use ($beginday, $lastday){
				$query->where('status', 'APPROVED')
					->whereBetween('start_date',[$beginday,$lastday])
					->whereBetween('end_date',[$beginday,$lastday]);
			}
		]);
		
		$employee = $employee->get();

		$totalWorkingDays = 0;
		if (!empty($month && $year)) {
			$totalWorkingDays = Helper::countDays($year, $month, array(0, 7));
		}

		$nr_work_days = Helper::workingDays($beginday, $lastday);
    	return view('dashboard.dashboard', compact('employeeCount', 'employee', 'totalWorkingDays', 'nr_work_days'));
    }

    public function changeSite(Request $request){
    	$id = Auth::id();

    	$employee = Employee::find($id);
    	$employee->selected_site_id = $request->id;
    	$employee->save();

    	$site = @$employee->site->name;
    	return response()->json(['status' => true,'data'=>$site]);
    }
}
