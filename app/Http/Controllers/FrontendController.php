<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FrontendController extends Controller
{
    public function index(Request $request){

        return redirect()->route($request->user()->role);
    }

    public function home(){

        $featured = Product::where('status','active')->where('is_featured',1)->orderBy('price','DESC')->limit(2)->get();

        $posts = Post::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        
        $banners = Banner::where('status','active')->limit(3)->orderBy('id','DESC')->get();

        //return $banner
        $products = Product::where('status','active')->orderBy('id','DESC')->limit(8)->get();

        $category = Category::where('status','active')->where('is_parent',1)->orderBy('title','ASC')->get();

        
    }

    public function register(){
        return view('frontend.pages.register');
    }
    

    public function registerSubmit(Request $request){

        $this->validate($request,[
            'name'=>'string|required|min:2',
            'email'=>'string|required|unique:users,email',
            'password'=>'required|min:6|confirmed',
        ]);
        $data = $request->all();
        $check = $this->create($data);
        Session::put('user',$data['email']);
        if($check){
            $request()->session()->flash('success','Successfully registered');
            return redirect()->route('home');
        }else{
             $request()->session()->flash('error','Please try again!');
             return back();
        }
    }
}
