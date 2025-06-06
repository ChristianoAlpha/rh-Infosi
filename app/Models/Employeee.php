<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Employeee extends Authenticatable implements CanResetPasswordContract
{
    use Notifiable, CanResetPassword;

    protected $fillable = [
        'departmentId',
        'fullName',
        'photo',
        'iban',
        'address',
        'mobile',
        'phone_code',
        'fatherName',
        'motherName',
        'bi',
        'biPhoto',   
        'birth_date',
        'nationality',
        'gender',
        'email',
        'positionId',
        'specialtyId',
        'employeeTypeId',
        'employmentStatus',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'departmentId');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'positionId');
    }

    public function specialty()
    {
        return $this->belongsTo(Specialty::class, 'specialtyId');
    }

    public function employeeType()
    {
        return $this->belongsTo(EmployeeType::class, 'employeeTypeId');
    }

    public function retirement()
    {
        return $this->hasOne(Retirement::class, 'employeeId');
    }

    public function admin()
    {
        return $this->hasOne(Admin::class, 'employeeId');
    }


    public function positionHistories()
    {
        return $this->hasMany(PositionHistory::class, 'employeeId')
                    ->with('position')
                    ->orderByDesc('startDate');
    }
      

    /**
 * Trabalhos Extras dos quais este funcionário participou.
 */
    public function extraJobs()
    {
        return $this->belongsToMany(
            ExtraJob::class,
            'extra_job_employees',
            'employeeId',
            'extraJobId'
        )
        ->withPivot('bonusAdjustment','assignedValue')
        ->withTimestamps();
    }


}