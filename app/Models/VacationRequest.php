<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacationRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'employeeId',
        'vacationType',
        'vacationStart',
        'vacationEnd',
        'reason',
        'supportDocument',
        'originalFileName',
        'approvalStatus',
        'approvalComment',
    ];

    public function employee()
    {
        return $this->belongsTo(Employeee::class, 'employeeId');
    }
}
