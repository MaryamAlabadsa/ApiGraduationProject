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
    public function getGetDataAttribute(){
        return [
            'id' => $this->id,
            'massage' => $this->massage,
            'post_id' => $this->post_id,
            'user_id' => $this->user_id,
            'is_donation_post' => $this->is_donation_post,
            'post' => $this->order_post,
        ];
    }

    public function getOrderPostAttribute(){
        return $this->post ? $this->post : 'orders not found';
    }
    // one request has one post
    public function post(){
        return $this->belongsTo(Post::class);
    }
    // one request has one user
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getIsDonationPostAttribute()
    {
        return $this->post ? $this->post->is_donation : 'post not found';
    }
//  public function getOrderForPostAttribute(Post $post)
//    {
//        return $this->post ? $this->post->is_donation : 'post not found';
//        return $this->post()->where(['post_id', '=',  $userId])->get('user_id')??false;
//    }



}
