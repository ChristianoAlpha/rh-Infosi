<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employeee extends Model
{
    use HasFactory;

    protected $fillable = [
        'departmentId',
        'fullName',
        'photo',
        'address',
        'mobile',
        'phone_code',
        'fatherName',
        'motherName',
        'bi',
        'birth_date',
        'nationality',
        'gender',
        'email',
        'positionId',
        'specialtyId',
        'employeeTypeId',
        'employmentStatus'  //campo: active, seconded, retired
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
}
