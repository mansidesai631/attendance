<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use URL;

class InspectionImage extends Model
{
    use HasFactory;
    public $fillable = ['inspection_id', 'image_type', 'image'];

    public function getImageAttribute($value)
	{
	    return $url = URL::to('/').'/storage/'.''.($value);
	}
}
