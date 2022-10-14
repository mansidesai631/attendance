@extends('layouts.master')

@section('title','Dashboard')
@section('content')
<!--Main layout-->
<style>
    .hidden {
        display: none;
    }
</style>
<main class="content-body">
    <div class="page-body">
    <div class="row cs-form">
        <div class="col-md-5 mx-auto">
            <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-baseline">
                <div class="d-flex flex-column">
                    <h5>Profile</h5>
                </div>
                </div>
            </div>
            <div class="card-block-hid">
                <div class="card-block p-4">
                <form id="profileForm"  enctype="multipart/form-data">
                    <div class="row ">
                        <div class="col-md-12 p-0 image-container d-flex justify-content-center">
                            <div class="profile-image">
                            <div class="avatar-container">
                                @if ($emp->image)
                                    <div class="avatar-content" id="avatar" style="background-color: transparent">
                                        <img alt="" id="profile" src="{{ asset('storage/profile/'.$emp->image) }}">
                                        <input type="file" class="form-control d-none" id="profile_file" name="profile_file" />
                                    </div>
                                @else
                                    <div class="avatar-content" id="avatar" style="background-color: #2c3e50;">
                                        <span id="profileSortName">{{ucwords($emp->name[0].$emp->name[1])}}</span>
                                        <img alt="" id="profile" src="" class="hidden">
                                        <input type="file" class="form-control d-none" id="profile_file" name="profile_file" />
                                    </div>   
                                @endif
                            </div>
                            </div>
                            <div class="change-profile w-100 mt-3">
                            <span class="select-btn">
                                <button type="button" class="btn btn-primary text-capitalize"  data-mdb-toggle="modal" data-mdb-target="#cropper-modal">Change Image
                                </button>
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <div class="row m-0">
                        <div class="col-md-12 mb-4">
                            <div class="form-outline">
                                <input type="hidden" name="profile_id" id="profile_id" value="{{ $emp->id }}"> 
                                <input type="text" id="name" name="name" value="{{ $emp->name }}" class="form-control" />
                                <label class="form-label">Name</label>
                            </div>
                            <div class="mt-3">
                                <h6 class="text-body mb-0">Role: {{ $emp->role->name }}</h6>
                            </div>
                        </div>
                        <div class="col-md-12 mb-4">
                            <div class="form-outline">
                            <input type="text" name="mobile" value="{{ $emp->mobile }}" class="form-control" disabled />
                            <label class="form-label">Mobile Number</label>
                            </div>
                        </div>
                        <div class="col-md-12 mb-4">
                            <div class="form-outline">
                            <input type="text" name="email" value="{{ $emp->email }}" class="form-control" disabled/>
                            <label class="form-label">Office Email</label>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <a class="btn btn-primary text-capitalize ripple-surface" href="{{url('reset_password')}}"> Change Password</a>
                        </div>
                        <div class="action-btns text-right mb-3">
                            <button type="submit" id="profileButton" class="btn btn-primary px-3 text-capitalize">Save</button>
                        </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
            </div>
        </div>
    </div>
    </div>
</main>
@endsection
<!--Main layout-->

<!-- Modal -->
<div class="modal fade" id="cropper-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header text-center">
            <h5 class="modal-title w-100" id="exampleModalLabel">Change Profile Picture
            </h5>
            <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row mb-4">
            <div class="col-md-8 mx-auto">
            <label class="form-label" for="customFile">Select Image</label>
            <input type="file" class="form-control" id="customFile" />
        </div>
        </div>
            <div class="img-container">
            <img id="image" src="img/profile.jpg" alt="Picture" >
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default text-capitalize" data-mdb-dismiss="modal">Close</button>
            <button type="button" id="selectImage" class="btn btn-primary text-capitalize">Select Image</button>
        </div>
        </div>
    </div>
</div>
@push('js')
<script>
    $(function() {
        $("#name").focus();
        $(document).on('change', '#customFile', function(event) {
            if(event.target.files && event.target.files.length)
            {
                let image = document.getElementById('image') 
                image.src= URL.createObjectURL(event.target.files[0])
            }
           
        })
        $(document).on('click', '#selectImage', function(event) {
           
            let files = $('#customFile').prop('files');
            if(files && files.length )
            {   
                $("#profile_file").prop("files", files);

                $("#profileSortName").addClass("hidden");
                $("#avatar").css("backeground-color", "transparent");

                let profile = document.getElementById('profile') 
                profile.src= URL.createObjectURL(files[0])
                $("#profile").removeClass("hidden");
                $("#cropper-modal").modal('toggle');

            }
        })
        
        $("#profileForm").validate({
            ignore: ":hidden",
            rules: {
                name: "required",
            },
            messages: {
                name: {
                    required: "Please enter name",
                },      
            },
            submitHandler: function (form) { 
                var id = $("#profile_id").val();
                console.log(id)
                var fd = new FormData(profileForm);        
                $.ajax({
                    url: "{{route('profile-save')}}",
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        if(result.status == true){
                            toastr.success(result.message);
                        }else{
                            toastr.error(result.message);
                        }
                    }
                });
            }
        });

    });    
</script>
@endpush