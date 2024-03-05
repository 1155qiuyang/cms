<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index(Request $request){

        return redirect()->route($request->user()->role);
    }

    public function home(){

        $featured = Product::where('status','active')->where('is_featured',1)->orderBy('price','DESC')->limit(2)->get();

        $posts = Post::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        
    }
}
