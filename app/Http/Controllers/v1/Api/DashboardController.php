<?php



namespace App\Http\Controllers\v1\Api;



use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Validator;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\v1\Api\BaseController as BaseController;

use App\Models\EmployeeWork;

use App\Models\Employee;

use App\Models\Attendance;

use App\Models\LeaveList;

use Illuminate\Support\Carbon;

use App\Helpers\Helper;

use URL;

use App\Http\Requests\v1\Api\ProfileRequest;



class DashboardController extends BaseController

{

    public function index(Request $request){

    	$today = Carbon::now();

		$month = $today->month; // retrieve the month

		$year = $today->year; // retrieve the year of the date



		$date=date_create($today);

		$dashboard['date'] = date_format($date,"jS F Y");



		$holidays = 2;

    	$dashboard['holidays'] = $holidays;



    	$totalWorkingDays = Helper::countDays($year, $month, array(0, 7));

    	$dashboard['totalWorkingDays'] = $totalWorkingDays - $holidays;



    	$weeklyOff = date('t') - $totalWorkingDays;

    	$dashboard['weeklyOff'] = $weeklyOff;



    	$remainingDays = date('t') - date('d');

    	$dashboard['remainingDays'] = $remainingDays;



		//get current month for example

		$beginday = date("Y-m-01");

		$lastday  = date($today->format("Y-m-d"));



		$nr_work_days = Helper::workingDays($beginday, $lastday);



    	$leave = LeaveList::where('status', 'APPROVED')

						->whereBetween('start_date',[$beginday,$lastday])

						->whereBetween('end_date',[$beginday,$lastday])

						->where('employee_id',Auth::id())->count();

		$dashboard['leave'] = $leave;



		$present = Attendance::whereBetween('created_at',[$beginday,$lastday])

						->where('employee_id',Auth::id())->count();

		$dashboard['present'] = $present;

		$dashboard['absent'] = $nr_work_days - $present;



		// In-Out Time

		$in_time = Attendance::whereDate('created_at',Carbon::today())->where('employee_id',Auth::id())->first();

		$in = @$in_time->in_time;

		$out = @$in_time->out_time;

		

		if(@$in_time->in_time){

			$in = date('h:i A',strtotime(@$in_time->in_time));

		}

		if(@$in_time->out_time){

			$out = date('h:i A',strtotime(@$in_time->out_time));

		}



		$dashboard['in_time'] = $in;

		$dashboard['out_time'] = $out;



		// Previous attendance entry

		$previous_entry = Attendance::where('employee_id',Auth::id())->orderBy('created_at', 'DESC')->first();

		$in = @$previous_entry->in_time;

		$out = @$previous_entry->out_time;

		$in_out = '-';

		

		if(@$previous_entry->in_time){

			$in = date('h:i A',strtotime(@$previous_entry->in_time));

			$in_out = 'in';

		}

		if(@$previous_entry->out_time){

			$out = date('h:i A',strtotime(@$previous_entry->out_time));

			$in_out = 'out';

		}

		$dashboard['in_out'] = $in_out;



    	return $this->handleResponse($dashboard, 'Dashboard details get successfully!');

    }



	public function profile(){

		$id = Auth::id();

		$employee = Employee::with('role')->where('id',$id)->first();
		if(Auth::user()->image != ""){
			$employee->image = URL::to('/').'/storage/profile/'.''.Auth::user()->image;
		}else{
			$employee->image = null;
		}
		$employee->city = 'Ahmedabad';

		return $this->handleResponse($employee, 'User profile details get successfully!');

	}



	public function updateProfile(ProfileRequest $request){

		$id = Auth::id();

        $emp =Employee::find($id);

        $emp->name = $request->name;

        if(isset($request->profile_file) && $request->profile_file != NULL){

            if(isset($emp->image) && $emp->image!=''){

                $filePath = storage_path('app/public/profile/').''.$emp->image;

                if(file_exists($filePath)){

                    unlink($filePath);    

                }

            }



            $filepath  = $request->profile_file;

            $filepathName = 'Profile-'.$request->staff_type.time().'.'. $filepath->getClientOriginalExtension();

            $filepath->move(storage_path('app/public/profile/'), $filepathName); 

            $emp->image = $filepathName;            

        }

        $emp->save();

        return $this->handleResponse($emp, 'Profile updated successfully!');

	}



	public function registerFace(Request $request){

        $id = $request->employee_id;

		// $id = Auth::id();

        $emp =Employee::find($id);

		if(isset($request->register_face) && $request->register_face != NULL){

            if(isset($emp->register_face) && $emp->register_face!=''){

                $filePath = storage_path('app/public/registerFace/').''.$emp->register_face;

                if(file_exists($filePath)){

                    unlink($filePath);    

                }

            }



            $filepath  = $request->register_face;

            $filepathName = 'registerFace-'.$request->staff_type.time().'.'. $filepath->getClientOriginalExtension();

            $filepath->move(storage_path('app/public/registerFace/'), $filepathName); 

            $emp->register_face = $filepathName;            

        }

		$emp->save();

		return $this->handleResponse($emp, 'Face Added successfully!');

	}

}

