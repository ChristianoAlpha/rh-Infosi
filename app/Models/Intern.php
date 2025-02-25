<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intern extends Model
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
        'specialtyId',
        'internshipStart', // Início do Estágio
        'internshipEnd',   // Fim do Estágio
        'institution'      // Instituição de origem
    ];

    public function department()
    {
        return $this->belongsTo(\App\Models\Department::class, 'departmentId');
    }

    public function position()
    {
        return $this->belongsTo(\App\Models\Position::class, 'positionId');
    }

    public function specialty()
    {
        return $this->belongsTo(\App\Models\Specialty::class, 'specialtyId');
    }
}
