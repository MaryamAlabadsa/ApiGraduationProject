<?php

namespace App\Models;

use App\Http\Resources\Order\OrderResource;
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
            'status' => 0,
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'is_donation' => $this->is_donation,
            'category_id' => $this->category_id,
            'first_user_id' => $this->first_user,
            'second_user_id' => $this->second_user,
            'category_name' => $this->category_name,
            'number_of_requests' => $this->number_of_requests,
            'first_user_name' => $this->first_user_name,
            'second_user_name' => $this->second_user_name,
            'post_first_user_email' => $this->post_first_user_email,
            'post_second_user_email' => $this->post_second_user_email,
            'post_media' => $this->post_media,
            'first_user_image_link' => $this->first_user_image_link,
            'is_ordered' => $this->is_ordered != false ? true : false,
            'is_he_the_owner_of_the_post' => $this->first_user===Auth::id()?true:false,
            'is_completed' => $this->second_user===null?false:true,

        ];
    }

    protected $casts = [
        'is_donation' => 'boolean',
    ];

    public function getPostOrdersAttribute()
    {
        return $this->orders != null ? $this->orders : null;
    }


    public function getIsOrderedAttribute()
    {
        $userId = Auth::id();
        $data = $this->orders
            ->where('user_id', $userId)
            ->first();
        return $data != null ? $data : false;
    }


    public function getCategoryNameAttribute()
    {
        return $this->category ? $this->category->name : 'category not found';
    }

    public function getNumberOfRequestsAttribute()
    {
        return $this->orders ? $this->orders->count() : 0;
    }

    //user

    public function getIsHeTheOwnerOfThePostAttribute()
    {
        $userId = Auth::id();
        return $this->post ? ($this->user->id = $userId ? $userId : false) : 'user not found';
    }

    public function getFirstUserIdAttribute()
    {
        return $this->user ? $this->user->id : 'user not found';
    }
    public function getFirstUserTokenAttribute()
    {
        return $this->user ? $this->user->fcm_token : 'user not found';
    }

    public function getFirstUserNameAttribute()
    {
        return $this->user ? $this->user->name : 'user not found';
    }


    public function getSecondUserNameAttribute()
    {
        return $this->second_user_data ? $this->second_user_data->name : 'not found';
    }
    public function getSecondUserTokenAttribute()
    {
        return $this->second_user_data ? $this->second_user_data->fcm_token : 'user not found';
    }

    public function getFirstUserEmailAttribute()
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
            array_push($media, url('/control_panel_style/images/faces/profile/profile.jpg'));
        }
        return $media;
    }

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
    //one post has many notifications
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }


}
