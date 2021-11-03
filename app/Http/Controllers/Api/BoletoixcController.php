<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Boletoixc;
use App\Models\Cobranca;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class BoletoixcController extends Controller
{
    protected $boletoixc, $cobranca;

    public function __construct (Boletoixc $boletoixc, Cobranca $cobranca)
    {
        $this->boletoixc = $boletoixc;
        $this->cobranca = $cobranca;
    }

    public function boletosAbertos()
    {
        $hoje = Carbon::today();
        
        $boletos = $this->boletoixc
                        ->with(
                            ['clientIxc' => function ($query) {
                                $query->select('id', 'razao', 'endereco', 'numero', 'bairro', 
                                'cnpj_cpf', 'ie_identidade', 'fone', 'cep', 'email', 'ativo', 
                                'status_internet', 'bloqueio_automatico', 'obs', 'telefone_celular', 
                                'referencia', 'complemento', 'data_nascimento', 'contato', 'filial_id', 
                                'alerta', 'data_cadastro', 'whatsapp', );
                            }], 
                        )->where([['status', 'A'],['liberado', 'S'], ['data_vencimento', '<', $hoje]])
                        ->orderBy('data_vencimento', 'asc')
                        ->get(['id', 'valor', 'data_vencimento', 'filial_id', 'id_cliente']);
                        // ->get();
                        // ->paginate(10);
        
        foreach ($boletos as $boleto) {
            $cobrancas = $this->cobranca->with(['usuario'])->where('boletoixc_id', $boleto->id)->get();

            foreach ($cobrancas as $cobranca) {
                if ($cobranca->dataAgendamento < $hoje && $cobranca->dataAgendamento != null) {
                    $cobranca->status = "VENCIDO";
                    $cobranca->save();
                }
            }
            $boleto->cobrancas = $cobrancas;
        }
        return response()->json($boletos, 200);
    }
}
