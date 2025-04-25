<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = 'Material';
    protected $fillable = [
        'name',
        'description',
        'serie',
        'origin',
        'manufacturingDate',
        'entryDate',
        'departureDate',
        'category',
        'currentStock',
        
    ];


    public function transactions()
    {
        return $this->hasMany(MaterialTransaction::class, 'materialId');
    }

    
    
    use HasFactory;
}
