@extends('layouts.master')

@section('title','Create Staff')
@section('content')
<!--Main layout-->
  <main class="content-body">
    <div class="page-body">
      <div class="card">
        <div class="card-block p-4">
          <div class="row">
            <div class="col-md-12">
              <button class="btn btn-link btn-sm text-body">
                <a href="{{route('staff-directory.index')}}">
                  <mat-icon role="img" class="mat-icon material-icons" aria-hidden="true">keyboard_arrow_left</mat-icon>
                </a>
              </button>
            </div>
          </div>
          <div class="stepwizard">
            <ul class="nav setup-panel nav-tabs staff-tabs">
              <li class="stepwizard-step nav-item">
                <a href="#step-1" type="button" class="btn active btn-link  nav-link">Personal</a>
              </li>
              <li class="stepwizard-step nav-item">
                <a href="#step-2" type="button" class="btn btn-default btn-link  nav-link" disabled="disabled">Work</a>
              </li>
              <li class="stepwizard-step nav-item">
                <a href="#step-3" type="button" class="btn btn-default btn-link  nav-link" disabled="disabled">Access</a>
              </li>
              <li class="stepwizard-step nav-item">
                <a href="#step-4" type="button" class="btn btn-default btn-link  nav-link" disabled="disabled">Other</a>
              </li>
            </ul>
          </div>
          <form method="post" action="{{ route('staff-directory.store') }}"  id="addForm" enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf
            <div class="setup-content" id="step-1" style="display:block;">
              <div class="personal-detail-tab cs-form">
                <div class="row form-section-body mt-5">
                  <div class="col-md-4">
                    <div class="form-heading text-right me-5">
                      <h5 class="typography"><small>Personal</small></h5>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="row form-row align-items-end">
                      <div class="col-md-4 mb-5">
                        <div class="form-outline">
                          <!-- is-invalid -->
                          <input type="text" class="form-control" name="name" required id="name"/>
                          <label class="form-label" for="name">Name</label>
                          @if ($errors->has('name'))
                              <mat-error role="alert" class="mat-error"> {{ $errors->first('name') }}.</mat-error>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-1 mb-5">
                        <div class="form-outline">
                          <input type="text" class="form-control" name="country_code" id="country_code" />
                        </div>
                      </div>
                      <div class="col-md-3 mb-5">
                        <div class="form-outline">
                          <input type="text" class="form-control" name="mobile" id="mobile" required />
                          <label class="form-label">Mobile</label>
                          @if ($errors->has('mobile'))
                              <mat-error role="alert" class="mat-error"> {{ $errors->first('mobile') }}.</mat-error>
                          @endif
                        </div>
                      </div>
                      <div class="clearfix"></div>
                      <div class="col-md-4 mb-5">
                        <div class="form-outline">
                          <input type="email" class="form-control" name="email"/>
                          <label class="form-label">Email</label>
                          @if ($errors->has('email'))
                              <mat-error role="alert" class="mat-error"> {{ $errors->first('email') }}.</mat-error>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-4 mb-5">
                        <div class="form-outline active">
                          <div class='input-group date' id='dob1'>
                            <input type='text' class="form-control" name="dob" id="dob" />

                            <span class="input-group-addon">
                              <i class="ti-calendar"></i>
                            </span>
                            <label class="form-label" for="form1">Date of Birth</label>
                          </div>
                        </div>
                      </div>
                      <div class="clearfix"></div>
                      <div class="col-md-4 mb-5">
                        <div class="form-outline">
                          <input type="text" class="form-control" name="blood_group" />
                          <label class="form-label">Blood Group</label>
                        </div>
                      </div>
                      <div class="clearfix"></div>
                      <div class="col-md-4 mb-5">
                        <div class="">
                          <label class="form-label">ID Type</label>
                          <select class="browser-default custom-select" name="id_type" id="id_type">
                            <option value="None">None</option>
                            <option selected value="Aadhaar">Aadhaar</option>
                            <option value="PAN">PAN</option>
                            <option value="Driving License">Driving License</option>
                            <option value="Voter ID">Voter ID</option>
                            <option value="Other">Other</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4 mb-5">
                        <div class="form-outline">
                          <input type="text" class="form-control" name="id_number" id="id_number" />
                          <label class="form-label">ID Number</label>
                        </div>
                      </div>
                      <!-- <div class="col-md-4 plusbtn-pos">
                        <button type="button" class="btn btn-sm btn-link text-body disabled" id="plusbtn-pos">
                          <mat-icon class="mat-icon material-icons" aria-hidden="true">add</mat-icon>
                        </button>
                      </div> -->
                      <div class="clearfix"></div>
                      <div class="col-md-4 mb-5" id="second_id_type" id="second_id_typee" style="display: none">
                        <div class="">
                          <label class="form-label">Second ID Type</label>
                          <select class="browser-default custom-select" name="second_id_type">
                            <option value="None">None</option>
                            <option selected value="Aadhaar">Aadhaar</option>
                            <option value="PAN">PAN</option>
                            <option value="Driving License">Driving License</option>
                            <option value="Voter ID">Voter ID</option>
                            <option value="Other">Other</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4 mb-5" id="second_id_number" style="display: none">
                        <div class="form-outline">
                          <input type="text" class="form-control" name="second_id_number" id="second_id_no"/>
                          <label class="form-label">Second ID Number</label>
                        </div>
                      </div>
                      <div class="col-md-4 plusbtn-pos" id="plusbtn-cross" style="display: none">
                        <button type="button" class="btn btn-sm btn-link text-body">
                          <mat-icon class="mat-icon material-icons" aria-hidden="true">close</mat-icon>
                        </button>
                      </div>
                      <div class="clearfix"></div>
                      <div class="col-md-4 mb-5">
                        <div class="">
                          <label class="form-label">Gender</label>
                          <select class="browser-default custom-select" name="gender" required>
                            <option selected value="Male">Male</option>
                            <option value="Female">Female</option>
                          </select>
                        </div>
                      </div>
                      <div class="clearfix"></div>
                      <div class="col-md-8 text-center mb-3">
                        <button type="button" class="btn btn-primary px-5 nextBtn">Next</button>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>
            <div class="setup-content" id="step-2">
              <div class="personal-detail-tab cs-form">
                <div class="row form-section-body mt-5">
                  <div class="col-md-4">
                    <div class="form-heading text-right me-5">
                      <h5 class="typography"><small>Work</small></h5>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="row form-row align-items-end">
                      <div class="col-md-4 mb-4">
                        <div class="">
                          <label class="form-label">Staff Type</label>
                          <select class="browser-default custom-select" name="staff_type" disabled>
                            @foreach($category as $cat)
                              <option value="{{$cat->id}}">{{$cat->name}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4 mb-4">
                        <div class="">
                          <label class="form-label">Staff Category</label>
                          <i class="ti-info-alt trailing" data-mdb-toggle="tooltip"
                            title="Changing category will also affect staffs leaves. It will be alloted again as per the new category."></i>
                          <select class="browser-default custom-select form-icon-trailing" name="staff_category">
                            @foreach($category as $cat)
                              <option value="{{$cat->id}}">{{$cat->name}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="clearfix"></div>
                      <div class="col-md-4 mb-4">
                        <div class="form-outline">
                          <input type="text" class="form-control" name="employee_code" value="{{@$code->id + 1}}" />
                          <label class="form-label">Employee ID</label>
                        </div>
                      </div>
                      <div class="clearfix"></div>
                      <div class="col-md-4 mb-4">
                        <div class="form-outline active">
                          <div class='input-group date'>
                            <input type='text' class="form-control" name="joining_date" id="joining_date" value="{{date('m/d/Y')}}" />

                            <span class="input-group-addon">
                              <i class="ti-calendar"></i>
                            </span>
                            <label class="form-label" for="form1">Joining Date</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4 mb-4">
                        <div class="form-outline active">
                          <div class='input-group date' id='deactivate-staff-date'>
                            <input type='text' class="form-control" name="deactive_date" id="deactive_date" />

                            <span class="input-group-addon">
                              <i class="ti-calendar"></i>
                            </span>
                            <label class="form-label" for="form1">Auto Deactivate Staff On</label>
                          </div>
                        </div>
                      </div>
                      <div class="clearfix"></div>
                      <div class="col-md-4 mb-4">
                        <div class="">
                          <label class="form-label">Designation</label>
                          <select class="browser-default custom-select" name="designation">
                            @foreach($designation as $des)
                              <option value="{{$des->id}}">{{$des->name}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4 mb-4">
                        <div class="">
                          <label class="form-label">Department</label>
                          <select class="browser-default custom-select" name="department">
                            @foreach($department as $dep)
                              <option value="{{$dep->id}}">{{$dep->name}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="clearfix"></div>
                      <div class="col-md-4 mb-4">
                        <div class="">
                          <label class="form-label">Manager</label>
                          <select class="browser-default custom-select" name="manager">
                            @foreach($managers as $manager)
                            <option value="{{$manager->id}}">{{$manager->name}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="clearfix"></div>
                      <div class="col-md-4 mb-4">
                        <div class="">
                          <label class="form-label">Shift</label>
                          <select class="browser-default custom-select" name="shift" id="shift">
                            @foreach($shift as $s)
                              <option value="{{$s->id}}">{{$s->name}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="clearfix"></div>
                      <div class="col-md-4 mb-4">
                        <div class="form-outline active">
                          <div class='input-group date' id='rintime'>
                            <input type='text' class="form-control" name="regular_in" value="09:00 AM" id="regular_in" />

                            <span class="input-group-addon">
                              <i class="ti-time"></i>
                            </span>
                            <label class="form-label" for="form1">Regular in-time</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4 mb-4">
                        <div class="form-outline active">
                          <div class='input-group date' id='routtime'>
                            <input type='text' class="form-control" name="regular_out" value="06:00 PM" id="regular_out" />

                            <span class="input-group-addon">
                              <i class="ti-time"></i>
                            </span>
                            <label class="form-label" for="form1">Regular out-time</label>
                          </div>
                        </div>
                      </div>
                      <div class="clearfix"></div>
                      <div class="col-md-4 mb-4">
                        <div class="form-outline">
                          <input type="text" class="form-control" name="pf_number" />
                          <label class="form-label">PF Number</label>
                        </div>
                      </div>
                      <div class="col-md-4 mb-4">
                        <div class="form-outline">
                          <input type="text" class="form-control" name="esic_number"/>
                          <label class="form-label">ESIC Number</label>
                        </div>
                      </div>
                      <div class="clearfix"></div>
                      <div class="col-md-4 mb-4">
                        <div class="form-outline">
                          <input type="text" class="form-control" name="uan_number" />
                          <label class="form-label">UAN Number</label>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
                <!-- <div class="row form-section-body mt-5">
                  <div class="col-md-4">
                    <div class="form-heading text-right me-5">
                      <h5 class="typography"><small>Weekly Off </small></h5>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="row form-row align-items-end">
                      <div class="col-md-12 mb-5">
                        <div class="form-check d-flex align-items-center">
                          <input class="form-check-input mt-1" type="checkbox" value="" id="weekoff" name="weekoff" />
                          <label class="form-check-label mx-3 fs-6 fw-600" for="weekoff"> Weekly Off at staff
                            level</label>
                          <mat-icon role="img" matsuffix="" data-mdb-toggle="tooltip"
                            title="Weekly Off would be set at staff level. Default Weekly Off would be at company level."
                            class="mat-icon me-2 material-icons" aria-hidden="true">info_outline</mat-icon>
                        </div>
                      </div>

                    </div>

                  </div>
                </div> -->
                <div class="row form-section-body">
                  <div class="col-md-4">
                    <div class="form-heading text-right me-5">
                      <h5 class="typography"><small>Leave Approvers </small></h5>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="row form-row align-items-end">
                      <div class="col-md-4 mb-5">
                        <div class="">
                          <label class="form-label">Level 1 Approver</label>
                          <select class="browser-default custom-select" name="leave_approvers">
                            <option value="1">None</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row form-section-body w-100 justify-content-center">
                  <!-- <div class="col-md-4">
                    <div class="form-heading text-right me-5">
                      <h5 class="typography"><small>Staff Documents</small></h5>
                    </div>
                  </div> -->
                  <div class="col-md-12">
                    <div class="row form-row align-items-end">
                      <!-- <div class="col-md-4 mb-5">
                        <div class="">
                          <label class="form-label">Document Type</label>
                          <select class="browser-default custom-select" name="staff_document">
                            <option selected value="Aadhaar">Aadhaar</option>
                            <option value="PAN">PAN</option>
                            <option value="Driving License">Driving License</option>
                            <option value="Other">Other</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4 mb-5">
                        <div class="form-outline">
                          <input type="text" class="form-control" name="staff_file"/>
                          <label class="form-label">Enter File Name *</label>
                        </div>
                      </div>
                      <div class="col-md-4 mb-5">
                        <div class="form-outline active">
                          <div class='input-group date' id='expire-date'>
                            <input type='text' class="form-control" name="staff_doc_expire_on" id="staff_doc_expire_on" />

                            <span class="input-group-addon">
                              <i class="ti-calendar"></i>
                            </span>
                            <label class="form-label" for="form1">Expire on</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-8 mb-5">
                        <div class="form-outline">
                          <input type="file" class="file-upload w-100" id="customFile" name="staff_doc"/>
                        </div>
                        <div id="textExample1" class="form-text">
                          Supported format: .pdf, .png, .jpg
                        </div>
                      </div> -->

                      <div class="clearfix"></div>
                      <div class="col-md-12 text-center mb-3">
                        <button type="button" class="btn btn-primary px-5 nextBtn">Next</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="setup-content" id="step-3">
              <div class="personal-detail-tab cs-form">
                <div class="row form-section-body mt-5">
                  <!-- <div class="col-md-4">
                    <div class="form-heading text-right me-5">
                      <h5 class="typography"><small>Attendance from kiosk</small></h5>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="row form-row align-items-end">
                      <div class="col-md-4 mb-5">
                        <div class="">
                          <label class="form-label">Attendance Devices Kiosk</label>
                          <div class="d-flex align-items-center gap-3">
                            <select class="browser-default custom-select" name="attendance_kiosk">
                              <option selected value="">Open this select menu</option>
                              <option value="1">Device 1</option>
                              <option value="2">Device 2</option>
                              <option value="3">Device 3</option>
                            </select>
                            <i class="ti-info-alt trailing" data-mdb-toggle="tooltip" title=""
                              data-mdb-original-title="Attendance allowed from selected kiosk devices"
                              aria-label="Click to check Truein roles info"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div> -->
                </div>
                <div class="row form-section-body mt-2">
                  <div class="col-md-4">
                    <div class="form-heading text-right me-5">
                      <h5 class="typography"><small>Attendance </small></h5>
                    </div>
                  </div>

                  <div class="col-md-8">
                    <div class="row form-row align-items-end">
                      <div class="col-md-12">
                        <div class="form-check d-flex align-items-center">
                          <input class="form-check-input mt-1" type="checkbox" id="allow_from_user_app" name="allow_from_user_app" checked/>
                          <label class="form-check-label ms-3 fs-6 fw-600" for="allow"> Allow attendance from user
                            app </label>
                        </div>
                      </div>

                    </div>

                  </div>
                </div>
                <div class="row form-section-body mt-2">
                  <div class="col-md-4">
                    <div class="form-heading text-right me-5">
                      <h5 class="typography"><small>Geofencing </small></h5>
                    </div>
                  </div>
                  <div class="col-md-8">
                      <div class="row">
                      <div class="col-md-12 mb-2">
                        <div class="form-check form-check-inline">
                          <input class="form-check-input mt-1" type="radio" name="inlineRadioOptions" id="inlineRadio1"
                            value="ad_anywhere" checked />
                          <label class="form-check-label fs-6" for="inlineRadio1"> Anywhere Attendance </label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input mt-1" type="radio" name="inlineRadioOptions" id="inlineRadio2"
                            value="ad_location"/>
                          <label class="form-check-label fs-6" for="inlineRadio2"> Allowed Attendance Geofencing</label>
                        </div>

                        <div class="col-md-4 mb-3  mt-4 location_custom_div" style="display: none">
                          <select class="browser-default custom-select" name="attendance_location">
                            <option selected value="">Attendance Geofencing</option>
                            @foreach($location as $l)
                            <option value="{{$l->id}}">{{$l->location_name}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      </div>
                  </div>
                </div>
                <div class="row form-section-body mt-2">
                  <div class="col-md-4">
                    <div class="form-heading text-right me-5">
                      <h5 class="typography"><small>Base Zone</small></h5>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="row form-row align-items-end">
                      <div class="col-md-4 mb-2">
                        <div class="">
                          <label class="form-label">Select Base Zone</label>
                          <select class="browser-default custom-select" name="site">
                            @foreach($sites as $site)
                              <option value="{{$site->id}}">{{$site->name}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row form-section-body mt-2">
                  <div class="col-md-4">
                    <div class="form-heading text-right me-5">
                      <h5 class="typography"><small>Ward</small></h5>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="row form-row align-items-end">
                      <div class="col-md-4 mb-2">
                        <div class="">
                          <label class="form-label">Select Ward</label>
                          <select class="browser-default custom-select" name="ward">
                            @foreach($wards as $ward)
                              <option value="{{$ward->id}}">{{$ward->ward_name}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- <div class="row form-section-body">
                  <div class="col-md-4">
                    <div class="form-heading text-right me-5">
                      <h5 class="typography"><small>Additional Zone Access</small></h5>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="row form-row align-items-end">
                      <div class="col-md-4 mb-5">
                        <div class="">
                          <label class="form-label">Select Additional Zones</label>
                          <select class="browser-default custom-select" name="additional_site_access">
                            <option selected value="">Open this select menu</option>
                            @foreach($sites as $site)
                              <option value="{{$site->id}}">{{$site->name}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div> -->
                <div class="row form-section-body">
                  <div class="col-md-4"></div>
                  <div class="col-md-8">
                    <div class="row form-row">
                      <div class="col-md-12 mb-3">
                        <!-- <div class="form-check d-flex align-items-center mb-3">
                          <input class="form-check-input mt-1" type="checkbox" id="usercan" name="user_can_be_added_as_manager" />
                          <label class="form-check-label ms-3 fs-6 fw-600" for="usercan">User can be added as
                            Manager/Dept head</label>
                        </div> -->
                        <!-- <div class="form-check d-flex align-items-center mb-3">
                          <input class="form-check-input mt-1" type="checkbox" id="usercan1" name="manager_approval_for_each_attendance" />
                          <label class="form-check-label ms-3 fs-6 fw-600 " for="usercan1">Manager Approval
                            required for each attendance</label>
                          <mat-icon role="img" matsuffix="" data-mdb-toggle="tooltip" title=""
                            class="mat-icon me-2 material-icons fs-6 pt-2 ms-1" aria-hidden="true"
                            data-mdb-original-title="Attendance approval request will go to Admin/Manager for approval.">
                            info_outline</mat-icon>
                        </div> -->
                        <div class="form-check d-flex align-items-center mb-3">
                          <input class="form-check-input mt-1" type="checkbox" id="m_challan_allowed" name="m_challan_allowed" />
                          <label class="form-check-label ms-3 fs-6 fw-600" for="m_challan_allowed">M Challan Allowed</label>
                        </div>
                        <div class="form-check d-flex align-items-center mb-3">
                          <input class="form-check-input mt-1" type="checkbox" id="monitoring_allowed" name="monitoring_allowed" />
                          <label class="form-check-label ms-3 fs-6 fw-600" for="monitoring_allowed">Field Monitoring Allowed</label>
                        </div>
                        <div class="form-check d-flex align-items-center mb-3">
                          <input class="form-check-input mt-1" type="checkbox" id="allow_other_emp_attendance" name="allow_other_emp_attendance" />
                          <label class="form-check-label ms-3 fs-6 fw-600" for="allow_other_emp_attendance">Allowed Other Employess Attendance</label>
                        </div>

                      </div>
                      <!-- <div class="col-md-4 mb-3">
                        <div class="form-check d-flex align-items-center mt-3">
                          <input class="form-check-input mt-1" type="checkbox" id="usercan2" name="invite_user" />
                          <label class="form-check-label ms-3 fs-6 fw-600" for="usercan2"> Invite to Attendance User
                            App </label>
                          <mat-icon role="img" matsuffix="" data-mdb-toggle="tooltip" title=""
                            class="mat-icon me-2 material-icons fs-6 pt-2 ms-1" aria-hidden="true"
                            data-mdb-original-title="Attendance approval request will go to Admin/Manager for approval.">
                            info_outline</mat-icon>
                        </div>
                      </div> -->
                      <div class="col-md-4 mb-5">
                        <div class="">
                          <label class="form-label">Role</label>
                          <div class="d-flex align-items-center gap-3">
                          <select class="browser-default custom-select" name="role">
                            @foreach($roles as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                          </select>
                          <i class="ti-info-alt trailing" data-mdb-toggle="tooltip" title=""
                            data-mdb-original-title="Changing category will also affect staffs leaves. It will be alloted again as per the new category."
                            aria-label="Click to check ManekTech roles info" aria-describedby="tooltip885639"></i>
                          </div>
                        </div>
                      </div>
                      <div class="clearfix"></div>
                      <div class="col-md-8 text-center mb-3">
                        <button type="button" class="btn btn-primary px-5 nextBtn">Next</button>
                      </div>

                    </div>

                  </div>
                </div>
              </div>
            </div>
            <div class="setup-content" id="step-4">
              <div class="personal-detail-tab cs-form">
                <div class="row form-section-body mt-4">
                  <div class="col-md-4">
                    <div class="form-heading text-right me-5">
                      <h5 class="typography"><small>Bank Account Details</small></h5>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="row form-row">
                      <div class="col-md-4 mb-5">
                        <div class="form-outline">
                          <input type="text" class="form-control" name="bank_name" id="bank_name" />
                          <label class="form-label">Bank Name</label>
                        </div>
                      </div>
                      <div class="col-md-4 mb-5">
                        <div class="form-outline">
                          <input type="text" class="form-control" name="staff_name" id="staff_name" />
                          <label class="form-label">Staff Name as Per Bank Record</label>
                        </div>
                      </div>
                      <div class="clearfix"></div>
                      <div class="col-md-4 mb-5">
                        <div class="form-outline">
                          <input type="text" class="form-control" name="account_number" id="account_number" />
                          <label class="form-label">Account Number</label>
                        </div>
                      </div>
                      <div class="col-md-4 mb-5" style="margin-top: -26px;">
                          <label class="form-label">Account Type</label>
                          <select class="browser-default custom-select" name="account_type" id="account_type" >
                            <option value="Current">Current</option>
                            <option selected value="Savings">Savings</option>
                          </select>
                      </div>
                      <div class="clearfix"></div>
                      <div class="col-md-4 mb-5">
                        <div class="form-outline">
                          <input type="text" class="form-control" name="ifsc_code" name="ifsc_code" />
                          <label class="form-label">IFSC Code</label>
                        </div>
                      </div>

                      <div class="col-md-4 mb-5">
                        <div class="form-outline">
                          <input type="text" class="form-control" name="micr_code" id="micr_code" />
                          <label class="form-label">MICR Code</label>
                        </div>
                      </div>
                      <div class="clearfix"></div>
                      <div class="col-md-4 mb-5">
                        <div class="form-outline">
                          <input type="text" class="form-control" name="swift_code" id="swift_code" />
                          <label class="form-label">Swift Code</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row form-section-body mt-4">
                  <div class="col-md-4">
                    <div class="form-heading text-right me-5">
                      <h5 class="typography"><small>Other Details</small></h5>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="row form-row">
                      <div class="col-md-4 mb-5">
                        <div class="form-outline">
                          <input type="text" class="form-control" name="father_name" id="father_name" />
                          <label class="form-label">Father's Name/Spouse Name</label>
                        </div>
                      </div>
                      <div class="clearfix"></div>
                      <div class="col-md-4 mb-5">
                        <div class="form-outline">
                          <textarea class="form-control" rows="2" name="permenent_address" id="permenent_address"></textarea>
                          <label class="form-label">Permanent Address</label>
                        </div>
                      </div>

                      <div class="col-md-4 mb-5">
                        <div class="form-outline">
                          <textarea class="form-control" rows="2" name="communication_address" id="communication_address"></textarea>
                          <label class="form-label">Communication Address</label>
                        </div>
                      </div>
                      <div class="col-md-8 text-center mb-3">
                        <button type="submit" class="btn btn-primary px-5 nextBtn">Add Staff</button>
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

  </main>
  <!--Main layout-->


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

@endsection
@push('js')
{!! JsValidator::formRequest('App\Http\Requests\v1\Backend\StaffRequest') !!}
<script type="text/javascript" src="{{ asset('js/intlTelInput.js')}}"></script>
<script type="text/javascript">

    $("#country_code").intlTelInput({
        initialCountry: "sd",
        separateDialCode: true
    });

    $(document).ready(function () {

      // Validation
      var navListItems = $('ul.setup-panel li a'),
        allWells = $('.setup-content'),
        allNextBtn = $('.nextBtn');

      allWells.hide();

      navListItems.click(function (e) {
        e.preventDefault();
        var $target = $($(this).attr('href')),
          $item = $(this);

        if (!$item.hasClass('disabled')) {
          navListItems.removeClass('active').addClass('btn-default');
          $item.addClass('active');
          allWells.hide();
          $target.show();
          $target.find('input:eq(0)').focus();
        }
      });

      allNextBtn.click(function () {
        var curStep = $(this).closest(".setup-content"),
          curStepBtn = curStep.attr("id"),
          nextStepWizard = $('ul.setup-panel li a[href="#' + curStepBtn + '"]').parent().next().children("a"),
          curInputs = curStep.find("input[type='text'],input[type='url']"),
          isValid = true;

        $(".form-outline").removeClass("has-error");
        for (var i = 0; i < curInputs.length; i++) {
          if (!curInputs[i].validity.valid) {
            isValid = false;
            $(curInputs[i]).closest(".form-outline").addClass("has-error");
          }
        }

        if (isValid)
          nextStepWizard.removeAttr('disabled').trigger('click');
      });

      $('ul.setup-panel li a.active').trigger('click');

      // Second Id type number hide show
      $(document).on("click","#plusbtn-pos",function(){
        $("#second_id_type").css("display","block");
        $("#second_id_number").css("display","block");
        $("#plusbtn-cross").css("display","block");

        $("#plusbtn-pos").css("display","none");
      });

      $(document).on("click","#plusbtn-cross",function(){
        $("#second_id_type").css("display","none");
        $("#second_id_number").css("display","none");
        $("#plusbtn-cross").css("display","none");

        $("#plusbtn-pos").css("display","block");
        $("#second_id_typee").val("");
        $("#second_id_no").val("");
      });

      function checkvalidation(){
        if($("#id_type").val() != "" && $("#id_number").val() !=""){
            $("#plusbtn-pos").removeClass('disabled');
        }
        else{
            $("#plusbtn-pos").addClass('disabled');
        }
      }

      $('#id_number').keyup(function(){
        checkvalidation();
      });

      // Allow user attendance extra field hide show
      $(document).on('change','input[name="inlineRadioOptions"]',function(event){
          if (this.value == 'ad_anywhere') {
              $(".location_custom_div").css('display','none');
          }
          else if (this.value == 'ad_location') {
             $(".location_custom_div").css('display','block');
          }
      });

      $(document).on('click','#allow_from_user_app',function(){
        var checked = $('#allow_from_user_app').is(":checked");
        if(checked == true){
          $('#inlineRadio1').attr('disabled',false);
          $('#inlineRadio2').attr('disabled',false);
        }else{
          $('#inlineRadio1').attr('disabled',true);
          $('#inlineRadio2').attr('disabled',true);
          $(".location_custom_div").css('display','none');
        }
      });

      // Regular in out time change automatically
      $(document).on('change','#shift',function(event){
        $.ajax({
          type:"POST",
          data:{
            id: $(this).val()
          },
          url: "{{route('get.shift.time')}}",
          dataType:'json',
          success:function(result){
            if(result.status == true){
              $("#regular_in").val(result.in);
              $("#regular_out").val(result.out);

              if(result.shift.id == 1){
                $("#regular_in").attr('disabled',false);
                $("#regular_out").attr('disabled',false);
              }else{
                $("#regular_in").attr('disabled',true);
                $("#regular_out").attr('disabled',true);
              }
            }
          }
        })
      });

      $(document).on('keyup','#mobile',function(event){
        var mobile = $("#mobile").val();
        if(mobile.length == 10){
          $.ajax({
            type:"POST",
            data:{mobile:mobile},
            url: "{{route('check.number')}}",
            dataType:'json',
            success:function(result){
              if(result.status == true){
                Swal.fire({
                  title: 'User already added. System will link employee with user details.?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, link it!'
                }).then((result) => {

                })
              }
            }
          })
        }
      })

      $('#dob').on('dp.change', function(e){
          if($('#dob').val() != ""){
            $('#dob').addClass('active');
          }else{
            $('#dob').removeClass('active');
          }
      })

      $('#deactive_date').on('dp.change', function(e){
          if($('#deactive_date').val() != ""){
            $('#deactive_date').addClass('active');
          }else{
            $('#deactive_date').removeClass('active');
          }
      })

      $('#joining_date').on('dp.change', function(e){
          if($('#joining_date').val() != ""){
            $('#joining_date').addClass('active');
          }else{
            $('#joining_date').removeClass('active');
          }
      })

      $('#staff_doc_expire_on').on('dp.change', function(e){
          if($('#staff_doc_expire_on').val() != ""){
            $('#staff_doc_expire_on').addClass('active');
          }else{
            $('#staff_doc_expire_on').removeClass('active');
          }
      })

      $("#dob").keyup(function(){
        if($('#dob').val() != ""){
          $('#dob').addClass('active');
        }else{
          $('#dob').removeClass('active');
        }
      });

      $("#deactive_date").keyup(function(){
        if($('#deactive_date').val() != ""){
          $('#deactive_date').addClass('active');
        }else{
          $('#deactive_date').removeClass('active');
        }
      });

      $("#joining_date").keyup(function(){
        if($('#joining_date').val() != ""){
          $('#joining_date').addClass('active');
        }else{
          $('#joining_date').removeClass('active');
        }
      });

      $("#staff_doc_expire_on").keyup(function(){
        if($('#staff_doc_expire_on').val() != ""){
          $('#staff_doc_expire_on').addClass('active');
        }else{
          $('#staff_doc_expire_on').removeClass('active');
        }
      });
    });
</script>
@endpush('js')
