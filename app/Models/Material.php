<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    protected $fillable = [
        'Name',
        'SerialNumber',
        'Category',
        'UnitOfMeasure',
        'SupplierName',
        'SupplierIdentifier',
        'EntryDate',
        'CurrentStock',
        'Notes'
    ];

    /**
     * Transações (entradas/saídas) deste material.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(MaterialTransaction::class, 'MaterialId');
    }
}
