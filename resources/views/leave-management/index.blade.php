@extends('layouts.master')

@section('title','Leave Management')
@section('content')
<!--Main layout-->
  <main class="content-body">
    <div class="page-body">
      	<div class="setting-body">
        	<div class="nav flex-column nav-tabs text-center" id="leave-management" role="tablist" aria-orientation="vertical">
          		<a class="nav-link ripple active" id="v-tabs-my-leaves-tab" data-mdb-ripple-color="primary" data-mdb-toggle="tab" href="#v-tabs-my-leaves" role="tab"
            	aria-controls="v-tabs-my-leaves" aria-selected="true">My Leaves</a>
          		<!-- <a class="nav-link ripple" id="v-tabs-approvals-tab" data-mdb-toggle="tab" href="#v-tabs-approvals" role="tab"
            	aria-controls="v-tabs-approvals" aria-selected="false">Leave Approvals</a>
          		<a class="nav-link ripple" id="v-tabs-leave-calendar-tab" data-mdb-toggle="tab" href="#v-tabs-leave-calendar" role="tab"
            	aria-controls="v-tabs-leave-calendar" aria-selected="false">Leave Calendar</a> -->
          		<a class="nav-link ripple" id="v-tabs-staff-leaves-tab" data-mdb-toggle="tab" href="#v-tabs-staff-leaves" role="tab"
            	aria-controls="v-tabs-staff-leaves" aria-selected="false">Staff Leaves</a>
          		<a class="nav-link ripple" id="v-tabs-setup-leaves-tab" data-mdb-toggle="tab" href="#v-tabs-setup-leaves" role="tab"
            	aria-controls="v-tabs-setup-leaves" aria-selected="false">Setup Leaves</a>
				<a class="nav-link ripple" id="v-tabs-attendance-tab" data-mdb-toggle="tab" href="#v-tabs-attendance" role="tab"
            	aria-controls="v-tabs-attendance" aria-selected="false">Attendance</a>
        	</div>
        	<!-- Tab navs -->
        	<!-- Tab content -->
        	<div class="tab-content" id="leave-managementContent">
          		<div class="tab-pane fade show active" id="v-tabs-my-leaves" role="tabpanel"
            		aria-labelledby="v-tabs-my-leaves-tab">
            		<div class="d-flex flex-wrap setting-section">
              			<a href="javascript:void(0);" data-mdb-toggle="modal" data-mdb-target="#apply-leave"  class="card mx-sm-3 mx-0 p-2 ripple" data-mdb-ripple-color="primary">
	                		<div class="d-flex align-items-center h-100">
	                  			<div class="icon_container pe-3 ps-1 py-2">
	                    			<img src="img/icons/apply_leave.svg">
	                    		</div>
	          					<div class="text-container d-flex flex-column">
				                    <div>
				                      <h6 class="mb-1">Apply Leave</h6>
				                    </div>
	            					<div class="description">You can apply for leave from here </div>
	          					</div>
				                  <div class="ms-auto align-self-center">
				                    <mat-icon role="img" class="mat-icon text-pody material-icons"
				                      aria-hidden="true">chevron_right</mat-icon>
				                  </div>
	                		</div>
              			</a>
              			<a href="{{route('my-history.index')}}" class="card mx-sm-3 mx-0 p-2 ripple" data-mdb-ripple-color="primary">
                			<div class="d-flex align-items-center h-100">
                  				<div class="icon_container pe-3 ps-1 py-2">
                    				<img src="img/icons/my_history.svg">
                				</div>
                  				<div class="text-container d-flex flex-column">
				                    <div>
				                      	<h6 class="mb-1">My History</h6>
				                    </div>
                    				<div class="description">View your Leave balance and Leave History</div>
                  				</div>
                  				<div class="ms-auto align-self-center">
                    				<mat-icon role="img" class="mat-icon text-body material-icons" aria-hidden="true">chevron_right</mat-icon>
                  				</div>
                			</div>
              			</a>
            		</div>
          		</div>
	          	<div class="tab-pane fade" id="v-tabs-approvals" role="tabpanel" aria-labelledby="v-tabs-approvals-tab">
		            <div class="card">
		              <div class="card-header">
		                <div class="d-flex">
		                  <div class="d-flex flex-column mt-2">
		                    <h5>Leave Approvals</h5>
		                    <small class="mt-1">Approve, Reject or Cancel your staff leaves </small>
		                  </div>
		                </div>
		              </div>
		              <div class="card-block-hid">
		                <div class="card-block px-4 pb-4">
		                  <div class="page-body">
		                    <div class="row mb-2 btn-tow cs-form align-items-end">
		                      <div class="col-md-7">
		                        <div class="row align-items-end">
		                          <div class="col-md-3">
		                            <label class="form-label">Date</label>
		                            <select class="browser-default custom-select">
		                              <option selected>This Month</option>
		                              <option value="1">One</option>
		                              <option value="2">Two</option>
		                              <option value="3">Three</option>
		                            </select>
		                          </div>
		                          <div class="col-md-3">
		                            <label class="form-label">Status</label>
		                            <select class="browser-default custom-select">
		                              <option selected>Pending, Approved</option>
		                              <option value="1">One</option>
		                              <option value="2">Two</option>
		                              <option value="3">Three</option>
		                            </select>
		                          </div>
		                          <div class="col-md-3">
		                            <label class="form-label">Select Zone</label>
		                            <select class="browser-default custom-select">
		                              <option selected>Root Business</option>
		                              <option value="1">One</option>
		                              <option value="2">Two</option>
		                              <option value="3">Three</option>
		                            </select>
		                          </div>
		                          <div class="col-md-3">
		                            <select class="browser-default custom-select">
		                              <option selected>Select Employee</option>
		                              <option value="1">One</option>
		                              <option value="2">Two</option>
		                              <option value="3">Three</option>
		                            </select>
		                          </div>
		                        </div>
		                      </div>
		                      <div class="col-md-5 d-flex justify-content-end">
		                        <div class="form-outline">
		                          <input type="text" class="form-control" />
		                          <label class="form-label">Search</label>
		                        </div>
		                      </div>
		                    </div>
		                    <div class="table-section mt-3">
		                      <div class="datatable">
		                        <table class="leave-approval table table-bordered border-bottom">
		                          <thead>
		                            <tr>
		                              <th width="240" class="th-sm">Name</th>
		                              <th width="140" class="th-sm">Leave Type</th>
		                              <th width="80" class="th-sm">Start Date</th>
		                              <th width="80" class="th-sm">End Date</th>
		                              <th width="80" class="th-sm">Total Days</th>
		                              <th width="140" class="th-sm">Document</th>
		                              <th width="200" class="th-sm">Reason</th>
		                              <th class="th-sm">Approver</th>
		                              <th class="th-sm">Admin/Manager Comment</th>
		                              <th width="180" class="th-sm">Last Update Date</th> 
		                              <th width="60" class="th-sm text-center">Action</th>
		                            </tr>
		                          </thead>
		                          <tbody>
		                            <tr>
		                              <td class="sorting_1">
		                                <div class="name-row">
		                                  <div class="cricle-img position-relative">
		                                      <div class="avatar-container">
		                                        <div class="avatar-content" style="background-color: #322a24;">MP</div>
		                                      </div>
		                                  </div>
		                                  <div class="name-text">
		                                    <div class="d-flex w-100">
		                                      <div>
		                                          <a href="javascript:">
		                                            <span>Mansi Mukeshbhai Parikh </span>
		                                          </a>
		                                      </div>
		                                    </div>
		                                    <span class="emp-id">3 </span>
		                                  </div>
		                                </div>
		                              </td>
		                              <td>Sick Leave</td>
		                              <td>-</td>
		                              <td>-</td>  
		                              <td>0.00</td>
		                              <td></td>
		                              <td></td>
		                              <td></td>
		                              <td></td>
		                              <td>30-May-2022 16:02</td>
		                              <td>
		                                <div class="d-flex flex-column align-items-center">
		                                  <a href="javascript:void(0);"  data-mdb-toggle="tooltip" title="View Leave Details" class="text-body my-1">Allotted</a>
		                                  <a href="javascript:void(0);"  data-mdb-toggle="tooltip" title="Cancel Leave" class="text-body my-1">
		                                    <mat-icon class="mat-icon material-icons" aria-hidden="true">close</mat-icon>
		                                  </a>
		                                </div>
		                              </td>
		                            </tr>
		                          </tbody>
		                        </table>
		                      </div>
		                      
		                    </div>
		                  </div>
		                </div>
		              </div>
		              
		            </div>
	          	</div>
          		<div class="tab-pane fade" id="v-tabs-leave-calendar" role="tabpanel" aria-labelledby="v-tabs-leave-calendar-tab">
		            <div class="card">
		              <div class="card-header">
		                <div class="d-flex">
		                  <div class="d-flex flex-column mt-2">
		                    <h5>Geofencing</h5>
		                    <small class="mt-1">staff-leaves geofencing can be changed from here</small>
		                  </div>
		                </div>
		              </div>
		              <div class="card-block-hid">
		                <div class="card-block px-4 pb-4">
		                  <div class="page-body">
		                    <div class="row mb-2 btn-tow cs-form">
		                      <div class="col-md-6">
		                        <div class="d-flex gap-4 align-items-center">
		                          <button type="button" mattooltip="Add New Staff Access" mattooltipposition="after" class="btn btn-outline-primary btn-floating btn-lg " data-mdb-ripple-color="dark">
		                            <mat-icon role="img"
		                                class="mat-icon material-icons mt-2" aria-hidden="true">add</mat-icon>
		                          </button>
		                          <button type="button" mattooltip="Download geofencing details" mattooltipposition="after" class="btn btn-outline-primary btn-floating btn-lg" data-mdb-ripple-color="dark">
		                            <mat-icon role="img" class="mat-icon material-icons mt-2" aria-hidden="true">cloud_download</mat-icon>
		                          </button>
		                        </div>
		                      </div>
		                      <div class="col-md-6 d-flex justify-content-end">
		                        <div class="form-outline">
		                          <input type="text" class="form-control" />
		                          <label class="form-label">Search</label>
		                        </div>
		                      </div>
		                    </div>
		                    <div class="table-section mt-3">
		                      <div class="datatable">
		                        <table class="manage-staff table table-bordered border-bottom">
		                          <thead>
		                            <tr>
		                              <th class="th-sm">Geofencing Name	</th>
		                              <th class="th-sm">Address </th>
		                              <th class="th-sm">Latitude</th>
		                              <th class="th-sm">Longitude</th>
		                              <th class="th-sm">staff-leaves taking radius (in mts)	</th>
		                              <th class="th-sm">Added by</th>
		                              <th width="80" class="th-sm">Action</th>
		                            </tr>
		                          </thead>
		                          <tbody>
		                            <tr>
		                              <td>Home</td>
		                              <td>Ahmedabad, Ahmedabad, Gujarat, India</td>
		                              <td>23.022505	</td>
		                              <td>72.5713621</td>
		                              <td>100</td>
		                              <td>Naushil Jain(7)	</td>
		                              <td>
		                                <button type="button" class="btn btn-link hidden-arrow btn-sm px-2 text-body"
		                                  data-mdb-toggle="dropdown" aria-expanded="false">
		                                  <mat-icon class="mat-icon material-icons" aria-hidden="true">more_vert</mat-icon>
		                                </button>
		                                <ul class="dropdown-menu shadow-1-strong">
		                                  <li>
		                                    <a class="dropdown-item d-flex align-items-center py-3" href="#" data-mdb-toggle="modal" data-mdb-target="#edit-location">
		                                      <mat-icon role="img" class="mat-icon material-icons" aria-hidden="true">edit</mat-icon>
		                                      <span class="ms-3">Edit</span>
		                                    </a>
		                                  </li>
		                                </ul>
		                              </td>
		                            </tr>
		                          </tbody>
		                        </table>
		                      </div>
		                      
		                    </div>
		                  </div>
		                </div>
		              </div>
		              
		            </div>
          		</div>
		        <div class="tab-pane fade" id="v-tabs-staff-leaves" role="tabpanel" aria-labelledby="v-tabs-staff-leaves-tab">
		            <div class="d-flex flex-wrap setting-section"> 
              			<a href="{{route('manage-emp-leaves.index')}}" class="card mx-sm-3 mx-0 p-2 ripple" data-mdb-ripple-color="primary">
                			<div class="d-flex align-items-center h-100">
                  				<div class="icon_container pe-3 ps-1 py-2">
                    				<img src="img/icons/my_history.svg">
                				</div>
                  				<div class="text-container d-flex flex-column">
				                    <div>
				                      	<h6 class="mb-1">Manage Staff Leaves</h6>
				                    </div>
                    				<div class="description">View staff Leave history. Apply leave on behalf.</div>
                  				</div>
                  				<div class="ms-auto align-self-center">
                    				<mat-icon role="img" class="mat-icon text-body material-icons" aria-hidden="true">chevron_right</mat-icon>
                  				</div>
                			</div>
              			</a>
            		</div>	
            	</div>
          		<div class="tab-pane fade" id="v-tabs-setup-leaves" role="tabpanel" aria-labelledby="v-tabs-setup-leaves-tab">
		            <div class="d-flex flex-wrap setting-section">
		              <a href="{{route('leave-type.index')}}" class="card mx-sm-3 mx-0 p-2 ripple" data-mdb-ripple-color="primary">
		                <div class="d-flex align-items-center h-100">
		                  <div class="icon_container pe-3 ps-1 py-2">
		                    <img src="img/icons/leave_types.svg"></div>
		                  <div class="text-container d-flex flex-column">
		                    <div>
		                      <h6 class="mb-1">Leave Types</h6>
		                    </div>
		                    <div class="description">Setup and manage your leave types from here </div>
		                  </div>
		                  <div class="ms-auto align-self-center">
		                    <mat-icon role="img" class="mat-icon text-pody material-icons"
		                      aria-hidden="true">chevron_right</mat-icon>
		                  </div>
		                </div>
		              </a>
		              <!-- <a href="#" class="card mx-sm-3 mx-0 p-2 ripple" data-mdb-ripple-color="primary">
		                <div class="d-flex align-items-center h-100">
		                  <div class="icon_container pe-3 ps-1 py-2">
		                    <img width="30" src="img/icons/leave_policies.svg"></div>
		                  <div class="text-container d-flex flex-column">
		                    <div>
		                      <h6 class="mb-1">Leave Policies</h6>
		                    </div>
		                    <div class="description"> Setup and manage your leave policies from here  </div>
		                  </div>
		                  <div class="ms-auto align-self-center">
		                    <mat-icon role="img" class="mat-icon text-body material-icons"
		                      aria-hidden="true">chevron_right</mat-icon>
		                  </div>
		                </div>
		              </a>
		              <a href="#" class="card mx-sm-3 mx-0 p-2 ripple" data-mdb-ripple-color="primary">
		                <div class="d-flex align-items-center h-100">
		                  <div class="icon_container pe-3 ps-1 py-2">
		                    <img width="30" src="img/icons/leave_cycle.svg"></div>
		                  <div class="text-container d-flex flex-column">
		                    <div>
		                      <h6 class="mb-1">Edit Leave Cycle</h6>
		                    </div>
		                    <div class="description">Manage your leave cycle from here </div>
		                  </div>
		                  <div class="ms-auto align-self-center">
		                    <mat-icon role="img" class="mat-icon text-body material-icons"
		                      aria-hidden="true">chevron_right</mat-icon>
		                  </div>
		                </div>
		              </a> -->
		            </div>
          		</div>
				<div class="tab-pane fade" id="v-tabs-attendance" role="tabpanel" aria-labelledby="v-tabs-attendance-tab">
					<div class="d-flex flex-wrap setting-section">
						<a href="{{route('attendance-entry.index')}}" class="card mx-sm-3 mx-0 p-2 ripple" data-mdb-ripple-color="primary">
							<div class="d-flex align-items-center h-100">
								<div class="icon_container pe-3 ps-1 py-2">
									<img src="img/icons/my_history.svg">
								</div>
								<div class="text-container d-flex flex-column">
									<div>
										<h6 class="mb-1">Attendance</h6>
									</div>
									<div class="description">View staff attendance.</div>
								</div>
								<div class="ms-auto align-self-center">
									<mat-icon role="img" class="mat-icon text-body material-icons" aria-hidden="true">chevron_right</mat-icon>
								</div>
							</div>
						</a>
						<a href="{{route('shift.index')}}" class="card mx-sm-3 mx-0 p-2 ripple" data-mdb-ripple-color="primary">
							<div class="d-flex align-items-center h-100">
								<div class="icon_container pe-3 ps-1 py-2">
									<mat-icon role="img" class="mat-icon material-icons" aria-hidden="true">add_circle_outline</mat-icon>
								</div>
								<div class="text-container d-flex flex-column">
									<div>
										<h6 class="mb-1">Create Shift</h6>
									</div>
									<div class="description"> Create your own shifts with allowed grace time. Enable Auto assign shift based on first IN punch. </div>
								</div>
								<div class="ms-auto align-self-center">
									<mat-icon role="img" class="mat-icon text-body material-icons" aria-hidden="true">chevron_right</mat-icon>
								</div>
							</div>
						</a>
					</div>	
				</div>
          	</div>
        	<!-- Tab content -->
      	</div>
    </div>



  </main>
  <!--Main layout-->

  <!-- Modal -->
   <!-- Modal -->
   <div class="modal fade" id="apply-leave" tabindex="-1" aria-labelledby="addlocation" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <form id="applyLeaveForm" enctype="multipart/form-data">
        <div class="modal-content">
          <div class="modal-body cs-form">
            <div class="text-center">
              <h5 class="text-body fw-600 my-4">Apply leave</h5>
            </div>
            <div class="row">
              <div class="col-md-10 mx-auto">
                <div class="row">
                  <div class="col-md-12">
                    <div class="row align-items-end">
                      <div class="col-md-6 mb-2">
                        <label class="form-label">Leave Type</label>
                        <select class="browser-default custom-select" name="leave_type" id="leave_type">
                          <option value="">Leave Type</option>
                          @foreach($leaveType as $type)
                          <option value="{{$type->id}}">{{$type->name}}</option>
                          @endforeach
                        </select>      
                      </div>
                      <div class="col-md-6 mb-2 leave_balance">
                           
                      </div>
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
                        <input type="file" name="file" id="file"/>
                    </div>
                    
                  </div>
                    <div class="row mt-4 align-items-end">
                      <div class="col-md-12 mb-3">
                        <div class="form-outline">
                          <textarea class="form-control" rows="1" name="leave_reason" id="leave_reason"></textarea>
                          <label class="form-label">Leave Reason</label>
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
        </div>
      </form>
    </div>
  </div>

   <!-- Modal -->
   <div class="modal fade" id="edit-location" tabindex="-1" aria-labelledby="edit-location" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-body cs-form">
          <div class="row">
            <div class="col-md-11 mx-auto">
              <div class="row">
                <div class="col-md-12 text-center mt-3 mb-4">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input mt-1" type="radio" name="inlineRadioOptions" id="edit-googleLocation"  value="option1" />
                    <label class="form-check-label fs-6" for="edit-googleLocation" data-mdb-toggle="tooltip" title="Set zone address of the location for geofencing" data-mdb-placement="bottom">Add Address from Google location </label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input mt-1" type="radio" name="inlineRadioOptions" id="edit-longitude"  value="option2" />
                    <label class="form-check-label fs-6" for="edit-longitude" data-mdb-toggle="tooltip" title="Set latitude/longitude of the location for geofencing" data-mdb-placement="bottom">Add Latitude Longitude </label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row mt-4 align-items-end">
                    <div class="col-md-12 mb-4">
                      <div class="form-outline">
                        <textarea class="form-control" rows="3"></textarea>
                        <label class="form-label">Address</label>
                      </div>
                    </div>
                  </div>
                  <div class="row mt-4 align-items-end">
                    <div class="col-md-6 mb-4">
                      <div class="form-outline">
                        <input type="text" class="form-control" disabled/>
                        <label class="form-label">Latitude</label>
                      </div>
                    </div>
                    <div class="col-md-6 mb-4">
                      <div class="form-outline">
                        <input type="text" class="form-control" disabled/>
                        <label class="form-label">Longitude</label>
                      </div>
                    </div>
                  </div>
                  <div class="row mt-4 align-items-end">
                    <div class="col-md-12 mb-4">
                      <div class="form-outline">
                        <input type="text" class="form-control" />
                        <label class="form-label">Attendance taking radius (in mts)</label>
                      </div>
                    </div>
                    <div class="col-md-12 mb-4">
                      <div class="form-outline">
                        <input type="text" class="form-control" />
                        <label class="form-label">Geofencing Name</label>
                      </div>
                    </div>
                   
                  </div>
                </div>
                <div class="col-md-6">
                  <div id="edit-map-canvas"></div>
                </div>
              </div>
              
            </div>
          </div>
          
        </div>
        <div class="modal-footer justify-content-between">
          <div>
           <button type="button" class="btn btn-danger text-capitalize px-3 align-items-center d-flex"><mat-icon  role="img" class="fs-5  mat-icon me-2 material-icons" aria-hidden="true">delete</mat-icon> Delete</button>
          </div>
          <div>
            <button type="button" class="btn btn-default text-capitalize ripple-surface me-3" data-mdb-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary text-capitalize">Save Geofencing</button>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('js')
<script type="text/javascript">
  $(document).ready(function(){
    $(document).on('change','#leave_type',function(event){
      $.ajax({
        type:"POST",
        data:{
          leave_type: $("#leave_type").val()
        },
        url: "{{route('check.leave.balance')}}",
        dataType:'json',
        success:function(result){
          if(result.status == true){
            var html = '<span>Balance : '+result.data+'</span>'
            $(".leave_balance").html(html);
          }          
        }
      })
    });   

    $("#applyLeaveForm").validate({
      rules: {
        leave_type: "required",
        start_date: "required",
        end_date: "required",
        start_date_period: "required",
        end_date_period: "required",
      },
      messages: {
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
        var fd = new FormData(applyLeaveForm);
        $.ajax({
          url: "{{route('leave-management.store')}}",
          type: 'post',
          data: fd,
          contentType: false,
          processData: false,
          success: function(response){
            if(response.status == true){
              toastr.success(response.message);
              $("#apply-leave").modal('toggle');
              $("#applyLeaveForm")[0].reset();
            }else{
            	toastr.error(response.message);
            }
          }
        });
      }   
    });

    $(document).on('change','#leave_type',function(){
    	nullValidation();
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
	    nullValidation();
	    if($('#start_date').val() != ""){
    		$('#start_date').addClass('active');
    	}else{
    		$('#start_date').removeClass('active');
    	}
	})

	$('#end_date').on('dp.change', function(e){ 
	    nullValidation();
	    if($('#end_date').val() != ""){
    		$('#end_date').addClass('active');
    	}else{
    		$('#end_date').removeClass('active');
    	}
	})


    function nullValidation(){
        if($("#leave_type").val() != "" && $("#start_date").val() !="" && $("#end_date").val() != ""){
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

  });
</script>
@endpush