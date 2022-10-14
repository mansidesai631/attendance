<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionRemark extends Model
{
    use HasFactory;
    protected $appends = ['created_name'];
    public function getCreatedNameAttribute(){ 
        return Employee::where('id', $this->created_by)->pluck('name')->first();
    }
}
