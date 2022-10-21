<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Clientixc;
use App\Models\Loginixc;
use App\Models\Pesqinstalacao;
use App\Models\Service;
use App\Models\Telegram\AlertReclamacoes;
use Illuminate\Http\Request;

class ServiceController extends Controller
{

    protected $entity, $clienteixc, $loginIxc, $pesqInstalacao;

    public function __construct (Service $service, Clientixc $clienteixc, Loginixc $loginIxc, Pesqinstalacao $pesqInstalacao)
    {
        $this->entity = $service;
        $this->clienteixc = $clienteixc;
        $this->loginIxc = $loginIxc;
        $this->pesqInstalacao = $pesqInstalacao;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = $this->entity->with(['cliente', 'usuario', 'tecnico', 'vendedor', 'tipoReclamacao'])->get();
        return response()->json($services, 200);
    }

    public function servicosAbertos()
    {
        $services = $this->entity->with(['cliente', 'usuario', 'tecnico', 'vendedor', 'tipoReclamacao'])
                    ->where([['status', '!=', 'BAIXADO'], ['status', '!=', 'EXECUTADO'], ['status', '!=', 'CANCELADO']])
                    ->orderBy('dataAgendamento', 'asc')
                    ->get();
        
        $servicos = [];

        foreach ($services as $servico) {
            if ($servico->tipo == 'REPARO') {
                $repetidas = $this->entity
                            ->where('clienteIdIxc', '=', $servico->clienteIdIxc)
                            ->where('tipo', '=', 'REPARO')
                            ->count();

                $reparos = $this->entity
                            ->with(['usuario', 'tecnico'])
                            ->where('clienteIdIxc', '=', $servico->clienteIdIxc)
                            ->where('tipo', '=', 'REPARO')
                            ->get();
            
                $servico->repetidas = $repetidas - 1;
                $servico->reparos = $reparos;
                array_push($servicos, $servico);

            } else {
                $servico->repetidas = 0;
                array_push($servicos, $servico);
            }
        }

                    

        return response()->json($servicos, 200);
    }

    public function pesquisaInstalacoes()
    {
        $servicosFiltrados = [];
        $services = $this->entity->with(['cliente', 'usuario', 'tecnico', 'vendedor', 'tipoReclamacao', 'pesqInstalacao'])
                    ->where([['status', '=', 'EXECUTADO'], ['tipo', '=', 'INSTALAÇÃO']])
                    ->orderBy('dataExecucao', 'asc')
                    ->get();
        foreach ($services as $servico) {
            if ($servico->pesqInstalacao) {
                if ($servico->pesqInstalacao->fase != "CONCLUIDO") {
                    array_push($servicosFiltrados, $servico);
                }
            }
        }



        return response()->json($servicosFiltrados, 200);
    }

    public function listarPorTecnico($idTecnico)
    {
        $services = $this->entity->with(['cliente', 'usuario', 'tecnico', 'vendedor', 'tipoReclamacao'])
                    ->where([['tecnico_id', '=', $idTecnico], ['status', '=', 'DESPACHADO'] ])
                    ->orWhere([['tecnico_id', '=', $idTecnico], ['status', '=', 'REMANEJADO'] ])
                    ->orderBy('dataAgendamento', 'asc')
                    ->get();
        return response()->json(['data' => $services], 200);
    }

    public function gerarboletos()
    {
        $services = $this->entity->with(['cliente', 'usuario', 'tecnico', 'vendedor'])
        ->where('boletogerado', '=', 'N')
        ->where('status', '=', 'EXECUTADO')
        ->where('tipo', '=', 'INSTALAÇÃO')
        ->orderBy('dataExecucao', 'asc')
        ->get();
        return response()->json($services, 200);
    }

    
    public function store(Request $request)
    {
    
        $data = $request->all();

        if ($data['tipo'] == 'INSTALAÇÃO') {
            $pesquisa = $this->pesqInstalacao->create();
            if (!$pesquisa) {
                return response()->json(['error' => 'error_insert', 500]);
            }
            $data['pesqInstalacao_id'] = $pesquisa->id;
        }
        

        $validate = validator($data, $this->entity->rules());
        if ($validate->fails()) {
            $messages = $validate->messages();
            return response()->json($messages, 400);
        }

        $service = $this->entity->create($data);

        if (!$service) {
            return response()->json(['error' => 'error_insert', 500]);
        }
       

        if ($service->tipo == 'REPARO') {
            $repetidas = $this->entity
                        ->with(['cliente', 'usuario', 'tecnico', 'vendedor', 'tipoReclamacao'])
                        ->where('clienteIdIxc', '=', $service->clienteIdIxc)
                        ->where('tipo', '=', 'REPARO')
                        ->count();
        
            if ($repetidas > 1) {
                $reparos = $this->entity
                        ->where('clienteIdIxc', '=', $service->clienteIdIxc)
                        ->where('tipo', '=', 'REPARO')
                        ->orderBy('dataExecucao', 'desc')
                        ->get();
                
                $texto = "########\n".$repetidas." RECLAMAÇÕES \n########";
                
                foreach ($reparos as $reparo) {

                    if ($reparo->status == 'EXECUTADO') {
                        $texto = $texto."\n\nCliente: ".$reparo->clienteNome."\nReclamação: ".$reparo->relatoCliente."\nReclamante: ".$reparo->reclamante
                        ."\nBaixa: ".$reparo->observacao."\nTécnico : ".$reparo->tecnico->nick_name."\nStatus: ".$reparo->status."\nData: ".$reparo->dataExecucao;
                    } else {
                        $texto = $texto."\n\nCliente: ".$reparo->clienteNome."\nReclamação: ".$reparo->relatoCliente."\nReclamante: ".$reparo->reclamante
                                ."\nBaixa: ".$reparo->observacao."\nStatus: ".$reparo->status."\nData: ".$reparo->dataExecucao;
                    }


                    
                }

                AlertReclamacoes::enviarMensagem($texto);
            }
        }

        return response()->json($service, 201);
    }

  
    public function show($id)
    {
        $service = $this->entity->with(['cliente', 'usuario', 'tecnico', 'vendedor', 'tipoReclamacao', 'pesqInstalacao'])->find($id);

        if ($service->clienteIdIxc != null) {
           $cliente =  $this->clienteixc->find($service->clienteIdIxc);
           if ($cliente) {
                $logins = $this->loginIxc
                        ->where('id_cliente', '=', $cliente->id)
                        ->orderBy('id_contrato', 'desc')
                        ->get();
                $cliente->logins = $logins;
            }

            $service->ixccliente = $cliente;

        } else {

            $cliente = $this->clienteixc->where('cnpj_cpf', '=', $this->formatarCpf($service->cliente->cpf))->first();

            if ($cliente) {

                $logins = $this->loginIxc
                        ->where('id_cliente', '=', $cliente->id)
                        ->orderBy('id_contrato', 'desc')
                        ->get();
                $cliente->logins = $logins;
            }

            $service->ixccliente = $cliente;
        }

        if (!$service) {
            return response()->json(['message' => 'Serviço Não Encontrado'], 404);
        }

        return response()->json($service, 200);
    }

    
    public function formatarCpf ($cpf) {
        $parte1 = substr($cpf, 0, 3);
        $parte2 = substr($cpf, 3, 3);
        $parte3 = substr($cpf, 6, 3);
        $parte4 = substr($cpf, 9, 2);

        return "$parte1.$parte2.$parte3-$parte4";
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $validate = validator($data, $this->entity->rules($id));

        if ($validate->fails()) {
            $messages = $validate->messages();
            return response()->json(['validade.error', $messages], 500);
        }

        $service = $this->entity->find($id);
        if (!$service) {
            return response()->json(['message' => 'Serviço Não Encontrado'], 404);
        }

        $update = $service->update($data);
        if (!$update) {
            return response()->json(['message' => 'Serviço Não Atualizado'], 500);
        }

        return response()->json($update, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = $this->entity->find($id);
        if (!$service) {
            return response()->json(['message' => 'Serviço Não Encontrado'], 404);
        }

        $delete =  $service->delete();
        if (!$delete) {
            return response()->json(['message' => 'Serviço Não Excluido'], 500);
        }

        return response()->json($delete, 200);
    }


}
