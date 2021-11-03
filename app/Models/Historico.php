<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historico extends Model
{
    use HasFactory;

    protected $fillable = [
        'dataAbertura',
        'mensagem',
        'usuario_id',
        'cobranca_id'
    ];
}
