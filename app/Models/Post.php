<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
   
    protected $guarded = ['id']; 
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id'); // author_id to'g'ri ko'rsatilganmi?
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
