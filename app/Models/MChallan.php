<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use URL;

class MChallan extends Model
{
    use HasFactory;

    public function employee(){
        return $this->hasOne(Employee::class,'id','concern_officer');
    }    

	public function getCreatedAtAttribute($date){
        if($date){
            return date('d M Y',strtotime($date));
        }
    }

    public function department(){
        return $this->hasOne(Department::class,'id','department');
    }

    public function mChallanImages()
    {
        return $this->hasMany(MChallanImage::class, 'm_challan_id');
    }

    public function site(){
        return $this->hasOne(Site::class,'id','zone');
    }

    public function wards(){
        return $this->hasOne(Ward::class,'id','ward');
    }

    public function circles(){
        return $this->hasOne(Circle::class,'id','circle');
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            if(!$model->m_unique_id){
                $model->m_unique_id = MChallan::createUnique();
            }
        });
    }

    public static function createUnique(){
        // Get the last order id
        $lastId = MChallan::orderBy('id', 'desc')->first()->m_unique_id;
        if($lastId == null){
            $lastId = 'M000';
        }

        // Get last 3 digits of last order id
        if(strlen($lastId) < 5) {
            $lastIncreament = substr($lastId, -3);
        } else {
            $lastIncreament = substr($lastId, 1);
        }

        // Make a new order id with appending last increment + 1
        $newId = 'M' . str_pad($lastIncreament + 1, 3, 0, STR_PAD_LEFT);
  
        return $newId;
    }
}
