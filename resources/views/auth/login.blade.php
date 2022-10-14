<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Manektech Login | User Dashboard</title>
    @include('layouts.includes.head') 
</head>

<body class="login-page">
  <div class="container">
    <div class="row align-items-center">
        <div class="col-md-3 col-lg-4"></div>
        <div class="col-md-6 col-lg-4">
            <div class="login-from-wrap">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <h1 style="display: none;"> Manektech Visitor Management System </h1>
                    <div class="login-header text-center">
                        <a href="#" class="w-75 d-block mx-auto"><img src="{{ URL::asset('img/Manektech_Logo.png') }}" alt="Manektech Visitor Management System" width="120px"></a>
                    </div>
                    <div class="login-body">
                            <div class="form-group">
                                <label>Your Email/Mobile</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </span>
                                    <!-- <input type="text" class="form-control" placeholder="Your Email/Mobile"> -->
                                    <input id="auth" type="text" placeholder="Your Email/Mobile" class="form-control @error('auth') is-invalid @enderror" name="auth" value="{{ old('auth') }}" required autocomplete="auth" autofocus>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-key"></i>
                                    </span>
                                    <!-- <input type="password" class="form-control" placeholder="Password"> -->
                                    <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" required autocomplete="current-password">
                                </div>
                            </div>
                            @if ($errors->all())
                                <div class="form-group">
                                    @if($errors->first('mobile'))
                                        <p id="login_text" align="left" style="color:red;"> {{ $errors->first('mobile') }}</p>
                                    @else
                                        <p id="login_text" align="left" style="color:red;"> {{ $errors->first('email') }}</p>
                                    @endif
                                </div>     
                            @endif                       
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <button class="btn btn-primary" type="submit" value="Login">
                                        <i class="fa fa-lock"></i> Login</button>
                                                        <div id="loader" style="display:none;">
                                            <img src="{{ URL::asset('img/loading.gif') }}" alt="Manektech Visitor Management System"> Loading...
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 text-right">
                                    <div class="form-group">
                                        <a class="reset_pass" href="{{url('reset_password')}}">Forgot password?</a>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="login-footer">
                        <i class="fa fa-copyright"></i>{{ date("Y") }} All Rights Reserved ManekTech                 
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('layouts.includes.footer')
</body>
</html>