<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use URL;

class MChallanImage extends Model
{
    use HasFactory;

    public function getImageAttribute($value)
	{
	    return $url = URL::to('/').'/storage/'.''.($value);
	}

}
