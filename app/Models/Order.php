<?php

namespace App\Models;

use App\Http\Resources\Post\PostResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory,SoftDeletes;

    protected $appends = ['post_status'];

    protected $fillable = [
        'post_id',
        'user_id',
        'massage',
    ];

    public function getGetDataAttribute()
    {
        return [
            'id' => $this->id,
            'status' => 1,
            'massage' => $this->massage,
            'post_id' => $this->post_id,
            'user_id' => $this->user_id,
            'user_name' => $this->user_name,
            'user_image' => $this->user_image_link,
            'created_at' => $this->created_at,
            'user_phone_number' => $this->user?$this->user->phone_number:"0",
            'post' => PostResource::make($this->order_post),
            'published_at' => $this->created_at->diffForHumans(now()),

        ];
    }

    public function getOrderPostAttribute()
    {
        return $this->post ? $this->post : 'orders not found';
    }

    // one request has one post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // one request has one user
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function getPostStatusAttribute()
    {
        //1 => completed
        //0 => pending
        return $this->post ? ($this->post->second_user_name ? 1 : 0) : 'user not found';
    }

    public function getUserImageLinkAttribute()
    {
        return $this->user ? ($this->user->img ? url('/storage/' . $this->user->img) : url("control_panel_style/images/auth/user.png")) : "control_panel_style/images/auth/user.png";
    }

    public function getUserNameAttribute()
    {
        return $this->user ? $this->user->name : 'user not found';
    }


}
