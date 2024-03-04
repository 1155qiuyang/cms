<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    
    protected $fillable = ['title','slug','summary','photo','status','is_parent','parent_id','added_by'];


    public static function getAllCategory(){

        return Category::orderBy('id','DESC')->with('parent_info')->paginate(10);

    }

    public static function shiftChild($cat_id){

        return Category::whereIn('id',$cat_id)->update(['is_parent'=>1]);
    }


    public static function getChildByParentID($id){

        return Category::where('parent_id',$id)->orderBy('id','DESC')->pluck('title','id');

    }

    public static function getAllParentWithChild(){

        return Category::with('child_cat')->where('is_parent',1)->where('status','active')->orderBy('title','ASC')->get();
    }

    public static function getProductByCat($slug){

        return Category::with('products')->where('slug',$slug)->first();


    }

    public static function getProductBySubCat($slug){

        return Category::with('sub_products')->where('slug',$slug)->first();
    }

    public static function countActiveCategory(){

        $data = Category::where('status','active')->count();

        if($data){
            return $data;
        }
        return 0;
    }

}
