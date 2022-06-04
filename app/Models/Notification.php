<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $appends = [
        'sender_name',
        'sent_time'
    ];

    protected $fillable = [
        'post_id',
        'sender_id',
        'receiver_id',
        'type'
    ];

    protected $hidden = [
        'sender_user',
        'updated_at',
        'created_at',
    ];

    //one Notification has one user
    public function sender_user()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver_user()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    //one Notification has one post
    public function second_user_data()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function getSenderNameAttribute()
    {
        return $this->sender_user ? $this->sender_user->name : 'sender name not found';
    }

    public function getSentTimeAttribute()
    {
        return $this->created_at->diffForHumans(now());
    }
}
