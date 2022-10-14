<?php

namespace App\Http\Controllers\v1\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Attendance;
use App\Models\Designation;
use Carbon\CarbonPeriod;
use App\Exports\DailyExport;
use App\Exports\IndividualExport;
use App\Models\Site;
use App\Models\Ward;

class ReportsController extends Controller
{
    public function index()
    { 
        $departments = Department::pluck('name','id');
        $designation = Designation::pluck('name','id');
        $zones = Site::pluck('name','id');
        $wards = Ward::pluck('ward_name','id');
        $employee = Employee::pluck('name','id');
        if(request()->ajax()){
            $data = request()->all();


            if($data['report_name'] == 'daily_attendance'){
                $data['from_date'] = date('Y-m-d',strtotime(request('from_date',date('Y-m-d'))));
                $employee = Employee::with('work');
                if (request('searchtext')) {
                    $search = $data['searchtext'];
                    $employee = $employee->where(function ($query) use ($search) {
                        $query->orWhere('name', 'like', '%' . $search . '%');
                        $query->orWhere('email', 'like', '%' . $search . '%');
                    });
                }

                $employee = $employee->when($data['department'])->whereHas('work', function($q1) use ($data) {
                        $q1->where('department_id',$data['department']);
                    });
                
                $employee = $employee->when($data['designation'])->whereHas('work', function($q1) use ($data) {
                     $q1->where('designation_id',$data['designation']);
                    });
                
                $employee = $employee->when($data['zone'])->whereHas('work', function($q1) use ($data) {
                    $q1->where('base_site_id',$data['zone']);
                    });
                
                $employee = $employee->when($data['ward'])->whereHas('work', function($q1) use ($data) {
                    $q1->where('ward_id',$data['ward']);
                    });

                $employee = $employee->when($data['from_date'])->with(['attendanceSingle'=> function($q1) use ($data) {
                     $q1->whereDate('created_at',$data['from_date']);
                    }]);
               
                $employee = $employee->paginate(5);
                //access all paramere form $data
                return response()->json(
                        View::make('reports.dailyRaw', compact('employee'))
                            ->render()
                    );
            }
            if($data['report_name'] == 'individual_attendance'){

                $formDate = strval(date('Y-m-d', strtotime(request('from_rang_date',date('Y-m-d')))));
                $toDate = strval(date('Y-m-d', strtotime(request('to_rang_date',date('Y-m-d')) . ' +1 day')));
                $employee = Employee::first();
                
                $employee = $data['employee'] ? $data['employee'] : $employee['id'];
                
                $attendances = Attendance::where('employee_id',$employee)->whereBetween('created_at',[$formDate.'%',  $toDate.'%'])->paginate(5);
                
                 //access all paramere form $data
                return response()->json(
                        View::make('reports.individualRaw', compact('attendances'))
                            ->render()
                    );
            }
        }
        return view('reports.index',compact('departments','designation','employee', 'zones', 'wards'));
    }

    public function exportReport(Request $request)
    {
        $data = request()->all();
        $fileName = ucwords((str_replace('_', ' ', $data['report_name']))).' Report.csv';

        $data['from_date'] = date('Y-m-d',strtotime(request('from_date',date('Y-m-d'))));
        $data['formDate'] = strval(date('Y-m-d', strtotime(request('from_rang_date',date('Y-m-d')))));
        $data['toDate'] = strval(date('Y-m-d', strtotime(request('to_rang_date',date('Y-m-d')) . ' +1 day')));

        
        if($data['report_name'] == 'daily_attendance'){
            $sheetDetails = $this->dailytData($data);
            return Excel::download(new DailyExport ($sheetDetails), $fileName);   
        }elseif($data['report_name'] == 'individual_attendance'){
            $sheetDetails = $this->individualData($data);
            return Excel::download(new IndividualExport ($sheetDetails), $fileName);
        }
    }

    public function dailytData($data)
    {
        $exportData['report_date'] = date('d-M-Y',strtotime($data['from_date'])) .'To'. date('d-M-Y',strtotime($data['from_date']));
        $employee = Employee::with('work');

        $employee = $employee->when($data['department'])->whereHas('work', function($q1) use ($data) {
                $q1->where('department_id',$data['department']);
            });
        
        $employee = $employee->when($data['designation'])->whereHas('work', function($q1) use ($data) {
             $q1->where('designation_id',$data['designation']);
            });

        $employee = $employee->when($data['zone'])->whereHas('work', function($q1) use ($data) {
            $q1->where('base_site_id',$data['zone']);
        });

        $employee = $employee->when($data['ward'])->whereHas('work', function($q1) use ($data) {
            $q1->where('ward_id',$data['ward']);
            });

        $employee = $employee->when($data['from_date'])->with(['attendanceSingle'=> function($q1) use ($data) {
             $q1->whereDate('created_at',$data['from_date']);
            }]);

        $employee = $employee->get();
        $i = 1;
        $list = [];
        foreach ($employee as $single_employee) {
            $list[] = [
                $i++,
                $single_employee['name'],
                $single_employee['email'],
                @$single_employee['work']['employee_id'],
                @$single_employee['work']['site']['name'],
                @$single_employee['work']['ward']['ward_name'],
                @$single_employee['work']['department']['name'],
                @$single_employee['work']['designation']['name'],
                @$single_employee['work']['managers']['name'],
                @$single_employee['attendanceSingle']['in_time'],
                '-',
                @$single_employee['attendanceSingle']['out_time'],
                '-',
                @$single_employee['attendanceSingle']['time_spent'],
                $single_employee['attendanceSingle'] ? 'In' : 'Not-In',
            ];    
        }
        $exportData['list'] = $list;
        
        return $exportData;
    }

    public function individualData ($data)
    {
        $exportData['report_date'] = date('d-M-Y',strtotime($data['formDate'])) .'To'. date('d-M-Y',strtotime($data['toDate']. '-1 day'));

        $employee = Employee::where('id',$data['employee'])->first();

        $exportData['employee_name'] = $employee['name']; 
        $exportData['employee_id'] = $employee['id']; 

        $attendances = Attendance::where('employee_id',$employee['id'])->whereBetween('created_at',[$data['formDate'].'%',  $data['toDate'].'%'])->get();
        $i = 1;
        $list = [];
        foreach ($attendances as $att) {
            $list[] = [
                $i++,
                date('l', strtotime($att['created_at'])),
                $att['created_at'],
                $att['in_time'],
                $att['out_time'],
                $att['time_spent'],
                '-',
                '-',
                $att['in_time'] ? 'PR' : 'AB'
            ];    
        }
        $exportData['list'] = $list;
        
        return $exportData;
    }
}
