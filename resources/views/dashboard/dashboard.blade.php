@extends('layouts.master')

@section('title','Dashboard')
@section('content')
<main class="content-body">
    <div class="page-body">
        <!-- Tabs content -->
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="small-box mb-0 bg-info text-white h-100">
                    <div class="inner">
                        <div class="dashboardbx-left">
                            <h3>{{$employeeCount['total']}}</h3>
                            <p>Staff</p>
                        </div>
                        <div class="dashboardbx-right">
                            <span><i class="fas fa-users "></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="small-box mb-0 bg-success text-white h-100">
                    <div class="inner">
                        <div class="dashboardbx-left">
                            <h3>{{$employeeCount['totalPresent']}}</h3>
                            <p>Present</p>
                        </div>
                        <div class="dashboardbx-right">
                            <span><i class="fas fa-user-plus"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="small-box mb-0 bg-warning text-white h-100">
                    <div class="inner">
                        <div class="dashboardbx-left">
                            <h3>{{$employeeCount['totalAbsent']}}</h3>
                            <p>Absent</p>
                        </div>
                        <div class="dashboardbx-right">
                            <span><i class="fas fa-user-minus"></i></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="small-box mb-0 bg-danger text-white h-100">
                        <div class="inner">
                            <div class="dashboardbx-left">
                                <h3>{{$employeeCount['totalLeave']}}</h3>
                                <p>Leave</p>
                            </div>
                            <div class="dashboardbx-right">
                                <span><i class="fas fa-user-slash"></i></span>
                            </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="small-box mb-0 bg-warning text-white h-100">
                    <div class="inner">
                        <div class="dashboardbx-left">
                            <h3>{{$employeeCount['totalLeaveWithoutInfo']}}</h3>
                            <p>Leave without information</p>
                        </div>
                        <div class="dashboardbx-right">
                            <span><i class="fas fa-book-reader"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="small-box mb-0 bg-danger text-white h-100">
                    <div class="inner">
                        <div class="dashboardbx-left">
                            <h3>{{$employeeCount['field']}}</h3>
                            <p>Total Field Monitor</p>
                        </div>
                        <div class="dashboardbx-right">
                            <span><i class="fas fa-user-tie"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="small-box mb-0 bg-secondary text-white h-100">
                    <div class="inner">
                        <div class="dashboardbx-left">
                            <h3>{{$employeeCount['m_challan']}}</h3>
                            <p>Total M-challan Amount</p>
                        </div>
                        <div class="dashboardbx-right">
                            <span><i class="fas fa-scroll"></i></span>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </div>    
        <!-- Tabs content --> 

        <div class="row">
            <div class="col mb-3">
              <div class="card">
                  <div class="card-block p-4">
                    <div class="table-section mt-3">
                      <div class="datatable">
                        <table class="department table table-bordered border-bottom">
                          <thead>
                            <tr>
                              <th class="th-sm">Name</th>
                              <th class="th-sm">Working Days </th>
                              <th class="th-sm">Present</th>
                              <th class="th-sm">Absent</th>
                              <th class="th-sm">Leave</th>
                              <th class="th-sm">Absent Without Leave</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($employee as $emp)
                                <tr>
                                    <td>{{ $emp->name }}</td>
                                    <td>{{ $totalWorkingDays }}</td>
                                    <td>{{ $emp->attendances_count }}</td>
                                    <td>{{ $nr_work_days - $emp->attendances_count}}</td>
                                    <td>{{ $emp->leave_list_count }}</td>
                                    <td>{{ ($nr_work_days - $emp->attendances_count) - $emp->leave_list_count}}</td>
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
@endsection