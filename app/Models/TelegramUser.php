<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TelegramUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'tguser_id',
        'first_name',
        'email',
        'last_name',
        'username',
        'language_code',
        'is_premium',
        'user_id',
    ];  
}
