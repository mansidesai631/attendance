<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendance_entries';
    protected $guarded = ['id'];

    use HasFactory, SoftDeletes;

    protected $appends = ['time_spent'];

    public function getTimeSpentAttribute(){ 
        $time = '-';  
        if($this->out_time){
            $time1 = strtotime($this->in_time);
            $time2 = strtotime($this->out_time);
            $time = date('H:i:s' ,$time2 - $time1);
        }


        return $time;
    }
}
