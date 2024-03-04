<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
   protected $fillable = ['title','slug','status'];


   public static function getBlogByCategory($slug){

    return PostCategory::with('post')->where('slug',$slug)->first();
   }
}
