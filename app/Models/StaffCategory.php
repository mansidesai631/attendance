<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class StaffCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'staff_category';

    protected $fillable = [
        'name', 'ad_limit','created_by'
    ];
}
