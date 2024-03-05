<?php

use App\Models\Cart;
use App\Models\Category;
use App\Models\Message;
use App\Models\Order;
use App\Models\PostCategory;
use App\Models\PostTag;
use App\Models\Shipping;
use App\Models\Wishlist;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Catch_;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Helper extends Model{

    public static function messageList(){

        return Message::whereNull('read_at')->orderBy('created_at','desc')->get();
    }


    public static function getAllCategory(){
        $category = new Category();

        $menu = $category->getAllParentWithChild();

        return $menu;
    }

    public static function getHeaderCategory(){

        $category = new Category();

        $menu = $category->getAllParentWithChild();

        if($menu){
            ?>

            <li>
                <a href="javascript:void(0);">Category<i class="ti-angle-down"></i></a>
                <ul class="dropdown border-0 shadow">
                    <?php
                    foreach($menu as $cat_info){
                        if($cat_info->child_cat->count() > 0){
                           ?>
                           <li><a href="<?php echo route('product_at',$cat_info->slug);?>"><?php echo $cat_info->title; ?></a>
                        
                           <?php
                           foreach($cat_info->child_cat as $sub_menu){
                            ?>
                            <li><a href="<?php echo route('product-sub-cat',[$cat_info->slug,$sub_menu->slug]);?>"><?php echo $sub_menu->title; ?></a></li>
                            <?php
                           }
                           ?>
                        </li> 
                        <?php
                        }
                       
                    
                    else{
                        ?>
                        <li><a href="<?php echo route('product-cat',$cat_info->slug);?>"><?php echo $cat_info->title; ?></a></li>
                             <?php
                    }
                }
                ?>
                </ul>
            </li>
          <?php
        }
        
    }


      public static function productCategoryList($option='all'){

        if($option='all'){
            return Category::orderBy('id','DESC')->get();
        }

        return Category::has('products')->orderBy('id','DESC')->get();
      }

      public static function postTagList($option='all'){

        if($option='all'){
            return PostTag::orderBy('id','desc')->get();
        }
        return PostTag::has('posts')->orderBy('id','desc')->get();
           
      }

      public static function postCategoryList($option='all'){

        if($option='all'){
            return PostCategory::orderBy('id','DESC')->get();
        }
        return PostCategory::has('posts')->orderBy('id','DESC')->get();
      }


      public static function cartCount($user_id=''){
        if(Auth::check()){
            if($user_id=="")
            return Cart::where('user_id',$user_id)->where('order_id',null)->sum('quantity');
        }
        else {
            return 0;
        }

        
      }
  
       public function product(){

        return $this->hasOne('App\Models\Product','id','product_id');
       }



      public static function getAllProductFromCart($user_id=''){

        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;

            return Cart::with('product')->where('user_id',$user_id)->where('order_id',null)->get();
        }
        else{
            return 0;
        }
      }


      public static function totalCarPrice($user_id=''){
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Cart::where('user_id',$user_id->where('order_id',null))->sum('amount');
        }
        else {
            return 0;
        }
      }

      public static function wishlistCount($user_id=''){

        if(Auth::check()){
            if($user_id=="") $user_id = auth()->user()->id;

            return Wishlist::where('user_id',$user_id)->where('car_id',null)->sum('quantity');
        }else{
            return 0;
        }
      }

      public static function getAllProductFromWishlist($user_id=''){

        if(Auth::check()){
               if($user_id=="") $user_id = auth()->user()->id;
               return Wishlist::with('product')->where('user_id',$user_id)->where('cart_id',null)->get();
        }else{
            return 0;
        }
      }

      public static function totalWishlistPrice($user_id=''){
        if(Auth::check()){
            if($user_id=="") $user_id = auth()->user()->id;
            return Wishlist::where('user_id',$user_id)->where('car_id',null)->sum('amount');
        }else{
            return 0;
        }
      }

      public static function grandPrice($id,$user_id){

        $order = Order::find($id);
        dd($id);
        if($order){
            $shipping_price = (float)$order->shipping->price;
            $order_price = self::orderPrice($id,$user_id);
            return number_format((float)($order_price+$shipping_price),2,'.','');
        }else{
            return 0;
        }
      }

      //Admin home 
      public static function earingPerMonth(){
        $month_data = Order::where('status','delivered')->get();

        $price = 0;
        foreach( $month_data as $data){
            $price = $data->cal_info->sum('price');
        }
        return number_format((float)($price),2,'.','');
      }



      public static function shipping(){
        return Shipping::orderBy('id','DESC')->get();
      }
}

?>