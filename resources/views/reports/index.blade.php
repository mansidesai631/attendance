@extends('layouts.master')

@section('title','Reports')
@section('content')
<main class="content-body">
    <div class="page-body">
      <div class="card">
        <div class="card-header">
          <div class="d-flex">
            <div class="d-flex flex-column mt-2">
              <h5>Report Download</h5>
            </div>
          </div>
        </div>
        <div class="card-block-hid reportpage">
          <div class="card-block px-4 pb-4">
            <div class="page-body">
              
                <div class="row mb-2 btn-tow cs-form align-items-end">
                  <div class="col-md-10">
                    <div class="row mt-3 align-items-end">
                      <div class="col-md-2">
                        <label class="form-label">Reports</label>
                        <select class="browser-default custom-select" id="select_report_type">
                          <option selected value="">Select Report</option>
                          <option value="daily_attendance">Daily Attendance Report</option>
                          <option value="individual_attendance">Individual Attendance Report</option>
                        </select>
                      </div>
                      {{-- Daily report --}}
                        <div class="col-md-2 daily_attendance_filter d-none">
                            <div class="form-outline active">
                              <label class="form-label">Date Filter</label>
                              <div class='input-group date'>
                                <input type='text' class="form-control active" name="from_date" id="from_datepicker" value="{{date('m-d-Y')}}" />
                                  <i class="ti-calendar"></i>
                                <label class="form-label" for="form1"></label>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-2 daily_attendance_filter d-none">
                            <label class="form-label">Zone Filter</label>
                            <select class="browser-default custom-select" id="zone_value">
                              <option selected value="">All</option>
                              @foreach($zones as $key => $value)
                                <option value={{$key}}>{{$value}}</option>
                              @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 daily_attendance_filter d-none">
                            <label class="form-label">Ward Filter</label>
                            <select class="browser-default custom-select" id="ward_value">
                              <option selected value="">All</option>
                              @foreach($wards as $key => $value)
                                <option value={{$key}}>{{$value}}</option>
                              @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 daily_attendance_filter d-none">
                            <label class="form-label">Department Filter</label>
                            <select class="browser-default custom-select" id="department_value">
                              <option selected value="">All</option>
                              @foreach($departments as $key => $value)
                                <option value={{$key}}>{{$value}}</option>
                              @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 daily_attendance_filter d-none">
                            <label class="form-label">Designation Filter</label>
                            <select class="browser-default custom-select" id="designation_value">
                              <option selected value="">All</option>
                               @foreach($designation as $key => $value)
                                <option value={{$key}}>{{$value}}</option>
                              @endforeach
                            </select>
                        </div>
                        {{-- individule report --}}
                        <div class="col-md-4 individual_attendance_filter d-none">
                            <div class="form-outline active">
                              <div class='input-group date'>
                                <input type="text" class="form-control active" name="daterange"  id="from_to_datepicker" />
                                  <i class="ti-calendar"></i>
                                 <label class="form-label">Date Filter</label>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-2 individual_attendance_filter d-none">
                              <label class="form-label">Select Employee</label>
                              <select class="browser-default custom-select" name="employee" id="employees">
                            
                               @foreach($employee as $key => $value)
                                <option value={{$key}}>{{$value}}</option>
                              @endforeach 
                              </select>
                        </div>

                    </div>
                  </div>
                  <div class="col-md-1">
                    <button type="button" class="d-none  btn btn-primary text-capitalize ripple-surface ripple-surface-dark" id="dawonload_excel">
                    Download
                    </button>
                  </div>
                </div>
             
              <div class="table-section mt-3 table-area d-none">
                <div class="cs-form mb-3">
                  <div class="col-md-12 d-flex justify-content-end">
                    <div class="form-outline">
                      <input type="text" class="form-control" name="search-box"  id="search-box"/>
                      <label class="form-label">Search</label>
                    </div>
                  </div>
                </div>
                <div class="datatable">
                  <div id="attendance_body" class="overflow-auto"><b><center>No record found..!</center></b></div>
                </div>
                
              </div>
            </div>
          </div>
        </div>
        
      </div>
    </div>

  </main>
@endsection
@push('js')
<script>
$("document").ready(function () {
  var report_name = '';
  var from_date = "{{date('m/d/Y')}}";
  var from_rang_date = "{{date('m/d/Y')}}";
  var to_rang_date = "{{date('m/d/Y')}}";
  var designation = $('#designation_value').val();
  var department = $('#department_value').val();
  var zone = $('#zone_value').val();
  var ward = $('#ward_value').val();
  var employees = $('#employees').val();  
  var page = 1;
  var searchtext = '';
  
  $('#from_to_datepicker').daterangepicker({
      "startDate": from_rang_date,
      "endDate": to_rang_date
  });

   $('#from_to_datepicker').on('apply.daterangepicker', function(ev, picker) {
    from_rang_date = picker.startDate.format('YYYY-MM-DD')
    to_rang_date = picker.endDate.format('YYYY-MM-DD')
    getRreports();
  }); 

  $('#from_datepicker').daterangepicker({
      singleDatePicker: true,
      showDropdowns: true,
    }); 

  $(document).on('change', '#select_report_type', function(event) {
    report_name  = $('#select_report_type').val();
    $('#search-box').val('');

     if(report_name == 'daily_attendance'){
      $('.individual_attendance_filter').addClass('d-none')
      $('.daily_attendance_filter').removeClass('d-none')
      $('.daily_attendance_filter').removeClass('d-none')
      $('#dawonload_excel').removeClass('d-none')
      $('.table-area').removeClass('d-none')
      } 
      else if(report_name == 'individual_attendance'){
      $('.daily_attendance_filter').addClass('d-none')
      $('.individual_attendance_filter').removeClass('d-none')
      $('#dawonload_excel').removeClass('d-none')
      $('.table-area').removeClass('d-none')

      }else{
        $('#dawonload_excel').addClass('d-none')
        $('.individual_attendance_filter').addClass('d-none')
        $('.daily_attendance_filter').addClass('d-none')
        $('#attendance_body').html('<b><center>No record found..!</center></b>');
        $('.table-area').addClass('d-none')
        return;
      }
       getRreports()
    }); 

  $(document).on('change', '#designation_value', function(e) {
    e.preventDefault();
      designation = $('#designation_value').val();
      getRreports()
  });

  $(document).on('keyup','#search-box',function(e){
    e.preventDefault();
    searchtext = $(this).val();
     if(report_name){
        getRreports();
      }

  });


  $(document).on('change', '#from_datepicker', function(event) {
      from_date = $('#from_datepicker').val();
      getRreports()
  }); 

  $(document).on('click', '.pagination li a', function (e) {
      e.preventDefault();
      page = $(this).attr('href').split('page=')[1];
      getRreports() 
  });

  $(document).on('change', '#employees', function(e) {
    e.preventDefault();
      employees = $('#employees').val();
     getRreports()
  }); 

  $(document).on('change', '#department_value', function(e) {
    e.preventDefault();
      department = $('#department_value').val();
      getRreports()
  });
  
  $(document).on('change', '#zone_value', function(e) {
    e.preventDefault();
      zone = $('#zone_value').val();
      getRreports()
  });

  $(document).on('change', '#ward_value', function(e) {
    e.preventDefault();
      ward = $('#ward_value').val();
      getRreports()
  });

  function getRreports() {
    var queryString = '&report_name='+ report_name + '&from_date='+ from_date +'&from_rang_date='+ from_rang_date + '&to_rang_date='+ to_rang_date + '&designation=' +designation+'&department='+department + '&zone=' + zone + '&ward=' + ward + '&employee=' +employees + '&page='+ page + '&searchtext='+ searchtext;
    $.ajax({
          'url': "{{ route('reports.index') }}",
          'type': 'get',
          data: queryString,
          dataType: 'json',
      })
      .done(function(result, status, xhr) {
          $('#attendance_body').html(result);
      })
      .fail(function() {
        //toast_error("error");
      });
  }
  $(document).on('click', '#dawonload_excel', function (e) {
      e.preventDefault();
      var query = {
                    report_name:report_name,
                    from_date:from_date,
                    from_rang_date:from_rang_date,
                    to_rang_date:to_rang_date,
                    designation:designation,
                    department:department,
                    zone:zone,
                    ward:ward,
                    employee:employees
                  }
      var url = "{{route('report.export')}}?" + $.param(query)
      window.location = url;
  });

});
</script>
@endpush