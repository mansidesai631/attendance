@extends('layouts.master')

@section('title','Field Report')
@section('content')
<style>
    .ti-calendar:before {
    content: "\e6b6";
    line-height: 33px;
}
</style>
<!--Main layout-->
  <main class="content-body">
    <div class="page-body">
      <div class="card">
        <div class="card-header">
          <div class="d-flex">

            <div class="d-flex flex-column mt-2">
              <h5>Field Report</h5>

            </div>
          </div>
        </div>
        <div class="card-block-hid">
          <div class="card-block px-4 pb-4">
            <div class="page-body">
              <div class="row mb-2 btn-tow cs-form">
                    <div class="col-md-8 gap-4 ms-auto d-flex justify-content-end">
                      <div class="col-md-4 individual_attendance_filter">
                            <div class="form-outline active">
                              <div class='input-group date'>
                                <input type="text" class="form-control active" name="daterange"  id="from_to_datepicker" />
                                  <i class="ti-calendar"></i>
                                 <label class="form-label">Date Filter</label>
                              </div>
                            </div>
                        </div>
                        <select class="browser-default custom-select w-25" id="filter_zone">
                            <option value="">Zone</option>
                            @foreach($sites as $site)
                            <option value="{{$site->id}}">{{$site->name}}</option>
                            @endforeach
                        </select>
                        <select class="browser-default custom-select w-25" id="filter_officer">
                            <option value="">Officer</option>
                            @foreach($staff as $s)
                            <option value="{{$s->id}}">{{$s->name}}</option>
                            @endforeach
                        </select>
                        <div class="form-outline">
                            <input type="text" class="form-control" id="filter_search" name="filter_search" />
                            <label class="form-label">Search</label>
                        </div>
                    </div>
              </div>
              <div class="table-section mt-3 report_table_section">
                <div class="datatable">
                  <table class="department table table-bordered border-bottom" id="report_table">
                    <thead>
                      <tr>
                        <th class="th-sm">Date</th>
                        <th class="th-sm">Title</th>
                        <th class="th-sm">Zone </th>
                        <th class="th-sm">Circle </th>
                        <th class="th-sm">Officer </th>
                        <th class="th-sm">Action </th>
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

  </main>
  <!--Main layout-->

@endsection

@push('js')
<script type="text/javascript">
  $(document).ready(function(){

    var from_rang_date = "{{date('m/d/Y')}}";
    var to_rang_date = "{{date('m/d/Y')}}";

    $('#from_to_datepicker').daterangepicker({
        "startDate": from_rang_date,
        "endDate": to_rang_date
    });

    $('#from_to_datepicker').on('apply.daterangepicker', function(ev, picker) {
      from_rang_date = picker.startDate.format('YYYY-MM-DD')
      to_rang_date = picker.endDate.format('YYYY-MM-DD')
      render_table();
    });

    render_table();
    function render_table(){
      var table = $("#report_table");
      table.DataTable().destroy();

      $filter_search = $('#filter_search').val();
      $filter_officer = $('#filter_officer').find('option:selected').val();
      $filter_zone = $('#filter_zone').find('option:selected').val();
      $from_rang_date = from_rang_date;
      $to_rang_date = to_rang_date;

      table.DataTable({
          processing: true,
          serverSide: true,
          scrollX: true,
          order: [],
          ajax: {
              'url': "{{ route('field.report.all.datatable') }}",
              'type': 'POST',
              data:{
                filter_search : $filter_search,
                filter_officer : $filter_officer,
                filter_zone : $filter_zone,
                from_rang_date : $from_rang_date,
                to_rang_date : $to_rang_date,
              }
          },
          columns: [
              {data: 'created_at', name: 'created_at'},
              {data: 'title', name: 'title'},
              {data: 'zone', name: 'zone'},
              {data: 'circle', name: 'circle'},
              {data: 'officer', name: 'officer'},
              {data: 'action', name: 'action'},
          ],
      });
    }

    $('#filter_search').keyup(function() {
      render_table();
    });

    $(document).on('change', '#filter_officer', function() {
      render_table();
    });

    $(document).on('change', '#filter_zone', function() {
      render_table();
    });


  });
</script>
@endpush
