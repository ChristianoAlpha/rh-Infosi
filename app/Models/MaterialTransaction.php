<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialTransaction extends Model
{
    protected $table = 'materialTransactions';
    protected $fillable = [
        'materialId','transactionType','quantity','departmentId','createdBy','note'
    ];

    public function material()
    {
        return $this->belongsTo(Material::class,'materialId');
    }

    public function department()
    {
        return $this->belongsTo(Department::class,'departmentId');
    }
}