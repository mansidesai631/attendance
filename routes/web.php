<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\SignupController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Register
Route::get('signup', [SignupController::class, 'index'])->name('signup');
Route::post('register', [SignupController::class, 'signup'])->name('register');

Route::get('reset_password', [ForgotPasswordController::class, 'ForgetPassword'])->name('ForgetPasswordGet');
Route::post('reset_password', [ForgotPasswordController::class, 'ForgetPasswordStore'])->name('ForgetPasswordPost');
Route::post('/sendOtp', [ForgotPasswordController::class, 'sendOtp']);
Route::post('/resendOtp', [ForgotPasswordController::class, 'resendOtp']);
Route::post('/verifyOtp', [ForgotPasswordController::class, 'verifyOtp'])->name('verifyOtp');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'ResetPassword'])->name('ResetPasswordGet');
Route::post('reset-password', [ForgotPasswordController::class, 'ResetPasswordStore'])->name('ResetPasswordPost');

Route::middleware(['auth'])->group(function (){
	Route::get('/dashboard', [App\Http\Controllers\v1\Backend\DashboardController::class, 'index'])->name('dashboard');
	Route::get('/profile', [App\Http\Controllers\v1\Backend\StaffDirectoryController::class, 'profile'])->name('profile');
	Route::post('/profile-save', [App\Http\Controllers\v1\Backend\StaffDirectoryController::class, 'profileSave'])->name('profile-save');
	Route::get('/change-site', [App\Http\Controllers\v1\Backend\DashboardController::class, 'changeSite'])->name('change.site');

	// Staff-directory
	Route::resource('staff-directory',  \App\Http\Controllers\v1\Backend\StaffDirectoryController::class);
	Route::post('staff-directory/all',[App\Http\Controllers\v1\Backend\StaffDirectoryController::class,'getAllStaff'])->name('staff-directory.all.datatable');
	Route::post('/staff-export', [App\Http\Controllers\v1\Backend\StaffDirectoryController::class, 'staffExport'])->name('staff.export');
	Route::post('change-staff-status',[App\Http\Controllers\v1\Backend\StaffDirectoryController::class, 'changeStatus'])->name('change.staff.status');
	Route::post('change-all-staff-status',[App\Http\Controllers\v1\Backend\StaffDirectoryController::class, 'changeAllStatus'])->name('change.all.staff.status');
	Route::post('delete-all-staff',[App\Http\Controllers\v1\Backend\StaffDirectoryController::class, 'deleteAll'])->name('delete.all.staff');
	Route::post('check-status',[App\Http\Controllers\v1\Backend\StaffDirectoryController::class, 'checkStatus'])->name('check.staff.status');
	Route::post('check-deactive-status',[App\Http\Controllers\v1\Backend\StaffDirectoryController::class, 'checkDeactiveStatus'])->name('check.deactive.staff.status');
	Route::post('get-shift-time',[App\Http\Controllers\v1\Backend\StaffDirectoryController::class, 'getShiftTime'])->name('get.shift.time');
	Route::post('check-number',[App\Http\Controllers\v1\Backend\StaffDirectoryController::class, 'checkNumber'])->name('check.number');
	Route::get('/print/{data}', [App\Http\Controllers\v1\Backend\StaffDirectoryController::class, 'print'])->name('print');
	Route::post('import-staff',[App\Http\Controllers\v1\Backend\StaffDirectoryController::class, 'importStaff'])->name('import.staff');

	// Leave Type
	Route::resource('leave-type',  \App\Http\Controllers\v1\Backend\LeaveTypeController::class);
	Route::post('leave-type/all',[App\Http\Controllers\v1\Backend\LeaveTypeController::class,'getAllLeaveType'])->name('leave-type.all.datatable');
	Route::post('leave-type-update',[App\Http\Controllers\v1\Backend\LeaveTypeController::class,'update'])->name('leave-type.update');
	Route::post('leave-type-delete',[App\Http\Controllers\v1\Backend\LeaveTypeController::class,'destroy'])->name('leave-type.delete');

	// Apply Leave Form
	Route::resource('leave-management',  \App\Http\Controllers\v1\Backend\LeaveController::class);
	Route::post('check-leave-balance',[App\Http\Controllers\v1\Backend\LeaveController::class,'checkLeaveBalance'])->name('check.leave.balance');

	// My History
	Route::resource('my-history',\App\Http\Controllers\v1\Backend\LeaveHistoryController::class);
	Route::post('my-history/all',[App\Http\Controllers\v1\Backend\LeaveHistoryController::class,'getAllLeaveHistory'])->name('my.history.all.datatable');
	Route::post('leave-update',[App\Http\Controllers\v1\Backend\LeaveHistoryController::class,'update'])->name('leave.update');

	//Employee Leaves
	Route::resource('manage-emp-leaves',\App\Http\Controllers\v1\Backend\ManageStaffLeaveController::class);
	Route::post('employee-leave-history',[App\Http\Controllers\v1\Backend\ManageStaffLeaveController::class,'empLeaveHistory'])->name('employee.leave.history');


	//department
	Route::resource('department', App\Http\Controllers\v1\Backend\DepartmentController::class);
	Route::post('department/all',[App\Http\Controllers\v1\Backend\DepartmentController::class,'getAlldepartment'])->name('department.all.datatable');
	Route::post('department-update',[App\Http\Controllers\v1\Backend\DepartmentController::class,'update'])->name('department.update');
	Route::post('department-delete',[App\Http\Controllers\v1\Backend\DepartmentController::class,'destroy'])->name('department.delete');

	//designation
	Route::resource('designation', App\Http\Controllers\v1\Backend\DesignationController::class);
	Route::post('designation-delete',[App\Http\Controllers\v1\Backend\DesignationController::class,'destroy'])->name('designation.delete');

	//staff-category
	Route::resource('staff-category', App\Http\Controllers\v1\Backend\StaffCategoryController::class);
	Route::post('staff-category-update',[App\Http\Controllers\v1\Backend\StaffCategoryController::class,'update'])->name('staff-category.update');
	Route::post('staff-category-delete',[App\Http\Controllers\v1\Backend\StaffCategoryController::class,'destroy'])->name('staff-category.delete');
	Route::post('staff-category/all',[App\Http\Controllers\v1\Backend\StaffCategoryController::class,'getAllStaffCategory'])->name('staff-category.all.datatable');

	Route::view('settings', 'settings.index');
	Route::post('staff-type-update',[App\Http\Controllers\v1\Backend\StaffCategoryController::class,'updateStaffType'])->name('staff-type.update');
	Route::post('staff-type-reset',[App\Http\Controllers\v1\Backend\StaffCategoryController::class,'resetStaffType'])->name('staff-type.reset');

	//site
	Route::resource('sites', App\Http\Controllers\v1\Backend\SiteController::class);
	Route::post('site/all',[App\Http\Controllers\v1\Backend\SiteController::class,'getAllSite'])->name('site.all.datatable');
	Route::post('site-update',[App\Http\Controllers\v1\Backend\SiteController::class,'update'])->name('site.update');
	Route::post('site-delete',[App\Http\Controllers\v1\Backend\SiteController::class,'destroy'])->name('site.delete');

	// Ward
	Route::resource('wards', App\Http\Controllers\v1\Backend\WardController::class);
	Route::post('wards/all',[App\Http\Controllers\v1\Backend\WardController::class,'getAllWard'])->name('ward.all.datatable');
	Route::post('ward-update',[App\Http\Controllers\v1\Backend\WardController::class,'update'])->name('ward.update');
	Route::post('ward-delete',[App\Http\Controllers\v1\Backend\WardController::class,'destroy'])->name('ward.delete');
	Route::get('get-all-sites',[App\Http\Controllers\v1\Backend\WardController::class,'getSites'])->name('get.all.sites');

	// circle
	Route::resource('circles', App\Http\Controllers\v1\Backend\CircleController::class);
	Route::post('circles/all',[App\Http\Controllers\v1\Backend\CircleController::class,'getAllCircle'])->name('circle.all.datatable');
	Route::post('circle-update',[App\Http\Controllers\v1\Backend\CircleController::class,'update'])->name('circle.update');
	Route::post('circle-delete',[App\Http\Controllers\v1\Backend\CircleController::class,'destroy'])->name('circle.delete');
	Route::get('get-all-wards',[App\Http\Controllers\v1\Backend\CircleController::class,'getwards'])->name('get.all.wards');

	// Default Manager
	Route::get('get-staff',[App\Http\Controllers\v1\Backend\SiteController::class,'getStaff'])->name('get.staff');
	Route::post('save-default-manager',[App\Http\Controllers\v1\Backend\SiteController::class,'saveDefaultManager'])->name('save.default.manager');

	// Settings - Location
	Route::resource('location', App\Http\Controllers\v1\Backend\LocationController::class);
	Route::post('location/all',[App\Http\Controllers\v1\Backend\LocationController::class,'getAllLocation'])->name('location.all.datatable');
	Route::post('location-update',[App\Http\Controllers\v1\Backend\LocationController::class,'update'])->name('location.update');
	Route::post('/location-export', [App\Http\Controllers\v1\Backend\LocationController::class, 'locationExport'])->name('location.export');
	Route::post('/location-delete', [App\Http\Controllers\v1\Backend\LocationController::class, 'destroy'])->name('location.delete');

	//Attendance
	Route::resource('attendance-entry',  \App\Http\Controllers\v1\Backend\AttendanceController::class);
	Route::post('attendance-entry/date-filter', [App\Http\Controllers\v1\Backend\AttendanceController::class, 'dateFilter'])->name('dateFilter');


	//Shift
	Route::resource('shift',  \App\Http\Controllers\v1\Backend\ShiftController::class);
	Route::post('shift/all',[App\Http\Controllers\v1\Backend\ShiftController::class,'getAllShift'])->name('shift.all.datatable');
	Route::post('shift-update',[App\Http\Controllers\v1\Backend\ShiftController::class,'update'])->name('shift.update');
	Route::post('shift-delete',[App\Http\Controllers\v1\Backend\ShiftController::class,'destroy'])->name('shift.delete');

	//M-Channel Listing
	Route::resource('m-challan', App\Http\Controllers\v1\Backend\MChallanController::class);
	Route::post('channel/all',[App\Http\Controllers\v1\Backend\MChallanController::class,'getAllChannel'])->name('channel.all.datatable');
	Route::post('get-mchallan-images',[App\Http\Controllers\v1\Backend\MChallanController::class,'getImages'])->name('get.mchallan.images');
	Route::any('/view-map/{id}',[App\Http\Controllers\v1\Backend\MChallanController::class,'viewMap'])->name('view.map');

	// Field report
	Route::resource('field-report',\App\Http\Controllers\v1\Backend\FieldMonitorController::class);
	Route::post('field-report/all',[App\Http\Controllers\v1\Backend\FieldMonitorController::class,'getAllFieldReport'])->name('field.report.all.datatable');
	Route::post('save-remark',[App\Http\Controllers\v1\Backend\FieldMonitorController::class,'saveRemark'])->name('save.remark');
	Route::post('get-before-images',[App\Http\Controllers\v1\Backend\FieldMonitorController::class,'getBeforeImages'])->name('get.before.images');
	Route::post('get-after-images',[App\Http\Controllers\v1\Backend\FieldMonitorController::class,'getAfterImages'])->name('get.after.images');

	//Reports
	Route::resource('reports',\App\Http\Controllers\v1\Backend\ReportsController::class);
	Route::get('report-export',[App\Http\Controllers\v1\Backend\ReportsController::class,'exportReport'])->name('report.export');
});
