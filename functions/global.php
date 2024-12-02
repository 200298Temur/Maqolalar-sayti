<?php

use App\Models\TelegramUser;
use Illuminate\Support\Facades\Log;

function sendMessage($chat_id, $text,$replyMarkup = null) {
    $data = [
        'chat_id' => $chat_id,
        'text' => $text
    ];
    if($replyMarkup){
        $data['reply_markup']=json_encode($replyMarkup);
    }
    return telegram_curl('sendMessage', $data);
}
// function editMessageText($text,$message_id)  {
    
// }
function deleteMessage($chat_id,$message_id){
    $data=[
        'chat_id'=>$chat_id,
        'message_id'=>$message_id
    ];
    return telegram_curl('deleteMessage',$data);
}
function setWebhook() {
    $url = env('TELEGRAM_WEBHOOK_URL', '') . "/api/telegram/webhook";
    $data = [
        "url" => $url
    ];
    return telegram_curl('setWebhook', $data);
}

function WebhookInfo() {
    $url = env('TELEGRAM_WEBHOOK_URL', '') . "/api/telegram/webhook";

    return telegram_curl('WebhookInfo');
}

function telegram_curl($command, $data = [])
{
    $token = env('TELEGRAM_BOT_TOKEN');
    $tg_url = "https://api.telegram.org/bot$token/";
    $curl = curl_init();
    //curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:multipart/form-data"));
    curl_setopt($curl, CURLOPT_URL, $tg_url . $command);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    //curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $type);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_POSTFIELDS, ($data));

    $response = curl_exec($curl);

    if ($response === false) {
        Log::error(curl_error($curl));
        Log::info($token . " " . $command . " " . http_build_query(data: $data));
    }
    curl_close($curl);
    $response = json_decode($response);
    if ($response->ok == false) {
        Log::error($response->error_code . ' ' . $response->description);
        Log::info( $token . " " . $command . " " . http_build_query($data));
    }

    return $response;
}

function telegram_user_update($from)
{
    $tguser = TelegramUser::where('tguser_id', $from['id'])->first();
    if (empty($tguser)) {
        $tguser = new TelegramUser();
        $tguser->tguser_id = $from['id'];
    }
    $tguser->first_name = $from['first_name'];
    $tguser->last_name = $from['last_name'] ?? null;
    $tguser->username = $from['username'] ?? null;
    $tguser->language_code = $from['language_code'] ?? null;
    $tguser->save();

    return $tguser;
}

