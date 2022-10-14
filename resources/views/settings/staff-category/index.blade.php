@extends('layouts.master')

@section('title','Designation Management')
@section('content')
  <!--Main layout-->
  <main class="content-body">
    <div class="page-body">
      <div class="card">
        <div class="card-header">
          <div class="d-flex">
            <a class="btn btn-sm btn-link text-body px-2" href="{{ url('settings') }}">
               <mat-icon role="img" class="mat-icon material-icons" aria-hidden="true">
              keyboard_arrow_left</mat-icon></a>
            <div class="d-flex flex-column mt-2">
              <h5>Staff Category settings</h5>
              <small class="mt-1">You can setup Categories from here </small>
            </div>
          </div>
        </div>
        <div class="card-block-hid">
          <div class="card-block px-4 pb-4">
            <div class="page-body">
              <div class="row mb-2 btn-tow cs-form">
                <div class="col-md-6">
                  <div class="d-flex gap-4 align-items-center">
                    <button type="button" data-mdb-toggle="modal" data-mdb-target="#add-category" data-mdb-toggle="tooltip" data-mdb-placement="right" title="Add New Category" class="btn btn-outline-primary btn-floating btn-lg" data-mdb-ripple-color="dark">
                      <mat-icon role="img"
                          class="mat-icon material-icons mt-2" aria-hidden="true">add</mat-icon>
                    </button>
                  </div>
                  <small class="mt-3 d-block">Weekly off configuration is available on <strong>Leaves > Weekly</strong> off section</small>
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
                  <table class="department table table-bordered border-bottom" id="staff_category_table">
                    <thead>
                      <tr>
                        <th class="th-sm">Category</th>
                        <th class="th-sm">Attendance Limit	</th>
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
    <div class="modal fade" id="add-category" tabindex="-1" aria-labelledby="adddepartment" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title w-100" id="exampleModalLabel">Add Staff Category</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="staffCategoryForm"> 
                    <div class="modal-body cs-form">
                        <div class="row">
                            <div class="col-md-10 mx-auto">
                                <div class="row mt-4 align-items-end">
                                <div class="col-md-12 mb-4">
                                    <div class="form-outline">
                                    <input type="text" class="form-control" name="staff_category_name" id="staff_category_name"/>
                                    <label class="form-label">Staff Category Name</label>
                                    </div>
                                    <div class="form-check d-flex align-items-center mt-4 mb-5 ms-2">
                                    <input class="form-check-input mt-1" type="checkbox" value="" id="chk-att">
                                    <label class="form-check-label text-body mx-3 fs-6" for="chk-att">Set Attendance Limit</label>
                                    </div>
                                    <div class="form-outline" style="display:none" id="attendance_limit_div">
                                        <input type="number" min="0" class="form-control" name="staff_category_ad_limit" id="staff_category_ad_limit"/>
                                        <label class="form-label">Attendance Limit</label>
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
                </form>    
            </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="edit-category" tabindex="-1" aria-labelledby=editdepartment" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title w-100" id="exampleModalLabel">Edit Staff Category</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editStaffCategoryForm"> 
                    <div class="modal-body cs-form">
                        <div class="row">
                        <div class="col-md-10 mx-auto">
                            <div class="row mt-4 align-items-end">
                            <div class="col-md-12 mb-4">
                                <div class="form-outline">
                                    <input type="hidden" name="staff_category_id" id="staff_category_id" value=""> 
                                    <input type="text" class="form-control" name="edit_staff_category_name" id="edit_staff_category_name"/>
                                    <label class="form-label">Staff Category Name</label>
                                </div>
                                <div class="form-check d-flex align-items-center mt-4 mb-5 ms-2">
                                    <input class="form-check-input mt-1" type="checkbox" value="" id="e-chk-att">
                                    <label class="form-check-label text-body mx-3 fs-6" for="e-chk-att">Set Attendance Limit</label>
                                </div>
                                <div class="form-outline" style="display:none" id="edit_attendance_limit_div">
                                    <input type="number" min="0" class="form-control" name="edit_staff_category_ad_limit" id="edit_staff_category_ad_limit"/>
                                    <label class="form-label">Attendance Limit</label>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <div>
                        <button type="button" class="btn btn-danger text-capitalize px-3 align-items-center d-flex delete_staff_category"><mat-icon  role="img" class="fs-5  mat-icon me-2 material-icons" aria-hidden="true">delete</mat-icon> Delete</button>
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
    $('#chk-att').on('click',function(e) {
        toggleCheckBoxSelection('#attendance_limit_div', this.checked)
    });
    $('#e-chk-att').on('click',function(e) {
        toggleCheckBoxSelection('#edit_attendance_limit_div', this.checked)
    });
    function toggleCheckBoxSelection(selector, show){
        var editBox = $(selector);
        show ? editBox.css('display','block') : editBox.css('display','none')
    }
    
    function render_table(){
      var table = $("#staff_category_table");
      table.DataTable().destroy();

      $filter_search = $('#filter_search').val();

      table.DataTable({
          processing: true,
          serverSide: true,
          scrollX: true,
          order: [],
          ajax: {
              'url': "{{ route('staff-category.all.datatable') }}",
              'type': 'POST',
              data:{
                filter_search : $filter_search,
              }
          },
          columns: [
              {data: 'name', name: 'name'},
              {data: 'ad_limit', name: 'ad_limit'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ],
      });
    }
    $('#filter_search').keyup(function() {
      render_table();
    });

    $("#staffCategoryForm").validate({
        ignore: ":hidden",
        rules: {
          staff_category_name: {
            required: true,
          },             
        },
        messages: { 
          staff_category_name: { 
            required: "Please enter a valid staff category name"
          }
        }, 
        submitHandler: function (form) { 
            $.ajax({
            type: "POST",
            url: "{{route('staff-category.store')}}",
            data: $(form).serialize(),
            success: function (result) {
              if(result.status == true){
                toastr.success(result.message);
                $("#add-category").modal('toggle');
                $("#staffCategoryForm")[0].reset();
                render_table();
              }
            }
          });
        }
    });

    $(document).on('click','.staff_category_edit',function(event){
      toggleCheckBoxSelection('#edit_attendance_limit_div', false);

      var id  = $(this).attr('data-id');
      $("#staff_category_id").val(id);
      $.ajax({
        type:"GET",
        data:{id:id},
        url: base_url+"staff-category/"+id+"/edit",
        dataType:'json',
        success:function(result){
          if(result.status == true){
            $("#edit_staff_category_name").val(result.data.name);
            $("#edit_staff_category_name").focus();
            
            if(result.data.ad_limit == '0') {
                toggleCheckBoxSelection('#edit_attendance_limit_div', false);
                $('#e-chk-att').prop("checked", false);
                $("#edit_staff_category_ad_limit").val('');

            } else {
                toggleCheckBoxSelection('#edit_attendance_limit_div',true);
                $('#e-chk-att').prop("checked", true);
                $("#edit_staff_category_ad_limit").val(result.data.ad_limit);
            }
          }          
        }
      })
    });

    $("#editStaffCategoryForm").validate({
        ignore: ":hidden",
        rules: {
          staff_category_name: {
            required: true,
          },             
        },
        messages: { 
          staff_category_name: { 
            required: "Please enter a valid staff category name"
          }
        }, 
        submitHandler: function (form) { 
            var id = $("#staff_category_id").val();

            $.ajax({
            type: "POST",
            url: "{{route('staff-category.update')}}",
            data: $(form).serialize(),
            success: function (result) {
              if(result.status == true){
                toastr.success(result.message);
                $("#edit-category").modal('toggle');
                $("#editStaffCategoryForm")[0].reset();
                render_table();
              }
            }
          });
        }
    });

    $(document).on('click','.delete_staff_category',function(event){
      var id = $("#staff_category_id").val();
      Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
              url: "{{route('staff-category.delete')}}",
              method: "POST",
              data:{
                id : id,
              }
            })
            .done(function(result) {
            if(result.status == true){
              $("#edit-category").modal('toggle');
                toastr.success(result.message);
                render_table();
            }
          })
          .fail(function() {
          });
        }
      })
    });

});

</script>
@endpush