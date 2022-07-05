<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesqinstalacao extends Model
{
    use HasFactory;

    protected $fillable = [
        'fase',
        
        'cliente1',
        'atendimentoTecnico1',
        'reclamacaoTecnico1',
        'instalacaoFisica1',
        'reclamacaoInstalacao1',
        'qualidadeInternet1',
        'reclamacaoInternet1',
        'equipamentoConectado1',
        'reclamacaoEquipamento1',
        'satisfacao1',
        'status1',
        'dataFase1',

        'cliente2',
        'qualidadeInternet2',
        'reclamacaoInternet2',
        'equipamentoConectado2',
        'reclamacaoEquipamento2',
        'reclamacao2',
        'reclamacaoReclamacao2',
        'satisfacao2',
        'status2',
        'dataFase2',

        'cliente3',
        'qualidadeInternet3',
        'reclamacaoInternet3',
        'equipamentoConectado3',
        'reclamacaoEquipamento3',
        'reclamacao3',
        'reclamacaoReclamacao3',
        'satisfacao3',
        'status3',
        'dataFase3',
    ];






           
}
