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
              keyboard_arrow_left</mat-icon></a>
            <div class="d-flex flex-column mt-2">
              <h5>Leave Types</h5>
              <small class="mt-1">You can set up and manage leave types from here</small>
            </div>
          </div>
        </div>
        <div class="card-block-hid">
          <div class="card-block px-4 pb-4">
            <div class="page-body">
              <div class="row mb-2 btn-tow cs-form">
                <div class="col-md-6">
                  <div class="d-flex gap-4 align-items-center">
                    <button type="button" data-mdb-toggle="modal" data-mdb-target="#add-leave-type" data-mdb-toggle="tooltip" data-mdb-placement="right" title="Add Leave Type" class="btn btn-outline-primary btn-floating btn-lg add_leave_type" data-mdb-ripple-color="dark">
                      <mat-icon role="img"
                          class="mat-icon material-icons mt-2" aria-hidden="true">add</mat-icon>
                    </button>
                  </div>
                </div>
                <div class="col-md-6 d-flex justify-content-end">
                  <div class="form-outline">
                    <input type="text" class="form-control" id="filter_search" name="filter_search" />
                    <label class="form-label">Search</label>
                  </div>
                </div>
              </div>
              <div class="table-section mt-3">
                <div class="datatable">
                  <table class="department table table-bordered border-bottom" id="leave_type_table">
                    <thead>
                      <tr>
                        <th class="th-sm">Leave type</th>
                        <th class="th-sm">Leave Code </th>
                        <th class="th-sm">Description </th>
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
    <div class="modal fade" id="add-leave-type" tabindex="-1" aria-labelledby="adddepartment" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <form id="leaveTypeForm">
          <div class="modal-content">
            <div class="modal-header text-center">
              <h5 class="modal-title w-100">Add Leave Type</h5>
              <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body cs-form">
              <div class="row">
                <div class="col-md-10 mx-auto">
                  <div class="row mt-4 align-items-end">
                    <div class="col-md-12 mb-4">
                      <div class="form-outline">
                        <input type="text" class="form-control" name="leave_name" id="leave_name" />
                        <label class="form-label">Leave Name *</label>
                      </div>
                    </div>
                    <div class="col-md-12 mb-4">
                      <div class="form-outline">
                        <input type="text" class="form-control" name="leave_code" id="leave_code"/>
                        <label class="form-label">Leave Code</label>
                      </div>
                    </div>
                    <div class="col-md-12 mb-4">
                      <div class="form-outline">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" rows="2" name="leave_description" id="leave_description"></textarea>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default text-capitalize ripple-surface" data-mdb-dismiss="modal">Cancel</button>
              <button type="sumit" class="btn btn-primary text-capitalize" id="add_leave_type">Add</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="edit-leave-type" tabindex="-1" aria-labelledby=editdepartment" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <form id="editLeaveTypeForm">
          <div class="modal-content">
            <div class="modal-header text-center">
              <h5 class="modal-title w-100">Edit Leave Type</h5>
              <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body cs-form">
              <div class="row">
                <div class="col-md-10 mx-auto">
                  <div class="row mt-4 align-items-end">
                    <div class="col-md-12 mb-4">
                      <div class="form-outline">
                        <input type="hidden" name="leave_type_id" id="leave_type_id" value="">
                        <input type="text" class="form-control" name="edit_leave_name" id="edit_leave_name" />
                        <label class="form-label">Leave Name *</label>
                      </div>
                    </div>
                    <div class="col-md-12 mb-4">
                      <div class="form-outline">
                        <input type="text" class="form-control" name="edit_leave_code" id="edit_leave_code"/>
                        <label class="form-label">Leave Code</label>
                      </div>
                    </div>
                    <div class="col-md-12 mb-4">
                      <div class="form-outline">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" rows="2" name="edit_leave_description" id="edit_leave_description"></textarea>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <div>
               <button type="button" class="btn btn-danger text-capitalize px-3 align-items-center d-flex delete_leave_type"><mat-icon  role="img" class="fs-5  mat-icon me-2 material-icons" aria-hidden="true">delete</mat-icon> Delete</button>
              </div>
              <div>
                <button type="button" class="btn btn-default text-capitalize ripple-surface me-3" data-mdb-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary text-capitalize" name="editLeave">Save</button>
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
      var table = $("#leave_type_table");
      table.DataTable().destroy();

      $filter_search = $('#filter_search').val();

      table.DataTable({
          processing: true,
          serverSide: true,
          scrollX: true,
          order: [],
          ajax: {
              'url': "{{ route('leave-type.all.datatable') }}",
              'type': 'POST',
              data:{
                filter_search : $filter_search,
              }
          },
          columns: [
              {data: 'name', name: 'name'},
              {data: 'code', name: 'code'},
              {data: 'description', name: 'description'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ],
      });
    }

    $('#filter_search').keyup(function() {
      render_table();
    });

    $("#leaveTypeForm").validate({
        ignore: ":hidden",
        rules: {
          leave_name: {
            required: true,
          },             
        },
        messages: { 
          leave_name: { 
            required: "Leave name is required"
          }
        }, 
        submitHandler: function (form) {             
          $.ajax({
            type: "POST",
            url: "{{route('leave-type.store')}}",
            data: $(form).serialize(),
            success: function (result) {
              if(result.status == true){
                toastr.success(result.message);
                $("#add-leave-type").modal('toggle');
                $("#leaveTypeForm")[0].reset();
                render_table();
              }else{
                toastr.error(result.message);
              }
            }
          });
        }
    });

    $(document).on('click','.leave_edit',function(event){
      var id  = $(this).attr('data-id');
      $("#leave_type_id").val(id);
      $.ajax({
        type:"GET",
        data:{id:id},
        url: base_url+"leave-type/"+id+"/edit",
        dataType:'json',
        success:function(result){
          if(result.status == true){
            console.log(result.data.name);
            $("#edit_leave_name").val(result.data.name);
            $("#edit_leave_code").val(result.data.code);
            $("#edit_leave_description").val(result.data.description);
            $("#edit_leave_name").focus();
            $("#edit_leave_code").focus();
            $("#edit_leave_description").focus();
          }          
        }
      })
    });

    $("#editLeaveTypeForm").validate({
        ignore: ":hidden",
        rules: {
          edit_leave_name: {
            required: true,
          },             
        },
        messages: { 
          edit_leave_name: { 
            required: "Leave name is required"
          }
        }, 
        submitHandler: function (form) { 
          var id = $("#leave_type_id").val();
          $.ajax({
            type: "POST",
            url: "{{route('leave-type.update')}}",
            data: $(form).serialize(),
            success: function (result) {
              if(result.status == true){
                toastr.success(result.message);
                $("#edit-leave-type").modal('toggle');
                render_table();
              }else{
                toastr.error(result.message);
              }
            }
          });
        }
    });

    $(document).on('click','.delete_leave_type',function(event){
      var id = $("#leave_type_id").val();
      Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
              url: "{{route('leave-type.delete')}}",
              method: "POST",
              data:{
                id : id,
              }
            })
            .done(function(result) {
            if(result.status == true){
              $("#edit-leave-type").modal('toggle');
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