<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class Employee extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'password',
        'otp',
        'otp_created_at',
        'role_id',
        'created_by',
        'selected_site_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    protected $appends = ['profile_path', 'register_face_path'];

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function work(){
        return $this->hasOne(EmployeeWork::class,'employee_id','id');
    }

    public function other(){
        return $this->hasOne(EmployeeOther::class,'employee_id','id');
    }

    public function access(){
        return $this->hasOne(EmployeeAccess::class,'employee_id','id');
    }

    public function site(){
        return $this->hasOne(Site::class,'id','selected_site_id');
    }

    public function attendances()
    {
    	return $this->hasMany(Attendance::class,'employee_id','id');
    }

    public function leaveList()
    {
    	return $this->hasMany(LeaveList::class,'employee_id','id');
    }

    public function attendanceSingle()
    {
        return $this->hasOne(Attendance::class,'employee_id','id');
    }

    public function getProfilePathAttribute(){
        return $this->image ? url('/').'/storage/profile/'.$this->image : null;
    }

    public function getRegisterFacePathAttribute(){
        return $this->register_face ? url('/').'/storage/registerFace/'.$this->register_face : null;
    }
}
