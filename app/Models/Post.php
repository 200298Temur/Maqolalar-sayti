<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
class Post extends Model
{
   use Searchable, HasFactory;  
    protected $guarded = ['id','image','title','publish','subtitle','content','author_id','Attime','lang']; 
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id'); // author_id to'g'ri ko'rsatilganmi?
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    // public function toSearchableArray()
    // {
    //     return [
    //         'title'=>$this->title,
    //         'subtitle'=>$this->subtitle,
    //         'content'=>$this->content,
    //     ];
    // }
}
