 @extends('layouts.master')

@section('title','Staff List')
@section('content')
<!--Main layout-->
  <main class="content-body">
    <div class="page-body">
      <div class="row mb-4 ">
        <div class=" col-md-2 col-6 col-sm-4 ">
           <div class="small-box mb-0 bg-success text-white h-100">
              <div class="inner">
                <div class="dashboardbx-left">
                    <h3>{{$activeEmp}}</h3>
                    <p>Total Active</p>
                </div>
                <div class="dashboardbx-right">
                    <span class="stafficon"><i class="fas fa-user-plus"></i></span>
                </div>
              </div>
            </div>
        </div>
        <div class="col-md-2 col-6 col-sm-4 ">
          <div class="small-box mb-0 bg-danger text-white h-100">
              <div class="inner">
                <div class="dashboardbx-left">
                    <h3>{{$inactiveEmp}}</h3>
                    <p>Deactivated</p>
                </div>
                <div class="dashboardbx-right">
                    <span class="stafficon"><i class="fas fa-user-slash"></i></span>
                </div>
              </div>
            </div>
        </div>
        </div>
        <!-- <div class="col-md-2 col-6 col-sm-4 ">
          <div class="card stat-card p-2 stat-card-primary">
            <div class="d-flex "><span class="main-stat mr-3 ">1</span></div><span class="title ">Signed up
              User-app</span>
          </div>
        </div>
        <div class="col-md-2 col-6 col-sm-4 ">
          <div class="card stat-card p-2 stat-card-cyan">
            <div class="d-flex "><span class="main-stat mr-3 ">0</span></div><span class="title ">User-app Attendance
              Access</span>
          </div>
        </div>
        <div class="col-md-2 col-6 col-sm-4 ">
          <div class="card stat-card p-2 stat-card-primary">
            <div class="d-flex "><span class="main-stat mr-3 ">0</span></div><span class="title ">Signup Pending</span>
          </div>
        </div>
        <div class="col-md-2 col-6 col-sm-4 ">
          <div class="card stat-card p-2 stat-card-danger">
            <div class="d-flex "><span class="main-stat mr-3 ">0</span></div><span class="title ">Not Invited</span>
          </div>
        </div> -->
      </div>
      <div class="card">
        <div class="card-header">
          <div class="d-flex align-items-baseline ">
            <div class="d-flex flex-column ">
              <h5>Staff Directory</h5>
            </div>
            <div class="card-header-right">
            <div class="cloud_download button-toolbar">
                  <button class="btn btn-outline-primary rn export" id="cloud_download">
                      <mat-icon role="img" aria-label="add-member" class="mat-icon primary material-icons" aria-hidden="true">cloud_download</mat-icon>
                  </button>
                </div>
            </div>
            
          </div>
         
        </div>
        <div class="card-block-hid">
          <div class="card-block p-3">
            <div class="row mb-3">
              <div class="col-md-6 button-toolbar ">
                <div class="person_add">
                  <button class="btn btn-outline-primary rn" id="add_staff">
                      <mat-icon role="img" aria-label="add-member" class="mat-icon primary material-icons" aria-hidden="true"><a href="{{route('staff-directory.create')}}">person_add</a></mat-icon>
                  </button>
                </div>
                <div class="cloud_upload">
                  <button class="btn btn-outline-primary rn"  type="button" id="cloud-upload" data-mdb-toggle="dropdown" aria-expanded="false">
                      <mat-icon role="img" aria-label="add-member" class="mat-icon primary material-icons" aria-hidden="true">cloud_upload</mat-icon>
                  </button>
                  <ul class="dropdown-menu" aria-labelledby="cloud-upload">
                    <li><a class="dropdown-item" data-mdb-toggle="modal" data-mdb-target="#import_user" id="import_user_button" href="javascript():;">Bulk upload - New staff</a></li>
                    <!-- <li><a class="dropdown-item" href="#">Bulk edit - Existing staff</a></li> -->
                  </ul>
                </div>
                <div>
                  <button class="btn btn-outline-primary rn" id="print_btn" style="display: none;">
                    <mat-icon role="img" aria-label="add-member" class="mat-icon primary material-icons"
                      aria-hidden="true">print</mat-icon>
                  </button>
                </div>
                <!-- <div class="view-roles">
                  <button class="btn btn-link text-body text-decoration-underline ripple-surface" data-mdb-toggle="modal" data-mdb-target="#view-roles">View Roles</button>
                </div>  -->                
                <div class="button-toolbar-wrap">
                  <!-- <button class="btn btn-outline-primary" data-mdb-toggle="modal" data-mdb-target="#roll-out" id="roll_out_staff">Roll-out</button> -->
                  <button class="btn btn-outline-primary" id="bulk_deactivate" style="display: none">Bulk deactivate</button>
                  <button class="btn btn-outline-primary" id="bulk_delete" style="display: none">Bulk delete</button>
                 </div>
              </div>
              <div class="col-md-6 site-filter-container staff-filters">
                <div class="row mb-3 g-2">
                  <div class="col-3"></div>
                  <div class="col-3">
                    <div class="filter ">
                      <button type="button" class="btn btn-link d-flex align-items-center px-3 text-body mt-2 text-capitalize" data-mdb-ripple-color="dark" id="more_filter_btn">
                        <div class="me-2"><span id="custom_filter_span">More</span> Filters </div><mat-icon role="img" class="mat-icon material-icons" aria-hidden="true"><span id="add_remove_icon">add</span></mat-icon>
                        <!-- remove -->
                      </button>                      
                    </div>
                  </div>
                  <div class="col-3">
                    <div class="">
                      <label>Select Zone</label>
                      <select name="site" id="site">
                        <option value="All">All</option>
                        @foreach($sites as $site)
                          <option value="{{$site->id}}" {{($site->id == $user->selected_site_id)?'selected':''}}>{{$site->name}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-3">
                    <div class="form-outline mt-3 pt-1">
                      <input type="text" id="filter_search" class="form-control" />
                      <label class="form-label" for="filter_search" id="typeText">Search</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-12 custom_staff_filters" style="display: none">
                  <div class="row">
                      <div class="col-6"></div>
                      <div class="col-6 staff-filters">
                          <div class="row g-2">
                            <div class="col-3">
                              <label>Department</label>
                              <select name="department[]" multiple id="department">
                                <option value="All">All</option>
                                @foreach($department as $dep)
                                  <option value="{{$dep->id}}">{{$dep->name}}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="col-3">
                              <label>Designation</label>
                              <select name="designation[]" multiple id="designation">
                                <option value="All">All</option>
                                @foreach($designation as $des)
                                  <option value="{{$des->id}}">{{$des->name}}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="col-3">
                              <label>Category</label>
                              <select name="category[]" multiple id="category">
                                <option value="All">All</option>
                                @foreach($category as $cat)
                                  <option value="{{$cat->id}}">{{$cat->name}}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="col-3">
                              <label>Filters</label>
                              <select name="filters" id="filters">
                                <option value="All">All</option>
                                <option value="active">Active</option>
                                <option value="deactivated">Deactivated</option>
                                <!-- <option value="face_registered">Face Registered</option>
                                <option value="pending_face_registered">Pending face Registration</option> -->
                              </select>
                            </div>
                           
                          </div>
                      </div>
                  </div>
                  
              </div>
            </div>
            @include('layouts.flash-message')
            <div class="datatable">
              <table class="staff-listing table table-bordered border-bottom" id="staff_table">
                <thead>
                  <tr>
                    <th class="th-sm pe-2">
                      <div class="form-check mt-2 ms-3">
                        <input class="form-check-input" type="checkbox" value="" id="checkall" />
                        <label class="form-check-label" for="checkall"></label>
                      </div>
                    </th>
                    <th class="th-sm">Name</th>
                    <th class="th-sm">Employee Id  </th>
                    <th class="th-sm">Mobile </th>
                    <th class="th-sm">Manager</th>
                    <th class="th-sm">Contractor</th>
                    <th class="th-sm">Designation</th>
                    <th class="th-sm">Department</th>
                    <th class="th-sm">Joining Date</th>
                    <th class="th-sm">Auto Deactivate Staff on</th>
                    <th class="th-sm">Role</th>
                    <th width="80" class="th-sm action-th">Action</th>
                  </tr>
                </thead>
                <tbody>
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </main>
  <input type="hidden" name="filter_search_export" id="filter_search_export">
  <input type="hidden" name="filter_site_export" id="filter_site_export">
  <input type="hidden" name="filter_department_export" id="filter_department_export">
  <input type="hidden" name="filter_designation_export" id="filter_designation_export">
  <input type="hidden" name="filter_category_export" id="filter_category_export">
  <input type="hidden" name="filter_filters_export" id="filter_filters_export">
  <!--Main layout-->

  <!-- Modal -->
  <div class="modal fade" id="employee-details" tabindex="-1" aria-labelledby="employeeDetails" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header text-center">
          <h5 class="modal-title w-100" id="employeeDetails">Employee Details</h5>
          <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row mx-0 mt-2 mb-3 custom-container">
            <div class="col-md-3 custom-container__left">
              <div class="emp-card border-bottom pb-2 mb-3">
                <div class="mb-1">
                  <a href="javascript:void(0);">
                    <div class="avatar-container mx-auto mb-3" id="emp_image">
                      
                    </div>
                  </a>
                </div>
                <div class="d-flex justify-content-center text-break">
                  <h5 class="text-center text-black" id="emp_name">Naushil Jain</h5>
                </div>
                <div class="d-flex justify-content-center text-break">
                  <div class="text-center staff-role"><span id="emp_role"><span> Zone Admin </span></span></div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <button class="btn btn-link text-body d-flex align-items-center py-3 text-capitalize w-100" id="detail_edit">                    
                    <mat-icon role="img" class="mat-icon material-icons me-3" aria-hidden="true">edit</mat-icon>
                    <span>Edit</span>
                  </button>
                  <button class="btn btn-link text-body d-flex align-items-center py-3 text-capitalize w-100 deactivated_user" data-mdb-toggle="modal" data-mdb-target="#deactivate">
                    <mat-icon role="img" class="mat-icon material-icons me-3" aria-hidden="true">lock</mat-icon>
                    <span>Deactivate</span>
                  </button>
                  <button class="btn btn-link text-body d-none align-items-center py-3 text-capitalize w-100 activated_user" data-val="activate">
                    <mat-icon role="img" class="mat-icon material-icons me-3" aria-hidden="true">lock_open</mat-icon>
                    <span>Activate</span>
                  </button>
                </div>
              </div>
            </div>
            <div class="col-md-9 border-start ps-4">
              <div class="row mt-2 text-body">
                <div class="col-md-6 form-group mb-4 d-flex justify-content-between">
                  <div class="row w-100">
                    <div class="col-md-6 d-flex justify-content-between">
                      <div class="fw-600"> Employee ID</div>:
                    </div>
                    <div class="col-md-6 px-0 text-break" > <span class="emp_id">1</span>
                     <input type="hidden" name="employee_id" id="employee_id" value=""> 
                     </div>
                  </div>
                </div>
                <div class="col-md-6 form-group mb-4 d-flex justify-content-between">
                  <div class="row w-100">
                    <div class="col-md-6 d-flex justify-content-between">
                      <div class="fw-600"> Designation </div>:
                    </div>
                    <div class="col-md-6 px-0 text-break" id="emp_designation">-</div>
                  </div>
                </div>
                <div class="col-md-6 form-group mb-4 d-flex justify-content-between">
                  <div class="row w-100">
                    <div class="col-md-6 d-flex justify-content-between">
                      <div class="fw-600"> Department </div>:
                    </div>
                    <div class="col-md-6 px-0 text-break" id="emp_department">-</div>
                  </div>
                </div>
                <div class="col-md-6 form-group mb-4 d-flex justify-content-between">
                  <div class="row w-100">
                    <div class="col-md-6 d-flex justify-content-between">
                      <div class="fw-600"> Mobile No.</div>:
                    </div>
                    <div class="col-md-6 px-0 text-break" id="emp_mobile"> +91 9033356976 </div>
                  </div>
                </div>
                <div class="col-md-6 form-group mb-4 d-flex justify-content-between">
                  <div class="row w-100">
                    <div class="col-md-6 d-flex justify-content-between">
                      <div class="fw-600"> Email </div>:
                    </div>
                    <div class="col-md-6 px-0 text-break" id="emp_email"> naushil.jain@gmail.com </div>
                  </div>
                </div>
                <div class="col-md-6 form-group mb-4 d-flex justify-content-between">
                  <div class="row w-100">
                    <div class="col-md-6 d-flex justify-content-between">
                      <div class="fw-600"> Employee Type</div>:
                    </div>
                    <div class="col-md-6 px-0 text-break"><span id="emp_type">-</span></div>
                  </div>
                </div>
                <div class="col-md-6 form-group mb-4 d-flex justify-content-between">
                  <div class="row w-100">
                    <div class="col-md-6 d-flex justify-content-between">
                      <div class="fw-600"> Staff Category </div>:
                    </div>
                    <div class="col-md-6 px-0 text-break" id="emp_category"> Other </div>
                  </div>
                </div>
                <div class="col-md-6 form-group mb-4 d-flex justify-content-between">
                  <div class="row w-100">
                    <div class="col-md-6 d-flex justify-content-between">
                      <div class="fw-600"> Manager </div>:
                    </div>
                    <div class="col-md-6 px-0 text-break"><span id="emp_manager">-</span></div>
                  </div>
                </div>
                <div class="col-md-6 form-group mb-4 d-flex justify-content-between">
                  <div class="row w-100">
                    <div class="col-md-6 d-flex justify-content-between">
                      <div class="fw-600"> Shift </div>:
                    </div>
                    <div class="col-md-6 px-0"><span id="emp_shift">-</span></div>
                  </div>
                </div>
                <div class="col-md-6 form-group mb-4 d-flex justify-content-between">
                  <div class="row w-100">
                    <div class="col-md-6 d-flex justify-content-between">
                      <div class="fw-600"> ID Type </div>:
                    </div>
                    <div class="col-md-6 px-0 text-break"><span id="emp_id_type">-</span></div>
                  </div>
                </div>
                <div class="col-md-6 form-group mb-4 d-flex justify-content-between">
                  <div class="row w-100">
                    <div class="col-md-6 d-flex justify-content-between">
                      <div class="fw-600"> ID Number </div>:
                    </div>
                    <div class="col-md-6 px-0 text-break"><span id="emp_id_number">-</span></div>
                  </div>
                </div>
                <div class="col-md-6 form-group mb-4 d-flex justify-content-between">
                  <div class="row w-100">
                    <div class="col-md-6 d-flex justify-content-between">
                      <div class="fw-600"> Base Zone </div>:
                    </div>
                    <div class="col-md-6 px-0 text-break" id="emp_base_site"> Raj steel enterprises </div>
                  </div>
                </div>
                <div class="col-md-6 form-group mb-4 d-flex justify-content-between">
                  <div class="row w-100">
                    <div class="col-md-6 d-flex justify-content-between">
                      <div class="fw-600"> Joining Date </div>:
                    </div>
                    <div class="col-md-6 px-0 text-break" id="emp_joining_date"><span>-</span></div>
                  </div>
                </div>
                <div class="col-md-6 form-group mb-4 d-flex justify-content-between">
                  <div class="row w-100">
                    <div class="col-md-6 d-flex justify-content-between">
                      <div class="fw-600"> Auto Deactivate On </div>:
                    </div>
                    <div class="col-md-6 px-0 text-break"><span id="emp_deactive_date">-</span></div>
                  </div>
                </div>
                <div class="col-md-6 form-group mb-4 d-flex justify-content-between">
                  <div class="row w-100">
                    <div class="col-md-6 d-flex justify-content-between">
                      <div class="fw-600"> Onboard From </div>:
                    </div>
                    <div class="col-md-6 px-0 text-break" id="emp_onboard_form"> Self Onboarded </div>
                  </div>
                </div>
                <div class="col-md-6 form-group mb-4 d-flex justify-content-between">
                  <div class="col-md-6 d-flex justify-content-between">
                    <div class="fw-600"> Onboard Date </div>:
                  </div>
                  <div class="col-md-6 px-0 text-break" id="emp_onboard_date"> 30-05-2022 </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  
<!-- Modal -->
<div class="modal fade" id="view-roles" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Roles</h5>
        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="image-container"><img width="100%" alt="Roles" src="img/truein-roles-access-view.png"></div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="import_user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body  py-4">
        <div class="w-100 px-3 pt-3" style="max-height: 450px;">
            <div>
                <p>
                Follow these steps for bulk upload.
                </p>
                <p class="mb-1" >
                    <!----><span>Step 1 -</span>
                    <!----> Download sample file - <a  download="Staff Upload Sample.xlsx"
                        href="{{url('employee-upload-sample.xlsx')}}"><b > Click
                            here </b></a>
                </p>
                <p class="mb-1">
                    <!----><span>Step 2 -</span>
                    <!----> Populate staff details and upload
                </p>
            </div>
            <div>
              <form  id="data_form" method="post" enctype="multipart/form-data">
                <input type="file" name="import_file" id="import_file"/>
                <button type="button" data-mdb-dismiss="modal" id="import_form" class="btn btn-primary mt-3 text-capitalize">
                  Send File
                </button>
              </form>
            </div>

        </div>
      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="roll-out" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center py-4">
        <p>All employees are already invited. To resend, invite them individually</p>
        <button type="button" data-mdb-dismiss="modal" class="btn btn-primary mt-3 text-capitalize">
           Okay
        </button>
      </div>
    </div>
  </div>
</div> 

<!-- Modal -->
  <div class="modal fade" id="deactivate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body text-center py-4">
          <div class="row form-row align-items-end cs-form">
            <div class="col-md-12 mb-4">
                <label class="form-label w-100 d-flex">Reason *</label>
                <select class="browser-default custom-select" required id="deactive_reason">
                  <option selected>Select</option>
                  <option value="Left Organization">Left Organization</option>
                  <option value="On Long Leaves">On Long Leaves</option>
                  <option value="Absconded">Absconded</option>
                  <option value="Employment Expired">Employment Expired</option>
                  <option value="Other">Other</option>
                </select>

                <input type="hidden" name="employees_id" id="employees_id" value="">
                <!-- <div class="invalid-feedback mt-0">Error</div> -->
              </div>

          </div>
          <div>
            <button type="button" data-mdb-dismiss="modal" class="btn btn-link text-body mt-3 me-3 text-capitalize">
              Cancel
            </button>
            <button type="button" data-mdb-dismiss="modal" class="btn btn-primary mt-3 text-capitalize deactive_user">
              Deactivate 
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- Modal -->
<div class="modal fade" id="name-avtar-img" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="image-container emp_image_container">
            
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
  <div class="modal fade" id="delete_employee" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body text-center py-4">
          <div class="row form-row align-items-end cs-form">
            <div class="col-md-12 mb-4">
                <label class="form-label w-100 d-flex">Reason *</label>
                <select class="browser-default custom-select" required id="delete_reason">
                  <option selected>Select</option>
                  <option value="Left Organization">Left Organization</option>
                  <option value="On Long Leaves">On Long Leaves</option>
                  <option value="Absconded">Absconded</option>
                  <option value="Employment Expired">Employment Expired</option>
                  <option value="Other">Other</option>
                </select>

                <input type="hidden" name="delete_employees_id" id="delete_employees_id" value="">
                <input type="hidden" name="delete_employee_url" id="delete_employee_url" value="">
                <!-- <div class="invalid-feedback mt-0">Error</div> -->
              </div>

          </div>
          <div>
            <button type="button" data-mdb-dismiss="modal" class="btn btn-link text-body mt-3 me-3 text-capitalize">
              Cancel
            </button>
            <button type="button" data-mdb-dismiss="modal" class="btn btn-primary mt-3 text-capitalize delete_user">
              Delete 
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('js')
<script type="text/javascript">
  $(document).ready(function(){
    $('#department').multiselect();
    render_table();
    function render_table(){
      var table = $("#staff_table");
      table.DataTable().destroy();

      $filter_search = $('#filter_search').val();
      $filter_site = $('#site').find('option:selected').val();
      $filter_department = $('#department').val();
      $filter_designation = $('#designation').val();
      $filter_category = $('#category').val();
      $filters = $('#filters').find('option:selected').val();

      $('#filter_search_export').val($filter_search);
      $('#filter_site_export').val($filter_site);
      $('#filter_department_export').val($filter_department);
      $('#filter_designation_export').val($filter_designation);
      $('#filter_category_export').val($filter_category);
      $('#filter_filters_export').val($filters);

      table.DataTable({
          processing: true,
          serverSide: true,
          scrollX: true,
          order: [],
          ajax: {
              'url': "{{ route('staff-directory.all.datatable') }}",
              'type': 'POST',
              data:{
                filter_search : $filter_search,
                filter_site : $filter_site,
                filter_department : $filter_department,
                filter_designation : $filter_designation,
                filter_category : $filter_category,
                filters : $filters,
              }
          },
          columns: [
              {data: 'checkbox', name: 'checkbox',orderable:false,searchable:false},
              {data: 'name', name: 'name'},
              {data: 'id', name: 'id'},
              {data: 'mobile', name: 'mobile'},
              {data: 'manager', name: 'manager'},
              {data: 'contractor', name: 'contractor'},
              {data: 'designation', name: 'designation'},
              {data: 'department', name: 'department'},
              {data: 'joining_date', name: 'joining_date'},
              {data: 'deactivate_date', name: 'deactivate_date'},
              {data: 'role_id', name: 'role_id'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ],
      });
    }

    $(document).on('change', '#site', function() {
      render_table();
    });

    $(document).on('change', '#department', function() {
      render_table();
    });

    $(document).on('change', '#designation', function() {
      render_table();
    });

    $(document).on('change', '#category', function() {
      render_table();
    });

    $(document).on('change', '#filters', function() {
      render_table();
    });  

    $('#filter_search').keyup(function() {
      render_table();
    }); 

    $("#more_filter_btn").click(function(){     
      if($('.custom_staff_filters').css('display') == 'none'){
        $(".custom_staff_filters").css("display","block");
        $("#custom_filter_span").text('Less');
        $("#add_remove_icon").text('remove');
      }else{
        $(".custom_staff_filters").css("display","none");
        $("#custom_filter_span").text('More');
        $("#add_remove_icon").text('add');
      }
    }); 

    $(document).on('click', '.emp_details', function(event) {
        event.preventDefault();
        $url = $(this).attr('data-url');
        $.ajax({
            url: $url,
            method: "GET",
        })
        .done(function(result) {
          if(result.status == true){
            $("#emp_id").text(result.employees.id ?? '-');
            $("#emp_designation").text(result.employees.work.designation.name ?? '-');
            $("#emp_department").text(result.employees.work.department.name ?? '-');
            $("#emp_mobile").text(result.employees.mobile ?? '-');
            $("#emp_email").text(result.employees.email ?? '-'); 
            $("#emp_type").text(result.employees.work.employee_type ?? '-');
            $("#emp_category").text(result.employees.work.category.name ?? '-');
            $("#emp_manager").text(result.employees.work.managers.name ?? '-');
            $("#emp_shift").text('-');
            $("#emp_id_type").text(result.employees.id_type ?? '-');
            $("#emp_id_number").text(result.employees.id_number ?? '-');
            $("#emp_base_site").text(result.employees.work.site.name ?? '-');
            $("#employee_id").val(result.employees.id);
            var tempDate = new Date(result.employees.work.joining_date);
            var joining_date = [tempDate.getDate(), tempDate.getMonth() + 1,tempDate.getFullYear()].join('-');
            $("#emp_joining_date").text(joining_date ?? '-');
            var tempDate1 = new Date(result.employees.work.deactivate_date);
            var deactivate_date = [tempDate1.getDate(), tempDate1.getMonth() + 1,tempDate1.getFullYear()].join('-');
            $("#emp_deactive_date").text(deactivate_date ?? '-');
            $("#emp_onboard_form").text('-');
            $("#emp_onboard_date").text('-');

            $("#emp_name").text(result.employees.name ?? '-');
            $("#emp_role").text(result.employees.role.name ?? '-');
            var image = '';
            if(result.employees.image == null || result.employees.image == ""){
              var string = (result.employees.name).charAt(0).toUpperCase();
              image += '<div class="cricle-img position-relative"><div class="avatar-container"><div class="avatar-content" data-mdb-toggle="modal" data-mdb-target="#name-avtar-img" id="name-avtar-img" style="background-color: #d35400;">'+string+'</div></div></div>';
            }else{
              image += '<img class="avatar-content"  src="'+result.url+'" width="100" height="100">';
            }
            $("#emp_image").html(image);

            if(result.employees.status == 1){
              $(".deactivated_user").addClass('d-flex');
              $(".activated_user").addClass('d-none');

              $(".deactivated_user").removeClass('d-none');
              $(".activated_user").removeClass('d-flex');
            }else{
              $(".deactivated_user").addClass('d-none');
              $(".activated_user").addClass('d-flex');

              $(".deactivated_user").removeClass('d-flex');
              $(".activated_user").removeClass('d-none');
            }

          }
        })
        .fail(function() {
              
        });
    });

    $(document).on('click', '.export', function(event) {
      filter_search_export = $('[name="filter_search_export"]').val();
      filter_site_export = $('[name="filter_site_export"]').val();
      filter_department_export = $('[name="filter_department_export"]').val();
      filter_designation_export = $('[name="filter_designation_export"]').val();
      filter_category_export = $('[name="filter_category_export"]').val();
      filter_filters_export = $('[name="filter_filters_export"]').val();
      $.ajax({
          'url': "{{ route('staff.export') }}",
          'type': 'POST',
          data:{
              filter_search_export : filter_search_export,
              filter_site_export : filter_site_export,
              filter_department_export : filter_department_export,
              filter_designation_export : filter_designation_export,
              filter_category_export : filter_category_export,
              filter_filters_export : filter_filters_export,
          }
      })
      .done(function(result, status, xhr) {
          if(result == false) {
              //toast_error("Record not found");
          } else {
              var disposition = xhr.getResponseHeader('content-disposition');
              var matches = /"([^"]*)"/.exec(disposition);
              var file_name = 'staff_report_'+getFormattedTime()+'.csv';
              var filename = (matches != null && matches[1] ? matches[1] : file_name);
  
              // The actual download
              var blob = new Blob([result], {
                  type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
              });
              var link = document.createElement('a');
              link.href = window.URL.createObjectURL(blob);
              link.download = filename;
  
              document.body.appendChild(link);
  
              link.click();
              document.body.removeChild(link);
          }
      })
      .fail(function() {
        //toast_error("error");
      });
    }); 
    function getFormattedTime() {
        var today = new Date();
        var y = today.getFullYear();
        // JavaScript months are 0-based.
        var m = today.getMonth() + 1;
        var d = today.getDate();
        var h = today.getHours();
        var i = today.getMinutes();
        var s = today.getSeconds();
        return d +"_"+ m +"_"+ y +"_"+ h +"_"+ i +"_"+ s;
    }

    $(document).on('click','.activate_user',function(event){
      var val = $(this).attr('data-val');
      var id = $(this).attr('data-id');
      Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, activate it!'
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
              url: "{{route('change.staff.status')}}",
              method: "POST",
              data:{
                id : id,
                status:1,
              }
            })
            .done(function(result) {
            if(result.status == true){
                swal.fire("Activated!", result.data+" has been activated!", "success");
                render_table();
            }
          })
          .fail(function() {
              //toast_error("error");
          });
        }
      })
    })

    $(document).on('click','.activated_user',function(event){
      var id = $("#employee_id").val();
      Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, activate it!'
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
              url: "{{route('change.staff.status')}}",
              method: "POST",
              data:{
                id : id,
                status:1,
              }
            })
            .done(function(result) {
            if(result.status == true){
                swal.fire("Activated!", result.data+" has been activated!", "success");
                $(".deactivated_user").addClass('d-flex');
                $(".activated_user").addClass('d-none');

                $(".deactivated_user").removeClass('d-none');
                $(".activated_user").removeClass('d-flex');
                $("#employee-details").modal('toggle');
                render_table();
            }
          })
          .fail(function() {
              //toast_error("error");
          });
        }
      })
    })

    $(document).on('click','.deactivated_user',function(event){
      var id = $("#employee_id").val();
      $("#employees_id").val(id);
    })

    $(document).on('click','.deactivate_user',function(event){
      var id = $(this).attr('data-id');
      $("#employees_id").val(id);
    });

    $(document).on('click','.delete',function(event){
      var id = $(this).attr('data-id');
      var url = $(this).attr('data-url');
      $("#delete_employees_id").val(id);
      $("#delete_employee_url").val(url);
    });

    $(document).on('click','.deactive_user',function(event){
      var id = $("#employees_id").val();
      var reason = $("#deactive_reason").val();
       $.ajax({
          url: "{{route('change.staff.status')}}",
          method: "POST",
          data:{
            id : id,
            status:0,
            reason : reason
          }
        })
        .done(function(result) {
        if(result.status == true){
            swal.fire("Deactivated!", result.data+" has been deactivated!", "success");
            $(".deactivated_user").addClass("d-none");
            $(".activated_user").addClass("d-flex");

            $(".deactivated_user").removeClass('d-flex');
            $(".activated_user").removeClass('d-none');
            $("#employee-details").modal('hide');
            render_table();
        }
      })
      .fail(function() {
          //toast_error("error");
      });
    });

    $(document).on('click','.delete_user',function(event){
      var id = $("#delete_employees_id").val();
      var url = $("#delete_employee_url").val();
      var reason = $("#delete_reason").val();
       $.ajax({
          url: url,
          method: "DELETE",
          data:{
            id : id,
            status:0,
            reason : reason
          }
        })
        .done(function(result) {
        if(result.status == true){
            swal.fire("Deleted!", result.data+" has been deleted!", "success");
            render_table();
        }
      })
      .fail(function() {
          //toast_error("error");
      });
    });

    $(document).on('click','#detail_edit',function(event){
      var id = $("#employee_id").val();
      var url = base_url+"staff-directory/"+id+"/edit";
      window.location.href = url;
    });

    $(document).on('change','input[name="staff_checkbox"]',function(event){
      var checked = $('input[name="staff_checkbox"]').is(":checked");
      if(checked == true){
        $("#bulk_delete").css("display","block");
        $("#bulk_deactivate").css("display","block");
        $("#add_staff").css("display","none");
        $("#cloud-upload").css("display","none");
        $("#print_btn").css("display","block");
        $('.view-roles').css("display","none");
      } else{
        $("#bulk_delete").css("display","none");
        $("#bulk_deactivate").css("display","none");
        $("#add_staff").css("display","block");
        $("#cloud-upload").css("display","block");
        $("#print_btn").css("display","none");
        $('.view-roles').css("display","block");
      }
    });

    $(document).on('click','#checkall',function(event){      
      var checked = $('#checkall').is(":checked");
      if(checked == true){
        $("#bulk_delete").css("display","block");
        $("#bulk_deactivate").css("display","block");
        $("#add_staff").css("display","none");
        $("#cloud-upload").css("display","none");
        $("#print_btn").css("display","block");
        $('.view-roles').css("display","none");
      } else{
        $("#bulk_delete").css("display","none");
        $("#bulk_deactivate").css("display","none");
        $("#add_staff").css("display","block");
        $("#cloud-upload").css("display","block");
        $("#print_btn").css("display","none");
        $('.view-roles').css("display","block");
      }
    });

    $(document).on('click','#bulk_deactivate',function(event){
      var arr = [];
      $('input[name=staff_checkbox]:checked').each(function () {
          arr.push($(this).val());
      });
      $.ajax({
        url: "{{route('check.staff.status')}}",
        method: "POST",
        data:{
          ids : arr,
        }
      })
      .done(function(data) {
        if(data.status == 0){
            swal.fire("", data.message, "info");
        }else if(data.status == 1){
          var text = data.message;
        }else{
          var text = data.message;
        }

        if(data.status == 1 || data.status ==2){
          Swal.fire({
            title: 'Are you sure?',
            text : text,
            input: 'select',
            inputOptions: {
              'Left Organization': 'Left Organization',
              'On Long Leaves': 'On Long Leaves',
              'Absconded': 'Absconded',
              'Employment Expired' : 'Employment Expired',
              'Other' : 'Other',
            },
            inputPlaceholder: 'required',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Dectivate it!',
            inputValidator: function (value) {
              return new Promise(function (resolve, reject) {
                if (value !== '') {
                  resolve();
                } else {
                  resolve('You need to select a reason');
                }
              });
            }
          }).then(function (result) {
            if (result.isConfirmed) {
              var arr = [];
              $('input[name=staff_checkbox]:checked').each(function () {
                  arr.push($(this).val());
              });
              var reason = result.value;
              $.ajax({
                url: "{{route('change.all.staff.status')}}",
                method: "POST",
                data:{
                  ids : arr,
                  status:0,
                  reason : reason
                }
              })
              .done(function(data) {
                if(data.status == true){
                    toastr.success(data.message);
                    render_table();
                }
              })
              .fail(function() {
              });
            }
          });
        }
      })
      .fail(function() {
      });      
    });

    $(document).on('click','#bulk_delete',function(event){
      var arr = [];
      $('input[name=staff_checkbox]:checked').each(function () {
          arr.push($(this).val());
      });
      $.ajax({
        url: "{{route('check.deactive.staff.status')}}",
        method: "POST",
        data:{
          ids : arr,
        }
      })
      .done(function(data) {
        if(data.status == 0){
            swal.fire("", data.message, "info");
        }else if(data.status == 1){
          var text = data.message;
        }else{
          var text = data.message;
        }

        if(data.status == 1 || data.status ==2){
          Swal.fire({
            title: 'Are you sure?',
            text : text,
            input: 'select',
            inputOptions: {
              'Left Organization': 'Left Organization',
              'On Long Leaves': 'On Long Leaves',
              'Absconded': 'Absconded',
              'Employment Expired' : 'Employment Expired',
              'Other' : 'Other',
            },
            inputPlaceholder: 'required',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete it!',
            inputValidator: function (value) {
              return new Promise(function (resolve, reject) {
                if (value !== '') {
                  resolve();
                } else {
                  resolve('You need to select a reason');
                }
              });
            }
          }).then(function (result) {
            if (result.isConfirmed) {
              var arr = [];
              $('input[name=staff_checkbox]:checked').each(function () {
                  arr.push($(this).val());
              });
              var reason = result.value;
              $.ajax({
                url: "{{route('delete.all.staff')}}",
                method: "POST",
                data:{
                  ids : arr,
                  status:0,
                  reason : reason
                }
              })
              .done(function(data) {
                if(data.status == true){
                    toastr.success(data.message);
                    render_table();
                }
              })
              .fail(function() {
              });
            }
          });
        }
      })
      .fail(function() {
      });
      
    });

    $("#checkall").change(function () {
      $(".chk").prop('checked', $(this).prop("checked"));
    });

    $(document).on('click','.chk',function(event){
      if ($('.chk:checked').length == $('.chk').length) {
        $('#checkall').prop('checked', true);
      } else {
        $('#checkall').prop('checked', false);
      }
    });

    // Image Modal
    $(document).on('click', '.name-avtar-img', function(event) {
        event.preventDefault();
        $url = $(this).attr('data-url');
        $.ajax({
            url: $url,
            method: "GET",
        })
        .done(function(result) {
          if(result.status == true){ 
            var image = '';
            if(result.employees.image != null || result.employees.image != ""){
              image += '<img class="avatar-content"  src="'+result.url+'" width="100" height="100"><h5 class="mt-3">'+result.employees.name+'</h5>';
            }
            $(".emp_image_container").html(image);
          }
        })
        .fail(function() {
        });
    });

    // Print Functionality
    $(document).on('click','#print_btn',function(){
      var arr = [];
      $('input[name=staff_checkbox]:checked').each(function () {
          arr.push($(this).val());
      });
      var string = arr.toString();
      var url = base_url+ 'print/'+string ;
      window.open(url,'_blank');
    });

    $(document).on('click','#import_form',function(event){
      event.preventDefault();
      let formData = new FormData(document.getElementById('data_form'));
      $.ajax({
          url: "{{route('import.staff')}}",
          method: "POST",
          cache: false,
        processData: false,
        contentType: false,
          data:formData,
        })
        .done(function(result) {
          if(result.status == true){
            swal.fire("Imported!"," Staff record imported successfully.", "success");
            
          }else{
            swal.fire("Error!","Your File is currept.", "error");
          }
      })
      .fail(function() {
      });
    });

  });
</script>
@endpush