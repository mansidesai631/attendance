<?php
$selected_site = App\Models\Employee::where('id',Auth::id())->first();
?>
@extends('layouts.master')

@section('title','Department Management')
@section('content')
<!--Main layout-->
  <main class="content-body">
    <div class="page-body">
      <div class="card">
        <div class="card-header">
            <div class="d-flex">
                <a class="btn btn-sm btn-link text-body" href="{{ url('settings') }}">
                    <mat-icon role="img" class="mat-icon material-icons" aria-hidden="true">
                    keyboard_arrow_left</mat-icon></a>
                <div class="d-flex flex-column mt-2">
                    <h5>Department settings</h5>
                    <small class="mt-1">You can set up Departments and Department Heads from here</small>
                </div>
            </div>
        </div>
        <div class="card-block-hid">
          <div class="card-block px-4 pb-4">
            <div class="page-body">
              <div class="row mb-2 btn-tow cs-form">
                <div class="col-md-6">
                  <div class="d-flex gap-4 align-items-center">
                    <button type="button" data-mdb-toggle="modal" data-mdb-target="#add-department" data-mdb-toggle="tooltip" data-mdb-placement="right" title="Add Department" class="btn btn-outline-primary btn-floating btn-lg" data-mdb-ripple-color="dark">
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
                
                    <table class="department table table-bordered border-bottom" id="department_table">
                        <thead>
                            <tr>
                                <th class="th-sm">Department</th>
                                <th class="th-sm">Department Head</th>
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
    <div class="modal fade" id="add-department" tabindex="-1" aria-labelledby="adddepartment" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <form id="departmentForm">
          <div class="modal-content">
            <div class="modal-body cs-form">
              <div class="text-center">
                <h5 class="text-body fw-600 my-4">Add Department</h5>
              </div>
              <div class="row">
                <div class="col-md-10 mx-auto">
                  <div class="row mt-4 align-items-end">
                    <div class="col-md-12 mb-4">
                      <div class="form-outline">
                        <input type="hidden" name="site_id" id="site_id" value="{{ $selected_site->site->id }}">
                        <input type="text" class="form-control" name="department_name" id="department_name" />
                        <label class="form-label">Department Name</label>
                      </div>
                    </div>
                    <div class="col-md-12 mb-4">
                        <label class="form-label">Department Head</label>
                        <select name="department_head" id="department_head" class="browser-default custom-select">
                            <option value="" selected>None</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" >{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>    
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default text-capitalize ripple-surface" data-mdb-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary text-capitalize" id="add_department">Add</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="edit-department" tabindex="-1" aria-labelledby=editdepartment" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
                <form id="editdepartmentForm"> 
                    <div class="modal-body cs-form">
                        <div class="text-center">
                            <h5 class="text-body fw-600 my-4">Edit Department</h5>
                        </div>
                        <div class="row">
                            <div class="col-md-10 mx-auto">
                                <div class="row mt-4 align-items-end">
                                    <div class="col-md-12 mb-4">
                                    <div class="form-outline">
                                        <input type="hidden" name="department_id" id="department_id" value="">
                                        <input type="hidden" name="site_id" id="site_id" value="{{ $selected_site->site->id }}">
                                        <input type="text" class="form-control" name="edit_department_name" id="edit_department_name" />
                                        <label class="form-label">Department Name</label>
                                    </div>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                    <label class="form-label">Department Head</label>
                                    <select name="edit_department_head" id="edit_department_head" class="browser-default custom-select">
                                        <option value="">None</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" >{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <div>
                            <button type="button" class="btn btn-danger text-capitalize px-3 align-items-center d-flex delete_department"><mat-icon  role="img" class="fs-5  mat-icon me-2 material-icons" aria-hidden="true">delete</mat-icon> Delete</button>
                        </div>
                        <div>
                            <button type="button" class="btn btn-default text-capitalize ripple-surface me-3" data-mdb-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary text-capitalize">Save</button>
                        </div>
                    </div>
                </form>
             </div>
        </div>
    </div>
@endsection

@push('js')
<script type="text/javascript">
  $(document).ready(function(){
    render_table();
    function render_table(){
      var table = $("#department_table");
      table.DataTable().destroy();

      $filter_search = $('#filter_search').val();

      table.DataTable({
          processing: true,
          serverSide: true,
          scrollX: true,
          order: [],
          ajax: {
              'url': "{{ route('department.all.datatable') }}",
              'type': 'POST',
              data:{
                filter_search : $filter_search,
              }
          },
          columns: [
              {data: 'name', name: 'name'},
              {data: 'head', name: 'head'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ],
      });
    }

    $('#filter_search').keyup(function() {
      render_table();
    });

    $("#departmentForm").validate({
        ignore: ":hidden",
        rules: {
          department_name: {
            required: true,
          },             
        },
        messages: { 
          department_name: { 
            required: "Please enter a valid department name"
          }
        }, 
        submitHandler: function (form) { 
            $.ajax({
            type: "POST",
            url: "{{route('department.store')}}",
            data: $(form).serialize(),
            success: function (result) {
              if(result.status == true){
                toastr.success(result.message);
                $("#add-department").modal('toggle');
                $("#departmentForm")[0].reset();
                render_table();
              }
            }
          });
        }
    });

    $(document).on('click','.department_edit',function(event){
      var id  = $(this).attr('data-id');
      $("#department_id").val(id);
      $.ajax({
        type:"GET",
        data:{id:id},
        url: base_url+"department/"+id+"/edit",
        dataType:'json',
        success:function(result){
          if(result.status == true){
            $("#edit_department_name").val(result.data.name);
            $("#edit_department_name").focus();
            $("#edit_department_head").val(result.data.head_id); 
          }          
        }
      })
    });

    $("#editdepartmentForm").validate({
        ignore: ":hidden",
        rules: {
          edit_department_name: {
            required: true,
          },             
        },
        messages: { 
          edit_department_name: { 
            required: "Please enter a valid department name"
          }
        }, 
        submitHandler: function (form) { 
          var id = $("#department_id").val();
          $.ajax({
            type: "POST",
            url: "{{route('department.update')}}",
            data: $(form).serialize(),
            success: function (result) {
              if(result.status == true){
                toastr.success(result.message);
                $("#edit-department").modal('toggle');
                render_table();
              }
            }
          });
        }
    });

     $(document).on('click','.delete_department',function(event){
      var id = $("#department_id").val();
      Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
              url: "{{route('department.delete')}}",
              method: "POST",
              data:{
                id : id,
              }
            })
            .done(function(result) {
            if(result.status == true){
              $("#edit-department").modal('toggle');
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