<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    use HasFactory;
    
    // Define explicitamente o nome da tabela (camelCase não afeta a migration, mas a tabela foi criada em snake_case)
    protected $table = 'leave_types';

    protected $fillable = ['name', 'description'];

    // Relação: Um tipo de licença pode ter muitos pedidos
    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class, 'leaveTypeId');
    }
}
