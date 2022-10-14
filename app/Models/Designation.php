<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'designation';

    protected $fillable = [
        'name', 'created_by'
    ];

    public function createdBy()
    {
        return $this->belongsTo(Employee::class,'created_by','id');
    }
}
