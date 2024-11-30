<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramPost extends Model
{
    protected $fillable = ['message_id', 'column', 'value', 'telegram_user_id'];

    
    public function user()
    {
        return $this->belongsTo(TelegramUser::class, 'telegram_user_id');
    }
}
