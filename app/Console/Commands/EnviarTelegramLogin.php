<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Telegram\AlertOffline;
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
        $ambiente = env('APP_ENV');
        if ($ambiente == 'production') {
            $this->loginoffline();
        }
        
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

        if ($dif > 0) {
            AlertOffline::enviarMensagem("Anterior: ".$offanterior->quantidade."\nAtual: ".$offatual."\nDesconectados: ".$dif);
        }

        if ($dif < 0) {
            AlertOffline::enviarMensagem("Anterior: ".$offanterior->quantidade."\nAtual: ".$offatual."\nConectados: ".$dif);
        }

        if ($dif < -4) {
            $logins = Loginixc::where('online', '=', 'S')
                        ->orderBy('ultima_conexao_inicial', 'asc')
                        ->limit($dif)
                        ->get(['id', 'id_cliente', 'senha', 'login', 'mac', 'onu_mac', 'ultima_conexao_inicial']);

            $clientes = [];
            for ($i=0; $i < $dif; $i++) { 
                $cliente = Clientixc::where('id', '=', $logins[$i]->id_cliente)->first();
                $cliente->login = $logins[$i]->login;
                array_push($clientes, $cliente);
            }
            $lista = '';
            foreach ($clientes as $cliente) {
                $lista = $lista."\n"."\n".$cliente->razao."\n".$cliente->endereco."\n".$cliente->login;
            }

            AlertOffline::enviarMensagem("###### EVENTO FINALIZADO ######"."\n \n".$lista);
        }

        if ($dif > 4) {
            $logins = Loginixc::where('online', '=', 'N')
                        ->orderBy('ultima_conexao_final', 'desc')
                        ->get(['id', 'id_cliente', 'senha', 'login', 'mac', 'onu_mac', 'ultima_conexao_final']);

            $clientes = [];
            for ($i=0; $i < $dif; $i++) { 
                $cliente = Clientixc::where('id', '=', $logins[$i]->id_cliente)->first();
                $cliente->login = $logins[$i]->login;
                array_push($clientes, $cliente);
            }
            $lista = '';
            foreach ($clientes as $cliente) {
                $lista = $lista."\n"."\n".$cliente->razao."\n".$cliente->endereco."\n".$cliente->login;
            }

            AlertOffline::enviarMensagem("###### EVENTO INICIADO ######"."\n \n".$lista);
        }


    }
}
