<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    

    protected $fileable = [
        
        'title',
        'tags',
        'summary',
        'slug',
        'description',
        'photo',
        'quote',
        'post_cat_id',
        'post_tag_id',
        'added_by',
        'status'

    ];
    public static function getPostBySlug($slug){

        return Post::with(['tag_info','author_info'])->where('slug',$slug)->where('status','active')->first();
    }

    public function author_info(){

        return $this->hasOne('App\Models\User','id','added_by');
    }


    public static function getAllPost(){
        return Post::with(['cat_info','author_info'])->orderBy('id','DESC')->paginate(10);
    }
    public static function getBlogByTag($slug){

        return Post::where('tags',$slug)->paginate(8);
    }

    public static function countActivePost(){
        $data = Post::where('status','active')->count();

        if($data){
            return $data;
        }
        return 0;
           
        
    }

}
