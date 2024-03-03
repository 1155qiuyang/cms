<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
     protected $fileable = ['user_id','order_number','sub_total','quantity','delivery_charge','status','total_amount','first_name','last_name','country','post_code','address1','address2','phone','email','payment_method','payment_status','shipping_id','coupon'];


     public static function getAllOrder($id){
        return Order::with('car_info')->find($id);
     }

     public static function countActiveOrder(){
        $data = Order::count();
        if($data){
            return $data;
        }
        return 0;
     }

}
