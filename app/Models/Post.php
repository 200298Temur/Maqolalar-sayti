<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable=['title','subtitle','content','author'];
    public function author()
    {
        return $this->belongsTo(User::class, 'author');
    }
}
