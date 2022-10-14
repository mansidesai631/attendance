<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Employee;
use App\Models\Attendance;
use Log;

class InTimeAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'intime:attendance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Intime for employee attendance.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $all_employee = Employee::pluck('id')->toArray();
        
        
        shuffle($all_employee);
        array_pop($all_employee);

        $all_employee = Employee::with('work')->whereIn('id',$all_employee)->get();
    
        foreach($all_employee as $single_employee){
            $existing_data = Attendance::where('employee_id',$single_employee['id'])->whereDate('created_at',date('Y-m-d'))->first();
            if(!$existing_data){
                Attendance::create(
                [    
                    'employee_id'=>$single_employee['id'],
                    'joining_date'=>$single_employee['work']['joining_date'],
                    'in_time'=>date('H:i:s'),
                    'in_latitude'=>'23.022505',
                    'in_longitude'=>'72.5713621',
                    'out_time'=>Null,
                    'attendance_from'=>'Mobile',
                    'create_by'=>'1',
                ]);
            }
        }
        Log::debug('Intime Crone job done.');
        return 'Set Intime Successfully.';
    }
}
