<?php
// app/Models/MaterialType.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialType extends Model
{
    protected $table = 'material_types';

    protected $fillable = ['name'];

    public function materials()
    {
        return $this->hasMany(Material::class, 'MaterialTypeId');
    }
}
