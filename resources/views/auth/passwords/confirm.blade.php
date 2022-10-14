
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Manektech | Change password</title>
    
    @include('layouts.includes.head') 

</head>

<body class="login">
    <div class="login_wrapper">
      <div class="animate form login_form">
        <section class="login_content">
        <form id="passwordUpdate" method="POST" action="{{ route('ResetPasswordPost') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <i class="fa fa-lock fa-4x"></i>
            <h5 class="mt-4">{{ __('Reset Password?') }}</h5>
            <div class="panel-body">
              <p>{{ __('You can reset your password here.') }}</p>
              <div class="form-group">
                  <div class="input-group">
                      <span class="input-group-addon">
                          <i class="ti-key rotate text-body"></i>
                      </span>
                      <input id="password" type="password" placeholder="New Password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                  </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="ti-key rotate text-body"></i>
                    </span>
                    <input id="password1" type="password" placeholder="Confirm Password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" required>
                </div>
              </div>
                <div class="form-group">
                        <button type="submit" class="btn btn-primary shadow-0 text-capitalize">
                            {{ __('Change Password') }}
                        </button>
                </div>
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
    $("#passwordUpdate").on('submit',function(e){
        e.preventDefault()
    })
    $("#passwordUpdate").validate({
        rules: {
            password: {
                required: true,
            },
            password_confirmation: {
                required: true,
            },
        },
        messages: {
            password: {
                required: "Please enter password",
            },
            password_confirmation: {
                required: "Please enter confirm password",
            },
        },
        invalidHandler: function(event, validator) {
            const errors = validator.errorMap
            if(errors.password){
                alert( "Please enter password");
            }
            if(errors.password_confirmation){
                alert( "Please enter confirm password");
            }
        },
        errorPlacement: function() {
            return false
        },
        submitHandler : function(form) {
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
                data: new FormData(passwordUpdate),
                cache:false,
                contentType: false,
                processData: false,
                
                success: (response) => {
                    console.log('success', response);
                    if(response.status){
                        window.location = "{{ route('login') }}";
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
</script>