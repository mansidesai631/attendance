<?php
   
namespace App\Http\Controllers\v1\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\v1\Api\BaseController as BaseController;
use App\Models\Employee;
use Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;
use Carbon\Carbon;
   
class AuthController extends BaseController
{

    public function login(Request $request)
    {
        $login = request()->input('auth');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';
 
        request()->merge([$fieldType => $login]);

        $rules = [
            'email' => 'required_without:mobile|exists:employees,email',
            'mobile' => 'required_without:email|exists:employees,mobile',
            'password' => 'required|min:8',
        ];

        $msg = [
            'email' => 'Mobile/Email is required',
            'mobile' => 'Mobile/Email is required',
            'password' => 'Password is required',
        ];
        
        $validator = Validator::make($request->all(), $rules, $msg);
        
        if ($validator->fails()) {
            return $this->handleError('Please Enter Valid Mobile/Email or password');       
        }

        if(Auth::attempt([$fieldType => $login, 'password' => $request->password])){ 

            if (auth()->check() && (auth()->user()->status == 0)) {
                Auth::logout();
                return $this->handleError('Your site has been deactivated. Please contact your organization admin for any query.');
            } else {
                $auth = Auth::user(); 
                $success['token'] =  $auth->createToken('LaravelSanctumAuth')->plainTextToken; 
                $success['id'] =  $auth->id;
                $success['name'] =  $auth->name;
                $success['mchallan-flag'] =  $auth->m_challan_allowed;
                $success['register-face'] =  $auth->register_face_path;
                $success['image'] =  $auth->profile_path;
                $success['register-flag'] =  $auth->register_face ? true : false;
    
                return $this->handleResponse($success, 'User logged-in!');
            }
        } 
        else{ 
            return $this->handleError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:employees',
            'password' => 'required',
            'mobile' => 'required|unique:employees',
        ]);
   
        if($validator->fails()){
            return $this->handleError($validator->errors());       
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = Employee::create($input);
        $success['token'] =  $user->createToken('LaravelSanctumAuth')->plainTextToken;
        $success['name'] =  $user->name;
   
        return $this->handleResponse($success, 'User successfully registered!');
    }
    
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ];
    }

    public function ForgetPasswordStore(Request $request)
    {
        $login = request()->input('auth');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';
 
        request()->merge([$fieldType => $login]);

        $rules = [
            'email' => 'required_without:mobile|exists:employees,email',
            'mobile' => 'required_without:email|exists:employees,mobile',
        ];

        $msg = [
            'email' => 'Mobile/Email is required',
            'mobile' => 'Mobile/Email is required',
        ];
        
        $validator = Validator::make($request->all(), $rules, $msg);
        
        if ($validator->fails()) {
            return $this->handleError('Please Enter Valid Mobile/Email');       
        }

        $employee = Employee::where($fieldType, $login)->first();
        if($employee) {
            $otp = Helper::sendOtp($employee->mobile);
            if ($otp) {
                $success['mobile'] =  $employee->mobile;
                return $this->handleResponse($success, 'Your registered mobile number OTP sent successfully');
            }
        }
        return $this->handleError("Email/Mobile doesn't exist!");
    }

    public function resendOtp(Request $request) 
    {
        $employee = Employee::where('mobile', $request->mobile)->first();
        $otp = Helper::sendOtp($employee->mobile);
        if ($otp) {
            $success['otp'] =  $otp;
            return $this->handleResponse($success, 'Your registered mobile number OTP sent successfully');
        } else {
            return $this->handleError("Invalid Employee Data");
        }
    }

    public function verifyOtp(Request $request) {
        $rules = [
            'mobile' => 'required|exists:employees,mobile',
            'otp' => 'required|exists:employees,otp'
        ];

        $msg = [
            'mobile' => 'Mobile number not exists',
            'otp' => 'Invalid otp!'
        ];
        
        $validator = Validator::make($request->all(), $rules, $msg);
        
        if ($validator->fails()) {
            return $this->handleError($validator->errors()); 
        }

        $user = Employee::where('mobile', '=', $request->mobile)
            ->first();

        if($user->otp == null) {
            return $this->handleError("OTP does not exist");
        }

        //verify otp
        if ($request->otp == $user->otp) {
            $carbon = new Carbon;
            $now = $carbon->now();
            $validity = Carbon::parse($user->otp_created_at)->addMinutes(10);

            if (strtotime($validity) < strtotime($now)) {
                //delete otp
                $otp = '';
                // $now = '';
                $user->update(['otp' => $otp]);
                return $this->handleError("OTP Expired");
            } else {
                $token = Str::random(8);
                //Create Password Reset Token
                DB::table('password_resets')->insert([
                    'email' => $request->mobile,
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]);
                
                //delete otp
                $otp = '';
                // $now = '';
                $user->update(['otp' => $otp]);

                //redirect to password update page
                $success['token'] =  $token;
                return $this->handleResponse($success, 'Your OTP match successfully');
            }
        }
        else {
            return $this->handleError("Invalid otp!");
        }
    }

    public function ResetPasswordStore(Request $request)
    {
        $rules = [
            'password' => 'required|confirmed|min:8',
            'token' => 'required'
        ];

        $msg = [
            'password' => 'PassWord Invalid',
            'token' => 'Token is Required'
        ];
        
        $validator = Validator::make($request->all(), $rules, $msg);
        
        if ($validator->fails()) {
            return $this->handleError($validator->errors()); 
        }

        $update = DB::table('password_resets')->where('token', $request->token)->first();

        if(!$update){
            return $this->handleError('Invalid token!'); 
        }

        if ($request->password === $request->password_confirmation) {
            $emp = Employee::where('mobile', $update->email)->update(['password' => Hash::make($request->password)]);

            // Delete password_resets record
            DB::table('password_resets')->where(['email'=> $update->email])->delete();
            $success['employee'] =  $emp;
            return $this->handleResponse($success, 'Your password changed successfully');
        } else {
            return response()->json(['status' => false,'error' => 'PassWord Invalid']);
        }
    }
}