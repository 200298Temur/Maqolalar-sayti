<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\TelegramPost;
use App\Models\TelegramUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TelegrambotController extends Controller
{
    public function index(Request $request)
    {
        // Log::info($request);
        try {
            $message = $request->message??null;
            $callback_query = $request->callback_query ?? null;        
            $edited_message=$request->edited_message??null;
            $inlineKeyboard=null;
           
            

            if (!empty($message)) {
                $text = $message['text'] ?? null;
                $photo = $message['photo'] ?? null;
                $caption = $message['caption'] ?? null;
                $media_group_id = $message['media_group_id'] ?? null;
                
                $from = $message['from'];
                $chat = $message['chat'];
                if($photo){
                    
                }elseif ($from['id'] == $chat['id']) {
                    $tguser = telegram_user_update($from);
    
                    if (!empty($text)) {
                        if ($text == "/start") {
                            $tguser->step = 0;
                        }
                    }
                    if (!empty($text)) {
                        if ($text == "/menu"||$tguser->step==4) {
                            $tguser->step = 4;
                            $send_message='Menuni tanlang:';
                            $inlineKeyboard = [
                                'inline_keyboard' => [
                                    [
                                        ['text' => 'Post', 'callback_data' => 'posts'],
                                        ['text' => 'Category', 'callback_data' => 'categories'],
                                    ],
                                ],
                            ];
                        }
                    }
                    if ($tguser->step == 0) {
                        $send_message = "Email kiriting";
                        $tguser->step = 1;
                    } else if ($tguser->step == 1) {
                        if (!empty($text)) {
                            $tguser->email = $text;
                            $tguser->step = 2;
                            $send_message = "Password kiriting";
                        }                      
                    }elseif($tguser->step==2){
                        if(!empty($text)){
                            if(auth()->attempt(['email'=>$tguser->email,'password'=>$text])){
                                $user=User::where('email',$tguser->email)->first();
                                $tguser->user_id=$user->id;
                                $tguser->step=4;
                                $send_message='Log In bo`ldingiz!';
                            }
                        }else{
                            $tguser->step=0;
                            $send_message='Log In mal`umotlaringiz xato!';
                        }
                        $message_id=$message['message_id'];
                        $deleteMessage=deleteMessage($chat['id'],$message_id);
                    }elseif($tguser->step==6){
                        $column='title';
                        $value=$text;
                        $message_id=$message['message_id'];

                         try {
                            $newpost = TelegramPost::create([
                                'message_id' => $message_id,
                                'column' => $column,
                                'value' => $value,
                                'telegram_user_id' => $tguser->id,
                            ]);
                        } catch (\Exception $e) {
                            Log::error('Error creating TelegramPost: ' . $e->getMessage());
                        }
                        // Log::info($newpost);
                        $send_message='Subcontent kiriting:';
                        $tguser->step=7;

                    }elseif($tguser->step==7){
                        $column='subcontent';
                        $value=$text;
                        $message_id=$message['message_id'];
                        TelegramPost::create([
                            'message_id'=>$message_id,
                            'column'=>$column,
                            'value'=>$value,
                            'telegram_user_id'=>$tguser->id
                        ]);
                        $send_message='Tilni  tanlang:';
                        $inlineKeyboard=[
                            'inline_keyboard' => [
                                [
                                    ['text' => 'Uzbek', 'callback_data' => 'uz'],
                                    ['text' => 'English', 'callback_data' => 'en'],
                                ],
                            ],
                        ];
                        
                        $tguser->step=8;
                        
                    }elseif($tguser->step==9)
                    {
                        $column='content';
                        $value=$text;
                        $message_id=$message['message_id'];
                        TelegramPost::create([
                            'message_id'=>$message_id,
                            'column'=>$column,
                            'value'=>"<p>$value</p>",
                            'telegram_user_id'=>$tguser->id
                        ]);
                        $send_message='Contentni yozib tugatsangiz:';
                        $inlineKeyboard=[
                            'inline_keyboard' => [
                                [
                                    ['text' => 'Tugatish', 'callback_data' => 'tugatish'],
                                ],
                            ],
                        ];
                        // $tguser->step=10;   
                    }elseif($tguser->step==10){
                        $inlineKeyboard=[
                            'inline_keyboard' => [
                                [
                                    ['text' => 'Uzbek', 'callback_data' => 'uz'],
                                    ['text' => 'English', 'callback_data' => 'en'],
                                ],
                            ],
                        ];
                    }

                    if (!empty($text)) {
                        if ($text == "/menu"||$tguser->step==4) {
                            $tguser->step = 4;
                            $send_message='Menuni tanlang:';
                            $inlineKeyboard = [
                                'inline_keyboard' => [
                                    [
                                        ['text' => 'Post', 'callback_data' => 'posts'],
                                        ['text' => 'Category', 'callback_data' => 'categories'],
                                    ],
                                ],
                            ];
                        }
                    }
                    if (!empty($send_message)) {
                        sendMessage($tguser->tguser_id, $send_message,$inlineKeyboard);
                    }
                    $tguser->save();
                    return 0;
                }
            }elseif(!empty($callback_query)){
                $from_callback=$callback_query['from'];
                $chat_callback=$callback_query['message']['chat'];
                $data=$callback_query['data']??null;
                $tguser_callback=telegram_user_update($from_callback);
            //    Log::info($chat_callback['id']==$from_callback['id']);

                if($chat_callback['id']==$from_callback['id']){
                    // Log::info($data);
                    if($data=='posts'){
                        $send_message='Post bo`limi:';
                        $inlineKeyboard=[
                            'inline_keyboard' => [
                                [
                                    ['text' => 'Post Create', 'callback_data' => 'postcreate'],
                                ],
                            ],                        
                        ];
                    }elseif($data=='categories'){

                    }elseif($data=='postcreate'){
                        Log::info($data);
                        $tguser_callback->step=6;
                        $send_message="Post yaratish \nTitleni kiriting:";
                    }elseif($data=='uz'||$data=='en'){
                        Log::info($tguser_callback->id);
                        $tguser_callback->step=9;
                        $column='lang';
                        $value=$data;
                        $message_id=$callback_query['message']['message_id'];
                        // Log::info($message_id);
                        TelegramPost::create([
                            'message_id'=>$message_id,
                            'column'=>$column,
                            'value'=>$value,
                            'telegram_user_id'=>$tguser_callback->id
                        ]);
                        $send_message="Content kiriting:";
                    }elseif($data=='postpublish'){
                        $tguser_callback->step=4;
                        $title=TelegramPost::where('column','title')
                        ->where('post_id',null)->first();
                        
                        $subcontent=TelegramPost::where('column','subcontent')
                        ->where('post_id',null)->first();
                        
                        $lang=TelegramPost::where('column','lang')
                        ->where('post_id',null)->first();
                        $publish='1';
                        
                        $contents=TelegramPost::where('column','content')
                        ->where('post_id',null)->get();
                        $author_id =$tguser_callback->user_id;
                        
                        $allContent = '';
                        foreach($contents as $content){
                            $allContent .= $content->value . "\n"; // Matnni birlashtirish
                        }
                        
                        // Log::info($allContent);

                        try {
                            $post = Post::create([
                                'title' => $title->value,
                                'subtitle' => $subcontent->value,
                                'content' => $allContent,
                                'lang' => $lang->value,
                                'publish' => 1,
                                'author_id' => $author_id
                            ]);
                        
                            // Agar yaratish muvaffaqiyatli bo'lsa, Logga yozish
                            Log::info('Post successfully created: ', ['post_id' => $post->id]);
                        } catch (\Exception $e) {
                            // Xatolikni Logga yozish
                            Log::error('Error creating post: ' . $e->getMessage(), [
                                'title' => $title->value ?? null,
                                'subtitle' => $subcontent->value ?? null,
                                'content' => $allContent ?? null,
                                'lang' => $lang->value ?? null,
                                'publish' => 1,
                                'author_id' => $author_id ?? null
                            ]);
                        }
                        
                        Log::info($post);
                        $post_id=$post->id;
                        $posts=TelegramPost::where('post_id',null)->get();
                        foreach($posts as $telegramPost){
                            $telegramPost->post_id = $post_id;
                            $telegramPost->save();
                        }
                        $send_message='nashir qilindi!';                        
                        
                    }elseif($data=='tugatish'){
                        $tguser_callback->step=10;
                        $send_message='Postni yakunlash:';
                            $inlineKeyboard=[
                                'inline_keyboard' => [
                                    [
                                        ['text' => 'Postni nashr qilish', 'callback_data' => 'postpublish'],
                                        ['text' => 'Bekor qilish', 'callback_data' => 'bekorqilish'],
                                    ],
                                ],                        
                            ];
                    }elseif($data=='bekorqilish'){
                        $tguser_callback->step=9;
                        $send_message='Contentni kiriting:';
                    }elseif($data=='tahrirlash'){
                        $step=$tguser_callback->spet;
                        $step+=100;
                        $step->save();
                    }
                }
                
                if (!empty($send_message)) {
                    sendMessage($tguser_callback->tguser_id, $send_message,$inlineKeyboard);
                }
                $tguser_callback->save();
                return 0;
            }elseif(!empty($edited_message)){
                $message_id=$edited_message['message_id'];
                $text=$edited_message['text'];
                // Log::info($message_id);

                $post=TelegramPost::where('message_id',$message_id)->first();
                if($post->column=='content'){
                    $post->value="<p>$text</p>";
                }else{
                    $post->value=$text;
                }
                $post->save();

            }
            
        } catch (\Throwable $e) {
            return 0;
        } catch (\Exception $e) {
            return 0;
        }

    }
    
}
