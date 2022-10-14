<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helper;
use App\Http\Requests\v1\Backend\SignupUserRequest;

class SignupController extends Controller
{
    public function index(){
    	return view('auth.register');
    }

    public function signup(SignupUserRequest $request){

	    $userCheck = Employee::where('email',$request->email)->orWhere('mobile',$request->mobile)->first();
        if($userCheck){
        	return back()->withInput()->withErrors('User with this email already exist! Please use Forgot Password if need.');
        }

        $mobile = explode(" ", $request->mobile);
    	$employees = new Employee();
        $employees->name = $request->name;
        $employees->email = $request->email;
        $employees->mobile = $mobile[1];
        $employees->country_code = $mobile[0];
        $employees->password = Hash::make($request->password);
        $employees->gender = 'Male';
        $employees->role_id = '1';
        $employees->user_type = 'Staff';
        $employees->status = '1';
        $employees->role_id = '1';
        $employees->created_by = 1;
        $employees->save();

    	return redirect()->route('signup')->with('success','Staff Registered Successfully');
    }
    
}
