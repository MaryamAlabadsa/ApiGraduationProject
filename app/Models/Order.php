<?php

namespace App\Models;

use App\Http\Resources\Post\PostResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;


class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = ['post_status'];

    protected $fillable = [
        'post_id',
        'user_id',
        'massage',
    ];

    public function getGetDataAttribute()
    {
        return [
            'status' => 1,
            'id' => $this->id,
            'massage' => $this->massage,
            'post_id' => $this->post_id,
            'user_id' => $this->user_id,
            'user_name' => $this->user_name,
            'user_image' => $this->user_image_link,
            'created_at' => $this->created_at,
            'user_phone_number' => $this->user ? $this->user->phone_number : "0",
            'order_created_at' => $this->created_at->diffForHumans(now()),
            'order_updated_at' => $this->updated_at->diffForHumans(now()),
            'is_my_profile' => Auth::id() == $this->user_id ? true : false,
            'post' => PostResource::make($this->order_post),

        ];
    }

    //----------------------------------start control panel----------------------------------------------
    public function getPostDisplayDataAttribute()
    {
        return [
            'user' => $this->show_order_user_image_name,
            'massage' => $this->massage,
            'sendAt' => $this->updated_at->diffForHumans(now()),
            'postUser' => $this->show_post_user_image_name,
            'title' => $this->order_post->title,
            'categoryName' => $this->order_post->category_name,
            'RequestNumber' => $this->order_post->number_of_requests,
            'postedAt' => $this->order_post->published_at,
            'isDonation' => $this->order_post->show_is_donation_post,
            'isAvailable' => $this->order_post->show_is_complete,
            'tools' => $this->order_post->show_post_images . '&nbsp' . $this->order_post->show_orders
        ];
    }

    public function scopeSearch($query, $searchWord)
    {
        return $query->where('id', 'like', "%" . $searchWord . "%")
            ->orWhere('massage', 'like', "%" . $searchWord . "%");

    }

    public function getShowOrdersAttribute()
    {
        if (!empty($this->order_post)) {

            if ($this->order_post->number_of_requests == 0) {
                return '<button  type="button" class="btn bg-gradient-faded-info w-80 mb-0 toast-btn disabled " data-toggle="tooltip" data-placement="top" rel="tooltip" title=" ' . $this->order_post->number_of_requests . '" onclick="ShowOrders(\'' . route('posts.ShowOrders', $this->order_post->id) . '\',this)"><i class="bi bi-list-ul"></i>post orders</button>';

            } else
                return '<button type="button" class="btn bg-gradient-faded-info w-80 mb-0 toast-btn" data-toggle="tooltip" data-placement="top" rel="tooltip" title=" ' . $this->order_post->number_of_requests . '" onclick="ShowOrders(\'' . route('posts.ShowOrders', $this->order_post->id) . '\',this)"><i class="bi bi-list-ul"></i>post orders</button>';
        }
    }

    public function getShowPostImagesAttribute()
    {
        if (!empty($this->order_post)) {

            return '<button type="button"class="btn bg-gradient-warning w-80 mb-0 toast-btn" data-toggle="tooltip" data-placement="top" rel="tooltip" title="showImages ' . count($this->order_post->post_media) . '" onclick="showImages(\'' . route('posts.showImages', $this->order_post->id) . '\',this)"><i class="bi bi-images"></i>post images</button>';
        }
    }

    public function getShowOrderUserImageNameAttribute()
    {
        //       return '<div class=" btn d-flex px-2" id="img-clck">

        return '<button class=" btn d-flex px-2" onclick="ShowProfileCard(\'' . route('posts.ShowProfileCard', $this->user_id) . '\')">
                                  <div>
                                    <img src="' . $this->user_image_link . '" class="avatar avatar-sm rounded-circle me-2" alt="spotify">
                                  </div>
                                  <div class="my-auto">
                                    <h6 class="mb-0 text-sm">' . $this->user_name . '</h6>
                                  </div>
                                </button>';
    }

    public function getShowPostUserImageNameAttribute()
    {
//        dd($this->order_post);
        if (!empty($this->order_post)) {
            return '<button class=" btn d-flex px-2" onclick="ShowProfileCard(\'' . route('posts.ShowProfileCard', $this->order_post->first_user) . '\')">
                                  <div>
                                    <img src="' . $this->order_post->first_user_image_link . '" class="avatar avatar-sm rounded-circle me-2" alt="spotify">
                                  </div>
                                  <div class="my-auto">
                                    <h6 class="mb-0 text-sm">' . $this->order_post->first_user_name . '</h6>
                                  </div>
                                </button>';
        }

    }

    public function getShowIsDonationPostAttribute()
    {
        if (!empty($this->order_post)) {

            if ($this->order_post->is_donation) {
                return ' <button class="btn bg-gradient-light w-100 mb-0 toast-btn" type="button" data-target="successToast">Donation</button>';
            }
            return ' <button class="btn bg-gradient-faded-info w-100 mb-0 toast-btn" type="button" data-target="successToast">Request</button>';
        }
    }

    public function getShowIsCompleteAttribute()
    {
        if (!empty($this->order_post)) {

            if ($this->order_post->is_completed) {
                return ' <label class="text-primary text-sm badge badge-success">Closed</label>';
            }
            return '<label class="text-danger text-2xl badge badge-danger">Pending</label>';
        }
    }

//-----------------------------------------end control panel ----------------------------------------
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
        return $this->user ? ($this->user->img ? url('/storage/' . $this->user->img) :
            url("/control_panel_style/usericon.png"))
            : "/control_panel_style/usericon.png";
    }

    public function getUserNameAttribute()
    {
        return $this->user ? $this->user->name : 'user not found';
    }


}
