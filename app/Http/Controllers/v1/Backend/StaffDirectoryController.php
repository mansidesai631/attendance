<?php



namespace App\Http\Controllers\v1\Backend;



use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Employee;

use DataTables;

use App\Models\Site;

use App\Models\Ward;

use App\Models\Department;

use App\Models\Designation;

use App\Models\StaffCategory;

use Validator;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;

use App\Models\Shift;

use App\Models\Role;

use App\Models\EmployeeWork;

use App\Models\Manager;

use Maatwebsite\Excel\Facades\Excel;

use App\Exports\UsersExport;

use App\Models\EmployeeOther;

use URL;

use App\Http\Requests\v1\Backend\StaffRequest;

use App\Models\EmployeeAccess;

use Illuminate\Support\Facades\Crypt;

use App\Models\Location;

use App\Imports\StaffImport;

use App\Jobs\SentEmailToCreatedEmployee;
use App\Jobs\SentSMSToCreatedEmployee;


class StaffDirectoryController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $user = Employee::find(Auth::id());



        $emp = Employee::with('work');



        $emp = $emp->whereHas('work', function($q1) use ($user) {

            $q1->where('base_site_id',$user->selected_site_id);

        });



        $sites = Site::all();



        $department = Department::with('createdBy');

        $department->whereHas('createdBy', function($q1) use ($user) {

            $q1->where('site_id',$user->selected_site_id);

        });

        $department = $department->get();



        $designation = Designation::with('createdBy');

        $designation->whereHas('createdBy', function($q1) use ($user) {

            $q1->where('site_id',$user->selected_site_id);

        });

        $designation = $designation->get();



        $category = StaffCategory::all();

        $activeEmp = $emp->where('status',1)->count();

        $inactiveEmp = $emp->where('status',0)->count();



        return view('staff-directory.index',compact('sites','department','designation','category','activeEmp','inactiveEmp','user'));

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        $sites = Site::all();

        $wards = Ward::all();

        $department = Department::all();

        $designation = Designation::all();

        $category = StaffCategory::all();

        $code = Employee::select('id')->orderBy('id','desc')->first();

        $shift = Shift::all();

        $roles = Role::all();

        $managers = Manager::all();

        $location = Location::all();

        return view('staff-directory.create',compact('sites','department','designation','category','code','shift','roles','managers','location','wards'));

    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(StaffRequest $request)

    {

        try{

            $input = $request->all();



            $emploee = new Employee();

            $emploee->name = @$request->name;

            $emploee->mobile = @$request->mobile;

            $emploee->email = @$request->email;

            $emploee->dob = ($request->dob) ?date('Y-m-d',strtotime($request->dob)) : NULL;

            $emploee->blood_group = @$request->blood_group;

            $emploee->id_type = @$request->id_type;

            $emploee->id_number = @$request->id_number;

            $emploee->second_id_type = @$request->second_id_type;

            $emploee->second_id_number = @$request->second_id_number;

            $emploee->gender = @$request->gender;

            $emploee->password = Hash::make('admin@123');

            $emploee->role_id = @$request->role;

            $emploee->user_type = 'Admin';

            $emploee->country_code = $request->country_code;

            $emploee->status = '0';

            $emploee->added_from = 'Normal';

            $emploee->invite_sent = '1';

            $emploee->created_by = Auth::id();

            $emploee->m_challan_allowed = ($request->m_challan_allowed == 'on')?'yes':'no';

            $emploee->field_report_allowed = ($request->monitoring_allowed == 'on')?'yes':'no';

            $emploee->allowed_other_emp_attendance = ($request->allow_other_emp_attendance == 'on')?'yes':'no';

            $emploee->selected_site_id = 1;



            if($emploee->save()){



                if($request->shift == 1){

                    $in_time = ($request->regular_in) ? date('H:i:s',strtotime($request->regular_in)) : NULL;

                    $out_time = ($request->regular_out) ? date('H:i:s',strtotime($request->regular_out)) : NULL;

                }else{

                    $shift = Shift::find($request->shift);

                    $in_time = date('H:i:s',strtotime($shift->start_time));

                    $out_time = date('H:i:s',strtotime($shift->end_time));

                }

                $empWorks = new EmployeeWork();

                $empWorks->employee_id = $emploee->id;

                $empWorks->emp_code = @$request->employee_code;

                $empWorks->staff_category_id  = @$request->staff_category;

                $empWorks->joining_date = ($request->joining_date) ?date('Y-m-d',strtotime($request->joining_date)) : NULL;

                $empWorks->deactivate_date = ($request->deactive_date) ?date('Y-m-d',strtotime($request->deactive_date)) : NULL;

                $empWorks->designation_id = @$request->designation;

                $empWorks->department_id = @$request->department;

                $empWorks->manager = @$request->manager;

                $empWorks->in_time = $in_time;

                $empWorks->out_time = $out_time;

                $empWorks->pf_number = @$request->pf_number;

                $empWorks->esic_number = @$request->esic_number;

                $empWorks->uan_number = @$request->uan_number;

                $empWorks->weekly_off = ($request->weekoff) ? '1' : '0';

                $empWorks->leave_approvers = @$request->leave_approvers;

                $empWorks->employee_document_type = @$request->staff_document;

                $empWorks->employee_document_expires = ($request->staff_doc_expire_on) ?date('Y-m-d H:i:s',strtotime($request->staff_doc_expire_on)) : NULL;

                $empWorks->base_site_id = $request->site;

                $empWorks->ward_id = $request->ward;

                $empWorks->employee_type = 'Permanent';

                $empWorks->staff_type_id = @$request->staff_category;

                $empWorks->shift_type_id = @$request->shift;

                $empWorks->created_by = Auth::id();

                if(isset($request->staff_doc)){

                    $filepath  = $request->staff_doc;

                    $filepathName = 'Employee-'.$request->staff_type.time().'.'. $filepath->getClientOriginalExtension();

                    $filepath->move(storage_path('app/public/employee/'), $filepathName);

                    $empWorks->employee_document_file = $filepathName;

                }

                $empWorks->save();



                $empOther = new EmployeeOther();

                $empOther->employee_id = $emploee->id;

                $empOther->bank_name = @$request->bank_name;

                $empOther->account_name = @$request->staff_name;

                $empOther->account_number = @$request->account_number;

                $empOther->account_type = @$request->account_type;

                $empOther->ifsc_code = @$request->ifsc_code;

                $empOther->micr_code = @$request->micr_code;

                $empOther->swift_code = @$request->swift_code;

                $empOther->father_name = @$request->father_name;

                $empOther->permanent_address = @$request->permenent_address;

                $empOther->communication_address = @$request->communication_address;

                $empOther->created_by = Auth::id();

                $empOther->save();



                $empAccess = new EmployeeAccess();

                $empAccess->employee_id = $emploee->id;

                $empAccess->ad_from_kiosk = @$request->attendance_kiosk;

                $empAccess->allow_from_user_app = ($request->allow_from_user_app == 'on')?1:0;

                $empAccess->ad_anywhere = ($request->inlineRadioOptions == 'ad_anywhere')?1:0;

                $empAccess->ad_allowed_location = ($request->inlineRadioOptions == 'ad_location')?1:0;;

                $empAccess->attendance_location_id = @$request->attendance_location;

                $empAccess->additional_site_access = @$request->additional_site_access;

                $empAccess->user_can_be_added_as_manager = ($request->user_can_be_added_as_manager == 'on')?1:0;

                $empAccess->manager_approval_for_each_attendance = ($request->manager_approval_for_each_attendance == 'on')?1:0;

                $empAccess->invite_user = ($request->invite_user == 'on')?1:0;

                $empAccess->created_by = Auth::id();

                $empAccess->save();

                if ($emploee->id) {
                    $data = [];
                    $data['name'] = $emploee->name;
                    $data['user_number'] = $emploee->mobile;
                    $data['email'] = $emploee->email;
                    $data['password'] = 'admin@123';
                    //send sms
                    // if ($emploee->mobile) {
                    //     SentSMSToCreatedEmployee::dispatch($data);
                    // }
                    //send mail
                    if ($emploee->email) {
                        SentEmailToCreatedEmployee::dispatch($data);
                    }
                }
            }

            return redirect()->route('staff-directory.index')->with('success','New Employee has been added successfully');

        }catch(Exception $e){

            session()->flash('error',$e->getMessage());

            return back()->withInput();

        }

    }



    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {

        $employees = Employee::with("role","work",'other',"work.department",'work.designation','work.category','work.site','work.managers')->where('id',$id)->first();

        $url = URL::to('/').'/storage/profile/'.''.$employees->image;

        return response()->json(['status' => true,'employees' => $employees,'url'=>$url]);

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $sites = Site::all();

        $wards = Ward::all();

        $department = Department::all();

        $designation = Designation::all();

        $category = StaffCategory::all();

        $shift = Shift::all();

        $roles = Role::all();

        $managers = Manager::all();

        $location = Location::all();

        $employees = Employee::with("role","work","access","work.department",'work.designation','work.category','work.site','work.managers')->where('id',$id)->first();

        return view('staff-directory.edit',compact('employees','sites','department','designation','category','shift','roles','managers','location','wards'));

    }



    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, $id)

    {

        try{

            $validator = Validator::make($request->all(), [
                'name'=>'required',
                'mobile' => 'required|unique:employees,mobile,'.$id,
                'email' => 'required|email|unique:employees,email,'.$id,
            ]);

            if($validator->fails()){
                return $this->handleError($validator->errors());
            }

            $input = $request->all();



            $emploee = Employee::find($id);

            $emploee->name = @$request->name;

            $emploee->mobile = @$request->mobile;

            $emploee->email = @$request->email;

            $emploee->dob = ($request->dob) ?date('Y-m-d',strtotime($request->dob)) : NULL;

            $emploee->blood_group = @$request->blood_group;

            $emploee->id_type = @$request->id_type;

            $emploee->id_number = @$request->id_number;

            $emploee->second_id_type = @$request->second_id_type;

            $emploee->second_id_number = @$request->second_id_number;

            $emploee->gender = @$request->gender;

            $emploee->password = Hash::make('admin@123');

            $emploee->role_id = @$request->role;

            $emploee->user_type = 'Admin';

            $emploee->country_code = $request->country_code;

            $emploee->status = '1';

            $emploee->added_from = 'Normal';

            $emploee->invite_sent = '1';

            $emploee->created_by = Auth::id();

            $emploee->m_challan_allowed = ($request->m_challan_allowed == 'on')?'yes':'no';

            $emploee->field_report_allowed = ($request->monitoring_allowed == 'on')?'yes':'no';

            $emploee->allowed_other_emp_attendance = ($request->allow_other_emp_attendance == 'on')?'yes':'no';



            if($emploee->save()){



                $delete = EmployeeWork::where('employee_id',$emploee->id)->delete();

                $deleteOthers = EmployeeOther::where('employee_id',$emploee->id)->delete();

                $deleteaccess = EmployeeAccess::where('employee_id',$emploee->id)->delete();



                if($request->shift == 1){

                    $in_time = ($request->regular_in) ? date('H:i:s',strtotime($request->regular_in)) : NULL;

                    $out_time = ($request->regular_out) ? date('H:i:s',strtotime($request->regular_out)) : NULL;

                }else{

                    $shift = Shift::find($request->shift);

                    $in_time = date('H:i:s',strtotime($shift->start_time));

                    $out_time = date('H:i:s',strtotime($shift->end_time));

                }



                $empWorks = new EmployeeWork();

                $empWorks->employee_id = $emploee->id;

                $empWorks->emp_code = @$request->employee_code;

                $empWorks->staff_category_id  = @$request->staff_category;

                $empWorks->joining_date = ($request->joining_date) ?date('Y-m-d',strtotime($request->joining_date)) : NULL;

                $empWorks->deactivate_date = ($request->deactive_date) ?date('Y-m-d',strtotime($request->deactive_date)) : NULL;

                $empWorks->designation_id = @$request->designation;

                $empWorks->department_id = @$request->department;

                $empWorks->manager = @$request->manager;

                $empWorks->in_time = $in_time;

                $empWorks->out_time = $out_time;

                $empWorks->pf_number = @$request->pf_number;

                $empWorks->esic_number = @$request->esic_number;

                $empWorks->uan_number = @$request->uan_number;

                $empWorks->weekly_off = ($request->weekoff) ? '1' : '0';

                $empWorks->leave_approvers = @$request->leave_approvers;

                $empWorks->employee_document_type = @$request->staff_document;

                $empWorks->employee_document_expires = ($request->staff_doc_expire_on) ?date('Y-m-d H:i:s',strtotime($request->staff_doc_expire_on)) : NULL;

                $empWorks->base_site_id = $request->site;

                $empWorks->ward_id = $request->ward;

                $empWorks->employee_type = 'Permanent';

                $empWorks->staff_type_id = @$request->staff_category;

                $empWorks->shift_type_id = @$request->shift;

                $empWorks->created_by = Auth::id();

                if(isset($request->staff_doc) && $request->staff_doc != NULL){

                    if(isset($empWorks->employee_document_file) && $empWorks->employee_document_file!=''){

                        $filePath = storage_path('app/public/employee/').''.$empWorks->employee_document_file;

                        if(file_exists($filePath)){

                            unlink($filePath);

                        }

                    }



                    $filepath  = $request->staff_doc;

                    $filepathName = 'Employee-'.$request->staff_type.time().'.'. $filepath->getClientOriginalExtension();

                    $filepath->move(storage_path('app/public/employee/'), $filepathName);

                    $empWorks->employee_document_file = $filepathName;

                }

                $empWorks->save();



                $empOther = new EmployeeOther();

                $empOther->employee_id = $emploee->id;

                $empOther->bank_name = @$request->bank_name;

                $empOther->account_name = @$request->staff_name;

                $empOther->account_number = @$request->account_number;

                $empOther->account_type = @$request->account_type;

                $empOther->ifsc_code = @$request->ifsc_code;

                $empOther->micr_code = @$request->micr_code;

                $empOther->swift_code = @$request->swift_code;

                $empOther->father_name = @$request->father_name;

                $empOther->permanent_address = @$request->permenent_address;

                $empOther->communication_address = @$request->communication_address;

                $empOther->updated_by = Auth::id();

                $empOther->save();



                $empAccess = new EmployeeAccess();

                $empAccess->employee_id = $emploee->id;

                $empAccess->ad_from_kiosk = @$request->attendance_kiosk;

                $empAccess->allow_from_user_app = ($request->allow_from_user_app == 'on')?1:0;

                $empAccess->ad_anywhere = ($request->inlineRadioOptions == 'ad_anywhere')?1:0;

                $empAccess->ad_allowed_location = ($request->inlineRadioOptions == 'ad_location')?1:0;;

                $empAccess->attendance_location_id = @$request->attendance_location;

                $empAccess->additional_site_access = @$request->additional_site_access;

                $empAccess->user_can_be_added_as_manager = ($request->user_can_be_added_as_manager == 'on')?1:0;

                $empAccess->manager_approval_for_each_attendance = ($request->manager_approval_for_each_attendance == 'on')?1:0;

                $empAccess->invite_user = ($request->invite_user == 'on')?1:0;

                $empAccess->created_by = Auth::id();

                $empAccess->save();

            }



            return redirect()->route('staff-directory.index')->with('success','Employee has been updated successfully');



            if($validator->fails()) {

                return back()->withInput()->withErrors($validator->errors());

            }

        }catch(Exception $e){

            session()->flash('error',$e->getMessage());

            return back()->withInput();

        }

    }



    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        $employee = Employee::find($id);

        $empWorks = EmployeeWork::where('employee_id',$employee->id)->first();

        if(isset($empWorks->employee_document_file) && $empWorks->employee_document_file!=''){

            $filePath = storage_path('app/public/employee/').''.$empWorks->employee_document_file;

            if(file_exists($filePath)){

                unlink($filePath);

            }

        }

        $delete  = Employee::where('id',$employee->id)->delete();

        $delete_works = EmployeeWork::where('employee_id',$employee->id)->delete();

        $delete_others = EmployeeOther::where('employee_id',$employee->id)->delete();

        $delete_access = EmployeeAccess::where('employee_id',$employee->id)->delete();

        return response()->json(['status' => true,'message' => 'Status has been activated','data'=>$employee->name]);



    }



    public function getAllStaff(Request $request){

        $user = Employee::find(Auth::id());

        $data = Employee::with("role","work","work.department",'work.designation','work.managers','work.site');



        $data->whereHas('work', function($q1) use ($user) {

            $q1->where('base_site_id',$user->selected_site_id);

        });



        if($request->filter_search != ""){

            $data->where(function($q) use ($request) {

                $q->orwhere('name','LIKE',"%".$request->filter_search."%");

                $q->orwhere('mobile','LIKE',"%".$request->filter_search."%");

                $q->orwhere('id','LIKE',"%".$request->filter_search."%");



                $q->orwhereHas('work.department', function($q1) use ($request) {

                    $q1->where('name','LIKE',"%".$request->filter_search."%");

                });



                $q->orwhereHas('work.designation', function($q2) use ($request) {

                    $q2->where('name','LIKE',"%".$request->filter_search."%");

                });



                $q->orwhereHas('work.manager', function($q3) use ($request) {

                    $q3->where('name','LIKE',"%".$request->filter_search."%");

                });



                $q->orwhereHas('role', function($q4) use ($request) {

                    $q4->where('name','LIKE',"%".$request->filter_search."%");

                });

            });

        }

        if($request->filter_site != ""){

            if($request->filter_site != 'All'){

                $data->where(function($q1) use ($request) {

                    $q1->whereHas('work', function($q2) use ($request) {

                        $q2->where('base_site_id',$request->filter_site);

                    });

                });

            }else{

                $data->where(function($q1) use ($request) {

                    $q1->whereHas('work', function($q2) use ($request) {

                        $sites = Site::pluck('id')->toArray();

                        $q2->whereIn('base_site_id',$sites);

                    });

                });

            }

        }



        if($request->filter_department != ""){

           if(in_array('All', $request->filter_department)){

                $data->where(function($q1) use ($request) {

                    $q1->whereHas('work', function($q2) use ($request) {

                        $department = Department::pluck('id')->toArray();

                        $q2->whereIn('department_id',$department);

                    });

                });

           }else{

                $data->where(function($q1) use ($request) {

                    $q1->whereHas('work', function($q2) use ($request) {

                        $q2->whereIn('department_id',$request->filter_department);

                    });

                });

           }

        }



        if($request->filter_designation != ""){

           if(in_array('All', $request->filter_designation)){

                $data->where(function($q1) use ($request) {

                    $q1->whereHas('work', function($q2) use ($request) {

                        $designation = Designation::pluck('id')->toArray();

                        $q2->whereIn('designation_id',$designation);

                    });

                });

           }else{

                $data->where(function($q1) use ($request) {

                    $q1->whereHas('work', function($q2) use ($request) {

                        $q2->whereIn('designation_id',$request->filter_designation);

                    });

                });

           }

        }



        if($request->filter_category != ""){

           if(in_array('All', $request->filter_category)){

                $data->where(function($q1) use ($request) {

                    $q1->whereHas('work', function($q2) use ($request) {

                        $category = StaffCategory::pluck('id')->toArray();

                        $q2->whereIn('staff_category_id',$category);

                    });

                });

           }else{

                $data->where(function($q1) use ($request) {

                    $q1->whereHas('work', function($q2) use ($request) {

                        $q2->whereIn('staff_category_id',$request->filter_category);

                    });

                });

           }

        }



        if($request->filters != ""){

           if($request->filters != 'All'){

                if($request->filters == 'active'){

                    $data->where(function($q1) use ($request) {

                        $q1->where('status',1);

                    });

                }

                else if($request->filters == 'deactivated'){

                    $data->where(function($q1) use ($request) {

                        $q1->where('status',0);

                    });

                }

            }

        }





        $data->when(!isset($request->order), function ($q) {

            $q->orderBy('id', 'desc');

        });

        return DataTables::of($data)

            ->addIndexColumn()

            ->addColumn('checkbox',function($row){

                $html = '<div class="form-check mt-2 ms-3" id="staff_'.$row->id.'"><input class="form-check-input chk" type="checkbox" value="'.$row->id.'" id="checkone" name="staff_checkbox"/><label class="form-check-label" for="checkone" ></label></div>';

                return $html;

            })

            ->addColumn('name',function($row){

                $url = URL::to('/').'/storage/profile/'.''.$row->image;

                $html = '';

                $html .= '<div class="name-row">

                        <div class="cricle-img position-relative">

                            <div class="avatar-container">';

                            if($row->image != ""){

                                $html.= '<a href="javascript:" data-mdb-toggle="modal" data-mdb-target="#name-avtar-img" class="name-avtar-img  d-block h-100 w-100" data-url="' . route('staff-directory.show',($row->id)) . '"><div class="avatar-content  d-block h-100 w-100" style="background: url('.$url.');background-size:cover;"></div>

                              </a>';

                            }else{

                                $html.= '<a href="javascript:"><div class="avatar-content" style="background-color: #d35400;">'.strtoupper(substr($row->name, 0, 1)).'</div>

                              </a>';

                            }



                $html .='</div>

                        </div>

                        <div class="name-text">

                          <div class="d-flex w-100">

                            <div>

                                <a href="javascript:" data-mdb-toggle="modal" data-mdb-target="#employee-details" data-url="' . route('staff-directory.show',($row->id)) . '" class="emp_details">

                                  <span>'.$row->name.'</span>

                                </a>

                            </div>

                          </div>

                        </div>

                      </div>';

                return $html;

            })

            ->addColumn('role_id', function($row) {

                return @$row->role->name ?? '-';

            })

            ->addColumn('manager', function($row) {

                return @$row->work->managers->name ?? '-';

            })

            ->addColumn('designation', function($row) {

                return @$row->work->designation->name ?? '-';

            })

            ->addColumn('department', function($row) {

                return @$row->work->department->name ?? '-';

            })

            ->addColumn('joining_date', function($row) {

                return ($row->work->joining_date)?date('l, M d, Y',strtotime(@$row->work->joining_date)):'-';

            })

            ->addColumn('deactivate_date', function($row) {

                return ($row->work->deactivate_date != NULL)?date('l, M d, Y',strtotime(@$row->work->deactivate_date)) :'-';

            })

            ->addColumn('contractor', function($row) {

                return @$row->work->site->name ?? '-';

            })

            ->addColumn('action', function($row) {

                $btn = "";

                $btn .= '<button type="button" class="btn btn-link hidden-arrow btn-sm px-2 text-body"

                          data-mdb-toggle="dropdown" aria-expanded="false">

                          <mat-icon class="mat-icon material-icons" aria-hidden="true">more_vert</mat-icon>

                        </button>

                        <ul class="dropdown-menu">

                          <li>

                            <a class="dropdown-item d-flex align-items-center" href="'.route('staff-directory.edit',$row->id).'">

                              <mat-icon role="img" class="mat-icon material-icons" aria-hidden="true">edit</mat-icon>

                              <span class="ms-3">Edit</span>

                            </a>

                          </li>';

                if($row->status == 1){

                    $btn  .= '<li>

                            <a class="dropdown-item d-flex align-items-center deactivate_user" href="#" data-mdb-toggle="modal" data-mdb-target="#deactivate" data-id="'.$row->id.'">

                              <mat-icon role="img" class="mat-icon material-icons" aria-hidden="true">lock</mat-icon>

                              <span class="ms-3">Deactivate</span>

                            </a>

                          </li>';

                }else{

                     $btn  .= '<li>

                            <a class="dropdown-item d-flex align-items-center activate_user" href="#" data-id="'.$row->id.'" data-val="activate">

                              <mat-icon role="img" class="mat-icon material-icons" aria-hidden="true">lock_open</mat-icon>

                              <span class="ms-3">Activate</span>

                            </a>

                          </li>';

                }

                $btn  .= '<li>

                            <a class="dropdown-item d-flex align-items-center delete" href="javascript:void(0)" data-id="' . $row->id . '" data-mdb-toggle="modal" data-mdb-target="#delete_employee" data-url="'.route('staff-directory.destroy',$row->id).'">

                              <mat-icon role="img" class="mat-icon material-icons" aria-hidden="true">delete</mat-icon>

                              <span class="ms-3">Delete</span>

                            </a>

                          </li>';

                $btn .='</ul>';

                return $btn;

            })

            ->orderColumn('id', function ($query, $order) {

                $query->orderBy('id', $order);

            })

            ->rawColumns(['checkbox','name','action'])

            ->make(true);

    }



    public function profile(Request $request)

    {

        $emp = Employee::with('role')->where('id', Auth::id())->first();

        // dd($emp);

        return view('profile', ['emp' => $emp]);

    }



    public function profileSave(Request $request)

    {

        $request->validate([

            'name' =>'required|string|max:255',

        ]);

        $id = Auth::id();

        $emp =Employee::find($id);

        $emp->name = $request->name;

        if(isset($request->profile_file) && $request->profile_file != NULL){

            if(isset($emp->image) && $emp->image!=''){

                $filePath = storage_path('app/public/profile/').''.$emp->image;

                if(file_exists($filePath)){

                    unlink($filePath);

                }

            }



            $filepath  = $request->profile_file;

            $filepathName = 'Profile-'.$request->staff_type.time().'.'. $filepath->getClientOriginalExtension();

            $filepath->move(storage_path('app/public/profile/'), $filepathName);

            $emp->image = $filepathName;

        }

        $emp->save();

        return response()->json(['status' => true,'message' => 'Employee updated successfully!']);

    }



    public function changeStatus(Request $request){

        $employee = Employee::find($request->id);

        $employee->status = $request->status;

        if($request->status == 0){

            $employee->deactive_reason = $request->reason;

        }else{

            $employee->deactive_reason = '';

        }

        $employee->save();

        return response()->json(['status' => true,'message' => 'Status has been activated','data'=>$employee->name]);

    }



    public function changeAllStatus(Request $request){



        foreach($request->ids as $id){

            $employee = Employee::find($id);

            $employee->status = $request->status;

            if($request->status == 0){

                $employee->deactive_reason = $request->reason;

            }

            $employee->save();

        }

        return response()->json(['status' => true,'message' => 'Employees successfully deavtivated!']);

    }



    public function deleteAll(Request $request){

        foreach($request->ids as $id){

            $employee = Employee::find($id);

            if($employee->status == 0){

                $employee->delete_reason = $request->reason;

                $empWorks = EmployeeWork::where('employee_id',$employee->id)->first();

                if(isset($empWorks->employee_document_file) && $empWorks->employee_document_file!=''){

                    $filePath = storage_path('app/public/employee/').''.$empWorks->employee_document_file;

                    if(file_exists($filePath)){

                        unlink($filePath);

                    }

                }

                $delete  = Employee::where('id',$employee->id)->delete();

                $delete_works = EmployeeWork::where('employee_id',$employee->id)->delete();

                $delete_others = EmployeeOther::where('employee_id',$employee->id)->delete();

                $delete_access = EmployeeAccess::where('employee_id',$employee->id)->delete();

            }



            $employee->save();

        }

        return response()->json(['status' => true,'message' => 'Employees successfully deleted!']);

    }



    public function staffExport(Request $request){

        try{



            $data = Employee::with("role","work","work.department",'work.designation','work.managers');



            if($request->filter_search_export != ""){

                $data->where(function($q) use ($request) {

                    $q->orwhere('name','LIKE',"%".$request->filter_search_export."%");

                    $q->orwhere('mobile','LIKE',"%".$request->filter_search_export."%");

                    $q->orwhere('id','LIKE',"%".$request->filter_search_export."%");



                    $q->orwhereHas('work.department', function($q1) use ($request) {

                        $q1->where('name','LIKE',"%".$request->filter_search_export."%");

                    });



                    $q->orwhereHas('work.designation', function($q2) use ($request) {

                        $q2->where('name','LIKE',"%".$request->filter_search_export."%");

                    });



                    $q->orwhereHas('work.manager', function($q3) use ($request) {

                        $q3->where('name','LIKE',"%".$request->filter_search_export."%");

                    });



                    $q->orwhereHas('role', function($q4) use ($request) {

                        $q4->where('name','LIKE',"%".$request->filter_search_export."%");

                    });

                });

            }

            if($request->filter_site_export != ""){

                if($request->filter_site_export != 'All'){

                    $data->where(function($q1) use ($request) {

                        $q1->whereHas('work', function($q2) use ($request) {

                            $q2->where('base_site_id',$request->filter_site_export);

                        });

                    });

                }else{

                    $data->where(function($q1) use ($request) {

                        $q1->whereHas('work', function($q2) use ($request) {

                            $sites = Site::pluck('id')->toArray();

                            $q2->whereIn('base_site_id',$sites);

                        });

                    });

                }

            }



            if($request->filter_department_export != ""){

               if(in_array('All', $request->filter_department_export)){

                    $data->where(function($q1) use ($request) {

                        $q1->whereHas('work', function($q2) use ($request) {

                            $department = Department::pluck('id')->toArray();

                            $q2->whereIn('department_id',$department);

                        });

                    });

               }else{

                    $data->where(function($q1) use ($request) {

                        $q1->whereHas('work', function($q2) use ($request) {

                            $q2->whereIn('department_id',$request->filter_department_export);

                        });

                    });

               }

            }



            if($request->filter_designation_export != ""){

               if(in_array('All', $request->filter_designation_export)){

                    $data->where(function($q1) use ($request) {

                        $q1->whereHas('work', function($q2) use ($request) {

                            $designation = Designation::pluck('id')->toArray();

                            $q2->whereIn('designation_id',$designation);

                        });

                    });

               }else{

                    $data->where(function($q1) use ($request) {

                        $q1->whereHas('work', function($q2) use ($request) {

                            $q2->whereIn('designation_id',$request->filter_designation_export);

                        });

                    });

               }

            }



            if($request->filter_category_export != ""){

               if(in_array('All', $request->filter_category_export)){

                    $data->where(function($q1) use ($request) {

                        $q1->whereHas('work', function($q2) use ($request) {

                            $category = StaffCategory::pluck('id')->toArray();

                            $q2->whereIn('staff_category_id',$category);

                        });

                    });

               }else{

                    $data->where(function($q1) use ($request) {

                        $q1->whereHas('work', function($q2) use ($request) {

                            $q2->whereIn('staff_category_id',$request->filter_category_export);

                        });

                    });

               }

            }



            if($request->filter_filters_export != ""){

               if($request->filter_filters_export != 'All'){

                    if($request->filter_filters_export == 'active'){

                        $data->where(function($q1) use ($request) {

                            $q1->where('status',1);

                        });

                    }

                    else if($request->filter_filters_export == 'deactivated'){

                        $data->where(function($q1) use ($request) {

                            $q1->where('status',0);

                        });

                    }

                }

            }



            $data = $data->get();

            $exportData = array();

            if(count($data) > 0){



                $count = 0;

                foreach($data as $ke=>$value){

                    $exportData[$count]['name'] = @$value->name;

                    $exportData[$count]['employee_id'] = @$value->id;

                    $exportData[$count]['mobile'] = @$value->mobile;

                    $exportData[$count]['manager'] = @$value->work->managers->name;

                    $exportData[$count]['contractor'] = @$value->work->site->name;

                    $exportData[$count]['designation'] = @$value->work->designation->name;

                    $exportData[$count]['department'] = @$value->work->department->name;

                    $exportData[$count]['joining_date'] = date('l, M d, Y',strtotime(@$value->work->joining_date));

                    $exportData[$count]['deactivate_date'] = date('l, M d, Y',strtotime(@$value->work->deactivate_date));

                    $exportData[$count]['role'] = @$value->role->name;

                    $count++;

                }



                $name = 'staff_'.date('d_m_Y_H_i_s').'.xlsx';

                return Excel::download(new UsersExport($exportData), 'export.csv');

            }else{

                return false;

            }

        }catch (\Exception $ex){

            return redirect()->route('staff-directory.index')->with('error',$ex->getMessage());

        }



    }



    public function checkStatus(Request $request){

        $Totalcount = count($request->ids);

        $active = 0;

        $inactive = 0;

        foreach($request->ids as $id){

            $employee = Employee::find($id);

            if($employee->status == 0){

                $inactive++;

            }else{

                $active++;

            }

        }



        if($Totalcount == $inactive){

            return response()->json(['status' => 0,'message' => 'All selected '.$Totalcount.' employees already deactivated!']);

        }else if($Totalcount == $active){

            return response()->json(['status' => 1,'message' => 'Total '.$Totalcount.' employees will be deactivated!']);

        }else{

            return response()->json(['status' => 2,'message' => 'Total '.$Totalcount.' employees selected of which '.$inactive.' are already deactive. Remaining '.$active.' will be deactivated!']);

        }

    }



    public function checkDeactiveStatus(Request $request){

        $Totalcount = count($request->ids);

        $active = 0;

        $inactive = 0;

        foreach($request->ids as $id){

            $employee = Employee::find($id);

            if($employee->status == 0){

                $inactive++;

            }else{

                $active++;

            }

        }



        if($Totalcount == $active){

            return response()->json(['status' => 0,'message' => 'All selected '.$Totalcount.' employees are active. Only deactivated employees can be deleted!']);

        }else if($Totalcount == $inactive){

            return response()->json(['status' => 1,'message' => 'All selected '.$Totalcount.' employees will be deleted!']);

        }else{

            return response()->json(['status' => 2,'message' => 'Total '.$Totalcount.' employees selected of which '.$active.' are still active. Remaining '.$inactive.' deactivated employees will be deleted!']);

        }

    }



    public function getShiftTime(Request $request){

        $shift = Shift::find($request->id);

        $in = date('h:i A',strtotime($shift->start_time));

        $out = date('h:i A',strtotime($shift->end_time));

        return response()->json(['status' => true,'in'=>$in,'out'=>$out,'shift'=>$shift]);

    }



    public function checkNumber(Request $request){

        $employee = Employee::where('mobile',$request->mobile)->first();

        if($employee){

            return response()->json(['status' => true]);

        }else{

            return response()->json(['status' => false]);

        }



    }



    public function print(){

        $route = URL::current();

        $string = explode("print/", $route);

        $ids = explode(",", $string[1]);

        $employees = Employee::with("role","work","access","work.department",'work.designation','work.category','work.site','work.managers')->whereIn('id',$ids)->get();

        return view('staff-directory.print',compact('employees'));

    }



    public function importStaff(Request $request)

    {



        Excel::import(new StaffImport, request('import_file'));

        return response()->json(['status' => true]);

    }

}

