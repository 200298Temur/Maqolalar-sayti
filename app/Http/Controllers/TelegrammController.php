<?php

namespace App\Http\Controllers;
use Telegram\Bot\Laravel\Facades\Telegram;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TelegrammController extends Controller
{
    public function handle(Request $request){
        $upgarade=Telegram::getWebhookUpdates();
        $message=$upgarade->getMessage();
        $chat_id=$message->getChat()->getId();
        $data=[
            'chat_id'=>$chat_id,
            'text'=>'salom'
        ];
        Telegram::sendMessage($data);
    }
}
