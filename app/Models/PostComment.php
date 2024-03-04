<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    protected $fillable = ['user_id','post_id','comment','replied_comment','parent_id','status'];



    public function user_info(){

        return $this->hasOne('App\Models\User','user_id');
    }
    public static function getALLComments(){

        return PostComment::with('user_info')->paginate(10);


    }

    public static function getALLUserComments(){

        return PostComment::where('user_id',auth()->user()->id->with('user_info'))->paginate(10);

    }
    public function post(){
        return $this->belongsTo(Post::class,'post_id');
    }

    public function replies(){
        return $this->hasMany(PostComment::class,'parent_id')->where('status','active');
    }
}
