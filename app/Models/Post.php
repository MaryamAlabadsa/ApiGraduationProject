<?php

namespace App\Models;

use App\Http\Resources\Order\OrderResource;
use App\Http\UtcDateTime;
use Database\Factories\UserFactory;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{

    use HasFactory, SoftDeletes;

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
            'second_user_id' => $this->second_user_data ? $this->second_user_data->id : 0,
            'category_name' => $this->category_name,
            'number_of_requests' => $this->number_of_requests,
            'first_user_name' => $this->first_user_name,
            'second_user_name' => $this->second_user_name,
            'post_first_user_email' => $this->post_first_user_email,
            'post_second_user_email' =>   $this->post_second_user_email,
            'post_media' => $this->post_media,
            'first_user_image_link' => $this->first_user_image_link,
            'is_ordered' => $this->is_ordered != false ? true : false,
            'Order_id' => $this->is_ordered == true ? $this->is_ordered->id : 0,
            'is_he_the_owner_of_the_post' => $this->first_user === Auth::id() ? true : false,
            'is_completed' => $this->is_completed,
            'post_created_at' => $this->created_at->diffForHumans(now()),
            'post_updated_at' => $this->updated_at->diffForHumans(now()),
            'the_owner_is_login' => $this->first_user == Auth::id() ? true : false,
        ];
    }

    protected $casts = [
        'is_donation' => 'boolean',
    ];

    //controll panel
    public function getPostDisplayDataAttribute()
    {
        return [
            'user' => $this->show_user_image_name,
            'title' => $this->title,
            'categoryName' => $this->category_name,
            'RequestNumber' => $this->number_of_requests,
            'postedAt' => $this->published_at,
            'isDonation' => $this->show_is_donation_post,
            'isAvailable' => $this->show_is_complete,
            'tools' => $this->show_post_images . '&nbsp' . $this->show_orders
        ];
    }

    public function scopeSearch($query, $searchWord)
    {
        return $query->where('id', 'like', "%" . $searchWord . "%")
            ->orWhere('title', 'like', "%" . $searchWord . "%")
//            ->orWhere('userName', 'like', "%" . $searchWord . "%")
            ->orWhereHas('category', function ($query) use ($searchWord) {
                $query->where('name', 'like', "%" . $searchWord . "%");
            });
    }

    public function getShowOrdersAttribute()
    {
        if ($this->number_of_requests == 0) {
            return '<button  type="button" class="btn bg-gradient-faded-info w-80 mb-0 toast-btn disabled " data-toggle="tooltip" data-placement="top" rel="tooltip" title=" ' . $this->number_of_requests . '" onclick="ShowOrders(\'' . route('posts.ShowOrders', $this->id) . '\',this)"><i class="bi bi-list-ul"></i>post orders</button>';

        } else
            return '<button type="button" class="btn bg-gradient-faded-info w-80 mb-0 toast-btn" data-toggle="tooltip" data-placement="top" rel="tooltip" title=" ' . $this->number_of_requests . '" onclick="ShowOrders(\'' . route('posts.ShowOrders', $this->id) . '\',this)"><i class="bi bi-list-ul"></i>post orders</button>';
    }

    public function getShowPostImagesAttribute()
    {
        return '<button type="button"class="btn bg-gradient-warning w-80 mb-0 toast-btn" data-toggle="tooltip" data-placement="top" rel="tooltip" title="showImages ' . count($this->post_media) . '" onclick="showImages(\'' . route('posts.showImages', $this->id) . '\',this)"><i class="bi bi-images"></i>post images</button>';
    }

    public function getShowUserImageNameAttribute()
    {
        //       return '<div class=" btn d-flex px-2" id="img-clck">

        return '<button class=" btn d-flex px-2" onclick="ShowProfileCard(\'' . route('posts.ShowProfileCard', $this->first_user) . '\')">
                                  <div>
                                    <img src="' . $this->first_user_image_link . '" class="avatar avatar-sm rounded-circle me-2" alt="spotify">
                                  </div>
                                  <div class="my-auto">
                                    <h6 class="mb-0 text-sm">' . $this->first_user_name . '</h6>
                                  </div>
                                </button>';
    }

    public function getShowIsDonationPostAttribute()
    {
        if ($this->is_donation) {
            return ' <button class="btn bg-gradient-light w-100 mb-0 toast-btn" type="button" data-target="successToast">Donation</button>';
        }
        return ' <button class="btn bg-gradient-faded-info w-100 mb-0 toast-btn" type="button" data-target="successToast">Request</button>';
    }

    public function getShowIsCompleteAttribute()
    {
        if ($this->is_completed) {
            return ' <label class="text-primary text-sm badge badge-success">Closed</label>';
        }
        return '<label class="text-danger text-2xl badge badge-danger">Pending</label>';
    }

//-------------------------------start scope -------------------------------------
    public function scopeDonation($query, $searchWord)
    {
        if (!empty($searchWord) || $searchWord == 0) {
            if ($searchWord == 0 || $searchWord == 1) {
                return $query->where('is_donation', $searchWord);
            } else {
                return $query;
            }
        } else {
            return $query;
        }
    }

    public function scopeStatus($query, $searchWord)
    {
        if (!empty($searchWord) || $searchWord == 0) {
//            dd($searchWord);
            if ($searchWord == 0) {
                return $query->whereNull('second_user');
            } else if ($searchWord == 1) {
                return $query->whereNotNull('second_user');
            } else {
                return $query;
            }
        } else {
            return $query;
        }
    }

    public function scopePostCategory($query, $searchWord)
    {
        if (!empty($searchWord) || $searchWord == 0) {
            if ($searchWord == 0) {
                return $query;
            } else
                return $query->where('category_id', $searchWord);
        } else {
            return $query;
        }
    }

    public function scopeData($query, $searchWord)
    {
        if (!empty($searchWord)) {
            return $query->where('title', 'like', "%" . $searchWord . "%")->orWhere('description', 'like', "%" . $searchWord . "%");
        } else {
            return $query;
        }

    }
//-------------------------------end scope---------------------------------------
//Api
    public function getPostOrdersAttribute()
    {
        return $this->orders ? $this->orders : 'orders not found';
    }

    public function getPublishedAtAttribute()
    {
        return $this->created_at->diffForHumans(now());
    }

    public function getIsCompletedAttribute()
    {
        return $this->second_user === null ? false : true;
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
        return $this->user ? $this->user->id : 0;
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
        return $this->user ? ($this->user->img ? url('/storage/' . $this->user->img) :
            url("control_panel_style/usericon.png")) : "control_panel_style/usericon.png";
    }

    public function getSecondUserImageLinkAttribute()
    {
        return $this->second_user_data ? ($this->second_user_data->img ?
            url('/storage/' . $this->second_user_data->img) :
            url("control_panel_style/usericon.png")) : "control_panel_style/usericon.png";

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

    public function getOrderIdAttribute()
    {
        return $this->orders ? ($this->orders->user_id == Auth::id() ? $this->orders->user_id : 0) : 0;
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
