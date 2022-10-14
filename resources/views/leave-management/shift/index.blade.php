<?php
$selected_site = App\Models\Employee::where('id',Auth::id())->first();
?>
@extends('layouts.master')

@section('title','Shift Management')
@section('content')
<!--Main layout-->
  <main class="content-body">
    <div class="page-body">
        <div class="card">
            <div class="card-header">
              <div class="d-flex">
                <a class="btn btn-sm btn-link text-body" href="{{ url('leave-management') }}">
                   <mat-icon role="img" class="mat-icon material-icons" aria-hidden="true">
                  keyboard_arrow_left</mat-icon></a>
                <div class="d-flex flex-column mt-2">
                  <h5>Create Shift</h5>
                  <small class="mt-1">Create your own shifts with allowed grace time. Enable Auto assign shift based on first IN punch.
                  </small>
                </div>
              </div>
            </div>
            <div class="card-block-hid">
              <div class="card-block px-4 pb-4">
                <div class="page-body">
                  <div class="row mb-2 btn-tow cs-form">
                    <div class="col-md-6">
                      <div class="d-flex gap-4 align-items-center">
                        <button type="button" data-mdb-toggle="modal" data-mdb-target="#creat-shift-modal" data-mdb-toggle="tooltip" data-mdb-placement="right" title="Add Kiosk" class="btn btn-outline-primary btn-floating btn-lg" data-mdb-ripple-color="dark">
                          <mat-icon role="img"
                              class="mat-icon material-icons mt-2" aria-hidden="true">add</mat-icon>
                        </button>
                      </div>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end align=align-items-center">
                      {{-- <div class="mt-2"><span data-mdb-toggle="tooltip" data-mdb-placement="right" title="Shift will be auto assigned based on employee's In Time" class="me-2 text-body" aria-describedby="cdk-describedby-message-3"> Auto shift assign: </span></div>
                      <div class="form-check form-switch mt-2 me-3">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked />
                      </div> --}}
                      <div class="form-outline">
                        <input type="text" class="form-control" id="filter_search" name="filter_search"/>
                        <label class="form-label">Search</label>
                      </div>
                    </div>
                  </div>
                  <div class="table-section mt-3">
                    <div class="datatable">
                      <table class="department table table-bordered border-bottom responsive-table" id="shift_table">
                        <thead>
                          <tr>
                            <th class="th-sm">Shift Code</th>
                            <th class="th-sm">Shift Name </th>
                            <th class="th-sm">Start Time	</th>
                            <th class="th-sm">End Time	</th>
                            <th class="th-sm">Grace Time(min)	</th>
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

  </main>
  <!--Main layout-->

<!-- Modal -->
    <!-- Modal -->
    <div class="modal fade" id="creat-shift-modal" tabindex="-1" aria-labelledby="createshift" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <form id="shiftForm">
            <div class="modal-content">
              <div class="modal-body cs-form">
                <div class="text-center">
                  <h5 class="text-body fw-600 my-4">Add Shift</h5>
                </div>
                <div class="row">
                  <div class="col-md-10 mx-auto">
                    <div class="row mt-4 align-items-end">
                      <div class="col-md-12 mb-4">
                        <div class="form-outline">
                          <input type="hidden" name="site_id" id="site_id" value="{{ $selected_site->site->id }}">
                          <input type="text" class="form-control" name="name" id="name"/>
                          <label class="form-label">Shift Name *</label>
                        </div>
                      </div>
                      <div class="col-md-6 mb-5">
                        <div class="form-outline">
                          <input type="text" class="form-control" name="code" id="code"/>
                          <label class="form-label">Shift code*</label>
                        </div>
                      </div>
                      <div class="col-md-6 mb-5">
                        <div class="form-outline">
                          <input type="text" class="form-control" name="grace_time" id="grace_time"/>
                          <label class="form-label">Grace time(in min)</label>
                        </div>
                      </div>
                      <div class="col-md-6 mb-4">
                        <div class="form-outline active">
                          <div class='input-group time' id='rintime'>
                            <input type='text' class="form-control" placeholder="Select Date" name="start_time" id="start_time"/>
                            <span class="input-group-addon">
                              <i class="ti-calendar"></i>
                            </span>
                            <label class="form-label" for="form1">Choose start time*</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6 mb-4">
                        <div class="form-outline active">
                          <div class='input-group time' id='routtime'>
                            <input type='text' class="form-control" placeholder="Select Date" name="end_time" id="end_time"/>
                            <span class="input-group-addon">
                              <i class="ti-calendar"></i>
                            </span>
                            <label class="form-label" for="form1">Choose end time*</label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default text-capitalize ripple-surface" data-mdb-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary text-capitalize">Add</button>
              </div>
            </div>
          </form>
        </div>
      </div>
  
         <!-- Modal -->
         <div class="modal fade" id="edit-shift-modal" tabindex="-1" aria-labelledby="editshift" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <form id="editShiftForm">
              <div class="modal-content">
                <div class="modal-body cs-form">
                  <div class="text-center">
                    <h5 class="text-body fw-600 my-4">Edit Shift</h5>
                  </div>
                  <div class="row">
                    <div class="col-md-10 mx-auto">
                      <div class="row mt-4 align-items-end">
                        <div class="col-md-12 mb-4">
                          <div class="form-outline">
                            <input type="hidden" name="shift_id" id="shift_id" value="">
                            <input type="hidden" name="site_id" id="site_id" value="{{ $selected_site->site->id }}">
                            <input type="text" class="form-control" name="edit_name" id="edit_name"/>
                            <label class="form-label">Shift Name *</label>
                          </div>
                        </div>
                        <div class="col-md-6 mb-5">
                          <div class="form-outline">
                            <input type="text" class="form-control" name="edit_code" id="edit_code"/>
                            <label class="form-label">Shift code*</label>
                          </div>
                        </div>
                        <div class="col-md-6 mb-5">
                          <div class="form-outline">
                            <input type="text" class="form-control" name="edit_grace_time" id="edit_grace_time"/>
                            <label class="form-label">Grace time(in min)</label>
                          </div>
                        </div>
                        <div class="col-md-6 mb-4">
                          <div class="form-outline active">
                            <div class='input-group time' id='rstarttime'>
                              <input type='text' class="form-control" placeholder="Select Start Time" name="edit_start_time" id="edit_start_time"/>
                              <span class="input-group-addon">
                                <i class="ti-calendar"></i>
                              </span>
                              <label class="form-label" for="form1">Choose start time*</label>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6 mb-4">
                          <div class="form-outline active">
                            <div class='input-group time' id='rendtime'>
                              <input type='text' class="form-control" placeholder="Select End Time" name="edit_end_time" id="edit_end_time"/>
                              <span class="input-group-addon">
                                <i class="ti-calendar"></i>
                              </span>
                              <label class="form-label" for="form1">Choose end time*</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer justify-content-between">
                  <div>
                  <button type="button" class="btn btn-danger text-capitalize px-3 align-items-center d-flex delete_shift"><mat-icon role="img" class="fs-5  mat-icon me-2 material-icons" aria-hidden="true">delete</mat-icon> Delete</button>
                  </div>
                  <div>
                    <button type="button" class="btn btn-default text-capitalize ripple-surface me-3" data-mdb-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary text-capitalize">Save</button>
                  </div>
                </div>
              </div>
          </form>
          </div>
        </div>
  
@endsection

@push('js')
<script type="text/javascript">
  $(document).ready(function(){
    render_table();
    function render_table(){
      var table = $("#shift_table");
      table.DataTable().destroy();

      $filter_search = $('#filter_search').val();

      table.DataTable({
          processing: true,
          serverSide: true,
          scrollX: true,
          order: [],
          ajax: {
              'url': "{{ route('shift.all.datatable') }}",
              'type': 'POST',
              data:{
                filter_search : $filter_search,
              }
          },
          columns: [
              {data: 'name', name: 'name'},
              {data: 'code', name: 'code'},
              {data: 'start_time', name: 'start_time'},
              {data: 'end_time', name: 'end_time'},
              {data: 'grace_time', name: 'grace_time'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ],
      });
    }

    $('#filter_search').keyup(function() {
      render_table();
    });

    if ($('#rstarttime').length) {
      $('#rstarttime').datetimepicker({
          format: 'LT',
      });
    }
    if ($('#rendtime').length) {
        $('#rendtime').datetimepicker({
            format: 'LT',
        });
    }

    $("#shiftForm").validate({
        ignore: ":hidden",
        rules: {
          name: {
            required: true,
          },
          code: {
            required: true,
          },            
        },
        messages: { 
          name: { 
            required: "Please enter a valid shift name"
          },
          code: { 
            required: "Please enter a valid shift code"
          }
        }, 
        submitHandler: function (form) { 
            $.ajax({
            type: "POST",
            url: "{{route('shift.store')}}",
            data: $(form).serialize(),
            success: function (result) {
              if(result.status == true){
                toastr.success(result.message);
                $("#creat-shift-modal").modal('toggle');
                $("#shiftForm")[0].reset();
                render_table();
              }
            }
          });
        }
    });

    $(document).on('click','.shift_edit',function(event){
      var id  = $(this).attr('data-id');
      $("#shift_id").val(id);
      $.ajax({
        type:"GET",
        data:{id:id},
        url: base_url+"shift/"+id+"/edit",
        dataType:'json',
        success:function(result){
          if(result.status == true){
            $("#edit_name").val(result.data.name);
            $("#edit_name").focus();
            $("#edit_code").val(result.data.code); 
            $("#edit_code").focus();
            $("#edit_grace_time").val(result.data.grace_time); 
            $("#edit_grace_time").focus();
            $("#edit_start_time").val(result.in); 
            if($('#edit_start_time').val() != ""){
              $('#edit_start_time').addClass('active');
            }else{
              $('#edit_start_time').removeClass('active');
            }
            $("#edit_end_time").val(result.out); 
            if($('#edit_end_time').val() != ""){
              $('#edit_end_time').addClass('active');
            }else{
              $('#edit_end_time').removeClass('active');
            }
          }          
        }
      })
    });

    $("#editShiftForm").validate({
        ignore: ":hidden",
        rules: {
            edit_name: {
                required: true,
            },
            edit_code: {
                required: true,
            },            
        },
        messages: { 
            edit_name: { 
                required: "Please enter a valid shift name"
            },
            edit_code: { 
                required: "Please enter a valid shift code"
            }
        }, 
        submitHandler: function (form) { 
          var id = $("#shift_id").val();
          $.ajax({
            type: "POST",
            url: "{{route('shift.update')}}",
            data: $(form).serialize(),
            success: function (result) {
              if(result.status == true){
                toastr.success(result.message);
                $("#edit-shift-modal").modal('toggle');
                render_table();
              }
            }
          });
        }
    });

     $(document).on('click','.delete_shift',function(event){
      var id = $("#shift_id").val();
      Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
              url: "{{route('shift.delete')}}",
              method: "POST",
              data:{
                id : id,
              }
            })
            .done(function(result) {
            if(result.status == true){
              $("#edit-shift-modal").modal('toggle');
                toastr.success(result.message);
                render_table();
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