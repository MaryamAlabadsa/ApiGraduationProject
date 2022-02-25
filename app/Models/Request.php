<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_id',
        'user_id',
    ];

    // one request has one post
    public function category(){
        return $this ->belongsTo(Post::class);
    }
}
