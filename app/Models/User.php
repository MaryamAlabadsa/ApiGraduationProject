<?php

namespace App\Models;

use http\Url;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
//    protected $appends=['image_link'];
    use HasFactory, Notifiable, HasApiTokens;

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
        dd('99');
        return [
            'id' => $this->id,
            'user' => $this->show_user_image_name,
            'email' => $this->email,
            'phoneNumber' => $this->phone_number,
            'address' => $this->address,
            'num_donation_posts' => $this->email,
//            'num_donation_posts' => $this->num_donation_posts,
            'num_request_posts' => $this->email,
//            'num_request_posts' => $this->num_request_posts,
            'created_at' => $this->published_at,
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

    public function getNumDonationPostsAttribute()
    {
        $DonationPosts = count(DonationPosts($this->id));
        return ' <div class="my-auto">
                                    <h6 class="mb-0 text-sm">' . $DonationPosts. '</h6>
                                  </div>
                                ';
    }

    public function getNumRequestPostsAttribute()
    {
        $DonationPosts = count(RequestPosts($this->id));
        return ' <div class="my-auto">
                                    <h6 class="mb-0 text-sm">' . $DonationPosts. '</h6>
                                  </div>
                                ';
    }
    public function getPublishedAtAttribute()
    {
        return $this->created_at->diffForHumans(now());
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
        return $this->img ? url('/storage/' . $this->img) : url("control_panel_style/images/auth/user.jpg");
    }

    //one user has many notifications
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

}
