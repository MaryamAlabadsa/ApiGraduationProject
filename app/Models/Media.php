<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'is_donation',
        'number_of_requests'
    ];
    //one image belongs to one post
    public function post()
    {
        return $this->belongsTo(Post::class, 'second_user');
    }
}
