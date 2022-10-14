<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeWork extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id','base_site_id'];

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function designation(){
        return $this->belongsTo(Designation::class);
    }

    public function category(){
        return $this->hasOne(StaffCategory::class,'id','staff_category_id');
    }

    public function site(){
        return $this->hasOne(Site::class,'id','base_site_id');
    }

    public function ward(){
        return $this->hasOne(Ward::class,'id', 'ward_id');
    }

    public function managers(){
        return $this->hasOne(Manager::class,'id','manager');
    }
}
