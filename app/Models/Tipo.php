<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipoNome',
        'tipoClasse',
        'tipoDescricao',
        
    ];

    public function rules($id = '')
    {
        $rules = [
            // 'tipo' => ['string'],
            // 'dataAbertura' => ['date'],
            // 'dataAgendamento' => ['date', 'nullable'],
            // 'dataVencimento' => ['date', 'nullable'],
            // 'dataExecucao' => ['date', 'nullable'],
            // 'dataFechamento' => ['date', 'nullable'],
            // 'observacao' => ['string', 'nullable', 'min:3', 'max:255'],
            // 'status' => ['string'],
            // 'historico' => ['string', 'nullable', 'min:3', 'max:255'],
            // 'usuario_id' => ['numeric'],
            // 'tecnico_id' => ['nullable', 'numeric'],
            // 'cliente_id' => ['nullable','numeric'],
        ];

        return $rules;
    }
}
