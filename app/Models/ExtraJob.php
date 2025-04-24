<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtraJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'totalValue',
    ];

    /**
     * Participantes deste trabalho extra,
     * com pivot bonusAdjustment e assignedValue.
     */
    public function employees()
    {
        return $this->belongsToMany(Employeee::class, 'extra_job_employees', 'extraJobId', 'employeeId')
                    ->withPivot('bonusAdjustment','assignedValue')
                    ->withTimestamps();
    }
}
