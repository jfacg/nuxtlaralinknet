<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cobranca extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'dataAbertura',
        'dataAgendamento',
        'status',
        'boletoixc_id',
        'usuario_id',
        'mensagem',
        'tipoAgendamento'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id', 'id');
    }

    
}
