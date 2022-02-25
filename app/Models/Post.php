<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'is_donation',
        'category_id',
        'first_user',
        'second_user',
    ];
    // one post has one category
    public function category(){
        return $this ->belongsTo(Category::class);
    }
    //one post has one user
    public function  user(){
        return $this->belongsTo(User::class,'first_user');
    }
    //one post has one user
    public function  second_user(){
        return $this->belongsTo(User::class,'second_user');
    }
    //one post has many request
    public function  request(){
        return $this->hasMany(Request::class);
    }
}
