<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaterialTransaction extends Model
{
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

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'MaterialId');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'DepartmentId');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'CreatedBy');
    }
}
