<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Inspection extends Model
{
    use HasFactory;

    public function inspectionImages()
    {
        return $this->hasMany(InspectionImage::class, 'inspection_id');
    }
    public function beforeImages()
    {
        return $this->hasMany(InspectionImage::class, 'inspection_id')->where('image_type', 'Before');
    }

    public function afterImages()
    {
        return $this->hasMany(InspectionImage::class, 'inspection_id')->where('image_type', 'After');
    }
    
    public function getCreatedAtAttribute($date){
        if($date){
            return date('d M Y',strtotime($date));
        }
    }

    public function inspectionRemarks()
    {
        return $this->hasMany(InspectionRemark::class, 'inspection_id');
    }
}
