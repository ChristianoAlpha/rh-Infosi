<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacationRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'employeeId',
        'departmentId',
        'vacationType',
        'vacationStart',
        'vacationEnd',
    ];

    public function employee()
    {
        return $this->belongsTo(Employeee::class, 'employeeId');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'departmentId');
    }
}
