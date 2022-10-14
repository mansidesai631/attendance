<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helper;

class ForgotPasswordController extends Controller
{

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\View\View
     */
    public function ForgetPassword()
    {
        return view('auth.passwords.reset');
    }

     /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function ForgetPasswordStore(Request $request, Employee $employee)
    {
        $login = request()->input('auth');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';
 
        request()->merge([$fieldType => $login]);

        $rules = [
            'email' => 'nullable|exists:employees,email',
            'mobile' => 'nullable|exists:employees,mobile',
        ];

        $msg = [
            'email' => 'Captcha verification failed',
            'mobile' => 'Please complete the captcha'
        ];
        
        $validator = Validator::make($request->all(), $rules, $msg);
        
        if ($validator->fails()) {
            return response()->json(['status' => false,'error' => "Email/Mobile doesn't exist!"]);
            // return $validator->errors();
        }
        $employee = Employee::where($fieldType, $login)->first();
        if($employee) {
            $otp = Helper::sendOtp($employee->mobile);
            if ($otp) {
                return response()->json(['status' => true,'message' => 'success','data'=>[
                    'mobile'=>$employee->mobile
                ]]);

            }
        }
        return response()->json(['status' => false,'error' => "Email/Mobile doesn't exist!"]);       
    }

    public function resendOtp(Request $request) 
    {
        $employee = Employee::where('mobile', $request->mobile)->first();
        $otp = Helper::sendOtp($employee->mobile);
        if ($otp) {
            return response()->json(['status' => true,'message' => 'success']);
        } else {
            return response()->json(['status' => false,'message' => 'Invalid Employee Data']);
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
            return response()->json(['status' => false,'error' => "Invalid otp!"]);
        }

        $user = Employee::where('mobile', '=', $request->mobile)
            ->first();

        if($user->otp == null) {
            return response()->json(['status' => false,'error' => "OTP does not exist"]);
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

                return response()->json(['status' => false,'error' => "OTP Expired"]);
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
                return response()->json(['status' => true,'token' => $token]);
            }
        }
        else {
            return response()->json(['status' => false,'error' => "Invalid otp!"]);
        }
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\View\View
     */
    public function ResetPassword($token)
    {
        return view('auth.passwords.confirm', ['token' => $token]);
    }

    public function ResetPasswordStore(Request $request)
    {
        $rules = [
            'password' => 'required|confirmed|min:8'
        ];

        $msg = [
            'password' => 'PassWord Invalid',
        ];
        
        $validator = Validator::make($request->all(), $rules, $msg);
        
        if ($validator->fails()) {
            return response()->json(['status' => false,'error' => 'PassWord Invalid']);
        }

        $update = DB::table('password_resets')->where('token', $request->token)->first();

        if(!$update){
            return response()->json(['status' => false,'error' => 'Invalid token!']);
        }

        if ($request->password === $request->password_confirmation) {
            Employee::where('mobile', $update->email)->update(['password' => Hash::make($request->password)]);

            // Delete password_resets record
            DB::table('password_resets')->where(['email'=> $update->email])->delete();
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false,'error' => 'PassWord Invalid']);
        }
    }
}

