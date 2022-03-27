<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $appends=['is_donation_post'];

    protected $fillable = [
        'post_id',
        'user_id',
        'massage',
    ];

    // one request has one post
    public function post(){
        return $this ->belongsTo(Post::class);
    }
    // one request has one user
    public function user(){
        return $this ->belongsTo(User::class);
    }

    public function getIsDonationPostAttribute()
    {
        return $this->post ? $this->post->is_donation : 'post not found';
    }

}
