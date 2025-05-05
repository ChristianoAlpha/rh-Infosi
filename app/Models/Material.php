<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    protected $fillable = [
        'Category',
        'materialTypeId',
        'Name',
        'SerialNumber',
        'Model',
        'ManufactureDate',
        'SupplierName',
        'SupplierIdentifier',
        'EntryDate',
        'CurrentStock',
        'Notes',
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(MaterialType::class, 'materialTypeId');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(MaterialTransaction::class, 'MaterialId');
    }
}
