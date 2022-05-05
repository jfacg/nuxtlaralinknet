<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class NotificationMaquinaFusao extends Notification
{
    use Queueable;

    protected $conteudo;

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

   
    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
        ->content($this->conteudo)
        ->button('Entre no APP', 'http://applinknet.linknetcg.com.br');
    }

    public function content($data)
    {   
        
        $this->conteudo = $data['tipo']."\n SOLICITANTE: ".$data['solicitante']."\n MAQUINA: ".$data['maquina'];
        
    }
}
