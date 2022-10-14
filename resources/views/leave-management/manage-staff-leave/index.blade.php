@extends('layouts.master')

@section('title','Leave Management')
@section('content')
<!--Main layout-->
  <main class="content-body">
    <div class="page-body">
      <div class="card">
        <div class="card-header">
          <div class="d-flex">
            <a class="btn btn-sm btn-link text-body" href="{{route('leave-management.index')}}">
              <mat-icon role="img" class="mat-icon material-icons" aria-hidden="true">
                keyboard_arrow_left</mat-icon>
            </a>
            <div class="d-flex flex-column mt-2">
              <h5>Manage Employee Leaves</h5>
              <small class="mt-1">View Employees leave history. Apply leave on behalf.</small>
            </div>
          </div>
        </div>
        <div class="card-block-hid">
          <div class="card-block px-4 pb-4">
            <div class="page-body">
              <div class="row mb-2 btn-tow cs-form">
                <div class="col-md-6">
                  <div class="d-flex gap-4 align-items-center">
                    <button type="button" class="btn btn-primary text-capitalize" data-mdb-ripple-color="dark" data-mdb-toggle="modal" data-mdb-target="#apply-employee-leave">
                      Apply for Others
                    </button>
                    <button type="button" class="btn btn-primary text-capitalize" data-mdb-ripple-color="dark"
                      data-mdb-toggle="dropdown" id="allote-leave">
                      Allot Leaves
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="allote-leave">
                      <li><a class="dropdown-item py-3" href="#" data-mdb-toggle="modal"
                          data-mdb-target="#allot-leave">Allot leave for single staff</a></li>
                      <li><a class="dropdown-item py-3" href="#" data-mdb-toggle="modal"
                          data-mdb-target="#upload-excel">Bulk-allot via spreadsheet upload</a></li>
                    </ul>
                  </div>
                </div>
                <div class="col-md-6 d-flex justify-content-end">
                  <div class="row align-items-end w-100">
                    <div class="col-md-4">
                      <label class="form-label">Department Filter </label>
                      <select name="department[]" class="custom-select" id="leave-department"><<option value="">Select Any</option>
                        @foreach($department as $dep)
                          <option  value="{{$dep->name}}">{{$dep->name}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Staff Category </label>
                      <select name="category[]" class="custom-select" id="leave-category">  "><<option value="">Select Any</option>                
                        @foreach($category as $cat)
                          <option  value="{{$cat->name}}">{{$cat->name}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-4">
                      <div class="form-outline">
                        <input type="text" class="form-control" id="filter_search" />
                        <label class="form-label">Search</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="table-section mt-3">
                <div class="price-details-table overflow-auto">
                  <table class="table table-bordered" id="emp_leave_table">
                    <thead role="rowgroup">
                      <tr>
                        <th scope="col" rowspan="2" style="vertical-align: middle;"> Name </th>
                        <th scope="col" rowspan="2" style="vertical-align: middle;"> Category </th>
                        <th scope="col" rowspan="2" style="vertical-align: middle;"> Department </th>
                        @foreach($leaveType as $type)
                          <th class="text-center" colspan="3"> {{$type->name}} </th>
                        @endforeach
                      </tr>
                      <tr>
                        @foreach($leaveType as $type)
                        <th class="subheader-top"> Allotted </th>
                        <th class="subheader-top"> Used </th>
                        <th class="subheader-top"> Balance </th>
                        @endforeach
                      </tr>
                    </thead>
                    <tbody role="rowgroup">
                      @foreach($leave as $l)
                      <tr>
                        <td scope="col">
                          <div class="name-row">
                            <div class="cricle-img position-relative">
                              <div class="avatar-container">
                                <div class="avatar-content" style="background-color: #322a24;">MP</div>
                              </div>
                            </div>
                            <div class="name-text">
                              <div class="d-flex w-100">
                                <div>
                                  <a href="javascript:void(0);" data-mdb-toggle="modal"
                                    data-mdb-target="#employee-leave-history-modal" data-id="{{$l->employee_id}}" class="employee_leave_history">
                                    <span>{{$l->employee->name}} </span>
                                  </a>
                                </div>
                              </div>
                              <span class="emp-id">{{$l->employee_id}} </span>
                            </div>
                          </div>
                        </td>
                        <td scope="col">{{$l->employee->work->category->name}}</td>
                        <td scope="col">{{$l->employee->work->department->name}}</td>
                        @foreach($leaveType as $type) 
                        <?php
                        $alloted = \App\Models\LeaveList::where('employee_id',$l->employee_id)->where('leave_type_id',$type->id)->where('status','ALLOTED')->sum('tota_days');
                        $used = \App\Models\LeaveList::where('employee_id',$l->employee_id)->where('leave_type_id',$type->id)->where('status','APPROVED')->sum('tota_days');
                        $balance  = $alloted - $used;
                        ?>
                        <td>{{$alloted}}</td>
                        <td>{{$used}}</td>
                        <td class="balance">{{$balance}}</td>
                        @endforeach
                      </tr>  
                      @endforeach                   
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

  </main>
  <!--Main layout-->

  <!-- Modal -->
  <div class="modal fade" id="employee-leave-history-modal" tabindex="-1" aria-labelledby="employeeLeaveHistory"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content">
        <div class="modal-header text-center">
          <h5 class="modal-title w-100">Employee Leave History</h5>
          <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body cs-form">
          <div class="employee_personal_details">
          </div>
          <div class="leave-container mb-1" id="leaveCount">
            
          </div>
          <div class="table-section mt-3">
            <div class="datatable leave_history">
              
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Modal -->
    <div class="modal fade" id="apply-employee-leave" tabindex="-1" aria-labelledby="edit-leave" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <form id="employeeLeaveForm" class="modal-content" enctype="multipart/form-data">
            <div class="modal-body cs-form">
              <div class="text-center">
                <h5 class="text-body fw-600 my-4">Apply Leave for Other Employee</h5>
              </div>
              <div class="row">
                <div class="col-md-10 mx-auto">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="row align-items-center">
                        <div class="col-md-6 mb-2">
                          <label class="form-label">Select Employee</label>
                          <select class="browser-default custom-select" name="employee_id" id="employee_id">
                            <option selected value="">Employee Name</option>
                            @foreach($employee as $emp)
                            <option value="{{$emp->id}}">{{$emp->name}}</option>
                            @endforeach
                          </select>
                          <!-- <div class="input-group mb-3 align-items-end">
                            <div class="dropdown ul-select flex-fill">
                              <button
                                class="dropdown-toggle" type="button" id="selectEmployee" data-mdb-toggle="dropdown" aria-expanded="false">
                                Employee Name
                              </button>
                              <ul class="dropdown-menu" aria-labelledby="selectEmployee">
                                <li>
                                  <a class="dropdown-item" href="#">
                                    <div class="d-flex align-items-center">
                                      <div class="pe-2">
                                        <div class="avatar-container" style="width: 35px; height: 35px;">
                                          <img  class="avatar-content" src="img/default-img.png" width="35" height="35">
                                        </div>
                                      </div>
                                      <div class="line-height-16">
                                        <div class="mb-0 me-2 policy-no"> Hardik</div>
                                        <div class="option-policy-description">
                                          <small> Emp ID:3 </small>
                                        </div>
                                      </div>
                                    </div>
                                  </a>
                                </li>
                                <li>
                                  <a class="dropdown-item" href="#">
                                    <div class="d-flex align-items-center">
                                      <div class="pe-2">
                                        <div class="avatar-container" style="width: 35px; height: 35px;">
                                          <img  class="avatar-content" src="img/default-img.png" width="35" height="35">
                                        </div>
                                      </div>
                                      <div class="line-height-16">
                                        <div class="mb-0 me-2 policy-no"> Hardik</div>
                                        <div class="option-policy-description">
                                          <small> Emp ID:3 </small>
                                        </div>
                                      </div>
                                    </div>
                                  </a>
                                </li>
                                <li>
                                  <a class="dropdown-item" href="#">
                                    <div class="d-flex align-items-center">
                                      <div class="pe-2">
                                        <div class="avatar-container" style="width: 35px; height: 35px;">
                                          <img  class="avatar-content" src="img/default-img.png" width="35" height="35">
                                        </div>
                                      </div>
                                      <div class="line-height-16">
                                        <div class="mb-0 me-2 policy-no"> Hardik</div>
                                        <div class="option-policy-description">
                                          <small> Emp ID:3 </small>
                                        </div>
                                      </div>
                                    </div>
                                  </a>
                                </li>
                              </ul>
                            </div>
                            <span class="input-group-text employee-leave-input-group-text border-end-0 border-start-0 border-top-0" id="basic-addon2"><mat-icon role="img" matsuffix="" data-mdb-toggle="tooltip" title="" class="mat-icon material-icons fs-5" aria-hidden="true" data-mdb-original-title="Leave will be auto approved">info_outline</mat-icon></span>
                          </div> -->

                         
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6 mb-2">
                          <label class="form-label">Leave Type</label>
                          <select class="browser-default custom-select" name="leave_type" id="leave_type" disabled>
                            <option selected value="">Leave Type</option>
                            @foreach($leaveType as $type)
                            <option value="{{$type->id}}">{{$type->name}}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="col-md-6 mb-2 leave_balance" style="display: none"></div>
                        </div>
                        <div class="row align-items-end">
                          <div class="col-md-6 mb-2">
                            <div class="form-outline active">
                              <div class='input-group date' id='fdol'>
                                <input type='text' class="form-control" placeholder="Select Date" name="start_date" id="start_date" />
                                <span class="input-group-addon">
                                  <i class="ti-calendar"></i>
                                </span>
                                <label class="form-label" for="form1">First Day of Leave*</label>
                              </div>
                          </div>
                        </div>
                        <div class="col-md-6 mb-2">
                          <label class="form-label">Full Day</label>
                          <select class="browser-default custom-select" name="start_date_period" id="start_date_period">
                            <option value="FULL DAY">Full Day</option>
                            <option value="FIRST HALF">First Half</option>
                            <option value="SECOND HALF">Second Half</option>
                          </select>
                        </div>
                      </div>
                      <div class="row mt-4 align-items-end">
                        <div class="col-md-6 mb-2">
                          <div class="form-outline active">
                            <div class='input-group date' id='ldol'>
                              <input type='text' class="form-control" placeholder="Select Date" name="end_date" id="end_date" />
                              <span class="input-group-addon">
                                <i class="ti-calendar"></i>
                              </span>
                              <label class="form-label" for="form1">Last Day of Leave*</label>
                            </div>                            
                        </div>
                       
                      </div>
                      
                      <div class="col-md-6 mb-2">
                        <label class="form-label">Full Day</label>
                        <select class="browser-default custom-select" name="end_date_period" id="end_date_period" disabled>
                          <option value="FULL DAY">Full Day</option>
                          <option value="FIRST HALF">First Half</option>
                          <option value="SECOND HALF">Second Half</option>
                        </select>
                      </div>
                    </div>
                    <div class="row mt-4 align-items-center">
                      <div class="col-md-6 mb-3">
                        <div class="leave-file file btn btn-link text-capitalize text-black btn-sm px-0 d-flex gap-3 align-items-center">
                          Attach document <mat-icon  role="img" class="mat-icon me-2 material-icons" aria-hidden="true">attachment</mat-icon>
                          <input type="file" name="file"/>
                        </div>
                          <small>Supported formats: jpeg, jpg, pdf</small>
                      </div>
                    </div>
                      <div class="row mt-3 align-items-end">
                        <div class="col-md-12 mb-5">
                          <div class="form-outline">
                            <textarea class="form-control" rows="1" name="leave_reason" id="leave_reason"></textarea>
                            <label class="form-label">Leave Reason</label>
                          </div>
                        </div>
                        <div class="col-md-12 mb-4">
                          <div class="form-outline">
                            <textarea class="form-control" rows="1" name="comment" id="comment"></textarea>
                            <label class="form-label">Comment</label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
               
                </div>
              </div>
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default text-capitalize ripple-surface" data-mdb-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary text-capitalize" name="apply_leave" id="apply_leave" disabled>Apply</button>
            </div>
          
        </form>
      </div>
    </div>

    <!-- Modal -->
  <div class="modal fade" id="allot-leave" tabindex="-1" aria-labelledby="edit-leave" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <form class="modal-content" id="employeeAllotLeaveForm">
          <div class="modal-body cs-form">
            <div class="text-center">
              <h5 class="text-body fw-600 my-4">Allot Leave</h5>
            </div>
            <div class="row">
              <div class="col-md-10 mx-auto">
                <div class="row">
                  <div class="col-md-12">
                    <div class="row align-items-center">
                      <div class="col-md-6 mb-5">
                        <label class="form-label">Select Employee</label>
                        <!-- <div class="dropdown ul-select flex-fill">
                          <button class="dropdown-toggle" type="button" id="selectEmployee" data-mdb-toggle="dropdown"
                            aria-expanded="false">
                            Employee Name
                          </button>
                          <ul class="dropdown-menu" aria-labelledby="selectEmployee">
                            <li>
                              <a class="dropdown-item" href="#">
                                <div class="d-flex align-items-center">
                                  <div class="pe-2">
                                    <div class="avatar-container" style="width: 35px; height: 35px;">
                                      <img class="avatar-content" src="img/default-img.png" width="35" height="35">
                                    </div>
                                  </div>
                                  <div class="line-height-16">
                                    <div class="mb-0 me-2 policy-no"> Hardik</div>
                                    <div class="option-policy-description">
                                      <small> Emp ID:3 </small>
                                    </div>
                                  </div>
                                </div>
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item active" href="#">
                                <div class="d-flex align-items-center">
                                  <div class="pe-2">
                                    <div class="avatar-container" style="width: 35px; height: 35px;">
                                      <img class="avatar-content" src="img/default-img.png" width="35" height="35">
                                    </div>
                                  </div>
                                  <div class="line-height-16">
                                    <div class="mb-0 me-2 policy-no"> Hardik</div>
                                    <div class="option-policy-description">
                                      <small> Emp ID:3 </small>
                                    </div>
                                  </div>
                                </div>
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item" href="#">
                                <div class="d-flex align-items-center">
                                  <div class="pe-2">
                                    <div class="avatar-container" style="width: 35px; height: 35px;">
                                      <img class="avatar-content" src="img/default-img.png" width="35" height="35">
                                    </div>
                                  </div>
                                  <div class="line-height-16">
                                    <div class="mb-0 me-2 policy-no"> Hardik</div>
                                    <div class="option-policy-description">
                                      <small> Emp ID:3 </small>
                                    </div>
                                  </div>
                                </div>
                              </a>
                            </li>
                          </ul>
                        </div> -->
                        <select class="browser-default custom-select" name="employee_allot_id" id="employee_allot_id">
                          <option selected value="">Employee Name</option>
                          @foreach($employee as $emp)
                          <option value="{{$emp->id}}">{{$emp->name}}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="clearfix"></div>
                      <div class="col-md-6 mb-5">
                        <label class="form-label">Leave Type</label>
                        <select class="browser-default custom-select" name="emp_leave_type" id="emp_leave_type">
                          <option selected value="">Leave Type</option>
                          @foreach($leaveType as $type)
                          <option value="{{$type->id}}">{{$type->name}}</option>
                          @endforeach
                        </select> 
                      </div>
                    </div>
                    <div class="row align-items-end">
                      <div class="col-md-6 mb-4">
                        <div class="form-outline">
                          <input type='number' class="form-control" name="total_days" id="total_days" value="1" />
                          <label class="form-label">Allot Leave days</label>
                        </div>
                      </div>

                    </div>
                    <div class="row mt-3 align-items-end">
                      <div class="col-md-12 mb-4">
                        <div class="form-outline">
                          <textarea class="form-control" rows="2" name="allot_comment" id="allot_comment"></textarea>
                          <label class="form-label">Comment</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default text-capitalize ripple-surface"
              data-mdb-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary text-capitalize" name="allot_leave" id="allot_leave" disabled>Allot</button>
          </div>
        </form>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="upload-excel" tabindex="-1" aria-labelledby="edit-leave" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form>
          <div class="modal-header text-center">
            <h5 class="modal-title w-100 fs-6" id="exampleModalLabel">Upload Excel of Employees Bulk Allot Leave</h5>
            <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body cs-form">
            <div class="row">
              <div class="col-md-10 mx-auto">
                <div class="row">
                  <div class="col-md-12">
                    <div class="dialog-note mb-5">
                      <p class="text-body"><span class="note-red"> Note: </span>
                        Download following sample file and add your Employee data to the file and then upload it.</p>
                      <p class="mt-2">
                        <a class="fw-600 mb-4 d-block" download="demo.xlsx" href="demo.xlsx"> Download
                          existing employees leave data - Click here </a>
                      </p>
                    </div>
                    <div class="row">
                      <div class="col-md-10 mx-auto">
                        <div class="row mb-4">
                            <div class="col-md-7">
                              <div class="form-outline active">
                                <input type="text" class="form-control" value="abc.xlx" disabled/>
                                <label class="form-label">XLSX File</label>
                              </div>
                            </div>
                            <div class="col-md-5">
                              <div class="leave-file file btn btn-default text-capitalize">
                                Select File
                                <input type="file" name="file" />
                              </div>
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="text-center mb-4">
                      <button type="button" class="btn btn-primary text-capitalize">Upload</button>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

@endsection

@push('js')
<script type="text/javascript">
  $(document).ready(function (){
    
    // Employee History Popup shows details
    $(".employee_leave_history").on("click",function(){
      var id = $(this).attr('data-id');
      $.ajax({
        type:"POST",
        data:{
          id: id
        },
        url: "{{route('employee.leave.history')}}",
        dataType:'json',
        success:function(result){
          console.log(result);
          if(result.status == true){
            $(".leave_history").html(result.data.leave_details);
            $("#leaveCount").html(result.data.leaveCount);
            $(".employee_personal_details").html(result.data.personaldetails);
          }          
        }
      })
    });

    // Apply Leave for other employees
    $("#employeeLeaveForm").validate({
      rules: {
        employee_id: "required",
        leave_type: "required",
        start_date: "required",
        end_date: "required",
        start_date_period: "required",
        end_date_period: "required",
      },
      messages: {
        employee_id: {
          required: "Please select employee",
        },
        leave_type: {
          required: "Please select leave type",
        },      
        start_date: {
          required: "Please select start date",
        },
        end_date: {
          required: "Please select end date",
        },
        start_date_period: {
          required: "Please select period",
        },
        end_date_period: {
          required: "Please select period",
        },
      },
      submitHandler: function(form) {
        var fd = new FormData(employeeLeaveForm);
        $.ajax({
          url: "{{route('leave-management.store')}}",
          type: 'post',
          data: fd,
          contentType: false,
          processData: false,
          success: function(response){
            if(response.status == true){
              toastr.success(response.message);
              $("#apply-employee-leave").modal('toggle');
              $("#employeeLeaveForm")[0].reset();
              location.reload(true);
            }else{
              toastr.error(response.message);
            }
          }
        });
      }   
    });

    // Enable disable Allot leave button
    nullValidation();

    $("#employee_allot_id").click(function(){
      nullValidation();
    });

    $("#emp_leave_type").click(function(){
      nullValidation();
    });

    $('#total_days').keyup(function() {
      nullValidation();
    });

    function nullValidation(){
        if($("#employee_allot_id").val() != "" && $("#emp_leave_type").val() && $("#total_days").val() != ""){
            $("#allot_leave").attr('disabled',false); 
        }
        else{
            $("#allot_leave").attr('disabled',true); 
        }
    }    

    // Allot Leave 
    $("#employeeAllotLeaveForm").validate({
      rules: {
        employee_allot_id: "required",
        emp_leave_type: "required",
        total_days: {
          required: true,
          min: 1
        }, 
      },
      messages: {
        employee_allot_id: {
          required: "Employee is required",
        },
        emp_leave_type: {
          required: "Leave type is requried",
        },      
        total_days: {
          required: "Please enter a valid No. of days",
          min: "The value can not be 0 or less than 0",
        },        
      },
      submitHandler: function(form) {
        var fd = new FormData(employeeAllotLeaveForm);
        $.ajax({
          url: "{{route('manage-emp-leaves.store')}}",
          type: 'post',
          data: fd,
          contentType: false,
          processData: false,
          success: function(response){
            if(response.status == true){
              toastr.success(response.message);
              $("#allot-leave").modal('toggle');
              $("#employeeAllotLeaveForm")[0].reset();
              location.reload(true);
            }else{
              toastr.error(response.message);
              $("#allot-leave").modal('toggle');
              $("#employeeAllotLeaveForm")[0].reset();
            }
          }
        });
      }   
    });

    // Apply leave button enable disable
    $(document).on('change','#employee_id',function(){
      nullLeaveValidation();
      $("#leave_type").attr('disabled',false);
    });

    $(document).on('change','#leave_type',function(){
      nullLeaveValidation();
      $.ajax({
        type:"POST",
        data:{
          id: $("#employee_id").val(),
          leave_type: $("#leave_type").val()
        },
        url: "{{route('check.leave.balance')}}",
        dataType:'json',
        success:function(result){
          if(result.status == true){
            var html = '<span>Balance : '+result.data+'</span>'
            $(".leave_balance").html(html);
            $(".leave_balance").css('display','block');
          }          
        }
      })
    });

    if ($('#start_date').length) {
      $('#start_date').datetimepicker({
          format: 'L',
      });
    }

    if ($('#end_date').length) {
        $('#end_date').datetimepicker({
            format: 'L',
        });
    }

    $('#start_date').on('dp.change', function(e){ 
      nullLeaveValidation();
      if($('#start_date').val() != ""){
        $('#start_date').addClass('active');
      }else{
        $('#start_date').removeClass('active');
      }
    })

    $('#end_date').on('dp.change', function(e){ 
      nullLeaveValidation();
      if($('#end_date').val() != ""){
        $('#end_date').addClass('active');
      }else{
        $('#end_date').removeClass('active');
      }
    })


    function nullLeaveValidation(){
        if($("#leave_type").val() != "" && $("#start_date").val() !="" && $("#end_date").val() != "" && $("#employee_id").val() != ""){
            $("#apply_leave").attr('disabled',false); 
        }
        else{
            $("#apply_leave").attr('disabled',true); 
        }
    } 

    $("#start_date").keyup(function(){
      if($('#start_date').val() != ""){
        $('#start_date').addClass('active');
      }else{
        $('#start_date').removeClass('active');
      }
    })
    
    $("#end_date").keyup(function(){
      if($('#end_date').val() != ""){
        $('#end_date').addClass('active');
      }else{
        $('#end_date').removeClass('active');
      }
    })

    $("document").ready(function () {

      $("#emp_leave_table").dataTable({
        "searching": true
      });
      var table = $('#emp_leave_table').DataTable();
      $("#filterTable_filter.dataTables_filter").append($("#leave-department"));
      $("#filterTable_filter.dataTables_filter").append($("#leave-category"));
      var categoryIndex = 0;
      var departmentIndex = 0;
      
      $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
          var selectedItem = $('#leave-department').val()
          var department = data[2];
          if (selectedItem === "" || department.includes(selectedItem)) {
            return true;
          }
          return false;
        }
      );

      $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
          var selectedItem1 = $('#leave-category').val()
          var category = data[1];
          if (selectedItem1 === "" || category.includes(selectedItem1)) {
            return true;
          }
          return false;
        }
      );

      $("#leave-department").change(function (e) {
        table.draw();
      });

      $("#leave-category").change(function (e) {
        table.draw();
      });

      $('#filter_search').keyup(function(){
        table.search($(this).val()).draw();
      })
      table.draw();
    });

});
 
</script>
@endpush