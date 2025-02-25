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
        'father_name',
        'mother_name',
        'bi',
        'birth_date',
        'nationality',
        'gender',
        'email',
        'positionId',
        'specialtyId'
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
}
