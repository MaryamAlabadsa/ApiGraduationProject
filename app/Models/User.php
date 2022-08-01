<?php

namespace App\Models;

use http\Url;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
//    protected $appends=['image_link'];
    use HasFactory, Notifiable, HasApiTokens,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'img',
        'phone_number',
        'address',
        'Longitude',
        'Latitude',
        'fcm_token',
    ];

    //controll panel
    public function getPostDisplayDataAttribute()

    {
//        dd('99');
        return [
            'id' => $this->id,
            'user' => $this->show_user_image_name,
            'email' => $this->email,
            'phoneNumber' => $this->phone_number,
            'address' => $this->address,
            'num_donation_posts' => $this->num_posts,
            'num_request_posts' => $this->num_requests,
            'created_at' => $this->published_at,
            'actions' => $this->btn_details. '&nbsp'. $this->delete_user,
        ];
    }
    public function scopeSearch($query, $searchWord)
    {
        return $query->where('id', 'like', "%" . $searchWord . "%")
            ->orWhere('email', 'like', "%" . $searchWord . "%")
            ->orWhere('address', 'like', "%" . $searchWord . "%");

    }

    public function getShowUserImageNameAttribute()
    {
        return '<div class="d-flex px-2">
                                  <div>
                                    <img src="' . $this->image_link . '" class="avatar avatar-sm rounded-circle me-2" alt="spotify">
                                  </div>
                                  <div class="my-auto">
                                    <h6 class="mb-0 text-sm">' . $this->name . '</h6>
                                  </div>
                                </div>';
    }

    public function getNumPostsAttribute()
    {

        return ' <div class="my-auto">
                                    <h6 class="mb-0 text-sm">' .  $this->posts. '</h6>
                                  </div>
                                ';
    }

    public function getNumRequestsAttribute()
    {

        return ' <div class="my-auto">
                                    <h6 class="mb-0 text-sm">' . $this->requests. '</h6>
                                  </div>
                                ';
    }
    public function getPostsAttribute(){
        $posts=Post::where('first_user',$this->id)->get();
        $PostsCount = count($posts);
        return $PostsCount;
    }
    public function getRequestsAttribute(){
        $order=Order::where('user_id',$this->id)->get();
        $OrdersCount = count($order);
        return $OrdersCount;
    }

    public function getPublishedAtAttribute()
    {
        return $this->created_at->diffForHumans(now());
    }

    public function getBtnDetailsAttribute()
    {
        return '<button type="button"class="btn bg-gradient-warning w-90 mb-0 toast-btn"
        ><a href="/profilePosts/'.$this->id.'" > More Details</a> </button>';
    }
    public function getDeleteUserAttribute()
    {
        if ($this->id != 1) {
            return '<button  type="button" class="btn bg-gradient-faded-danger w-40 mb-0 toast-btn " data-toggle="tooltip"
             data-placement="top" rel="tooltip" title="Delete '.$this->name.'" onclick="deleteItem(\''.route('users.destroy',$this->id).'\')"><i class="fa fa-trash"></i></button>';

        }
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function sendPasswordResetNotification($token)
    {
        $url = 'https://spa.test/reset-password?token=' . $token;

        $this->notify(new ResetPasswordNotification($url));
    }

    public function getImageLinkAttribute()
    {
        return $this->img ? url('/storage/' . $this->img) : url("/control_panel_style/usericon.png");
    }

    //one user has many notifications
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

}
