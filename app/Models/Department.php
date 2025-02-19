<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    // Relacionamento: cada departamento possui muitos Employeee (funcionários)
    public function employeee()
    {
        return $this->hasMany(\App\Models\Employeee::class, 'departmentId');
    }
}



