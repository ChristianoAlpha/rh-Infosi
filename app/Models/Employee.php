<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'father', 'mother', 'adress', 'bi', 'birthDay', 'nacionality', 'genero', 'email', 'phone'
    ];
}
