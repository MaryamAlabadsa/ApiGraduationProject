<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'image',
        'name_ar'
    ];
    //one Category has many posts
    public function  posts(){
        return $this->hasMany(Post::class);
    }

    public function getImageLinkAttribute(){
        return $this->image ? url('/storage/'.$this->image) : url("control_panel_style/images/faces/face1.jpg");
    }
//    public function getNameAttribute(){
//        return ucfirst($this->name);
//    }
}
