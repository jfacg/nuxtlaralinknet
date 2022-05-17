<?php

namespace App\Utils;

use App\Models\Telegram\AlertMaquina;

class MonitorLogin 
{

  public function enviarMensagem($mensagem)
  {
    AlertMaquina::enviarMensagem($mensagem);
  }




  public function setInterval ( $func, $seconds ) 
  {
        $seconds = (int)$seconds;
        $_func = $func;
        while ( true )
        {
              $_func;
              sleep($seconds);
        }
  }
}