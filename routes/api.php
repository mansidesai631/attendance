<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:sanctum')->group( function () {
    Route::post('logout', [AuthController::class, 'logout']);

    // M-challan
    Route::resource('m-challan', App\Http\Controllers\v1\Api\MChallanController::class);
    Route::get('get-all-challan', [App\Http\Controllers\v1\Api\MChallanController::class, 'getAllChallan']);
    Route::post('save-remark', [App\Http\Controllers\v1\Api\InspectionsController::class,'saveRemark']);


    Route::get('id-type', [App\Http\Controllers\v1\Api\MChallanController::class, 'getIdType']);
    Route::resource('field-monitoring', App\Http\Controllers\v1\Api\FieldMonitorController::class);
    Route::get('get-all-departments',[App\Http\Controllers\v1\Api\DepartmentController::class,'index']);
    Route::get('get-all-staff',[App\Http\Controllers\v1\Api\StaffController::class,'index']);
    Route::resource('inspections', App\Http\Controllers\v1\Api\InspectionsController::class);
    Route::get('get-all-inspection-details/{id}',[App\Http\Controllers\v1\Api\InspectionsController::class,'index']);

    Route::get('dashboard',[App\Http\Controllers\v1\Api\DashboardController::class,'index']);
    Route::get('profile',[App\Http\Controllers\v1\Api\DashboardController::class,'profile']);
    Route::post('update-profile',[App\Http\Controllers\v1\Api\DashboardController::class,'updateProfile']);
    Route::post('register-face',[App\Http\Controllers\v1\Api\DashboardController::class,'registerFace']);

    Route::post('attendance-history', [App\Http\Controllers\v1\Api\AttendanceController::class,'history']);



});

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::post('forget-password', [AuthController::class, 'ForgetPasswordStore'])->name('ForgetPasswordPost');
Route::post('resend-otp', [AuthController::class, 'resendOtp']);
Route::post('verify-otp', [AuthController::class, 'verifyOtp'])->name('verifyOtp');
Route::post('reset-password', [AuthController::class, 'ResetPasswordStore'])->name('ResetPasswordPost');

 // Face match

 Route::post('face-match',[App\Http\Controllers\v1\Api\FacematchController::class,'userInfo']);
  Route::post('upgrade',[App\Http\Controllers\v1\Api\FacematchController::class,'upgrade']);
