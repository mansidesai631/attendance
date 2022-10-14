@extends('layouts.master')

@section('title','M-Challan')
@section('content')
<!--Main layout-->
  <main class="content-body">
    <div class="page-body">
      <div class="card">
        <div class="card-header">
          <div class="d-flex">

            <div class="d-flex flex-column mt-2">
              <h5>M-Challan</h5>

            </div>
          </div>
        </div>
        <div class="card-block-hid">
          <div class="card-block px-4 pb-4">
            <div class="page-body">
              <div class="row mb-2 btn-tow cs-form">
                <div class="col-md-6 gap-4 ms-auto d-flex justify-content-end">
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
                  <select class="browser-default custom-select w-25" id="filter_department">
                    <option value="">Department</option>
                    @foreach($department as $dep)
                    <option value="{{$dep->id}}">{{$dep->name}}</option>
                    @endforeach
                  </select>
                  <div class="form-outline">
                    <input type="text" class="form-control" id="filter_search" name="filter_search" />
                    <label class="form-label">Search</label>
                  </div>
                </div>
              </div>
              <div class="table-section mt-3">
                <div class="datatable">
                  <table class="department table table-bordered border-bottom" width="100%" id="channel_table">
                    <thead>
                      <tr>
                        <th class="th-sm">Concern Officer</th>
                        <th class="th-sm">Department</th>
                        <th class="th-sm">Name of citizen </th>
                        <th class="th-sm">Mobile </th>
                        <th class="th-sm">ID Type </th>
                        <th class="th-sm">ID Number </th>
                        <th class="th-sm">Fine Challan Date</th>
                        <th class="th-sm">Amount of Fine </th>
                        <th class="th-sm"><div style="min-width:240px;">Reason</div></th>
                        <th class="th-sm">Address </th>
                        <th class="th-sm">Zone</th>
                        <th class="th-sm">Ward</th>
                        <th class="th-sm">Circle</th>
                        <th class="th-sm">Action</th>
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

   <!-- Modal -->
   <div class="modal fade" id="view-gallery" tabindex="-1" aria-labelledby="addusers" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body p-0">
          <button type="button" class="btn-close position-absolute bg-black rounded-0 p-2" data-mdb-dismiss="modal" aria-label="Close" style="position: absolute;z-index: 11;right: 0;"></button>
            <div class="row">
              <div class="col-md-12 mx-auto">
                <div id="carouselExampleInterval" class="carousel slide carousel-fade rounded-3 overflow-hidden" data-mdb-ride="carousel">
                  <div class="carousel-inner" id="view_report_gallery">

                  </div>
                  <button class="carousel-control-prev" data-mdb-target="#carouselExampleInterval" type="button" data-mdb-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                  </button>
                  <button class="carousel-control-next" data-mdb-target="#carouselExampleInterval" type="button" data-mdb-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

@endsection

@push('js')
<script type="text/javascript">
  $(document).ready(function(){
    render_table();
    function render_table(){
      var table = $("#channel_table");
      table.DataTable().destroy();

      $filter_search = $('#filter_search').val();
      $filter_officer = $('#filter_officer').find('option:selected').val();
      $filter_department = $('#filter_department').find('option:selected').val();
      $filter_zone = $('#filter_zone').find('option:selected').val();

      table.DataTable({
          processing: true,
          serverSide: true,
          scrollX: true,
          order: [],
          ajax: {
              'url': "{{ route('channel.all.datatable') }}",
              'type': 'POST',
              data:{
                filter_search : $filter_search,
                filter_officer : $filter_officer,
                filter_department : $filter_department,
                filter_zone : $filter_zone,
              }
          },
          columns: [
              {data: 'concern_officer', name: 'concern_officer'},
              {data: 'department', name: 'department'},
              {data: 'name_of_citizen', name: 'name_of_citizen'},
              {data: 'mobile', name: 'mobile'},
              {data: 'id_type', name: 'id_type'},
              {data: 'id_number', name: 'id_number'},
              {data: 'created_at', name: 'created_at'},
              {data: 'amount_of_fine', name: 'amount_of_fine'},
              {data: 'reason', name: 'reason'},
              {data: 'address', name:'address'},
              {data: 'zone', name:'zone'},
              {data: 'ward', name:'ward'},
              {data: 'circle', name:'circle'},
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

    $(document).on('change', '#filter_department', function() {
      render_table();
    });

    $(document).on('change', '#filter_zone', function() {
      render_table();
    });

    $(document).on('click','#view_report_images',function(){
      var id = $(this).attr('data-id');
      $.ajax({
        type: "POST",
        url: "{{route('get.mchallan.images')}}",
        data: {
          id: id
        },
        success: function (result) {
          if(result.status == true){
            var html = '';
            $.each(result.data, function( index, value ) {
              if(index == 0){
                html += '<div class="carousel-item active" data-mdb-interval="10000"><img src="'+value.image+'" class="d-block mx-auto"/></div>';
              }else{
                html += '<div class="carousel-item"><img src="'+value.image+'" class="d-block mx-auto"/></div>';
              }

            });

            $("#view_report_gallery").html(html);
          }
        }
      });
    });

  });
</script>


@endpush
