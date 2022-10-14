@extends('layouts.master')

@section('title','My History')
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
              <h5>History</h5>
              <small class="mt-1">View your Leave balance and Leave History</small>
            </div>
          </div>
        </div>
        <div class="card-block-hid">
          <div class="card-block px-4 pb-4">
            <div class="page-body">
              <div class="row mb-2 btn-tow cs-form align-items-end">
                <div class="col-md-12">
                    <div class="text-body fs-6 fw-600">History</div>
                </div>
                <div class="col-md-8">
                  <div class="row mt-3 align-items-end">
                    <div class="col-md-3">
                      <label class="form-label">Date</label>
                      <select class="browser-default custom-select" name="duration_filter" id="duration_filter">
                        <option value="This week">This week</option>
                        <option value="This month" selected>This month</option>
                        <option value="Last month">Last month</option>
                        <option value="This year">This year</option>
                        <option value="date range">Select date range</option>
                      </select>
                    </div>
                    <div class="col-md-3 leave_start_date" style="display: none;">
                      <div class="form-outline active">
                        <div class='input-group date' id='from-date'>
                        <input type='text' class="form-control" placeholder="Select Date" name="start_date" id="from_date" value="{{date('m/1/Y')}}" />
                        <span class="input-group-addon">
                          <i class="ti-calendar mt-2 d-inline-block"></i>
                        </span>
                        <label class="form-label" for="form1">From Date</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3 leave_end_date" style="display: none;">
                      <div class="form-outline active">
                        <div class='input-group date' id='to-date'>
                        <input type='text' class="form-control" placeholder="Select Date" name="end_date" id="to_date" value="{{date('m/l/Y')}}" />
                        <span class="input-group-addon">
                          <i class="ti-calendar mt-2 d-inline-block"></i>
                        </span>
                        <label class="form-label" for="form1">To Date</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <label class="form-label">Status</label>
                      <select id="status" name="status[]" multiple>
                        <option value="PENDING">Pending</option>
                        <option value="APPROVED">Approved</option>
                        <option value="REJECTED">Rejected</option>
                        <option value="CANCELLED">Cancelled</option>
                        <option value="ALLOTED">Alloted</option>
                        <option value="ENCASHED">Encashed</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-4 d-flex justify-content-end">
                  <div class="form-outline">
                    <input type="text" class="form-control" id="filter_search"/>
                    <label class="form-label">Search</label>
                  </div>
                </div>
              </div>
              <div class="table-section mt-3">
                <div class="datatable">
                  <table class="department table table-bordered border-bottom" id="my_history_table">
                    <thead>
                      <tr>
                        <th class="th-sm">Name</th>
                        <th class="th-sm">Leave Type </th>
                        <th class="th-sm">Start Date</th>
                        <th class="th-sm">End Date</th>
                        <th class="th-sm">Total days</th>
                        <th class="th-sm">Documents</th>
                        <th class="th-sm">Reason</th>
                        <th class="th-sm">Status</th>
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
  <div class="modal fade" id="edit-leave" tabindex="-1" aria-labelledby="addlocation" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <form id="editLeaveForm" enctype="multipart/form-data">
        <div class="modal-content">
          <div class="modal-body cs-form">
            <div class="text-center">
              <h5 class="text-body fw-600 my-4">Edit leave</h5>
            </div>
            <div class="row">
              <div class="col-md-10 mx-auto">
                <div class="row">
                  <div class="col-md-12">
                    <div class="row align-items-end">
                      <div class="col-md-6 mb-2">
                        <input type="hidden" name="leave_id" id="leave_id" value="">
                        <label class="form-label">Leave Type</label>
                        <select class="browser-default custom-select" name="leave_type" id="leave_type" disabled>
                          <option selected>Leave Type</option>
                          @foreach($leaveType as $type)
                          <option value="{{$type->id}}">{{$type->name}}</option>
                          @endforeach
                        </select>      
                      </div>
                      <div class="col-md-6 mb-2 leave_balance">
                           
                      </div>
                      </div>
                      <div class="row align-items-end">
                        <div class="col-md-6 mb-2">
                          <div class="form-outline active">
                            <div class='input-group date' id='fdol'>
                              <input type='text' class="form-control" placeholder="Select Date" name="start_date" id="start_date" />
                              <span class="input-group-addon">
                                <i class="ti-calendar"></i>
                              </span>
                              <label class="form-label" for="form1">First Day of Leave*</label>
                            </div>
                        </div>
                      </div>
                      <div class="col-md-6 mb-2">
                        <label class="form-label">Full Day</label>
                        <select class="browser-default custom-select" name="start_date_period" id="start_date_period">
                          <option value="FULL DAY">Full Day</option>
                          <option value="FIRST HALF">First Half</option>
                          <option value="SECOND HALF">Second Half</option>
                        </select>
                      </div>
                    </div>
                    <div class="row mt-4 align-items-end">
                      <div class="col-md-6 mb-2">
                        <div class="form-outline active">
                          <div class='input-group date' id='ldol'>
                            <input type='text' class="form-control" placeholder="Select Date" name="end_date" id="end_date" />
                            <span class="input-group-addon">
                              <i class="ti-calendar"></i>
                            </span>
                            <label class="form-label" for="form1">Last Day of Leave*</label>
                          </div>
                      </div>
                     
                    </div>
                    
                    <div class="col-md-6 mb-2">
                      <label class="form-label">Full Day</label>
                      <select class="browser-default custom-select" name="end_date_period" id="end_date_period">
                        <option value="FULL DAY">Full Day</option>
                        <option value="FIRST HALF">First Half</option>
                        <option value="SECOND HALF">Second Half</option>
                      </select>
                    </div>
                  </div>
                  <div class="row mt-4 align-items-center">
                    <div class="col-md-6 mb-3">
                        <div class="leave_doc">
                        </div>
                        <input type="file" name="file" id="file"/>
                    </div>                    
                  </div>
                    <div class="row mt-4 align-items-end">
                      <div class="col-md-12 mb-3">
                        <div class="form-outline">
                          <textarea class="form-control" rows="1" name="leave_reason" id="leave_reason"></textarea>
                          <label class="form-label">Leave Reason</label>
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
            <button type="submit" class="btn btn-primary text-capitalize" name="edit_leave" id="edit_leave" disabled>Update</button>
          </div>
        </div>
      </form>
    </div>
  </div>



@endsection

@push('js')
<script type="text/javascript">
  $(document).ready(function(){
    // Display Listing
    render_table();
    function render_table(){
      var table = $("#my_history_table");
      table.DataTable().destroy();

      $filter_search = $('#filter_search').val();
      $filter_duration = $('#duration_filter').find('option:selected').val();
      $status = $('#status').val();
      $from_date = $("#from_date").val();
      $to_date = $("#to_date").val();

      table.DataTable({
          processing: true,
          serverSide: true,
          scrollX: true,
          order: [],
          ajax: {
              'url': "{{ route('my.history.all.datatable') }}",
              'type': 'POST',
              data:{
                filter_search : $filter_search,
                filter_duration : $filter_duration,
                status : $status,
                from_date : $from_date,
                to_date : $to_date,
              }
          },
          columns: [
              {data: 'name', name: 'name'},
              {data: 'leave_type_id', name: 'leave_type_id'},
              {data: 'start_date', name: 'start_date'},
              {data: 'end_date', name: 'end_date'},
              {data: 'tota_days', name: 'tota_days'},
              {data: 'document', name: 'document'},
              {data: 'leave_applied_reason', name: 'leave_applied_reason'},
              {data: 'status', name: 'status'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ],
      });
    }

    // Filters
    $('#filter_search').keyup(function() {
      render_table();
    });

    $(document).on('change', '#duration_filter', function() {
      render_table();
    });

    $(document).on('change', '#status', function() {
      render_table();
    });
    
    // Delete Data
    $(document).on('click','.delete',function(event){
      var id = $(this).attr('data-id');
      var url = $(this).attr('data-url');
      Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Cancel it!'
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
              url: url,
              method: "DELETE",
              data:{
                id : id,
              }
            })
            .done(function(result) {
            if(result.status == true){
              toastr.success(result.message);
              render_table();
            }
          })
          .fail(function() {
          });
        }
      })
    })

    // Display data on Edit Modal
    $(document).on('click','.edit_leave',function(event){
      var id = $(this).attr('data-id');
      $("#leave_id").val(id);
      $.ajax({
        type:"GET",
        data:{id:id},
        url: base_url+"my-history/"+id+"/edit",
        dataType:'json',
        success:function(result){
          if(result.status == true){
            console.log(result.data.attachment);
            $("#leave_type").val(result.data.leave_type_id);
            $("#start_date").val(result.start_date);
            $("#start_date_period").val(result.data.start_leave_period);
            $("#end_date").val(result.end_date);
            $("#end_date_period").val(result.data.end_leave_period);
            $("#leave_reason").val(result.data.leave_applied_reason);
            if($('#start_date').val() != ""){
                $('#start_date').addClass('active');
            }else{
                $('#start_date').removeClass('active');
            }
            if($('#end_date').val() != ""){
                $('#end_date').addClass('active');
            }else{
                $('#end_date').removeClass('active');
            }
            // if(result.data.attachment != "" || result.data.attachment != null){
            //   $(".leave_doc").html('<a href="'+result.url+'" target="_blank">'+result.data.attachment+'</a>');
            // } else{
            //   $(".leave_doc").html('');
            // }           
            var html = '<span>Balance : '+result.balance+'</span>'
            $(".leave_balance").html(html);
          }          
        }
      })
    });

    // Update Data
    $("#editLeaveForm").validate({
      rules: {
        leave_type: "required",
        start_date: "required",
        end_date: "required",
        start_date_period: "required",
        end_date_period: "required",
      },
      messages: {
        leave_type: {
          required: "Please select leave type",
        },      
        start_date: {
          required: "Please select start date",
        },
        end_date: {
          required: "Please select end date",
        },
        start_date_period: {
          required: "Please select period",
        },
        end_date_period: {
          required: "Please select period",
        },
      },
      submitHandler: function(form) {
        var fd = new FormData(editLeaveForm);
        $.ajax({
          url: "{{route('leave.update')}}",
          type: 'post',
          data: fd,
          contentType: false,
          processData: false,
          success: function(response){
            if(response.status == true){
              toastr.success(response.message);
              $("#edit-leave").modal('toggle');
              $("#edit_leave").attr('disabled',true);
              render_table();

            }
          }
        });
      }   
    });

    // Edit Leave button enable disable
    if ($('#start_date').length) {
      $('#start_date').datetimepicker({
          format: 'L',
      });
    }

    if ($('#end_date').length) {
        $('#end_date').datetimepicker({
            format: 'L',
        });
    }

    $('#start_date').on('dp.change', function(e){ 
      nullValidation();
    })

    $('#end_date').on('dp.change', function(e){ 
        nullValidation();
    })

    $(document).on('change','#start_date_period',function(){
      nullValidation();
    });

    $(document).on('change','#end_date_period',function(){
      nullValidation();
    });

    function nullValidation(){
        if($("#start_date").val() !="" && $("#end_date").val() != "" && $("#end_date_period").val() != "" && $("#start_date_period").val() != ""){
            $("#edit_leave").attr('disabled',false); 
        }
        else{
            $("#edit_leave").attr('disabled',true); 
        }
    } 

    $(document).on('change','#duration_filter',function(){
      if($(this).val() == 'date range'){
        $('.leave_start_date').css('display','block');
        $('.leave_end_date').css('display','block');
      }else{
        $('.leave_start_date').css('display','none');
        $('.leave_end_date').css('display','none');
      }
    });

    if ($('#from_date').length) {
      $('#from_date').datetimepicker({
          format: 'L',
      });
    }

    if ($('#to_date').length) {
        $('#to_date').datetimepicker({
            format: 'L',
        });
    }

    $('#from_date').on('dp.change', function(e){ 
      render_table();
    })

    $('#to_date').on('dp.change', function(e){ 
        render_table();
    })

    if ($('#status').length) {
      $('#status').multiselect({
          columns: 1,
          placeholder: 'Select Options',
          search: true
      });
    }

    

  });
</script>
@endpush