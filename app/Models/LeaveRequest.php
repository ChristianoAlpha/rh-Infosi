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

    // Relação com o funcionário
    public function employee()
    {
        return $this->belongsTo(Employeee::class, 'employeeId');
    }

    // Relação com o departamento
    public function department()
    {
        return $this->belongsTo(Department::class, 'departmentId');
    }

    // Relação com o tipo de licença
    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class, 'leaveTypeId');
    }
}
