<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Telegram\AlertTeste;
use App\Http\Controllers\Api\ClientIxcController;
use App\Models\Clientixc;
use App\Models\Loginixc;
use App\Models\Offline;

class EnviarTelegramLogin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegramlogin:enviar', $offline = 0;
    protected $clienteixc;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar Status Login';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Clientixc $clienteixc) 
    {
        parent::__construct();
        $this->clienteixc = $clienteixc;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->loginoffline();
    }


    public function loginoffline()
    {
        $offatual = Loginixc::where('online', '=', 'N')->count();

        $offanterior = Offline::orderBy('id', 'desc')->first();

        $quantidade = [
            'quantidade' => $offatual
        ];

        Offline::create($quantidade);

        $dif = $offatual - $offanterior->quantidade;
        AlertTeste::enviarMensagem("Anterior: ".$offanterior->quantidade."\nAtual: ".$offatual."\nDiferenca: ".$dif);

        if ($dif < -4) {
            AlertTeste::enviarMensagem("###### EVENTO RESOLVIDO ######");
        }

        if ($dif > 4) {
            $clientes = [];
            
            $logins = Loginixc::where('online', '=', 'N')
                        ->orderBy('ultima_conexao_final', 'desc')
                        ->get(['id', 'id_cliente', 'senha', 'login', 'mac', 'onu_mac', 'ultima_conexao_final']);

            for ($i=0; $i < $dif; $i++) { 
                $cliente = Clientixc::where('id', '=', $logins[$i]->id_cliente)->first();
                array_push($clientes, $cliente);
            }
            $lista = '';
            foreach ($clientes as $cliente) {
                $lista = $lista."\n"."\n".$cliente->razao."\n".$cliente->endereco;
            }

            AlertTeste::enviarMensagem($lista);
        }


    }
}
