<?php

namespace App\Models;

use App\Http\UtcDateTime;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{

    use HasFactory;

//    protected $appends = [ 'post_first_user', 'post_second_user', 'post_first_user_email', 'post_second_user_email'];
    protected $fillable = [
        'title',
        'description',
        'is_donation',
        'category_id',
        'first_user',
        'second_user',
        //  'number_of_requests'
    ];
    /**
     * @var mixed
     */

    public function getGetDataAttribute()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'is_donation' => $this->is_donation,
            'number_of_requests' => $this->number_of_requests,
            'post_first_user' => $this->post_first_user,
            'post_second_user' => $this->post_second_user,
            'post_first_user_email' => $this->post_first_user_email,
            'post_second_user_email' => $this->post_second_user_email,
            'post_media' => $this->post_media,

        ];
    }

    protected $casts = [
        'is_donation' => 'boolean',
    ];

    public function getPostOrdersAttribute(){
        return $this->orders() ? $this->orders() : 'orders not found';
    }


    public function getIsOrderedAttribute()
    {
        $userId = Auth::id();
        return $this->orders()
                ->where('user_id', $userId)
                ->first() ?? false;

    }



    public function getCategoryNameAttribute()
    {
////        $c = Post::with('category')->where('id',$this->category_id)->first();
////        $obj =json_decode($c);
////        return $obj->id;
////        return $this->attributes[$c] ;
//        $c = Category::where('id', $this->category_id)->first();
//
////        echo json_decode($c)->type;
////        return json_decode($c['type']);
//        return json_decode($c) ? json_decode($c)->type : 'll';
////        return $c;
//        return 99;
        return $this->category ? $this->category->name : 'category not found';
    }

    public function getNumberOfRequestsAttribute()
    {
        return $this->orders ? $this->orders->count() : 0;
    }

    //user

    public function getPostFirstUserAttribute()
    {
        return $this->user ? $this->user->name : 'user not found';
    }

    public function getPostSecondUserAttribute()
    {
        return $this->second_user_data ? $this->second_user_data->name : 'not found';
    }

    public function getPostFirstUserEmailAttribute()
    {
        return $this->user ? $this->user->email : 'user not found';
    }

    public function getFirstUserImageLinkAttribute()
    {
        return $this->user ? ($this->user->img ? url('/storage/' . $this->user->img) : url("control_panel_style/images/faces/face1.jpg")) : "control_panel_style/images/faces/face3.jpg";
    }

    public function getSecondUserImageLinkAttribute()
    {
        return $this->second_user_data ? ($this->second_user_data->img ? url('/storage/' . $this->second_user_data->img) : url("control_panel_style/images/faces/face1.jpg")) : "control_panel_style/images/faces/face3.jpg";

    }

    public function getPostSecondUserEmailAttribute()
    {
        return $this->second_user_data ? $this->second_user_data->email : 'not found';
    }

    //media

    public function getPostMediaAttribute()
    {
        $media = [];
        if ($this->media->count()) {
            foreach ($this->media as $medium) {
                array_push($media, url('/storage/' . $medium->name));
            }
        } else {
            array_push($media, url('/man3.png'));

        }
        return $media;
    }
//    public function getOrdersAttribute()
//    {
//        $media = [];
//        if ($this->media->count()) {
//            foreach ($this->media as $medium) {
//                array_push($media, url('/storage/' . $medium->name));
//            }
//        } else {
//            array_push($media, url('/man3.png'));
//
//        }
//        return $media;
//    }




    // one post has one category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    //one post has one user
    public function user()
    {
        return $this->belongsTo(User::class, 'first_user');
    }

    //one post has one user
    public function second_user_data()
    {
        return $this->belongsTo(User::class, 'second_user');
    }

    //one post has many request
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    //one post has many image
    public function media()
    {
        return $this->hasMany(Media::class);
    }

}
