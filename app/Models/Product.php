<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
   protected $fillable = ['title','slug','summary','description','cat_id','child_cat_id','price','brand_id','discount','status','photo','size','stock','is_featured','condition'];


   public static function getAllProduct(){

    return Product::with(['cat_info','sub_cat_info'])->orderBy('id','desc')->paginate(10);
   }


   public static function getProductBySlug($slug){
    return Product::with(['cat_info','rel_prods','getReview'])->where('slug',$slug)->first();


   }


   public static function countActiveProduct(){

    $data = Product::where('status','active')->count();

    if($data){
        return $data;
    }
    return 0;
   }
}
