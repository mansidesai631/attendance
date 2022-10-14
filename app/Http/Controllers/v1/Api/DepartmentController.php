<?php

namespace App\Http\Controllers\v1\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\v1\Api\BaseController as BaseController;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Site;
use App\Models\Ward;
use App\Models\Circle;

class DepartmentController extends BaseController
{
    public function index()
    {
    	$arr = [];
        $department = Department::select('id','name')->get();
        $staff = Employee::select('id','name')->where('created_by',1)->get();

        $zones = Site::select('id','name')->get();

        $Ward = Ward::select('id','site_id as zone_id','ward_name')->get();

        // $values = ['Central Zone', 'East Zone', 'North Zone', 'North West Zone', 'South Zone','South West Zone','West Zone'];

        // foreach ($values as $i => $val) {
        //     array_push($zones, [
        //         'id' => $i + 1,
        //         'name' => $val,
        //     ]);
        // }

        $circles = Circle::select('id','ward_id','circle_name')->get();
        // $values = ['Prahladnagar', 'Sivranjani', 'Vastrapur', 'Satellite', 'Maninagar','Vejalpur','Bapunagar','Naroda','Ghatlodiya','CG Road'];

        // foreach ($values as $i => $val) {
        //     array_push($circles, [
        //         'id' => $i + 1,
        //         'name' => $val,
        //     ]);
        // }

        $arr = ['department'=>$department,'staff'=>$staff,'zones'=>$zones,'circles'=>$circles,'wards'=>$Ward];
        return $this->handleResponse($arr, 'Your department details get Successfully!');

    }

}
