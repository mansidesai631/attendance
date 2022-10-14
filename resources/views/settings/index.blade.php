<?php
$selected_site = App\Models\Employee::where('id',Auth::id())->first();
?>
@extends('layouts.master')

@section('title','Settings')
@section('content')
 <!--Main layout-->
 <main class="content-body">
    <div class="page-body">
        <div class="setting-body">
            <div class="nav flex-column nav-tabs text-center" id="v-tabs-tab" role="tablist" aria-orientation="vertical">
                <!-- <a class="nav-link ripple" id="v-tabs-policies-tab" data-mdb-ripple-color="primary" data-mdb-toggle="tab" href="#v-tabs-policies" role="tab"
                    aria-controls="v-tabs-policies" aria-selected="true">Policies</a>
                <a class="nav-link ripple active" id="v-tabs-admin-tab" data-mdb-toggle="tab" href="#v-tabs-admin" role="tab"
                    aria-controls="v-tabs-admin" aria-selected="false">Admin</a> -->
                <a class="nav-link ripple" id="v-tabs-geofencing-tab" data-mdb-toggle="tab" href="#v-tabs-geofencing" role="tab"
                    aria-controls="v-tabs-geofencing" aria-selected="false">Geofencing</a>
                <!-- <a class="nav-link ripple" id="v-tabs-attendance-tab" data-mdb-toggle="tab" href="#v-tabs-attendance" role="tab"
                    aria-controls="v-tabs-attendance" aria-selected="false">Attendance</a>
                <a class="nav-link ripple" id="v-tabs-kiosk-tab" data-mdb-toggle="tab" href="#v-tabs-kiosk" role="tab"
                    aria-controls="v-tabs-kiosk" aria-selected="false">Kiosk</a> -->
                <a class="nav-link ripple" id="v-tabs-sites-tab" data-mdb-toggle="tab" href="#v-tabs-sites" role="tab"
                    aria-controls="v-tabs-sites" aria-selected="false">Zones</a>

                <a class="nav-link ripple" id="v-tabs-wards-tab" data-mdb-toggle="tab" href="#v-tabs-wards" role="tab"
                    aria-controls="v-tabs-wards" aria-selected="false">Wards</a>
                <a class="nav-link ripple" id="v-tabs-circles-tab" data-mdb-toggle="tab" href="#v-tabs-circles" role="tab"
                    aria-controls="v-tabs-circles" aria-selected="false">Circles</a>
                <a class="nav-link ripple" id="v-tabs-other-tab" data-mdb-toggle="tab" href="#v-tabs-other" role="tab"
                    aria-controls="v-tabs-other" aria-selected="false">Other</a>

            </div>
            <!-- Tab navs -->
            <!-- Tab content -->
            <div class="tab-content" id="v-tabs-tabContent">
                <div class="tab-pane fade" id="v-tabs-policies" role="tabpanel"
                    aria-labelledby="v-tabs-policies-tab">
                    policies content
                </div>
                <div class="tab-pane fade show" id="v-tabs-admin" role="tabpanel" aria-labelledby="v-tabs-admin-tab">
                    <div class="d-flex flex-wrap setting-section">
                        <a href="manage-users-access.html" class="card mx-sm-3 mx-0 p-2 ripple" data-mdb-ripple-color="primary">
                            <div class="d-flex align-items-center h-100">
                            <div class="icon_container pe-3 ps-1 py-2">
                                <img src="img/icons/manage_users.svg"></div>
                            <div class="text-container d-flex flex-column">
                                <div>
                                <h6 class="mb-1">Manage Staff and Access</h6>
                                </div>
                                <div class="description"> Add non attendance staff. Manage access of all staff </div>
                            </div>
                            <div class="ms-auto align-self-center">
                                <mat-icon role="img" class="mat-icon text-pody material-icons"
                                aria-hidden="true">chevron_right</mat-icon>
                            </div>
                            </div>
                        </a>
                        <a href="system-log.html" class="card mx-sm-3 mx-0 p-2 ripple" data-mdb-ripple-color="primary">
                            <div class="d-flex align-items-center h-100">
                            <div class="icon_container pe-3 ps-1 py-2">
                                <img src="img/icons/system_log.svg"></div>
                            <div class="text-container d-flex flex-column">
                                <div>
                                <h6 class="mb-1">System Log</h6>
                                </div>
                                <div class="description"> System trails of settings changed by staff </div>
                            </div>
                            <div class="ms-auto align-self-center">
                                <mat-icon role="img" class="mat-icon text-body material-icons"
                                aria-hidden="true">chevron_right</mat-icon>
                            </div>
                            </div>
                        </a>
                        <div class="card mx-sm-3 mx-0 p-2">
                            <div class="d-flex align-items-center h-100">
                                <div class="icon_container pe-3 ps-1 py-2">
                                    <mat-icon role="img" class="mat-icon text-body material-icons"
                                    aria-hidden="true">plus_one</mat-icon>
                                </div>
                                <div class="text-container d-flex flex-column">
                                    <div>
                                    <h6 class="mb-1">ManekTech Features</h6>
                                    </div>
                                    <div class="description"> All the ManekTech features' status </div>
                                </div>
                                <div class="ms-auto align-self-center">
                                    <mat-icon role="img" class="mat-icon text-body material-icons"
                                    aria-hidden="true">chevron_right</mat-icon>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="v-tabs-geofencing" role="tabpanel" aria-labelledby="v-tabs-sites-tab">
                    <div class="card">
                        <div class="card-header">
                          <div class="d-flex">
                            <div class="d-flex flex-column mt-2">
                              <h5>Geofencing</h5>
                              <small class="mt-1">Attendance geofencing can be changed from here</small>
                            </div>
                          </div>
                        </div>
                         <!-- <button type="button" data-mdb-toggle="modal" data-mdb-target="#add-location" mattooltip="Add New Staff Access" mattooltipposition="after" class="btn btn-outline-primary btn-floating btn-lg " data-mdb-ripple-color="dark">
                                <mat-icon role="img"
                                    class="mat-icon material-icons mt-2" aria-hidden="true">add</mat-icon>
                              </button>
                              <button type="button" mattooltip="Download geofencing details" mattooltipposition="after" class="btn btn-outline-primary btn-floating btn-lg export_locations" data-mdb-ripple-color="dark">
                                <mat-icon role="img" class="mat-icon material-icons mt-2" aria-hidden="true">cloud_download</mat-icon>
                              </button> -->
                        <div class="card-block-hid">
                          <div class="card-block px-4 pb-4">
                            <div class="page-body">
                              <div class="row mb-2 btn-tow cs-form">
                                <div class="col-md-6">
                                    <div class="d-flex gap-4 align-items-center">
                                        <button type="button" data-mdb-toggle="modal" data-mdb-target="#add-location" mattooltip="Add New Staff Access" mattooltipposition="after" class="btn btn-outline-primary btn-floating btn-lg " data-mdb-ripple-color="dark">
                                          <mat-icon role="img"
                                              class="mat-icon material-icons mt-2" aria-hidden="true">add</mat-icon>
                                        </button>
                                        <button type="button" mattooltip="Download geofencing details" mattooltipposition="after" class="btn btn-outline-primary btn-floating btn-lg export_locations" data-mdb-ripple-color="dark">
                                          <mat-icon role="img" class="mat-icon material-icons mt-2" aria-hidden="true">cloud_download</mat-icon>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex justify-content-end">
                                  <div class="form-outline">
                                    <input type="text" class="form-control" id="location_filter_search"/>
                                    <label class="form-label">Search</label>
                                  </div>
                                </div>
                              </div>
                              <div class="table-section mt-3">
                                <div class="datatable">
                                  <table class="manage-staff table table-bordered border-bottom" width="100%" id="location_table">
                                    <thead>
                                      <tr>
                                        <th class="th-sm">Geofencing Name</th>
                                        <th class="th-sm">Address</th>
                                        <th class="th-sm">Latitude</th>
                                        <th class="th-sm">Longitude</th>
                                        <th class="th-sm">Attendance taking radius (in mts)</th>
                                        <th class="th-sm">Added by</th>
                                        <th width="80" class="th-sm">Action</th>
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
                    </div>
                </div>
                <div class="tab-pane fade" id="v-tabs-attendance" role="tabpanel" aria-labelledby="v-tabs-attendance-tab">
                    attendance content
                </div>
                <div class="tab-pane fade" id="v-tabs-kiosk" role="tabpanel" aria-labelledby="v-tabs-kiosk-tab">
                    kiosk content
                </div>
                <div class="tab-pane fade" id="v-tabs-sites" role="tabpanel" aria-labelledby="v-tabs-sites-tab">
                    <div class="card">
                        <div class="card-header">
                          <div class="d-flex">
                            <div class="d-flex flex-column mt-2">
                              <h5>Zones</h5>
                              <small class="mt-1">Setup and manage your zones from here</small>
                            </div>
                          </div>
                        </div>
                        <div class="card-block-hid">
                          <div class="card-block px-4 pb-4">
                            <div class="page-body">
                                <div class="row mb-2 btn-tow cs-form">
                                    <div class="col-md-6">
                                        <div class="d-flex gap-4 align-items-center">
                                          <button type="button" data-mdb-toggle="modal" data-mdb-target="#create-new-site" mattooltip="Add New Staff Access" mattooltipposition="after" class="btn btn-outline-primary btn-floating btn-lg " data-mdb-ripple-color="dark">
                                            <mat-icon role="img"
                                                class="mat-icon material-icons mt-2" aria-hidden="true">add</mat-icon>
                                          </button>
                                        </div>
                                      </div>
                                    <div class="col-md-6 d-flex justify-content-end">
                                        <div class="form-outline">
                                            <input type="text" class="form-control" id="filter_search" name="filter_search"/>
                                            <label class="form-label">Search</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-section mt-3">
                                    <div class="datatable">
                                    <table class="manage-staff table table-bordered border-bottom" width="100%" id="site_table">
                                        <thead>
                                        <tr>
                                            <th class="th-sm">Zone Name</th>
                                            <th class="th-sm">Country Code</th>
                                            <th class="th-sm">Timezone</th>
                                            <th class="th-sm">Address</th>
                                            <th class="th-sm">Current Active Users</th>
                                            <th width="80" class="th-sm">Action</th>
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

                    </div>
                </div>
                <div class="tab-pane fade" id="v-tabs-wards" role="tabpanel" aria-labelledby="v-tabs-wards-tab">
                    <div class="card">
                        <div class="card-header">
                          <div class="d-flex">
                            <div class="d-flex flex-column mt-2">
                              <h5>Wards</h5>
                              <small class="mt-1">Setup and manage your wards from here</small>
                            </div>
                          </div>
                        </div>
                        <div class="card-block-hid">
                          <div class="card-block px-4 pb-4">
                            <div class="page-body">
                                <div class="row mb-2 btn-tow cs-form">
                                    <div class="col-md-6">
                                        <div class="d-flex gap-4 align-items-center">
                                          <button type="button" data-mdb-toggle="modal" data-mdb-target="#create-wards-site" mattooltip="Add New Staff Access" mattooltipposition="after" class="btn btn-outline-primary btn-floating btn-lg " data-mdb-ripple-color="dark">
                                            <mat-icon role="img"
                                                class="mat-icon material-icons mt-2" aria-hidden="true">add</mat-icon>
                                          </button>
                                        </div>
                                      </div>
                                    <div class="col-md-6 d-flex justify-content-end">
                                        <div class="form-outline">
                                            <input type="text" class="form-control" id="filter_search_ward" name="filter_search_ward"/>
                                            <label class="form-label">Search</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-section mt-3">
                                    <div class="datatable">
                                    <table class="manage-staff table table-bordered border-bottom" width="100%" id="ward_table">
                                        <thead>
                                        <tr>
                                            <th class="th-sm">Zone Name</th>
                                            <th class="th-sm">Ward Name</th>
                                            <th class="th-sm">Address</th>
                                            <th width="80" class="th-sm">Action</th>
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

                    </div>
                </div>
                <div class="tab-pane fade" id="v-tabs-circles" role="tabpanel" aria-labelledby="v-tabs-circles-tab">
                  <div class="card">
                      <div class="card-header">
                        <div class="d-flex">
                          <div class="d-flex flex-column mt-2">
                            <h5>Circles</h5>
                            <small class="mt-1">Setup and manage your circles from here</small>
                          </div>
                        </div>
                      </div>
                      <div class="card-block-hid">
                        <div class="card-block px-4 pb-4">
                          <div class="page-body">
                              <div class="row mb-2 btn-tow cs-form">
                                  <div class="col-md-6">
                                      <div class="d-flex gap-4 align-items-center">
                                        <button type="button" data-mdb-toggle="modal" data-mdb-target="#create-new-circle" mattooltip="Add New Circle" mattooltipposition="after" class="btn btn-outline-primary btn-floating btn-lg " data-mdb-ripple-color="dark">
                                          <mat-icon role="img"
                                              class="mat-icon material-icons mt-2" aria-hidden="true">add</mat-icon>
                                        </button>
                                      </div>
                                    </div>
                                  <div class="col-md-6 d-flex justify-content-end">
                                      <div class="form-outline">
                                          <input type="text" class="form-control" id="filter_search_circle" name="filter_search_circle"/>
                                          <label class="form-label">Search</label>
                                      </div>
                                  </div>
                              </div>
                              <div class="table-section mt-3">
                                  <div class="datatable">
                                  <table class="manage-staff table table-bordered border-bottom" width="100%" id="circle_table">
                                      <thead>
                                      <tr>
                                          <th class="th-sm">Ward Name</th>
                                          <th class="th-sm">Circle Name</th>
                                          <th width="80" class="th-sm">Action</th>
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

                  </div>
              </div>
                <div class="tab-pane fade show active" id="v-tabs-other" role="tabpanel" aria-labelledby="v-tabs-other-tab">
                    <div class="d-flex flex-wrap setting-section">
                        <a href="{{ route('department.index') }}" class="card mx-sm-3 mx-0 p-2 ripple" data-mdb-ripple-color="primary">
                            <div class="d-flex align-items-center h-100">
                                <div class="icon_container pe-3 ps-1 py-2">
                                    <img src="img/icons/department_settings.svg"></div>
                                <div class="text-container d-flex flex-column">
                                    <div>
                                    <h6 class="mb-1">Department settings</h6>
                                    </div>
                                    <div class="description">You can set up Departments and Department Heads from here</div>
                                </div>
                                <div class="ms-auto align-self-center">
                                    <mat-icon role="img" class="mat-icon text-pody material-icons"
                                    aria-hidden="true">chevron_right</mat-icon>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('staff-category.index') }}" class="card mx-sm-3 mx-0 p-2 ripple" data-mdb-ripple-color="primary">
                            <div class="d-flex align-items-center h-100">
                                <div class="icon_container pe-3 ps-1 py-2">
                                    <img width="30" src="img/icons/staff_catagory_settings.svg"></div>
                                <div class="text-container d-flex flex-column">
                                    <div>
                                    <h6 class="mb-1">Staff Category settings</h6>
                                    </div>
                                    <div class="description">You can setup Categories from here</div>
                                </div>
                                <div class="ms-auto align-self-center">
                                    <mat-icon role="img" class="mat-icon text-body material-icons"
                                    aria-hidden="true">chevron_right</mat-icon>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('designation.index') }}" class="card mx-sm-3 mx-0 p-2 ripple" data-mdb-ripple-color="primary">
                            <div class="d-flex align-items-center h-100">
                                <div class="icon_container pe-3 ps-1 py-2">
                                    <img width="30" src="img/icons/designation_settings.svg"></div>
                                <div class="text-container d-flex flex-column">
                                    <div>
                                    <h6 class="mb-1">Designation and other fields settings</h6>
                                    </div>
                                    <div class="description">You can setup Designations and Other Staff Functions from here</div>
                                </div>
                                <div class="ms-auto align-self-center">
                                    <mat-icon role="img" class="mat-icon text-body material-icons"
                                    aria-hidden="true">chevron_right</mat-icon>
                                </div>
                            </div>
                        </a>
                        <a href="javascript:void(0);" data-mdb-toggle="modal" data-mdb-target="#default-manager" class="card mx-sm-3 mx-0 p-2 ripple" data-mdb-ripple-color="primary">
                            <div class="d-flex align-items-center h-100">
                                <div class="icon_container pe-3 ps-1 py-2">
                                    <img width="30" src="img/icons/default_manager.svg"></div>
                                <div class="text-container d-flex flex-column">
                                    <div>
                                    <h6 class="mb-1">Default Manager </h6>
                                    </div>
                                    <div class="description">You can setup a Default Manager from here</div>
                                </div>
                                <div class="ms-auto align-self-center">
                                    <mat-icon role="img" class="mat-icon text-body material-icons"
                                    aria-hidden="true">chevron_right</mat-icon>
                                </div>
                            </div>
                        </a>
                        <a href="javascript:void(0);" data-mdb-toggle="modal" data-mdb-target="#staff-mode" class="card mx-sm-3 mx-0 p-2 ripple staff" data-mdb-ripple-color="primary">
                            <div class="d-flex align-items-center h-100">
                                <input type="hidden" name="site_id" id="site_id" value="{{ $selected_site->site->id }}">
                                <div class="icon_container pe-3 ps-1 py-2">
                                    <img width="30" src="img/icons/emp_mode.svg"></div>
                                <div class="text-container d-flex flex-column">
                                    <div>
                                    <h6 class="mb-1">Staff Mode</h6>
                                    </div>
                                    <div class="description">You can setup your staff mode like Permanent, Temporary or Both from here</div>
                                </div>
                                <div class="ms-auto align-self-center">
                                    <mat-icon role="img" class="mat-icon text-body material-icons"
                                    aria-hidden="true">chevron_right</mat-icon>
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
  <div class="modal fade" id="default-manager" tabindex="-1" aria-labelledby="addusers" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header text-center">
          <h5 class="modal-title w-100">Default Manager</h5>
          <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body cs-form">
          <div class="attend-page p-4">
            <span class="setting-title"> Default Manager </span>
            <div class="outer-container">
              <div class="row align-items-end w-100">
                <div class="col-md-4 mb-4">
                  <label class="form-label">Manager</label>
                  <select class="browser-default custom-select" id="default_manager_id" name="default_manager_id">
                    <!-- <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option> -->
                  </select>
                </div>
                <div class="col-md-4 mb-4">
                  <button class="btn btn-primary w-50" id="manager_set">Set</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal -->
  <div class="modal fade" id="staff-mode" tabindex="-1" aria-labelledby="addusers" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header text-center">
          <h5 class="modal-title w-100">Staff Mode</h5>
          <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body cs-form">
          <div class="attend-page p-4">
            <span class="setting-title"> Staff Mode <mat-icon role="img" matsuffix="" data-mdb-toggle="tooltip" title="
              Permanent: Your zone will be configured for permanent employees. Some features specific to contract workers will be disabled.

              Contract: Your zone will be configured for contract employees. Contract worker specific features like contractor agency will be enabled.

              Both: Your zone will be configured for both Permanent and Contract employees." class="mat-icon me-2 material-icons fs-5 mt-2" aria-hidden="true" >info_outline</mat-icon></span>
            <div class="outer-container">
              <div class="row align-items-end w-100">
                <div class="col-md-4 mb-4">
                  <input type="hidden" name="site_id" id="site_id" value="{{ $selected_site->site->id }}">
                  <label class="form-label">Select Mode</label>
                  <select class="browser-default custom-select" id="staffDropdown" name="staffDropdown">
                    <option value="PERMANENT" selected>Permanent</option>
                    <option value="CONTRACT">Contract</option>
                    <option value="BOTH">Both</option>
                  </select>
                </div>
                <div class="col-md-6 mb-4">
                  <button class="btn btn-default me-3" id="resetDropdown" disabled>Reset</button>
                  <button class="btn btn-primary " id="changeStaffType" disabled>Change</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
   <div class="modal fade" id="add-location" tabindex="-1" aria-labelledby="addlocation" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
       <form id="addLocationForm" method="post">
      <div class="modal-content">
        <div class="modal-body cs-form">
          <div class="row">
            <div class="col-md-11 mx-auto">

                  <div class="row">
                    <div class="col-md-12 text-center mt-3 mb-4">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input mt-1" type="radio" name="address_type" id="googleLocation"  value="0" checked/>
                        <label class="form-check-label fs-6" for="googleLocation" data-mdb-toggle="tooltip" title="Set zone address of the location for geofencing" data-mdb-placement="bottom">Add Address from Google location </label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input mt-1" type="radio" name="address_type" id="longitude"  value="1" />
                        <label class="form-check-label fs-6" for="longitude" data-mdb-toggle="tooltip" title="Set latitude/longitude of the location for geofencing" data-mdb-placement="bottom">Add Latitude Longitude </label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="row mt-4 align-items-end">
                        <div class="col-md-12 mb-4">
                          <div class="form-outline">
                            <input type="text" class="form-control" name="location_address" id="location_address">
                            <input type="hidden" name="location_address" value="">
                            <label class="form-label">Address</label>
                          </div>
                        </div>
                      </div>
                      <div class="row mt-4 align-items-end">
                        <div class="col-md-6 mb-4">
                          <div class="form-outline">
                            <input type="number" class="form-control" name="location_latitude" id="location_latitude" value="0" />
                            <input type="hidden" name="location_latitude" value="0">
                            <label class="form-label">Latitude</label>
                          </div>
                        </div>
                        <div class="col-md-6 mb-4">
                          <div class="form-outline">
                            <input type="number" class="form-control" name="location_longitude" id="location_longitude" value="0" />
                            <input type="hidden" name="location_longitude" value="0">
                            <label class="form-label">Longitude</label>
                          </div>
                        </div>
                      </div>
                      <div class="row mt-4 align-items-end">
                        <div class="col-md-12 mb-4">
                          <div class="form-outline">
                            <input type="number" class="form-control" name="location_radius"  id="location_radius" value="100" />
                            <label class="form-label">Attendance taking radius (in mts)</label>
                          </div>
                        </div>
                        <div class="col-md-12 mb-4">
                          <div class="form-outline">
                            <input type="text" class="form-control" name="location_name" id="location_name" />
                            <label class="form-label">Geofencing Name</label>
                          </div>
                        </div>

                      </div>
                    </div>
                    <div class="col-md-6">
                      <div id="map-canvas"></div>
                    </div>
                  </div>

            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default text-capitalize ripple-surface" data-mdb-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary text-capitalize" id="add_location" name="add_location" disabled>Add Geofencing</button>
        </div>
      </div>
      </form>
    </div>
  </div>

  <!-- Modal -->
   <div class="modal fade" id="edit-location" tabindex="-1" aria-labelledby="addlocation" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form id="editLocationForm" method="post">
      <div class="modal-content">
        <div class="modal-body cs-form">
          <div class="row">
            <div class="col-md-11 mx-auto">

                  <div class="row">
                    <div class="col-md-12 text-center mt-3 mb-4">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input mt-1" type="radio" name="edit_address_type" id="edit_googleLocation"  value="0" />
                        <label class="form-check-label fs-6" for="googleLocation" data-mdb-toggle="tooltip" title="Set zone address of the location for geofencing" data-mdb-placement="bottom">Edit Address from Google location </label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input mt-1" type="radio" name="edit_address_type" id="edit_longitude"  value="1" />
                        <label class="form-check-label fs-6" for="longitude" data-mdb-toggle="tooltip" title="Set latitude/longitude of the location for geofencing" data-mdb-placement="bottom">Edit Latitude Longitude </label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="row mt-4 align-items-end">
                        <div class="col-md-12 mb-4">
                          <div class="form-outline">
                            <input type="hidden" name="location_id" id="location_id" value="">
                            <input type="text" class="form-control" name="edit_location_address" id="edit_location_address">
                            <input type="hidden" name="edit_location_address">
                            <label class="form-label">Address</label>
                          </div>
                        </div>
                      </div>
                      <div class="row mt-4 align-items-end">
                        <div class="col-md-6 mb-4">
                          <div class="form-outline">
                            <input type="number" class="form-control" name="edit_location_latitude" id="edit_location_latitude" />
                            <input type="hidden" name="edit_location_latitude">
                            <label class="form-label">Latitude</label>
                          </div>
                        </div>
                        <div class="col-md-6 mb-4">
                          <div class="form-outline">
                            <input type="number" class="form-control" name="edit_location_longitude" id="edit_location_longitude" />
                            <input type="hidden" name="edit_location_longitude">
                            <label class="form-label">Longitude</label>
                          </div>
                        </div>
                      </div>
                      <div class="row mt-4 align-items-end">
                        <div class="col-md-12 mb-4">
                          <div class="form-outline">
                            <input type="number" class="form-control" name="edit_location_radius"  id="edit_location_radius" />
                            <label class="form-label">Attendance taking radius (in mts)</label>
                          </div>
                        </div>
                        <div class="col-md-12 mb-4">
                          <div class="form-outline">
                            <input type="text" class="form-control" name="edit_location_name" id="edit_location_name" />
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
            <div class="delete-btn">
               <button type="button" class="btn btn-danger text-capitalize px-3 align-items-center d-flex delete_location"><mat-icon  role="img" class="fs-5  mat-icon me-2 material-icons" aria-hidden="true">delete</mat-icon> Delete</button>
            </div>
            <div class="buttonmodal-group">
              <button type="button" class="btn btn-default text-capitalize ripple-surface" data-mdb-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary text-capitalize" id="edit_location" name="edit_location">Save Geofencing</button>
          </div>
        </div>
      </div>
      </form>
    </div>
  </div>

   <!-- Modal -->
    <div class="modal fade" id="edit-site" tabindex="-1" aria-labelledby="editSite" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title w-100" id="exampleModalLabel">Edit zone</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editSiteForm"  enctype="multipart/form-data">
                    <div class="modal-body cs-form">
                        <div class="row">
                            <div class="col-md-11 mx-auto">
                            <div class="row g-5">
                                <div class="col-md-6">
                                <div class="company-logo mt-3">
                                    <div class="logo-container mt-1">
                                        <img id="logo" alt="" src="img/default-img.png"></div>
                                        <input type="file" class="form-control d-none" id="edit_site_logo_file" name="edit_site_logo_file" />
                                        <!-- data-mdb-toggle="tooltip" title="Change Logo"  -->
                                        <button data-mdb-toggle="modal" data-mdb-target="#site-logo-modal" class="btn btn-sm btn-link text-body change-logo-btn"  type="button" >
                                            <mat-icon role="img" class="mat-icon material-icons" aria-hidden="true">edit</mat-icon>
                                        </button>
                                    </div>
                                    <div class="row mt-5 align-items-end">
                                        <div class="col-md-12 mb-4">
                                            <div class="form-outline">
                                            <textarea class="form-control" rows="4" name="edit_site_address" id="edit_site_address"></textarea>
                                            <label class="form-label">Address</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                <div class="row mt-4 align-items-end">
                                    <div class="col-md-12 mb-4">
                                    <div class="form-outline">
                                        <input type="hidden" name="edit_site_id" id="edit_site_id" value="">
                                        <input type="text" class="form-control" name="edit_site_name" id="edit_site_name"/>
                                        <label class="form-label">Zone Name</label>
                                    </div>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label class="form-label">Zone Country Code</label>
                                        <select class="form-control select2" id="edit_countries" name="edit_countries">
                                            <option value="91" data-capital="New Delhi" selected>+91 India(भारत)</option>
                                            <option value="62" data-capital="Mariehamn">+62 Indonesia(Indonesia)</option>
                                            <option value="354" data-capital="Tirana"> +354 Iceland(Ísland)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label class="form-label">Select TimeZone</label>
                                        <select class="select2" id="edit_timezone" name="edit_timezone">
                                            <option value="Asia/Kolkata" selected>Asia/Kolkata - (GMT+05:30)</option>
                                            <option value="Asia/Krasnoyarsk" >Asia/Krasnoyarsk - (GMT+07:00)</option>
                                            <option value="Asia/Kuching">Asia/Kuching - (GMT+08:00)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-check d-flex align-items-center mt-4 mb-5 ms-2">
                                            <input class="form-check-input mt-1" type="checkbox" value="" id="chk2">
                                            <label class="form-check-label text-body mx-3 fs-6" for="chk2">Set Attendance Limit</label>
                                        </div>
                                        <div class="form-outline" style="display:none" id="edit_attendance_limit_div">
                                            <input type="number" min="0" class="form-control" name="edit_attendance_limit" id="edit_attendance_limit"/>
                                            <label class="form-label">Maximum Attendance Count</label>
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
                        <button type="submit" class="btn btn-primary text-capitalize" id="update_site" >Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="create-wards-site" tabindex="-1" aria-labelledby="addSite" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title w-100" id="employeeDetails">Create Ward</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addWardForm"  method="post">
                    <div class="modal-body cs-form">
                        <div class="row">
                            <div class="col-md-11 mx-auto">
                                <div class="row">
                                <div class="col-md-12">
                                    <div class="row mt-4 align-items-end">
                                        <div class="col-md-12 mb-2">
                                            <div class="" id="section_code">
                                                <label class="form-label">Zone</label>
                                                <select class="browser-default custom-select" name="site_ward_id" id="site_ward_id">

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4 align-items-end">
                                        <div class="col-md-12 mb-2">
                                            <div class="form-outline">
                                                <input type="text" class="form-control" name="ward_name" id="ward_name"/>
                                                <label class="form-label">Ward name</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4 align-items-end">
                                      <div class="col-md-12 mb-2">
                                          <div class="form-outline">
                                              <input type="text" class="form-control" name="ward_address" id="ward_address"/>
                                              <label class="form-label">Ward address</label>
                                          </div>
                                      </div>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="modal-footer mt-4 d-flex justify-content-between">
                            <div class="">
                                <!-- <button type="button" class="btn btn-primary text-capitalize ripple-surface" data-mdb-dismiss="modal">Delete</button> -->
                            </div>
                            <div class="">
                                <button type="button" class="btn btn-default text-capitalize ripple-surface" data-mdb-dismiss="modal">cancle</button>
                                <button type="submit" class="btn btn-primary text-capitalize" id="create_ward_btn">create</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="edit-ward" tabindex="-1" aria-labelledby="addSite" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title w-100" id="employeeDetails">Edit Wards</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editWardForm"  method="post">
                    <div class="modal-body cs-form">
                        <div class="row">
                            <div class="col-md-11 mx-auto">
                                <div class="row">
                                <input type="hidden" name="ward_id" id="ward_id">
                                <div class="col-md-12">
                                    <div class="row mt-4 align-items-end">
                                        <div class="col-md-12 mb-2">
                                            <div class="" id="section_code">
                                                <label class="form-label">Zone</label>
                                                <select class="browser-default custom-select" name="edit_site_ward_id" id="edit_site_ward_id">

                                                </select>
                                             </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4 align-items-end">
                                        <div class="col-md-12 mb-2">
                                            <div class="form-outline">
                                                <input type="text" class="form-control" name="edit_ward_name" id="edit_ward_name"/>
                                                <label class="form-label">Ward name</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4 align-items-end">
                                      <div class="col-md-12 mb-2">
                                          <div class="form-outline">
                                              <input type="text" class="form-control" name="edit_ward_address" id="edit_ward_address"/>
                                              <label class="form-label">Ward address</label>
                                          </div>
                                      </div>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="modal-footer mt-4 d-flex justify-content-between">
                            <div class="">
                                <button type="button" class="btn btn-danger text-capitalize ripple-surface delete_ward" data-mdb-dismiss="modal">Delete</button>
                            </div>
                            <div class="">
                                <button type="button" class="btn btn-default text-capitalize ripple-surface" data-mdb-dismiss="modal">Cancle</button>
                                <button type="submit" class="btn btn-primary text-capitalize" id="edit_ward_btn">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade circle-modal" id="create-new-circle" tabindex="-1" aria-labelledby="addCircle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
              <div class="modal-header text-center">
                  <h5 class="modal-title w-100" id="employeeDetails">Create Circle</h5>
                  <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
              </div>
              <form id="addCircleForm"  method="post">
                  <div class="modal-body cs-form">
                      <div class="row">
                          <div class="col-md-11 mx-auto">
                              <div class="row">
                              <div class="col-md-12">
                                  <div class="row mt-4 align-items-end">
                                      <div class="col-md-12 mb-2">
                                            <div class="" id="section_code">
                                                <label class="form-label">Ward</label>
                                                <select class="browser-default custom-select" name="ward_id" id="ward_id">

                                                </select>
                                            </div>
                                      </div>
                                  </div>
                                  <div class="row mt-4 align-items-end">
                                      <div class="col-md-12 mb-2">
                                          <div class="form-outline">
                                              <input type="text" class="form-control" name="circle_name" id="circle_name"/>
                                              <label class="form-label">Circle name</label>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                      <div class="modal-footer mt-4 d-flex justify-content-between">
                          <div class="">
                              <button type="button" class="btn btn-default text-capitalize ripple-surface" data-mdb-dismiss="modal">Cancle</button>
                              <button type="submit" class="btn btn-primary text-capitalize" id="create_circle_btn">Create</button>
                          </div>
                      </div>
                  </div>
              </form>
          </div>
      </div>
    </div>


  <!-- Modal -->
  <div class="modal fade circle-modal" id="edit-circle" tabindex="-1" aria-labelledby="editCircle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
              <div class="modal-header text-center">
                  <h5 class="modal-title w-100" id="employeeDetails">Edit Circles</h5>
                  <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
              </div>
              <form id="editCircleForm"  method="post">
                  <div class="modal-body cs-form">
                      <div class="row">
                          <div class="col-md-11 mx-auto">
                              <div class="row">
                              <div class="col-md-12">
                                  <div class="row mt-4 align-items-end">
                                      <div class="col-md-12 mb-2">
                                            <div class="" id="section_code">
                                                <label class="form-label">Ward</label>
                                                <select class="browser-default custom-select" name="edit_ward_id" id="edit_ward_id">

                                                </select>
                                            </div>
                                      </div>
                                  </div>
                                  <div class="row mt-4 align-items-end">
                                      <div class="col-md-12 mb-2">
                                          <div class="form-outline">
                                                <input type="hidden" name="edit_circle_id" id="edit_circle_id" value="">
                                                <input type="text" class="form-control" name="edit_circle_name" id="edit_circle_name"/>
                                                <label class="form-label">Circle name</label>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                      <div class="modal-footer mt-4 d-flex justify-content-between">
                          <div class="">
                              <button type="button" class="btn btn-primary text-capitalize ripple-surface delete_circle" data-mdb-dismiss="modal">Delete</button>
                          </div>
                          <div class="">
                              <button type="button" class="btn btn-default text-capitalize ripple-surface" data-mdb-dismiss="modal">Cancle</button>
                              <button type="submit" class="btn btn-primary text-capitalize" id="edit_circle_btn">Update</button>
                          </div>
                      </div>
                  </div>
              </form>
          </div>
      </div>
  </div>

    <!-- Modal -->
    <div class="modal fade" id="create-new-site" tabindex="-1" aria-labelledby="addSite" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title w-100" id="employeeDetails">Create new zone</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addSiteForm"  enctype="multipart/form-data">
                    <div class="modal-body cs-form">
                        <div class="row">
                            <div class="col-md-11 mx-auto">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row mt-4 align-items-end">
                                        <div class="col-md-12 mb-2">
                                            <div class="form-outline edit-profile">
                                                <img alt="" id="site_logo" class="site-logo-img" src="img/default-img.png">
                                                <input type="file" class="form-control d-none" id="site_logo_file" name="site_logo_file" />
                                                <a href="#" data-mdb-toggle="modal" data-mdb-target="#site-logo-modal"><i class="fas fa-pen"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4 align-items-end">
                                        <div class="col-md-12 mb-2">
                                            <div class="form-outline">
                                                <textarea class="form-control" rows="3" name="site_address" id="site_address"></textarea>
                                                <label class="form-label">Address</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row mt-4 align-items-end">
                                        <div class="col-md-12 mb-2">
                                            <div class="form-outline">
                                                <input type="text" class="form-control" name="site_name" id="site_name"/>
                                                <label class="form-label">zone name</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4 align-items-end">
                                        <div class="col-md-12 mb-2">
                                            {{-- <div class="form-outline" id="section_code"> --}}
                                                <label class="form-label">Zone Country Code</label>
                                                <select class="form-control select2" id="countries" name="countries">
                                                    <option value="91" data-capital="New Delhi" selected>+91 India(भारत)</option>
                                                    <option value="62" data-capital="Mariehamn">+62 Indonesia(Indonesia)</option>
                                                    <option value="354" data-capital="Tirana"> +354 Iceland(Ísland)</option>
                                                </select>
                                            {{-- </div> --}}
                                        </div>
                                    </div>
                                    <div class="row mt-4 align-items-end">
                                        <div class="col-md-12 mb-2">
                                            {{-- <div class="form-outline" id="section_timezone"> --}}
                                                <label class="form-label"> Select Timezone </label>
                                                <select class="form-control select2" id="timezone" name="timezone">
                                                    <option value="Asia/Kolkata" selected>Asia/Kolkata - (GMT+05:30)</option>
                                                    <option value="Asia/Krasnoyarsk" >Asia/Krasnoyarsk - (GMT+07:00)</option>
                                                    <option value="Asia/Kuching">Asia/Kuching - (GMT+08:00)</option>
                                                </select>
                                            {{-- </div> --}}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                      <div class="form-check d-flex align-items-center mt-4 mb-5 ms-2">
                                          <input class="form-check-input mt-1" type="checkbox" value="" id="chk">
                                          <label class="form-check-label text-body mx-3 fs-6" for="chk">Set Attendance Limit</label>
                                      </div>
                                      <div class="form-outline" style="display:none" id="attendance_limit_div">
                                          <input type="number" min="0" class="form-control" name="attendance_limit" id="attendance_limit"/>
                                          <label class="form-label">Maximum Attendance Count</label>
                                      </div>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="modal-footer mt-4">
                            <button type="button" class="btn btn-default text-capitalize ripple-surface" data-mdb-dismiss="modal">cancle</button>
                            <button type="submit" class="btn btn-primary text-capitalize">create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

   <!-- Modal -->
    <div class="modal fade" id="site-logo-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                <h5 class="text-body fw-600 my-4">Change Zone Logo</h5>
                </div>
                <div class="row mb-4">
                <div class="col-md-8 mx-auto">
                    <label class="form-label" for="customFile">Select Image</label>
                    <input type="file" class="form-control" id="customFile" />
                </div>
                </div>
                <div class="img-container">
                <img id="image" src="img/picture.jpg" alt="Picture">
                </div>
                <!-- <div class="text-center"><h3 class="text-body my-5 py-5 fw-600">Select Image</h3></div> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default text-capitalize" data-mdb-dismiss="modal">Close</button>
                <button type="button" id="selectImage" class="btn btn-primary text-capitalize">Add Slide</button>
            </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="filter_search_export" id="filter_search_export">

@endsection
@push('js')
<script type="text/javascript" src="{{asset('js/settings/location/map.js')}}"></script>
<script>
$(function() {
    var st_type;
    render_table();
    function render_table(){
      var table = $("#site_table");
      table.DataTable().destroy();

      $filter_search = $('#filter_search').val();

      table.DataTable({
          processing: true,
          serverSide: true,
          // scrollX: true,
          order: [],
            ajax: {
                'url': "{{ route('site.all.datatable') }}",
                'type': 'POST',
                data:{
                    filter_search : $filter_search,
                }
            },
            columns: [
                {data: 'name', name: 'name'},
                {data: 'code', name: 'code'},
                {data: 'timezone', name: 'timezone'},
                {data: 'addess', name: 'addess'},
                {data: 'current_active_users', name: 'current_active_users'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
      });
    }

    $('#filter_search').keyup(function() {
      render_table();
    });

    function format(item, state) {
        if (!item.id) {
        return item.text;
        }
        var countryUrl = "https://hatscripts.github.io/circle-flags/flags/";
        var stateUrl = "https://oxguy3.github.io/flags/svg/us/";
        var url = state ? stateUrl : countryUrl;
        var img = $("<img>", {
        class: "img-flag",
        width: 26,
        src: url + item.element.value.toLowerCase() + ".svg"
        });
        var span = $("<span>", {
        text: " " + item.text
        });
        // span.prepend(img);
        return span;
    }

    $(document).ready(function() {
        $(".select2").select2({
            dropdownParent: $('#create-new-site')
        });
        $("#countries").select2({
        dropdownParent: $('#create-new-site'),
        templateResult: function(item) {
            return format(item, false);
        }
        });

    });

    $('#chk').on('click',function(e) {
        toggleCheckBoxSelection('#attendance_limit_div', this.checked)
    });
    $('#chk2').on('click',function(e) {
        toggleCheckBoxSelection('#edit_attendance_limit_div', this.checked)
    });
    function toggleCheckBoxSelection(selector, show){
        var editBox = $(selector);
        show ? editBox.css('display','block') : editBox.css('display','none')
    }

    $("#addSiteForm").validate({
        ignore: ":hidden",
        rules: {
            site_name: "required",
            site_address: "required",
        },
        messages: {
            site_name: {
                required: "Please enter zone name",
            },
            site_address: {
                required: "Please enter zone address",
            },
        },
        submitHandler: function (form) {
            var fd = new FormData(addSiteForm);
            $.ajax({
                url: "{{route('sites.store')}}",
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function (result) {
                    if(result.status == true){
                        toastr.success(result.message);
                        $("#create-new-site").modal('toggle');
                        render_table();
                        $("#addSiteForm")[0].reset();
                    }else{
                        toastr.error(result.message);
                        $("#create-new-site").modal('toggle');
                        render_table();
                        $("#addSiteForm")[0].reset();
                    }
                }
            });
        }
    });

    $(document).on('click','.edit_site',function(event){
        var id  = $(this).attr('data-id');
        $("#edit_site_id").val(id);
        $.ajax({
            type:"GET",
            data:{id:id},
            url: base_url+"sites/"+id+"/edit",
            dataType:'json',
            success:function(result){
                if(result.status == true){
                    $("#edit_site_name").val(result.data.name);
                    $("#edit_site_name").focus();
                    $("#edit_site_address").val(result.data.addess);
                    $("#edit_site_address").focus();
                    $('.select2').select2();
                    $("#edit_countries").val(result.data.code).trigger('change');
                    $("#edit_timezone").val(result.data.timezone).trigger('change');
                    if(result.data.logo){
                      	let logo = document.getElementById('logo')
                        logo.src= base_url+"storage/siteLogo/"+result.data.logo
                    } else {
						let logo = document.getElementById('logo')
                        logo.src= "img/default-img.png"
					}

                    if(result.data.ad_limit == '0') {
                        toggleCheckBoxSelection('#edit_attendance_limit_div', false);
                        $('#chk2').prop("checked", false);
                        $("#edit_attendance_limit").val('');

                    } else {
                        toggleCheckBoxSelection('#edit_attendance_limit_div',true);
                        $('#chk2').prop("checked", true);
                        $("#edit_attendance_limit").val(result.data.ad_limit);
                    }
                }
            }
        })
    });

    $(document).on('change', '#customFile', function(event) {
        if(event.target.files && event.target.files.length)
        {
            let image = document.getElementById('image')
            image.src= URL.createObjectURL(event.target.files[0])
        }

    })

    $(document).on('click', '#selectImage', function(event) {

        let files = $('#customFile').prop('files');
        if(files && files.length )
        {
            $("#site_logo_file").prop("files", files);
            let site_logo = document.getElementById('site_logo')
            site_logo.src= URL.createObjectURL(files[0])

            $("#edit_site_logo_file").prop("files", files);
            let logo = document.getElementById('logo')
            logo.src= URL.createObjectURL(files[0])

            $("#site-logo-modal").modal('toggle');
        }
    })

    $("#editSiteForm").validate({
        ignore: ":hidden",
        rules: {
            edit_site_name: "required",
            edit_site_address: "required",
        },
        messages: {
            edit_site_name: {
                required: "Please enter zone name",
            },
            edit_site_address: {
                required: "Please enter zone address",
            },
        },
        submitHandler: function (form) {
            var id = $("#edit_site_id").val();
            var fd = new FormData(editSiteForm);
            $.ajax({
                url: "{{route('site.update')}}",
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function (result) {
                    if(result.status == true){
                        toastr.success(result.message);
                        $("#edit-site").modal('toggle');
                        render_table();
                        $("#editSiteForm")[0].reset();
                    }else{
                        toastr.error(result.message);
                        $("#edit-site").modal('toggle');
                        render_table();
                        $("#editSiteForm")[0].reset();
                    }
                }
            });
        }
    });

    $("#staffDropdown").change(function(){
      nullValidation();
    });

    function nullValidation(){
        if($("#staffDropdown").val() == st_type){
            $("#resetDropdown").attr('disabled',true);
            $("#changeStaffType").attr('disabled',true);
        }
        else{
            $("#resetDropdown").attr('disabled',false);
            $("#changeStaffType").attr('disabled',false);
        }
    }

    function getStaffType(){
        var site_id = $('#site_id').val();
        $.ajax({
            type:"POST",
            data:{
                site_id : site_id,
            },
            url: "{{route('staff-type.reset')}}",
            dataType:'json',
            success:function(result){
                if(result.status == true){
                    st_type = result.data.mode;
                    $("#staffDropdown").val(result.data.mode);
                }
            }
        })
    }

    $(document).on('click','.staff',function(event){
        getStaffType();
    });

    $("#resetDropdown").on('click',function(e){
        getStaffType();
        $("#resetDropdown").attr('disabled',true);
        $("#changeStaffType").attr('disabled',true);
    });

    $("#changeStaffType").on('click',function(e){
        var staff_type = $('#staffDropdown').val();
        var site_id = $('#site_id').val();
        $.ajax({
            url: "{{route('staff-type.update')}}",
            method: "POST",
            data:{
                staff_type : staff_type,
                site_id : site_id,
            }
        })
        .done(function(result) {
            $("#staff-mode").modal('toggle');
        })
        .fail(function(error) {
            console.log(error);
        });
    });
});

$(document).ready(function(){

    // Get Datatables Data
    render_table1();
    function render_table1(){
      var table = $("#location_table");
      table.DataTable().destroy();

      $filter_search = $('#location_filter_search').val();
      $('#filter_search_export').val($filter_search);

      table.DataTable({
          processing: true,
          serverSide: true,
          // scrollX: true,
          order: [],
          ajax: {
              'url': "{{ route('location.all.datatable') }}",
              'type': 'POST',
              data:{
                filter_search : $filter_search,
              }
          },
          columns: [
              {data: 'location_name', name: 'location_name'},
              {data: 'address', name: 'address'},
              {data: 'latitude', name: 'latitude'},
              {data: 'longitude', name: 'longitude'},
              {data: 'radius', name: 'radius'},
              {data: 'added_by', name: 'added_by'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ],
      });
    }

    // Filters
    $('#location_filter_search').keyup(function() {
      render_table1();
    });

    // Store Location Details
    $("#addLocationForm").validate({
        ignore: ":hidden",
        rules: {
          location_radius: {
            min: 20,
          },
        },
        messages: {
          location_radius: {
            min: "Radius Should be 20 meters or above."
          }
        },
        submitHandler: function (form) {
          $.ajax({
            type: "POST",
            url: "{{route('location.store')}}",
            data: $(form).serialize(),
            success: function (result) {
              if(result.status == true){
                toastr.success(result.message);
                $("#add-location").modal('toggle');
                $("#addLocationForm")[0].reset();
                render_table1();
              }
            }
          });
        }
    });

    // Validation Null not allowed for add modal
    $('#location_address').keyup(function() {
      nullValidation();
    });

    $('#location_latitude').keyup(function() {
      nullValidation();
    });

    $('#location_longitude').keyup(function() {
      nullValidation();
    });

    $('#location_radius').keyup(function() {
      nullValidation();
    });

    $('#location_name').keyup(function() {
      nullValidation();
    });

    function nullValidation(){
        if($("#location_address").val() != "" && $("#location_latitude").val() != "" && $("#location_longitude").val() !="" && $("#location_radius").val() != "" && $("#location_name").val() != ""){
            $("#add_location").attr('disabled',false);
        }
        else{
            $("#add_location").attr('disabled',true);
        }
    }

    // Validation Null not allowed for edit modal
    $('#edit_location_address').keyup(function() {
      editNullValidation();
    });

    $('#edit_location_latitude').keyup(function() {
      editNullValidation();
    });

    $('#edit_location_longitude').keyup(function() {
      editNullValidation();
    });

    $('#edit_location_radius').keyup(function() {
      editNullValidation();
    });

    $('#edit_location_name').keyup(function() {
      editNullValidation();
    });

    $("#edit_location").attr('disabled',true);

    function editNullValidation(){
        if($("#edit_location_address").val() != "" &&
            $("#edit_location_latitude").val() != "" &&
            $("#edit_location_longitude").val() != "" &&
            $("#edit_location_radius").val() != "" &&
            $("#edit_location_name").val() != ""){

            $("#edit_location").attr('disabled',false);
        }else{
            $("#edit_location").attr('disabled',true);
        }
    }

    // Display Location Details in edit Modal
    $(document).on('click','.location_edit',function(){
        var id = $(this).attr('data-id');
        $("#location_id").val(id);
        $.ajax({
            type:"GET",
            data:{id:id},
            url: base_url+"location/"+id+"/edit",
            dataType:'json',
            success:function(result){
              if(result.status == true){
                $("#edit_location_address").val(result.data.address);
                $("#edit_location_latitude").val(result.data.latitude);
                $("#edit_location_longitude").val(result.data.longitude);
                $("#edit_location_radius").val(result.data.radius);
                $("#edit_location_name").val(result.data.location_name);

                $('input[name="edit_location_address"]').val(result.data.address);
                $('input[name="edit_location_latitude"]').val(result.data.latitude);
                $('input[name="edit_location_longitude"]').val(result.data.longitude);

                $("#edit_location_address").focus();
                $("#edit_location_latitude").focus();
                $("#edit_location_longitude").focus();
                $("#edit_location_radius").focus();
                $("#edit_location_name").focus();

                if(result.data.address_type == 0){
                    $("#edit_googleLocation").prop('checked',true);
                    $("#edit_location_longitude").attr('disabled',true);
                    $("#edit_location_latitude").attr('disabled',true);
                    $("#edit_location_address").attr('disabled',false);
                    edit_add_lat_long();
                }else{
                    $("#edit_longitude").prop('checked',true);
                    $("#edit_location_longitude").attr('disabled',false);
                    $("#edit_location_latitude").attr('disabled',false);
                    $("#edit_location_address").attr('disabled',true);
                }
              }
            }
        })
    })

    // Update Location Details
    $("#editLocationForm").validate({
        ignore: ":hidden",
        rules: {
          edit_location_radius: {
            min: 20,
          },
        },
        messages: {
          edit_location_radius: {
            min: "Radius Should be 20 meters or above."
          }
        },
        submitHandler: function (form) {
          $.ajax({
            type: "POST",
            url: "{{route('location.update')}}",
            data: $(form).serialize(),
            success: function (result) {
              if(result.status == true){
                toastr.success(result.message);
                $("#edit-location").modal('toggle');
                render_table1();
              }else{
                toastr.error(result.message);
              }
            }
          });
        }
    });

    // Export location functionality
    $(document).on('click', '.export_locations', function(event) {
      filter_search_export = $('[name="filter_search_export"]').val();
      $.ajax({
          'url': "{{ route('location.export') }}",
          'type': 'POST',
          data:{
              filter_search_export : filter_search_export,
          }
      })
      .done(function(result, status, xhr) {
          if(result == false) {
              //toast_error("Record not found");
          } else {
              var disposition = xhr.getResponseHeader('content-disposition');
              var matches = /"([^"]*)"/.exec(disposition);
              var file_name = 'location_'+getFormattedTime()+'.csv';
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

    // Delete location functionality
    $(document).on('click','.delete_location',function(event){
      var id = $("#location_id").val();
      Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
              url: "{{route('location.delete')}}",
              method: "POST",
              data:{
                id : id,
              }
            })
            .done(function(result) {
            if(result.status == true){
                $('#edit-location').modal('toggle');
                toastr.success(result.message);
                render_table1();
            }
          })
          .fail(function() {
          });
        }
      })
    })

    $.ajax({
        type:"GET",
        url: "{{route('get.staff')}}",
        dataType:'json',
        success:function(result){
            if(result.status == true){
                var html  = '';
                $(result.data).each(function(index, value) {
                    html += '<option value="'+value.id+'">'+value.name+'</option>';
                });
                $("#default_manager_id").html(html);

            }
        }
    })

    $(document).on('click','#manager_set',function(){
        $.ajax({
            type: "POST",
            url: "{{route('save.default.manager')}}",
            data: {
                'id':$('#default_manager_id').find('option:selected').val(),
            },
            success: function (result) {
              if(result.status == true){
                toastr.success(result.message);
                $("#default-manager").modal('toggle');
              }
            }
        });
    });
});

$(document).ready(function(){
    // Get Datatables Data
    render_table2();
    function render_table2(){
      var table = $("#ward_table");
      table.DataTable().destroy();

      $filter_search = $('#filter_search_ward').val();

      table.DataTable({
          processing: true,
          serverSide: true,
          // scrollX: true,
          order: [],
          ajax: {
              'url': "{{ route('ward.all.datatable') }}",
              'type': 'POST',
              data:{
                filter_search : $filter_search,
              }
          },
          columns: [
              {data: 'site', name: 'site'},
              {data: 'ward_name', name: 'ward_name'},
              {data: 'address', name: 'address'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ],
      });
    }

    $('#filter_search_ward').keyup(function() {
      render_table2();
    });

    $.ajax({
        type: "GET",
        url: "{{route('get.all.sites')}}",
        success: function (result) {
          if(result.status == true){
            var option = '';
            $.each(result.data,function(key,val){
                option += "<option value='"+val.id+"'>"+val.name+"</option>";
            });
            $('select#site_ward_id').html(option);
            $('select#edit_site_ward_id').html(option);
          }
        }
    });

    $("#addWardForm").validate({
        ignore: ":hidden",
        rules: {
            ward_name: "required",
            site_ward_id: "required",
            ward_address: "required",
        },
        messages: {
            site_ward_id: {
                required: "Please enter zone",
            },
            ward_name: {
                required: "Please enter ward name",
            },
            ward_address: {
                required: "Please enter ward address",
            },
        },
        submitHandler: function (form) {
          $.ajax({
            type: "POST",
            url: "{{route('wards.store')}}",
            data: $(form).serialize(),
            success: function (result) {
              if(result.status == true){
                toastr.success(result.message);
                $("#create-wards-site").modal('toggle');
                $("#addWardForm")[0].reset();
                render_table2();
              }
            }
          });
        }
    });

    $(document).on('click','.circle_edit',function(event){
        var id  = $(this).attr('data-id');
        $("#edit_circle_id").val(id);
        $.ajax({
            type:"GET",
            data:{id:id},
            url: base_url+"circles/"+id+"/edit",
            dataType:'json',
            success:function(result){
                if(result.status == true){
                    $("#edit_circle_name").val(result.data.circle_name);
                    $("#edit_circle_name").focus();
                    $('select#edit_ward_id').val(result.data.ward_id);
                }
            }
        })
    });

    $(document).on('click','.ward_edit',function(event){
        var id  = $(this).attr('data-id');
        $("#ward_id").val(id);
        $.ajax({
            type:"GET",
            data:{id:id},
            url: base_url+"wards/"+id+"/edit",
            dataType:'json',
            success:function(result){
                if(result.status == true){
                    $("#edit_ward_name").val(result.data.ward_name);
                    $("#edit_ward_name").focus();
                    $("#edit_ward_address").val(result.data.address);
                    $("#edit_ward_address").focus();
                    $('select#edit_site_ward_id').val(result.data.site_id);
                }
            }
        })
    });

    $("#editWardForm").validate({
        ignore: ":hidden",
        rules: {
            edit_ward_name: "required",
            edit_site_ward_id: "required",
            edit_ward_address: "required",
        },
        messages: {
            edit_site_ward_id: {
                required: "Please enter zone",
            },
            edit_ward_name: {
                required: "Please enter ward name",
            },
            edit_ward_address: {
                required: "Please enter ward address",
            },
        },
        submitHandler: function (form) {
          $.ajax({
            type: "POST",
            url: "{{route('ward.update')}}",
            data: $(form).serialize(),
            success: function (result) {
              if(result.status == true){
                toastr.success(result.message);
                $("#edit-ward").modal('toggle');
                $("#editWardForm")[0].reset();
                render_table2();
              }
            }
          });
        }
    });

    $(document).on('click','.delete_ward',function(event){
      var id = $("#ward_id").val();
      Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
              url: "{{route('ward.delete')}}",
              method: "POST",
              data:{
                id : id,
              }
            })
            .done(function(result) {
            if(result.status == true){
                toastr.success(result.message);
                render_table2();
            }
          })
          .fail(function() {
          });
        }
      })
    })

});

$(document).ready(function(){
    // Get Datatables Data
    render_table3();
    function render_table3(){
      var table = $("#circle_table");
      table.DataTable().destroy();

      $filter_search = $('#filter_search_circle').val();

      table.DataTable({
          processing: true,
          serverSide: true,
          // scrollX: true,
          order: [],
          ajax: {
              'url': "{{ route('circle.all.datatable') }}",
              'type': 'POST',
              data:{
                filter_search : $filter_search,
              }
          },
          columns: [
              {data: 'ward', name: 'ward'},
              {data: 'circle_name', name: 'circle_name'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ],
      });
    }

    $('#filter_search_circle').keyup(function() {
      render_table3();
    });

    $(document).on('click','#v-tabs-circles-tab',function(event){
        $.ajax({
            type: "GET",
            url: "{{route('get.all.wards')}}",
            success: function (result) {
            if(result.status == true){
                var option = '';
                $.each(result.data,function(key,val){
                    option += "<option value='"+val.id+"'>"+val.ward_name+"</option>";
                });
                $('select#ward_id').html(option);
                $('select#edit_ward_id').html(option);
            }
            }
        });
    });

    $("#addCircleForm").validate({
        ignore: ":hidden",
        rules: {
            circle_name: "required",
            ward_id: "required",
        },
        messages: {
            ward_id: {
                required: "Please enter ward",
            },
            circle_name: {
                required: "Please enter circle name",
            },
        },
        submitHandler: function (form) {
          $.ajax({
            type: "POST",
            url: "{{route('circles.store')}}",
            data: $(form).serialize(),
            success: function (result) {
              if(result.status == true){
                toastr.success(result.message);
                $("#create-new-circle").modal('toggle');
                $("#addCircleForm")[0].reset();
                render_table3();
              }
            }
          });
        }
    });

    $(document).on('click','.circle_edit',function(event){
        var id  = $(this).attr('data-id');
        $("#edit_circle_id").val(id);
        $.ajax({
            type:"GET",
            data:{id:id},
            url: base_url+"circles/"+id+"/edit",
            dataType:'json',
            success:function(result){
                if(result.status == true){
                    $("#edit_circle_name").val(result.data.circle_name);
                    $("#edit_circle_name").focus();
                    $('select#edit_ward_id').val(result.data.ward_id);
                }
            }
        })
    });

    $("#editCircleForm").validate({
        ignore: ":hidden",
        rules: {
            edit_ward_id: "required",
            edit_circle_name: "required",
        },
        messages: {
            edit_ward_id: {
                required: "Please enter ward",
            },
            edit_circle_name: {
                required: "Please enter circle name",
            },
        },
        submitHandler: function (form) {
            var id = $("#edit_circle_id").val();
            var fd = new FormData(editCircleForm);
            $.ajax({
                url: "{{route('circle.update')}}",
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function (result) {
                    if(result.status == true){
                        toastr.success(result.message);
                        $("#edit-circle").modal('toggle');
                        render_table3();
                        $("#editCircleForm")[0].reset();
                    }else{
                        toastr.error(result.message);
                        $("#edit-circle").modal('toggle');
                        render_table3();
                        $("#editCircleForm")[0].reset();
                    }
                }
            });
        }
    });

    $(document).on('click','.delete_circle',function(event){
      var id = $("#edit_circle_id").val();
      Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
              url: "{{route('circle.delete')}}",
              method: "POST",
              data:{
                id : id,
              }
            })
            .done(function(result) {
            if(result.status == true){
                toastr.success(result.message);
                render_table3();
            }
          })
          .fail(function() {
          });
        }
      })
    })
});

</script>
@endpush
