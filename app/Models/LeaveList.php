<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveList extends Model
{
    use HasFactory,SoftDeletes;

    public function employee(){
        return $this->hasOne(Employee::class,'id','employee_id');
    }

    public function LeaveType(){
        return $this->hasOne(LeaveType::class,'id','leave_type_id');
    }
}
