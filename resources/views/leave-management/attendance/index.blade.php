<?php
$selected_site = App\Models\Employee::where('id',Auth::id())->first();
?>
@extends('layouts.master')
@section('title','Leave Management')
@section('content')
@php
if(!empty($date)){
$time = strtotime($date);
$month = date('t',$time);
$months = date('m',$time);
$year = date('Y',$time);
$currentMonth = date('F',$time);
}else{
$today = today();
$month = $today->daysInMonth;
$year = $today->year;
$months = $today->month;
$currentMonth = date('F');
}
$dates = [];
for($i=1; $i <  $month + 1; ++$i) {
$dates[] = \Carbon\Carbon::createFromDate($year, $months, $i);
}
@endphp
<!--Main layout-->
<main class="content-body">
    <div class="page-body">
        <div class="card">
            <div class="card-header">
                <div class="d-flex">
                    <div class="d-flex flex-column mt-2">
                        <h5>Attendance</h5>
                        <small class="mt-1">Manage attendance</small>
                    </div>
                </div>
            </div>
            <div class="card-block-hid">
                <div class="card-block px-4 pb-4">
                    <div class="page-body">
                        <div class="row mb-2 btn-tow cs-form">
                            <div class="col-md-12 d-flex justify-content-end">
                                <div class="col-md-6">
                                    <form style="margin:15px 0px 0px 0px;" method="POST" action="{{ route('dateFilter') }}">
                                        {{ csrf_field() }}
                                        <div class="form-group" style="width:200px; float:left;margin:9px 0px 0px 0px;">
                                            <input type="text" value="{{date('Y-m')}}" placeholder="Select Date" class="custom-select" name="datepicker" id="datepicker" />
                                        </div>
                                        <button type="submit" class="btn btn-default">Submit</button>
                                    </form>
                                </div>
                                <div class="col-md-6 d-flex justify-content-end">
                                    <div class="row align-items-end w-100">
                                        <div class="col-md-3">
                                            <label class="form-label">Zone </label>
                                            <select name="site[]" class="custom-select" id="atten-site">
                                                @foreach($sites as $site)
                                                <option  {{($selected_site->site->id == $site->id) ? 'selected' : ''}} value="{{$site->name}}">{{$site->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Staff Employee </label>
                                            <select name="name[]" class="custom-select" id="atten-name">
                                                <option value="">Show All</option>
                                                @foreach($employee as $emp)
                                                <option  value="{{$emp->name}}">{{$emp->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Department Filter </label>
                                            <select name="department[]" class="custom-select" id="atten-department">
                                                <option value="">Show All</option>
                                                @foreach($department as $dep)
                                                <option  value="{{$dep->name}}">{{$dep->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-outline">
                                                <input type="text" class="form-control" id="filter_search" />
                                                <label class="form-label">Search</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-section mt-3">
                            <div class="price-details-table">
                                <table class="table table-bordered attendance-entry-section " id="emp_leave_table">
                                    <thead role="rowgroup">
                                        <tr>
                                            <th rowspan="2" class="attendance-table-head" style="vertical-align: middle;"> Name </th>
                                            <th rowspan="2" class="attendance-table-head" style="vertical-align: middle;"> Zone </th>
                                            <th rowspan="2" class="attendance-table-head" style="vertical-align: middle;"> Department </th>
                                            <th class="" colspan="{{count($dates)}}"> {{$currentMonth}} </th>
                                        </tr>
                                        <tr>
                                            @foreach($dates as $date)
                                            <th class="subheader-top"> {{ $date->format('d') }} </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody role="rowgroup">
                                        @foreach($employee as $l)
                                        <tr>
                                            <td>
                                                <div class="name-row">
                                                    @if($l['image'])
                                                        <div class="staff-img">
                                                            <img src="{{$l['profile_path']}}" alt="img"></span>
                                                        </div>
                                                    @else
                                                        <div class="cricle-img position-relative">
                                                            <div class="avatar-container">
                                                                <div class="avatar-content" style="background-color: #322a24;">{{ucwords($l['name'][0].$l['name'][1])}}</div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                <div class="name-text">
                                                    <div class="d-flex w-100">
                                                        <div>
                                                            <div data-id="{{$l->id}}" class="employee_leave_history">
                                                                <span>{{$l->name}} </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <span class="emp-id">{{$l->id}} </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{$l->work->site->name}}</td>
                                        @if($l->work->department)
                                        <td>{{$l->work->department->name}}</td>
                                        @else
                                        <td>{{"-"}}</td>
                                        @endif
                                        <?php
                                        $attendances = \App\Models\Attendance::where('employee_id',$l->id)
                                        ->whereYear('created_at', $date)
                                        ->whereMonth('created_at', $date)->select(DB::raw('DATE(created_at) AS created_date'))->pluck('created_date')->toArray();
                                        ?>
                                        @if(count($attendances) == 0)
                                        @foreach($dates as $date)
                                        @if ($date->format('Y-m-d') > today()->format('Y-m-d'))
                                        <td>{{'-'}}</td>
                                        @else
                                        <td class="balance-red">{{'AB'}}</td>
                                        @endif
                                        @endforeach
                                        @else
                                        @foreach($dates as $date)
                                        @if(in_array($date->format('Y-m-d'), $attendances))
                                        <td class="balance">{{'P'}}</td>
                                        @elseif($date->format('Y-m-d') > today()->format('Y-m-d'))
                                        <td>{{'-'}}</td>
                                        @else
                                        <td class="balance-red">{{'AB'}}</td>
                                        @endif
                                        @endforeach
                                        @endif
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
<style>
.balance-red {
background-color: rgba(253, 219, 211, 0.836)!important;
}
</style>
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
<script>
$("document").ready(function () {
$("#emp_leave_table").dataTable({
"searching": true
});
var table = $('#emp_leave_table').DataTable();
$("#filterTable_filter.dataTables_filter").append($("#atten-department"));
$("#filterTable_filter.dataTables_filter").append($("#atten-name"));
$("#filterTable_filter.dataTables_filter").append($("#atten-site"));
var nameIndex = 0;
var departmentIndex = 0;
var siteIndex = 0;
$.fn.dataTable.ext.search.push(
function (settings, data, dataIndex) {
var selectedItem = $('#atten-department').val()
var department = data[2];
if (selectedItem === "" || department.includes(selectedItem)) {
return true;
}
return false;
}
);
$.fn.dataTable.ext.search.push(
function (settings, data, dataIndex) {
var selectedItem1 = $('#atten-name').val()
var name = data[0];
if (selectedItem1 === "" || name.includes(selectedItem1)) {
return true;
}
return false;
}
);
$.fn.dataTable.ext.search.push(
function (settings, data, dataIndex) {
var selectedItem1 = $('#atten-site').val()
var name = data[1];
if (selectedItem1 === "" || name.includes(selectedItem1)) {
return true;
}
return false;
}
);
$("#atten-department").change(function (e) {
table.draw();
});
$("#atten-name").change(function (e) {
table.draw();
});
$("#atten-site").change(function (e) {
table.draw();
});
$('#filter_search').keyup(function(){
table.search($(this).val()).draw();
})
table.draw();
});
$("#datepicker").datepicker( {
format: "yyyy-mm",
endDate: '+0m',
viewMode: "months",
minViewMode: "months"
});
</script>
@endpush