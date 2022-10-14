<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FieldMonitoring extends Model
{
    use HasFactory, SoftDeletes;

    public function department(){
        return $this->hasOne(Department::class,'id','department');
    }

    public function officer(){
        return $this->hasOne(Employee::class,'id','officer');
    }

    public function Employee(){
        return $this->belongsTo(Employee::class,'officer');
    }
  
    public function site(){
        return $this->hasOne(Site::class,'id','zone');
    }

    public function circles(){
        return $this->hasOne(Circle::class,'id','circle');
    }

    public function getCreatedAtAttribute($date){
        if($date){
            return date('d M Y',strtotime($date));
        }
    }
    public function inspection()
    {
        return $this->hasMany(Inspection::class, 'monitoring_id');
    }
}
