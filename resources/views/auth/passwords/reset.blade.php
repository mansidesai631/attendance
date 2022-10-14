
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Manektech | Reset password</title>
    
    @include('layouts.includes.head') 
    <style>
        .hidden {
            display: none;;
        }
    </style>
</head>

<body class="login">
    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content" style="min-width:421px;">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <form id="resetForm" action="{{ route('ForgetPasswordPost') }}">
                @csrf                
                <h1>{{__("Reset Password")}}</h1>
				<div class="panel-body">
					<div class="form-group">
                        <input id="auth" type="text" placeholder="Please enter registered Email/Mobile" class="form-control w-100 @error('auth') is-invalid @enderror" name="auth" value="{{ $auth ?? old('auth') }}" required>
					</div>
					<div class="form-group mt-3">
                        <button type="submit" id="resetButton" class="btn btn-primary">
                            {{ __('Reset My Password') }}
                        </button>
					</div>
				</div>
                <div class="separator">
                    <a href="{{url('login')}}" class="to_register"> Login </a>
                </div>
                <div class="mt-5">
				    <a href="javascript:void(0);"><img align="center" src="{{ URL::asset('img/Manektech_Logo.png') }}" height="30px"></a>
                    <br>
                        ©{{ date("Y") }} All Rights Reserved ManekTech 
                    <a href="javascript:void(0);">T & C</a>
                </div>
            </form>
            <form id="verifyForm" class="hidden" method="POST" action="{{ route('verifyOtp') }}">
                <h1>{{__("Reset Password")}}</h1>
                @csrf 
                <div class="panel-body">
                  <p> We have sent OTP on <span id="mobileLabel"></span> and your registered email.</p>
                  <input type="hidden" name="mobile" id="mobile" value="">
                  <div class="form-group">
                      <input id="otp" type="text" class="form-control w-100 @error('otp') is-invalid @enderror" name="otp" value="{{ old('otp') }}" required autocomplete="otp">
                  </div>
                  <div class="form-group">
                    <input type="submit" value="Verify OTP" class="mx-2 shadow-0 text-capitalize mt-3 btn btn-primary">
                    <button id="resend_otp" type="button" value="Resend OTP" class="mx-2 btn-link text-body text-decoration-underline text-capitalize mt-3 btn counter-btn"> Resend OTP <span id="counter"></span> </button>
                  </div>
                </div>
                <div class="separator">
                    <a href="{{url('login')}}" class="to_register"> Login </a>
                </div>
                <div class="mt-5">
                    <a href="javascript:void(0);"><img align="center" src="{{ URL::asset('img/Manektech_Logo.png') }}" height="30px"></a>
                    <br>
                    ©{{ date("Y") }} All Rights Reserved ManekTech 
                    <a href="javascript:void(0);">T & C</a>
                </div>
              </form>
            </section>
        </div>
    </div>
    @include('layouts.includes.footer')
</body>
</html>
<script>
$(function() {
    $("#resetForm").on('submit',function(e){
        e.preventDefault()
    })
    $("#resetForm").validate({
        rules: {
            auth: {
                required: true,
            },
        },
        messages: {
            auth: {
                required: "Please enter your email.",
            },
        },
        //  errorClass:'text-danger',
        invalidHandler: function(event, validator) {
            const errors = validator.errorMap
            if(errors.auth){
                alert( "Please enter your email.");
            }
        },
        errorPlacement: function() {
            return false
        },
        submitHandler : function(form) {
            console.log('-----')
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // let form = $('#resetForm');
            let url = form.getAttribute('action');
            $.ajax({
                type:'POST',
                url: url,
                data: new FormData(resetForm),
                cache:false,
                contentType: false,
                processData: false,
                
                success: (response) => {
                    console.log('success', response);
                    if(response.status){
                        $("#resetForm").addClass('hidden')
                        $("#verifyForm").removeClass('hidden')
                        let mobile= response.data.mobile 
                        mobile = mobile.substr(6,4);
                        $('#mobileLabel').text(`******${mobile}`)
                        $('#mobile').val(response.data.mobile)
                    }else {
                        alert(response.error)
                    }
                },
                error: function(error){
                    console.log('error',error);
                }
            });
        }     
    });

    $("#verifyForm").on('submit',function(e){
        e.preventDefault()
    })
    $("#verifyForm").validate({
        rules: {
            otp: {
                required: true,
            },
        },
        messages: {
            otp: {
                required: "Please enter otp!",
            },
        },
        invalidHandler: function(event, validator) {
            const errors = validator.errorMap
            if(errors.otp){
                alert( "Please enter otp!");
            }
        },
        errorPlacement: function() {
            return false
        },
        submitHandler : function(form) {
            console.log('-----')
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // let form = $('#resetForm');
            let url = form.getAttribute('action');
            $.ajax({
                type:'POST',
                url: url,
                data: new FormData(verifyForm),
                cache:false,
                contentType: false,
                processData: false,
                
                success: (response) => {
                    console.log('success', response);
                    if(response.status){
                        window.location = 'reset-password/' + response.token;
                    }else {
                        alert(response.error)
                    }
                },
                error: function(error){
                    console.log('error',error);
                }
            });
        }     
    });
    var timer;
    var count = 30;
    $("#counter").text('');
    $("#resend_otp").on('click',function(e){
        count = 30;
        timer = setTimeout(update, 1000);
        mobile = $('[name="mobile"]').val();
        $.ajax({
            url: 'resendOtp',
            method: "POST",
            data:{
                    mobile : mobile,
                } 
        })
        .done(function(result) {
            console.log(result);
        })
        .fail(function(error) {
            console.log(error);  
        });
    });

    function update()
    {
        if (count > 0)
        {
            $("#counter").text(--count);
            timer = setTimeout(update, 1000);
            $('#resend_otp').prop('disabled', true);
        }
        else
        {
            $("#counter").text('');
            $('#resend_otp').prop('disabled', false);
        }
    }
});    
</script>
