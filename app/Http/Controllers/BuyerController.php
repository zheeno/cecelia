<?php

namespace App\Http\Controllers;
use App\Category;
use App\Subcategory;
use App\FoodItem;
use App\UnitMeasure;
use App\Cart;
use App\Order;
use Auth;

use Illuminate\Http\Request;

class BuyerController extends Controller
{

    //show buyer's orders
    public function orders(){
        $allCategories = Category::orderBy("category_name", "ASC")->get();
        // get all orders for the user
        $user_id = Auth::user()->id;
        $orders =  Order::where("user_id", $user_id)->orderBy("id", "DESC")->get();

        return view("me/orders")->with('params', [
            'orders' => $orders,
            "navBarCatList" => $allCategories
        ]);
    }

    // open selected order
    public function viewOrder($id){
        $allCategories = Category::orderBy("category_name", "ASC")->get();
        $order = Order::findorfail($id);
        if($order->user_id !== Auth::user()->id){
            // show a 404 error
            Order::findorfail(0);
        }
        
        return view("me/orderPage")->with("params", [
            "order" => $order,
            "cartItems" => $order->cartItems,
            "navBarCatList" => $allCategories
        ]);
    }

}
