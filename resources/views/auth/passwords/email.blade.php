
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Manektech | Reset password</title>
    
    @include('layouts.includes.head') 
</head>

<body class="login">
    <div class="login_wrapper">
      <div class="animate form login_form">
        <section class="login_content">
          <form method="POST" action="{{ route('verifyOtp') }}">
            <h1>{{__("Reset Password")}}</h1>
            @csrf 
            <div class="panel-body">
              <p> We have sent OTP on {{ $employee->mobile }} and your registered email.</p>
              <input type="hidden" name="mobile" value="{{ $employee->mobile }}">
              <div class="form-group">
                  <input id="otp" type="text" class="form-control @error('otp') is-invalid @enderror" name="otp" value="{{ old('otp') }}" required autocomplete="otp">
              </div>
              <div class="form-group">
                <input type="submit" value="Verify OTP" class="mx-2 shadow-0 text-capitalize mt-3 btn btn-primary">
                <button type="button" value="Resend OTP" class="mx-2 btn-link text-body text-decoration-underline text-capitalize mt-3 btn counter-btn"> Resend OTP </button>
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