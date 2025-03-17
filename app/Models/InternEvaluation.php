<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'internId',
        'evaluationStatus',
        'evaluationComment',
        'pontualidade',
        'trabalhoEquipe',
        'autodidacta',
        'disciplina',
        'focoResultado',
        'comunicacao',
        'apresentacao',
        'programaEstagio',
        'projectos',
        'atividadesDesenvolvidas',
    ];

    public function intern()
    {
        return $this->belongsTo(Intern::class, 'internId');
    }
}
