<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Manektech | Member Sign up</title>
    @include('layouts.includes.head') 
</head>

<body class="login-page">
    <?php
        if ($message = Session::get('success')){
            echo '<script>alert("Thanks for signup. We have sent email to admin of your organization to approve registration.")</script>';
            echo '<script>window.location.href="http://127.0.0.1:8000/"</script>';
        }
    ?>
  <div class="container">
    <div class="row align-items-center">
        <div class="col-md-3 col-lg-4"></div>
        <div class="col-md-6 col-lg-4">
            <div class="login-from-wrap">
                <form method="POST" action="{{route('register')}}">
                    @csrf
                    <div class="login-from-wrap">
                        <h1 style="display: none;"> Manektech Visitor Management System </h1>
                        <div class="login-header text-center">
                            <a href="#"><img src="{{asset('img/Manektech_Logo.png')}}" alt="Manektech Visitor Management System" width="120px"></a>
                        </div>
                        <div class="login-body cs-form bg-white pt-4">
                            <div class="form-outline mb-4">
                                <input type="text" class="form-control is-valid" name="name" id="name" />
                                <label class="form-label">Name</label>
                            </div>
                            <div class="form-outline mb-4">
                                <input type="text" class="form-control question" id="mobile" name="mobile" />
                                <label class="form-label"><span>Mobile Number</span></label>
                                
                            </div>
                            <div class="form-outline mb-4">
                                <input type="text" class="form-control" name="email" id="email" />
                                <label class="form-label">Work Email</label>
                            </div>
                            <div class="form-outline mb-4">
                                <input type="password" class="form-control" name="password" id="password" />
                                <label class="form-label">Password</label>
                            </div>
                            <div class="form-outline mb-4">
                                <input type="text" class="form-control" name="company_name" id="company_name" />
                                <label class="form-label">Your Company Name</label>
                            </div>
                            <div>
                                @if ($errors->all())
                                <div class="form-group">
                                    @if(in_array('User with this email already exist! Please use Forgot Password if need.',$errors->all()))
                                        <p id="login_text" align="left" style="color:red;">User with this email already exist! Please use Forgot Password if need.</p>
                                        @else
                                        <p id="login_text" align="left" style="color:red;">Please fill all the fields</p>
                                        @endif
                                </div>     
                                @endif
                            </div>
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button class="btn btn-primary" type="submit" value="signup">Sign up</button>
                                        <div id="loader" style="display:none;">
                                        <img src="img/loading.gif" alt="Manektech Visitor Management System"> Loading...
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        Already a member?
                                    <a href="{{ route('login') }}" class="to_register"> Login here</a>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="login-footer">
                            <i class="fa fa-copyright"></i>{{ date("Y") }} All Rights Reserved ManekTech <a href="javascript:void(0);">T&C</a>                 
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('layouts.includes.footer')
</body>
</html>
<script type="text/javascript" src="{{asset('js/intlTelInput.js')}}"></script>
<script type="text/javascript">
    $("#mobile").intlTelInput({
        placeholderNumberType:"MOBILE",
    });
</script>