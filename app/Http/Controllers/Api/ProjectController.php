<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Box;
use App\Models\Port;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    protected $project, $box, $port;

    public function __construct (Project $project, Box $box, Port $port)
    {
        $this->project = $project;
        $this->box = $box;
        $this->port = $port;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $project = $this->project->with(['boxes', 'boxes.ports'])->get();

        return response()->json($project, 200);
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

        $validate = validator($data, $this->project->rules());
        if ($validate->fails()) {
            $messages = $validate->messages();
            return response()->json( $messages, 500);
        }

        $projectExist = DB::table('projects')
                            ->where('oltSlot', '=', $data['oltSlot'])
                            ->where('oltPort', '=', $data['oltPort'])
                            ->get();

        if ($projectExist->count() > 0) {
            return response()->json(['error' => 'Placa e Porta Existente'], 406);
        }


        if (!$project = $this->project->create($data)) {
            return response()->json(['error' => 'error_insert'], 500);
        }



        for ($i=0; $i < $project->numberBoxes; $i++) {
            $numberBoxe = $i + 1;
            $box = $this->createBox($project, $numberBoxe);

            for ($j=0; $j < $box->numberPorts; $j++) {
                $numberPort = $j + 1;
                $port = $this->createPort($box, $numberPort);
            }
        }

        return response()->json($project, 201);
    }

    public function createBox($project, $numberBox)
    {
        $newBox['name'] = $project->shortName.'-'.$project->oltSlot.'/'.$project->oltPort.'/'.$numberBox;
        $newBox['numberPorts'] = $project->numberBoxPorts;
        $newBox['project_id'] = $project->id;
        $newBox['address'] = "";
        $newBox['status'] = 'PROJETADA';

        $box = $this->box->create($newBox);

        return $box;
    }


    public function createPort($box, $numberPort)
    {
        $newPort['name'] = $box->name.'/'.$numberPort;
        $newPort['box_id'] = $box->id;
        $newPort['status'] = 'VAGA';

        $port = $this->port->create($newPort);

        return $port;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$project = $this->project->with(['boxes', 'boxes.ports', 'boxes.ports.clientIxc'])->find($id)) {
            return response()->json(['message' => 'project Not Found'], 404);
        }

        foreach ($project->boxes as $box) {
            foreach ($box->ports as $port) {
                if ($port->clientIxc != null && $port->clientIxc != "") {
                    if ($port->clientIxc->ativo != "S") {
                        $data = [
                            "id" => $port->id,
                            "name" => $port->name,
                            "cableCode" => $port->cableCode,
                            "clientIxc_id" => $port->clientIxc_id,
                            "partner" => $port->partner,
                            "status" => "CANCELADO",
                            "box_id" => $port->box_id
                        ];

                        $porta = $this->port->find($port->id);
                        
                        $update = $porta->update($data);
                    }
                }
            }
        }

        if (!$project = $this->project->with(['boxes', 'boxes.ports', 'boxes.ports.clientIxc'])->find($id)) {
            return response()->json(['message' => 'project Not Found'], 404);
        }

        return response()->json($project, 200);
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

        $validate = validator($data, $this->project->rules($id));

        if ($validate->fails()) {
            $messages = $validate->messages();
            return response()->json(['validade.error', $messages], 500);
        }

        if (!$project = $this->project->find($id)) {
            return response()->json(['message' => 'project Not Found'], 404);
        }

        if (!$update = $project->update($data)) {
            return response()->json(['message' => 'project Not Update'], 500);
        }

        return response()->json(['data' => $update], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$project = $this->project->find($id)) {
            return response()->json(['message' => 'project Not Found'], 404);
        }

        if (!$delete =  $project->delete()) {
            return response()->json(['message' => 'project Not Delete'], 500);
        }

        return response()->json(['data' => $delete], 200);
    }
}
