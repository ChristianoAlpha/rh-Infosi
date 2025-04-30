<?php
// app/Models/Material.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = 'materials';

    protected $fillable = [
        'Category',
        'MaterialTypeId',
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

    public function type()
    {
        return $this->belongsTo(MaterialType::class, 'MaterialTypeId');
    }

    public function transactions()
    {
        return $this->hasMany(MaterialTransaction::class, 'MaterialId');
    }
}
