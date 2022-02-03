<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Clientixc;
use App\Models\Loginixc;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{

    protected $entity, $clienteixc, $loginIxc;

    public function __construct (Service $service, Clientixc $clienteixc, Loginixc $loginIxc)
    {
        $this->entity = $service;
        $this->clienteixc = $clienteixc;
        $this->loginIxc = $loginIxc;
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validate = validator($data, $this->entity->rules());
        if ($validate->fails()) {
            $messages = $validate->messages();
            return response()->json($messages, 400);
        }

        $service = $this->entity->create($data);

        if (!$service) {
            return response()->json(['error' => 'error_insert', 500]);
        }

        return response()->json($service, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = $this->entity->with(['cliente', 'usuario', 'tecnico', 'vendedor', 'tipoReclamacao'])->find($id);

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

 

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
