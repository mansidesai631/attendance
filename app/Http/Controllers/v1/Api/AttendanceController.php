<?php

namespace App\Http\Controllers\v1\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\v1\Api\BaseController as BaseController;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceController extends BaseController
{
    public function history(Request $request)
    {
        $date = $request->date;
        $id = $request->employee_id;

        $d = Carbon::parse($date);

        $attendances = Attendance::where('employee_id',$id)
            ->whereYear('created_at', $d)
            ->whereMonth('created_at', $d)->orderBy('id', "desc")->get();

        $data = [];
        foreach($attendances as $attendance){
            $in = $attendance->in_time;
            $out = $attendance->out_time;
            
            if($attendance->in_time){
                $in = date('h:i A',strtotime($attendance->in_time));
            }
            if($attendance->out_time){
                $out = date('h:i A',strtotime($attendance->out_time));
            }
            $temp['date'] = date_format($attendance->created_at,"d F Y");
            $temp['in'] = $in;
		    $temp['out'] = $out;
            array_push($data, $temp);
        }

    	return $this->handleResponse($data, 'Attendance history get successfully!');
    }
}