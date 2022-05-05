<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;


class TelegramNotification extends Notification
{
    use Queueable;

    public $texto;
  
    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
        ->content("Olá" . "\n Maquina teste" . "\n" . $this->texto)
        ->button('Entre no APP', 'http://applinknet.linknetcg.com.br');
    }

    public function mensagem ($mensagem)
    {
        # code...
    }



    

   
}
