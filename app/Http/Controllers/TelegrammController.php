<?php 
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Str;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TelegramUser;
use App\Models\User;

class TelegrammController extends Controller
{
    public function handle(Request $request)
    {
        $message = $request->input('message.text'); 
        $chat_id = $request->input('message.chat.id');
        $tguser_id = $request->input('message.from.id');
        $step=$this->getStep($tguser_id);
        
        if($message){
            $Tguser = TelegramUser::where('tguser_id', $tguser_id)->first();
            if($message=='/start'){
                $this->saveOrUpdateStep($request,1);
                $this->logout($tguser_id);
                Telegram::sendMessage([
                    'chat_id'=>$chat_id,
                    'text'=>'Email kiriting:'
                ]);
            }elseif($message=='/menu'){
                $this->menu($chat_id);
            }elseif ($Tguser && $Tguser->user_id) {
                Telegram::sendMessage([
                    'chat_id' => $chat_id,
                    'text' => 'Siz allaqachon Log In bo‘lgansiz!'
                ]);            
            }else{
                if($step==1){
                    $this->saveOrUpdateStep($request,2);
                    $this->setEmail($tguser_id,$message);
                    Telegram::sendMessage([
                        'chat_id'=>$chat_id,
                        'text'=>'Passwrord kiriting:'
                    ]);
                }elseif ($step == 2) {
                    $this->saveOrUpdateStep($request,3);
                    $email = $this->getEmail($chat_id);
                    $password = $message;
                
                    if (Auth::attempt(['email' => $email, 'password' => $password])) {
                        auth()->login(User::where('email', $email)->first());
                        $name = auth()->user()->name;
                        Telegram::sendMessage([
                            'chat_id' => $chat_id,
                            'text' => 'Log In bo`ldingiz'.$name
                        ]);
                        $user = User::where('email', $email)->first();

                        $Tguser = TelegramUser::where('tguser_id', $tguser_id)->first();                    
                        if ($user && $Tguser) {
                            $Tguser->user_id = $user->id;
                            $Tguser->save();
                        }
                        $this->menu($chat_id);
                    } else {
                        Telegram::sendMessage([
                            'chat_id' => $chat_id,
                            'text' => 'Log In mal`umotlaringiz noto`g`ri'
                        ]);
                    }
                }
                else{
                    Telegram::sendMessage([
                        'chat_id'=>$chat_id,
                        'text'=>'Siz Log In bo`lmagansiz!'
                    ]);

                }
            }
        }
        if ($request->has('callback_query')) {
            $callbackQuery = $request->input('callback_query');
            $data = $callbackQuery['data'];
            $chat_id = $callbackQuery['message']['chat']['id'];
    
            if ($data == 'category') {
                $categories = Category::all(['id', 'name']); // ID va nomni oling
            
                if ($categories->isEmpty()) {
                    Telegram::sendMessage([
                        'chat_id' => $chat_id,
                        'text' => "Kategoriyalar topilmadi.",
                    ]);
                } else {
                    // ID va nomni formatlash
                    $categoriesList = $categories->map(function ($category) {
                        return $category->id . '. ' . $category->name;
                    })->implode("\n"); // Qatorlarga ajratish
            
                    Telegram::sendMessage([
                        'chat_id' => $chat_id,
                        'text' => $categoriesList,
                    ]);
                }
            } elseif ($data == 'posts') {
                $posts = Post::all(['id', 'title']); // ID va sarlavhani oling
            
                if ($posts->isEmpty()) {
                    Telegram::sendMessage([
                        'chat_id' => $chat_id,
                        'text' => 'Postlar mavjud emas.',
                    ]);
                } else {
                    // ID va sarlavhani formatlash
                    $postList = $posts->map(function ($post) {
                        return $post->id . '. ' . $post->title;
                    })->implode("\n"); // Qatorlarga ajratish
            
                    Telegram::sendMessage([
                        'chat_id' => $chat_id,
                        'text' => $postList,
                    ]);
                }
            }
            
            
        }
    }
    public function menu($chat_id)
    {
        $inlineLayout = [
            [
                Keyboard::inlineButton(['text' => 'Category', 'callback_data' => 'category']),
                Keyboard::inlineButton(['text' => 'Posts', 'callback_data' => 'posts'])
            ]
        ];
    
        Telegram::sendMessage([
            'chat_id' => $chat_id, 
            'text' => 'Quyidagi tugmalarni tanlang:',
            'reply_markup' => json_encode([
                'inline_keyboard' => $inlineLayout
            ])
        ]);
    
        return;
    }

    public function setEmail($tguser_id, $email)
    {
        $user = TelegramUser::where('tguser_id', $tguser_id)->first();
        if ($user) {
            $user->email = $email;
            $user->save();
        }
    }
    public function getEmail($tguser_id)
    {
        $user = TelegramUser::where('tguser_id', $tguser_id)->first();
        return $user ? $user->email : null;
    }
    public function getStep($tguser_id)
    {
        $user = TelegramUser::where('tguser_id', $tguser_id)->first();
        return $user ? $user->step : 0; 
    }
    public function logout($tguserId){
        $user = TelegramUser::where('tguser_id', $tguserId)->first();

        if ($user) {
            // Foydalanuvchini yangilash
            $user->user_id ='';
            $user->save();
        } 
    }
    public function saveOrUpdateStep(Request $request, $step)
    {   
        $from = $request->input('message.from');
        $tguserId = $from['id'];        
        $user = TelegramUser::where('tguser_id', $tguserId)->first();

        if ($user) {
            // Foydalanuvchini yangilash
            $user->step = $step;
            $user->save();
        } else {
            // Yangi foydalanuvchini yaratish
            TelegramUser::create([
                'tguser_id' => $tguserId,
                'first_name' => $from['first_name'] ?? null,
                'last_name' => $from['last_name'] ?? null,
                'username' => $from['username'] ?? null,
                'language_code' => $from['language_code'] ?? null,
                'is_premium' => $from['is_premium'] ?? null,
                'step' => '1',
            ]);
        }
    }

}
