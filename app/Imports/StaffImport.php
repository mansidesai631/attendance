<?php

namespace App\Imports;

use App\Models\Employee;
use App\Models\Designation;
use App\Models\Department;
use App\Models\EmployeeWork;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Hash;

class StaffImport implements ToCollection,WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function startRow(): int
    {
        return 3;
    }

    public function collection(Collection $rows)
    {
       
        foreach ($rows as $row) 
        {
            $employee_check = Employee::where(function ($query) use ($row) {
                $query->orWhere('mobile',$row[2])
                      ->orWhere('email',$row[3]);
            })->first();
            if(!$employee_check){
                $employee = Employee::create([
                    'name' => $row[0],
                    'mobile' => $row[2],
                    'email' => $row[3],
                    'dob' =>  NULL,
                    'blood_group' => NULL,
                    'id_type' => NULL,
                    'id_number' => NULL,
                    'second_id_type' => NULL,
                    'second_id_number' => NULL,
                    'gender' => $row[4]== 'M' ? 'Male' : 'Female',
                    'password' => Hash::make('admin@123'),
                    'role_id' => 1,
                    'user_type' => 'Admin',
                    'country_code' => $row[1],
                    'status' => '1',
                    'added_from' => 'Normal',
                    'invite_sent' => '1',
                    'created_by' => auth()->user()->id,
                    'm_challan_allowed' => 'no',
                    'field_report_allowed' => 'no',
                    'selected_site_id'=>1,
                    ]);

                    $designation_id = Designation::where('name',$row[5])->first();
                    $department_id = Department::where('name',$row[6])->first();
                    $empWorks = EmployeeWork::create([
                    'employee_id' => $employee->id,
                    'joining_date' => date('Y-m-d'),
                    'designation_id' => $designation_id ? $designation_id->id : 1 ,
                    'department_id' => $department_id ? $department_id->id : 1 ,
                    'employee_type' => 'Permanent',
                    'base_site_id' => 1,
                    'ward_id' => 1,
                    ]);
            }
        }
    }
}
