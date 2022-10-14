<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'department';

    protected $fillable = [
        'name', 'head', 'created_by'
    ];
    
    public function employees()
    {
        return $this->belongsTo(Employee::class,'head_id','id');
    }

    public function createdBy()
    {
        return $this->belongsTo(Employee::class,'created_by','id');
    }
}
