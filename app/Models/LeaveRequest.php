<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'employeeId',
        'departmentId',
        'leaveTypeId',
        'reason',
    ];

    // Relação com Employeee
    public function employee()
    {
        return $this->belongsTo(Employeee::class, 'employeeId');
    }

    // Relação com Department
    public function department()
    {
        return $this->belongsTo(Department::class, 'departmentId');
    }

    // Relação com LeaveType
    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class, 'leaveTypeId');
    }
}
