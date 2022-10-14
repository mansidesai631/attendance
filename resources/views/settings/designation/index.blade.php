<?php
$selected_site = App\Models\Employee::where('id',Auth::id())->first();
?>
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
                            keyboard_arrow_left</mat-icon>
                        </a>
                        <div class="d-flex flex-column mt-2">
                        <h5>Designation and other fields settings</h5>
                        <small class="mt-1">You can setup Designations and Other Staff Functions from here</small>
                        </div>
                    </div>
                </div>
                <div class="card-block-hid">
                    <div class="card-block px-4 pb-4">
                        <div class="page-body">
                            <div class="row card-list-section cs-form">
                                <div class="col-md-4">
                                    <div class="d-flex flex-column flex-wrap">
                                    <div class="row p-3 p-t-0 p-b-0">
                                        <div class="col-md-3 p-0">
                                        <button class="btn btn-link btn-sm px-1 text-black" data-mdb-toggle="tooltip" data-mdb-placement="right" title="Add Designation" aria-describedby="cdk-describedby-message-15" id="addDesignation">
                                            <mat-icon role="img" class="mat-icon material-icons" aria-hidden="true">add</mat-icon>
                                        </button>
                                        <button class="btn btn-link btn-sm px-1 text-black" data-mdb-toggle="tooltip" data-mdb-placement="right" title="Close Designation" aria-describedby="cdk-describedby-message-15" id="closeDesignation" style="display: none">
                                            <mat-icon role="img" class="mat-icon material-icons" aria-hidden="true">close</mat-icon>
                                        </button>
                                        </div>
                                        <div class="col-md-4 "></div>
                                        <div  class="col-md-5 p-0 "></div>
                                    </div>
                                    <div  id="designation_div" style="display: none;">
                                        <div class="row p-3 p-t-0 p-b-0">
                                            <div class="col-md-8">
                                                <form id="designationForm">
                                                @csrf
                                                    <div class="form-outline">
                                                        <input type="hidden" name="site_id" id="site_id" value="{{ $selected_site->site->id }}">
                                                        <input type="text" class="form-control" name="designation_name" id="designation_name"/>
                                                        <label class="form-label">Enter New Designation</label>
                                                    </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                    <button class="btn btn-link text-body btn-sm text-capitalize fs-6">Add</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="card">
                                    <div class="card-header pt-3 pb-1">
                                        <h5>Designation</h5>
                                    </div>
                                    <div class="card-block">
                                        <div class="ps-content">
                                            <ul class="list-view department-list-view">
                                                @foreach($designations as $designation)
                                                <li>
                                                    <div class="card list-view-media">
                                                        <div class="card-block staff-block">
                                                            <div class="media">
                                                            <div class="media-body">
                                                                <h6>{{ $designation->name }}</h6>
                                                            </div>
                                                            <div class="media-right">
                                                                <div class="d-inline-block right-control">
                                                                <button class="btn btn-link px-0 btn-sm" data-mdb-toggle="dropdown" id="closebtn">
                                                                    <mat-icon role="img" class="mat-icon material-icons" aria-hidden="true">delete_forever</mat-icon>
                                                                </button>
                                                                <ul class="dropdown-menu" aria-labelledby="closebtn">
                                                                    <li><a class="dropdown-item py-3" href="#">Cancel</a></li>
                                                                    <li><a class="dropdown-item py-3 designation_delete" href="#" data-id="{{ $designation->id}}">Yes, Delete!</a></li>
                                                                </ul>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    </div>
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
     $("#designationForm").validate({
        ignore: ":hidden",
        rules: {
            designation_name: {
                required: true,
          },             
        },
        messages: { 
            designation_name: { 
                required: "Please enter a valid designation name"
          }
        }, 
        submitHandler: function (form) { 
            $.ajax({
            type: "POST",
            url: "{{route('designation.store')}}",
            data: $(form).serialize(),
            success: function (result) {
              if(result.status == true){
                toastr.success(result.message);
                $("#designationForm")[0].reset();
                location.reload(true);
              }
            }
          });
        }
    });

    $(document).on('click','.designation_delete',function(event){
      var id  = $(this).attr('data-id');
      $.ajax({
        type:"POST",
        data:{id:id},
        url: "{{route('designation.delete')}}",
        dataType:'json',
        success:function(result){
          if(result.status == true){
            toastr.success(result.message);
            location.reload(true);
          }          
        }
      })
    });

    $(document).on('click','#addDesignation',function(event){
        $("#closeDesignation").css('display','block');
        $("#designation_div").css('display','block');

        $("#addDesignation").css('display','none');
    });

    $(document).on('click','#closeDesignation',function(event){
        $("#closeDesignation").css('display','none');
        $("#designation_div").css('display','none');

        $("#addDesignation").css('display','block');
    });

</script>
@endpush