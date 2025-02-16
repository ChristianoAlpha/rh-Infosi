<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employeee extends Model
{
    use HasFactory;

    function department(){

        return $this->belongsTo(Department::class, 'departmentId');
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }
}
