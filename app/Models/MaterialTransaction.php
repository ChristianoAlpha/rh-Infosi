<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaterialTransaction extends Model
{
    protected $table = 'material_transactions';

    protected $fillable = [
        'MaterialId',
        'TransactionType',
        'TransactionDate',
        'Quantity',
        'SupplierName',
        'SupplierIdentifier',
        'DepartmentId',
        'CreatedBy',
        'Notes'
    ];

    /**
     * Material desta transação.
     */
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'MaterialId');
    }

    /**
     * Departamento de destino/origem.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'DepartmentId');
    }

    /**
     * Usuário que registrou.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'CreatedBy');
    }
}
