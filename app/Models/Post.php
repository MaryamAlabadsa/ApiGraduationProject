<?php

namespace App\Models;

use App\Http\UtcDateTime;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\String_;
use phpDocumentor\Reflection\Types\This;

class Post extends Model
{

    use HasFactory;

    protected $appends = ['post_category', 'post_first_user', 'post_second_user','post_first_user_email','post_second_user_email'];
    protected $fillable = [
        'title',
        'description',
        'is_donation',
        'category_id',
        'first_user',
        'second_user',
        'number_of_requests'
    ];
    protected $casts = [
        'is_donation' => 'boolean',
    ];

    public function getPostCategoryAttribute()
    {
//        $c = Post::with('category')->where('id',$this->category_id)->first();
//        $obj =json_decode($c);
//        return $obj->id;
//        return $this->attributes[$c] ;
        $c = Category::where('id', $this->category_id)->first();

//        echo json_decode($c)->type;
//        return json_decode($c['type']);
        return json_decode($c) ? json_decode($c)->type : 'll';
//        return $c;
//        return 99;
//        return $this->category ? $this->category->type : 'category not found';
    }

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

    public function getPostSecondUserEmailAttribute()
    {
        return $this->second_user_data ? $this->second_user_data->email : 'not found';
    }

    public function getPostMediaAttribute()
    {
        $media=[];
        if ($this->media->count() ){
            foreach ($this->media as $medium){
                array_push($media,url('/storage/'.$medium->name) );
            }
        }else{
            array_push($media, url('/man3.png'));

        }
        return $media;
    }

    public function getFirstUserImageLinkAttribute(){
        return $this->user ? ($this->user->img? url('/storage/'.$this->user->img) : url("control_panel_style/images/faces/face1.jpg")) :"control_panel_style/images/faces/face3.jpg";
    }
    public function getSecondUserImageLinkAttribute(){
        return $this->second_user_data  ? ($this->user->img? url('/storage/'.$this->second_user_data ->img) : url("{{asset('control_panel_style/images/faces/face1.jpg')}}")) :"{{asset('control_panel_style/images/faces/face4.jpg')}}";

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
    public function request()
    {
        return $this->hasMany(Request::class);
    }
    //one post has many image
    public function media()
    {
        return $this->hasMany(Media::class);
    }
}
