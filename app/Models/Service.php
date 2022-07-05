<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo',
        'dataAbertura',
        'dataAgendamento',
        'dataVencimento',
        'dataExecucao',
        'dataFechamento',
        'vencimento',
        'valorInstalacao',
        'pagamento',
        'observacao',
        'plano',
        'valorPlano',
        'status',
        'historico',
        'usuario_id',
        'tecnico_id',
        'cliente_id',
        'vendedor_id',
        'contato',
        'indicacao',
        'boletodigital',
        'boletogerado',
        'cep',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'uf',
        'complemento',
        'antigoCep',
        'antigoLogradouro',
        'antigoNumero',
        'antigoBairro',
        'antigaCidade',
        'antigaUf',
        'antigoComplemento',
        'clienteNome',
        'clienteCpf',
        'clienteIdIxc',
        'clienteEmail',
        'clienteContato',
        'reclamante',
        'tipoReclamacao_id',
        'relatoCliente',
        'pesqInstalacao_id'


    ];

    public function rules($id = '')
    {
        $rules = [
            'tipo' => ['string'],
            'dataAbertura' => ['date'],
            'dataAgendamento' => ['date', 'nullable'],
            'dataVencimento' => ['date', 'nullable'],
            'dataExecucao' => ['date', 'nullable'],
            'dataFechamento' => ['date', 'nullable'],
            'observacao' => ['string', 'nullable', 'min:3', 'max:255'],
            'status' => ['string'],
            'historico' => ['string', 'nullable', 'min:3', 'max:255'],
            'usuario_id' => ['numeric'],
            'tecnico_id' => ['nullable', 'numeric'],
            'cliente_id' => ['nullable','numeric'],
        ];

        return $rules;
    }

    public function cliente()
    {
        return $this->belongsTo(Client::class, 'cliente_id', 'id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id', 'id');
    }

    public function vendedor()
    {
        return  $this->belongsTo(User::class, 'vendedor_id', 'id');
    }

    public function tecnico()
    {
        return $this->belongsTo(User::class, 'tecnico_id', 'id');
    }

    public function tipoReclamacao()
    {
        return $this->belongsTo(Tipo::class, 'tipoReclamacao_id', 'id');
    }

    public function pesqInstalacao()
    {
        return $this->belongsTo(Pesqinstalacao::class, 'pesqInstalacao_id', 'id');
    }

    


}
