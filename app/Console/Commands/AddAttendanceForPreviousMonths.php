<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\Attendance;
use App\Models\Employee;

class AddAttendanceForPreviousMonths extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:entries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It will add entries to attendance table for previous months';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $startDate = new Carbon('2022-01-01');
        $endDate = new Carbon('2022-07-04');
        $dates = array();
        while ($startDate->lte($endDate)){
            $dates[] = $startDate->toDateString();
            $startDate->addDay();
        }

        $user = Employee::find(1);
        $employee = Employee::with('work');
        $employee->whereHas('work', function($q1) use ($user) {
            $q1->where('base_site_id',$user->selected_site_id);
        });
        $employees = $employee->get();

        foreach($dates as $date)
        {
            $emp_id = $employees->random()->id;
            foreach($employees as $employee)
            {
                $attendances = Attendance::where('employee_id',$employee->id)
                ->where('created_at', 'like', '%' . $date . '%')->first();
                if($attendances) {
                    echo "Attendances Entry already available";
                } else {
                    if($employee->id === $emp_id){
                        continue;
                    }else{
                        $attendance = new Attendance();
                        $attendance->employee_id = $employee->id;
                        $attendance->joining_date = '2022-01-01';
                        $attendance->in_time = '04:00:00';
                        $attendance->out_time = '09:00:00';
                        $attendance->attendance_from = 'Mobile';
                        $attendance->created_by = 1;
                        $attendance->created_at = $date;
                        $attendance->updated_at = $date;
                        $attendance->save();
                    }
                }
            } 
        }
        return 0;
    }
}
