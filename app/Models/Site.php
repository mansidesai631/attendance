<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    public function employees()
    {
    	return $this->hasMany(Employee::class, 'selected_site_id', 'id');
    }

    public function activeUser()
    {
    	return $this->hasMany(Employee::class, 'selected_site_id', 'id')->where('status',1);
    }
}
