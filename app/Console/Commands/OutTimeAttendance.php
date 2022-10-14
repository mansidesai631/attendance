<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Attendance;
use Log;

class OutTimeAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'outtime:attendance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Outtime for employee attendance.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       $set_out_time_record = Attendance::whereDate('created_at',date('Y-m-d'))->whereNull('out_time')->get();
       if(count($set_out_time_record)){
        Attendance::whereDate('created_at',date('Y-m-d'))->whereNull('out_time')->update([
            'out_time'=>date('H:i:s'),
            'out_latitude'=>'23.022505',
            'out_longitude'=>'72.5713621',
        ]);
       }
       Log::debug('Outtime Crone job done.');
       return 'Set Outtime Successfully.';
    }
}
