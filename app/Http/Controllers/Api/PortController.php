<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Clientixc;
use App\Models\Port;
use Illuminate\Http\Request;

class PortController extends Controller
{
    protected $entity;

    public function __construct (Port $port)
    {
        $this->entity = $port;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ports = $this->entity->all();

        return response()->json(['data' => $ports], 200);
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
            return response()->json( $messages, 500);
        }

        if (!$port = $this->entity->create($data)) {
            return response()->json(['error' => 'error_insert', 500]);
        }

        return response()->json(['data' => $port], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$port = $this->entity->with(['box','clientIxc'])->find($id)) {
            return response()->json(['message' => 'box Not Found'], 404);
        }

        return response()->json(['data' => $port], 200);
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

        if (($data['clientIxc_id'] != null) && ($data['partner'] != null)) {
            return response()->json(['message' => 'Obrigadorio somente Cliente IXC ou Parceiro'], 404);
        }

        if (($data['clientIxc_id'] == null) && ($data['partner'] == null) && ($data['cableCode'] != null && $data['cableCode'] != 0 )) {
            return response()->json(['message' => 'Obrigadorio Cliente IXC ou Parceiro'], 404);
        }

        if ($data['clientIxc_id'] != null) {
            $portClientBusy = $this->entity->portBusyIxc($data['clientIxc_id']);
            if (count($portClientBusy) > 0) {
                return response()->json(['message' => 'Cliente cadastrado em outra Caixa', 'data' => $portClientBusy], 404);
            }
        }

        if ($data['partner'] != null) {
            $portBusyPartner = $this->entity->portBusyPartner($data['partner']);
            if (count($portBusyPartner) > 0) {
                return response()->json(['message' => 'Parceiro cadastrado em outra Caixa', 'data' => $portBusyPartner], 404);
            }
        }

        

        if (($data['clientIxc_id'] == null) && ($data['partner'] == null) && ($data['cableCode'] == null)) {
            $data['clientIxc_id'] = null;
            $data['partner'] = null;
            $data['cableCode'] = null;
            $data['status'] = "ATIVA";
        }

        if ($data['cableCode'] == 0) {
            $data['clientIxc_id'] = null;
            $data['partner'] = null;
            $data['cableCode'] = null;
            $data['status'] = "OCUPADA";
        }

        $validate = validator($data, $this->entity->rules($data['id']));
        

        if ($validate->fails()) {
            $messages = $validate->messages();
            return response()->json($messages, 500);
        }


        if (!$port = $this->entity->find($id)) {
            return response()->json(['message' => 'box Not Found'], 404);
        }


        if (!$update = $port->update($data)) {
            return response()->json(['message' => 'box Not Update'], 404);
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
        if (!$port = $this->entity->find($id)) {
            return response()->json(['message' => 'box Not Found'], 404);
        }

        if (!$delete =  $port->delete()) {
            return response()->json(['message' => 'box Not Delete'], 500);
        }

        return response()->json(['data' => $delete], 200);
    }

    public function teste($id)
    {
        $data = Clientixc::find($id);

        return response()->json($data);
    }
}
