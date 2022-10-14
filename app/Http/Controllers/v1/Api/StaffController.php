<?php

namespace App\Http\Controllers\v1\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\v1\Api\BaseController as BaseController;
use App\Models\Employee;

class StaffController extends BaseController
{
    public function index()
    {
        $staff = Employee::select('id','name')->where('created_by',1)->get();
        return $this->handleResponse($staff, 'Staff details get successfully!');
    }
}
