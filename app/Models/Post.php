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

    use HasFactory , SoftDeletes;

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
            'second_user_id' => $this->second_user_data?$this->second_user_data->id:0,
            'category_name' => $this->category_name,
            'number_of_requests' => $this->number_of_requests,
            'first_user_name' => $this->first_user_name,
            'second_user_name' => $this->second_user_name,
            'post_first_user_email' => $this->post_first_user_email,
            'post_second_user_email' => $this->post_second_user_email,
            'post_media' => $this->post_media,
            'first_user_image_link' => $this->first_user_image_link,
            'is_ordered' => $this->is_ordered != false ? true : false,
            'Order_id' => $this->is_ordered == true ? $this->is_ordered->id: 0,
            'is_he_the_owner_of_the_post' => $this->first_user===Auth::id()?true:false,
            'is_completed' =>$this->is_completed ,
            'published_at' =>$this->published_at ,

        ];
    }

    protected $casts = [
        'is_donation' => 'boolean',
    ];

    //controll panel
    public function getPostDisplayDataAttribute(){
        return [
            'userImage'=>'<img src="'.$this->first_user_image_link.'"/>',
            'userName'=>$this->first_user_name,
            'postTitle'=>$this->title,
            'categoryName'=>$this->price,
            'RequestNumber'=>$this->number_of_requests,
            'postedAt'=>$this->published_at,
            'isDonation'=>$this->is_donation,
            'isAvailable'=>$this->is_completed,
            'tools'=>$this->show_post_images.'&nbsp'.$this->show_orders
        ];
    }

    public function scopeSearch($query,$searchWord)
    {
        return $query->where('id', 'like', "%" . $searchWord . "%")
            ->orWhere('name', 'like', "%" . $searchWord . "%")
            ->orWhere('userName', 'like', "%" . $searchWord . "%")
            ->orWhereHas('category',function($query) use($searchWord){
                $query->where('name', 'like', "%" . $searchWord . "%");
            });
    }
    public function getShowOrdersAttribute(){
        return '<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" rel="tooltip" title=" '.$this->number_of_requests.'" onclick="ShowOrders(\''.route('posts.ShowOrders',$this->id).'\',this)"><i class="bi bi-list-ul"></i></button>';
    }
    public function getShowPostImagesAttribute(){
        return '<button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" rel="tooltip" title="showImages '.$this->name.'" onclick="showImages(\''.route('posts.showImages',$this->id).'\')"><i class="bi bi-images"></i></button>';
    }


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
        return $this->second_user===null?false:true;
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
        return $this->user ? ($this->user->img ? url('/storage/' . $this->user->img) : url("control_panel_style/images/auth/user.png")) : "control_panel_style/images/auth/user.png";
    }

    public function getSecondUserImageLinkAttribute()
    {
        return $this->second_user_data ? ($this->second_user_data->img ? url('/storage/' . $this->second_user_data->img) : url("control_panel_style/images/auth/user.png")) : "control_panel_style/images/auth/user.png";

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

    public function  getOrderIdAttribute(){
        return $this->orders ?($this->orders->user_id == Auth::id()?$this->orders->user_id :0):0;
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
