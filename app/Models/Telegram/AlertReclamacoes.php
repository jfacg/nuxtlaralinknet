<?php

namespace App\Models\Telegram;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TelegramBot\Api\BotApi;

class AlertReclamacoes extends Model
{
    use HasFactory;

    const TELEGRA_BOT_TOKEN = '5128220534:AAE5b_BEdPSi_VYxfV-jXOYbHzCOm2nBTaU';
    const TELEGRAM_CHAT_ID = -656340611;

    public static function enviarMensagem ($mensagem)
    {
        $obBotApi = new BotApi(self::TELEGRA_BOT_TOKEN);

        return $obBotApi->sendMessage(self::TELEGRAM_CHAT_ID, $mensagem);
    }

}
