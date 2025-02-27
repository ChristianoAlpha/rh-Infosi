<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    use HasFactory;
    
    // Define explicitamente o nome da tabela
    protected $table = 'leave_types';

    protected $fillable = ['name', 'description'];
}
