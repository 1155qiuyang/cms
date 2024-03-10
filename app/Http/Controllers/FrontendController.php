<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Brand;
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
        
        return view('frontend.index')
               ->with('featured',$featured)
               ->with('posts',$posts)
               ->with('banners',$banners)
               ->with('product_lists',$products)
               ->with('category_lists',$category);
        
    }




    public function aboutUs(){
        return view('frontend.pages.about-us');
    }

    public function contact(){
        return view('frontend.pages.contact');
    }

    public function productDetail($slug){

        $product_detail = Product::getProductBySlug($slug);

        return view('frontend.pages.product_detail')->with('product_detail',$product_detail);
    }

    public function productGrids(){

        $products = Product::query();
        if(!empty($_GET['category'])){
            $slug = explode(',',$_GET['category']);
            $cat_ids = Category::select('id')->whereIn('slug',$slug)->pluck('id')->toArray();
            $products->whereIn('cat_id',$cat_ids);
        }
        if(!empty($_GET['brand'])){
            $slugs = explode(',',$_GET['brand']);
            $brand_ids = Brand::select('id')->whereIn('slug',$slugs)->pluck('id')->toArray();

            return $brand_ids;
            $products->whereIn('brand_id',$brand_ids);
        }

        if(!empty($_GET['sortBy'])){
            if($_GET['sortBy']=='title'){
                $products=$products->where('status','active')->orderBy('title','ASC');

            }
            if($_GET['sortBy']=='price'){
                $products = $products->orderBy('price','ASC');
            }

            if(!empty($_GET['price'])){
                $price = explode('-',$_GET['price']);


                $products->whereBetween('price',$price);
            }

            $recent_products = Product::where('status','active')->orderBy('id','DESC')->limit(3)->get();

            // Sort by number
            if(!empty($_GET['show'])){
                $products = $products->where('status','active')->paginate($_GET['show']);
            }
            else{
                $products = $products->where('status','active')->paginate(9);
            }

            // Sort by name price category

            return view('frontend.pages.product-grids')->with('products',$products)->with('recent_products',$recent_products);

        }


    }


    public function productLists(){

        $products = Product::query();
        if(!empty($_GET['category'])){
            $slug = explode(',',$_GET['category']);
            $cat_ids = Category::select('id')->whereIn('slug',$slug)->pluck('id')->toArray();

            $products->whereIn('cat_id',$cat_ids)->paginate;
        }
        if(!empty($_GET['brand'])){
            $slugs = explode(',',$_GET['brand']);
            $brand_ids = Brand::select('id')->whereIn('slugs',$slugs)->pluck('id')->toArray();
            return $brand_ids;
            $products->whereIn('brand_id',$brand_ids);
        }

        if(!empty($_GET['sortBy'])){
            $products=$products->where('status','active')->orderBy('title','ASC');


        }
        if($_GET['sortBy']=='price'){
            $products = $products->orderBy('price','ASC');
        }

        if(!empty($_GET['price'])){
            $price = explode(',',$_GET['price']);

            $products->whereBetween('price',$price);
        }

        $recent_products = Product::where('status','active')->orderBy('id','DESC')->limit(3)->get();

        // Sort by number
        if(!empty($_GET['show'])){
            $products = $products->where('status','active')->paginate($_GET['show']);
        }else{
            $products = $products->where('status','active')->paginate(9);
        }
        return view('frontend.pages.product-lists')->with('products',$products)->with('recent_products',$recent_products);

    }

    public function productFilter(Request $request){

        $data = $request->all();

        // return $data
        $showURL ="";
        if(!empty($data['show'])){
            $showURL .='&show=' .$data['show'];
        }
        $sortByURL = '';
        if(!empty($data['sortBy'])){
            $sortByURL .'&sortBy=' .$data['sortBy'];

        }
        $catURL="";
        if(!empty($data['category'])){
            foreach($data['category'] as $category){
                if(empty($catURL)){
                    $catURL .='&category=' .$category;
                }else{
                    $catURL .=',' .$category;
                }
            }
        }

        $brandURL = "";
        if(!empty($data['brand'])){
            foreach($data['brand'] as $brand){
                if(empty($brandURL)){
                    $brandURL .='&brand=' .$brand;
                }
                else{
                    $brandURL .=',' .$brand;
                }
            }
        }
        // return $brandURL
        $priceRangeURL = "";
        if(!empty($data['price_range'])){
            $priceRangeURL .='&price' .$data['price_range'];
        }
        if(request()->is('e-shop.loc/product-grids')){
            return redirect()->route('product-grids',$catURL.$brandURL.$priceRangeURL.$showURL.$sortByURL);
        }else{
            return redirect()->route('product-lists',$catURL.$brandURL.$priceRangeURL.$showURL.$sortByURL);
        }
    }
    public function register(){
        return view('frontend.pages.register');
    }

    public function productSearch(Request $request){
        $recent_products = Product::where('status','active')->orderBy('id','DESC')->limit(3)->get();

        $products = Product::orwhere('title','like','%'.$request->search.'%')
                             ->orwhere('slug','like','%'.$request->search .'%')
                             ->orwhere('description','like','%'.$request->search.'%')
                             ->orwhere('summary','like','%'.$request->search.'%')
                             ->orwhere('price','like','%'.$request->search.'%')
                             ->orderBy('id','DESC')
                             ->paginate(9);

                 return view('frontend.pages.product-grids')->with('products',$products)->with('recent_products',$recent_products);
                             
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
