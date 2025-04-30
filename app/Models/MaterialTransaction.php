<?php
// app/Models/MaterialTransaction.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialTransaction extends Model
{
    protected $table = 'material_transactions';

    protected $fillable = [
        'MaterialId',
        'TransactionType',
        'TransactionDate',
        'Quantity',
        'OriginOrDestination',
        'DocumentationPath',
        'Notes',
        'DepartmentId',
        'CreatedBy',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class, 'MaterialId');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'DepartmentId');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'CreatedBy');
    }
}
