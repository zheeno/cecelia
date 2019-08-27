<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Subcategory;
use App\FoodItem;
use App\UnitMeasure;
use App\Cart;
use App\Order;
use Auth;
use Rave;
use Illuminate\Support\Facades\Hash;



class MarketPlaceController extends Controller
{
    // initial page to be displayed when the market place is visited
    public function openMarketPlace($path = 'index'){
        $allCategories = Category::orderBy("category_name", "ASC")->get();
        return view("marketPlace")->with('params', [
            'curPage' => $path,
            "navBarCatList" => $allCategories
        ]);
    }

    // fetches the data required by the market place index page
    // which is to be populated on the react js component <Landing />
    public function getMarketPlaceData(){
        // get all categories
        $allCategories = Category::orderBy("category_name", "ASC")->get();
        // generate a random list of food items from allCategories
        $allCatFoods = [];
        foreach ($allCategories as $key => $category) {
            $food = FoodItem::where('category_id', $category->id)->orderByRaw("RAND()")->take(4)->get();
            if(count($food) > 0){
                array_push($allCatFoods, ["category" => $category, "foodItems" => $food]);                
            }
        }

        // generate a random list of food items from categories
        $categories = Category::orderByRaw("RAND()")->take(6)->get();
        $suggestedFoodItems = [];
        foreach ($categories as $key => $category) {
            // get a random sub category
            $sub_category = Subcategory::where('category_id', $category->id)->orderByRaw("RAND()")->take(1)->get();
            // get a random food item within that subcategory
            if(count($sub_category) > 0){
                $food = FoodItem::where('category_id', $category->id)->where('sub_category_id', $sub_category[0]->id)->orderByRaw("RAND()")->take(1)->get();
                if(count($food) > 0){
                    $item = ["item" => $food[0], "subCategory" => $sub_category[0], "category" => $category];
                    array_push($suggestedFoodItems, $item);
                }
            }
        }

        $response = [
            "suggestedFoodItems" => $suggestedFoodItems,
            "allCategories" => $allCategories,
            "allCatFoods" => $allCatFoods
        ];

        return json_encode($response);
    }

    public function searchFoodItemsWithKeyword(Request $request){
        $q = $request->input('q');

        return redirect('/market/search/'.$q);
    }

    // serach food item
    public function searchFoodItems(Request $request){
        $input = $request->input();
        $keywords = explode(" ", $request->input('q'));
        $foodItems = FoodItem::where(function($query) use($keywords){
            foreach ($keywords as $key => $keyword){
                if($keyword != ''){
                    $query->where('item_name', 'LIKE', "%".$keyword."%")
                    ->orWhere('description', 'LIKE', "%".$keyword."%");
                }
            }
        })->orderBy('id', 'DESC')->get();

        return json_encode([
            "foodItems" => $foodItems
        ]);
    }

    // getCategory
    public function getCategory(Request $request){
        $catId = $request->input('id');
        $category = Category::findorfail($catId);
        // check if category has any sub categories
        $sub_cat_check = Subcategory::where('category_id', $catId)->orderBy("sub_category_name", "ASC")->get();
        if(count($sub_cat_check) > 0){
            $subCategories = [];
            foreach ($sub_cat_check as $key => $subCat) {
                // get all food items within that subcategory
                $foods = FoodItem::where('category_id', $catId)->where('sub_category_id', $subCat->id)->orderByRaw("RAND()")->take(4)->get();
                $item = ["foodItems" => $foods, 
                "subCategory" => $subCat,
                //  "category" => $category
                ];
                array_push($subCategories, $item);
            }
            return json_encode([
                "category" => $category,
                "subCategories" => $subCategories
            ]);
        }else{
            // there are no sub categories
        }
    }

    // getSubCategory
    public function getSubCategory(Request $request){
        $id = $request->input("id");
        // get sub category data
        $sub_category = Subcategory::findorfail($id);
        // get main category
        $category = Category::findorfail($sub_category->category_id);
        // get all food items in the selected sub category
        $foodItems = FoodItem::where('sub_category_id', $sub_category->id)->where('category_id', $category->id)->orderBy('item_name', 'ASC')->get();

        return json_encode([
            "subCategory" => $sub_category,
            "category" => $category,
            "foodItems" => $foodItems
        ]);
    }

    // getFoodItem
    public function getFoodItem(Request $request){
        $id = $request->input("id");
        $token = $request->input("_token");
        $addedToCart = false; $itemCartId = null; $itemCartQty = 1;
        if($token != null){
            // check if the item has previously been added to cart
            $item_check = Cart::where('item_id', $id)->where('token', $token)->take(1)->get();
            if(count($item_check) > 0){
                $addedToCart = true;
                $itemCartId = $item_check[0]->id;
                $itemCartQty = $item_check[0]->qty;
            }
        }
        $food = FoodItem::findorfail($id);
        // get category and sub category data
        $category = Category::findorfail($food->category_id);
        if($food->sub_category_id != null){
            $sub_category = Subcategory::findorfail($food->sub_category_id);
            // get related food items based on sub category
            $relatedItems = FoodItem::where("category_id", $food->category_id)->where("sub_category_id", $food->sub_category_id)->where("id", "!=", $food->id)->orderByRaw("RAND()")->take(6)->get();
        }else{
            $sub_category = null;
            // get related food items based on category
            $relatedItems = FoodItem::where("category_id", $food->category_id)->where("id", "!=", $food->id)->orderByRaw("RAND()")->take(6)->get();
        }
        // get measurement details
        $measure = UnitMeasure::findorfail($food->unit_measure_id);
        $foodItem = ["item" => $food, "category" => $category, "subCategory" => $sub_category, "measure" => $measure];
        return json_encode([
            "foodItem" => $foodItem,
            "addedToCart" => $addedToCart,
            "itemCartId" => $itemCartId,
            "itemCartQty" => $itemCartQty,
            "relatedItems" => $relatedItems
        ]);
    }

    public function addItemToCart(Request $request){
        $item_id = $request->input('item_id');
        $qty = $request->input('qty');
        $token = $request->input('token');

        if($token !== null && $token !== "null"){
            // check for items in the cart with the same token
            // check if the current item has been added to the cart
            $item_check = Cart::where('token', $token)->where("item_id", $item_id)->take(1)->get();
            // find item
            $item_data = FoodItem::findorfail($item_id);
            // calculate item price with tax
            $item_total = $item_data->price * (int)$qty;
            $item_total = $item_total + ($item_total * $item_data->tax);
            // if item has not been added to the cart, add new item
            if(count($item_check) == 0){
                // add new item to cart
                $item = new Cart();
                // generate token
                // $token = "7488399300";
            }else{
               $item = Cart::find($item_check[0]->id);
            }
            // insert item into cart
            $item->token = $token;
            $item->item_id = $item_id;
            $item->qty = (int)$qty;
            $item->price = $item_data->price;
            $item->tax = $item_data->tax;
            $item->total = $item_total;
            if(Auth::user()){
                $item->user_id = Auth::user()->id;
            }
            $item->save();
        }else{

        }

        // fetch updated cart
        return $this->getCartItems($token);
    }

    // removeItemFromCart
    public function removeItemFromCart(Request $request){
        $item_id = $request->input('item_id');
        // find item from the cart
        $cart_item = Cart::findorfail($item_id);
        // get the cart token
        $token = $cart_item->token;
        // delete the item from cart
        $cart_item->forceDelete();
        // return the updated cart
        return $this->getCartItems($token);
    }

    public function getCartItemsData(Request $request){
        $token = $request->input("_token");
        return $this->getCartItems($token, false);
    }

    public function getCartItems($token, $auth_check = false){
        // check if cart items have been registered on the orders list
        $order_check = Order::where("cart_token", $token)->take(1)->get();

        $cart = Cart::where("token", $token)->orderBy("id", "DESC")->get();
        $cartItems = []; 
        $total = 0; $sub_total = 0;
        $tax = 0; $has_tax = false; 
        // $has_shipping_carge = true; $shipping_charge = 0; 

        foreach ($cart as $key => $item) {
            if($auth_check){
                // assign the items to a user if the user is signed in
                if(Auth() && $item->user_id == null){
                    $modItem = Cart::findorfail($item->id);
                    $modItem->user_id = Auth::user()->id;
                    $modItem->save();
                }
            }
            // search food
            $_item = FoodItem::findorfail($item->item_id);
            // get food item measurement unit
            $unit = UnitMeasure::find($_item->unit_measure_id);
            // compile a list of food items on the cart
            array_push($cartItems, ["foodItem" => $_item,
                                    "itemData" => $item, 
                                    "unit" => $unit
                                    ]);
            // calculate the food price
            $total += $item->total;
        }
        $sub_total = $total + $tax;
        // get more info about the cart
        $cartData = ["total" => $total,
                    "tax" => $tax,
                    "subTotal" => $sub_total, 
                    "token" => $token
                    ];
        
        if(count($order_check) > 0){
            return json_encode([
                "cart" => [],
                "cartData" => $cartData,
                "is_on_order_list" => true,
                'order_id' => $order_check[0]->id
            ]);
        }else{
            return json_encode([
                "cart" => $cartItems,
                "cartData" => $cartData,
                "is_on_order_list" => false
            ]);
        }
    }

    // checkout
    public function checkout(Request $request){
        $token = $request->input('q');
        // get cart content
        $cart = $this->getCartItems($token, true);
        $cart = json_decode($cart, true);
        $allCategories = Category::orderBy("category_name", "ASC")->get();

        // dd([
        //     "cartContent" => $cart,
        //     "cartToken" => $token,
        //     "navBarCatList" => $allCategories
        //     ]);
        return view("checkout")->with("params", [
            "cartContent" => $cart,
            "cartToken" => $token,
            "navBarCatList" => $allCategories
            ]);
    }

    // leaveMarket
    public function leaveMarket(Request $request){
        $token = $request->input('cart_token');
        $cart = Cart::where("token", $token)->orderBy("id", "DESC")->get();
        foreach ($cart as $key => $item) {
            $_item = Cart::findorfail($item->id);
            $_item->forceDelete();
        }

        return redirect("/home");
    }

    // genCartToken
    public function genCartToken(){
        return json_encode([
            "token" => Hash::make(Date('Ymdhisgia'))
        ]);
    }

    // initRepay
    public function initRepay(Request $request){
        $order_id = $request->input("order_id");

        $order = Order::findorfail($order_id);

        $request->request->add([
            '_token' => $request->input("_token"),            
            'cart_token' => $order->cart_token,
            'customer_name' => $order->customer_name,
            'customer_email' => $order->customer_email,
            'phone_no' => $order->phone_no,
            'country' => $order->country,
            'state' => $order->state,
            'lga' => $order->lga,
            'address' => $order->address,
        ]);

        return $this->submitCheckout($request);
    }

    // submitCheckout
    public function submitCheckout(Request $request){
        $token = $request->input('cart_token');
        $customer_name = $request->input('customer_name');
        $customer_email = $request->input('customer_email');
        $phone_no = $request->input('phone_no');
        $country = $request->input('country');
        $state = $request->input('state');
        $lga = $request->input('lga');
        $address = $request->input('address');
        $pay_on_delivery = $request->input('pay_on_delivery');

        // get cart items
        $cart_items = Cart::where("token", $token)->orderBy('id', 'DESC')->get();
        $cart = json_decode($this->getCartItems($token, false), true);
        $cartData = $cart['cartData'];

        if(count($cart_items) > 0){
            // dd($cartData);
            // check if the cart token has been used to place an order
            $order_check = Order::where("cart_token", $token)->where("payment_status", 1)->take(1)->get();
            if(count($order_check) == 0){
                $order_exists = Order::where("cart_token", $token)->take(1)->get();
                if(count($order_exists) == 0){
                    $order = new Order();
                }else{
                    $order = Order::find($order_exists[0]->id);
                }
                // place order
                
                $order->user_id = Auth::user()->id;
                $order->cart_token = $token;
                $order->customer_name = $request->input('customer_name');
                $order->customer_email = $request->input('customer_email');
                $order->phone_no = $request->input('phone_no');
                $order->country = $request->input('country');
                $order->state = $request->input('state');
                $order->lga = $request->input('lga');
                $order->address = $request->input('address');
                $order->shipping_fee = 0;
                $order->discount = 0;
                $order->cart_total = $cartData['subTotal'];
                $order->order_total = $cartData['subTotal'] + 0;
                if($pay_on_delivery == null){
                    $order->payment_method = "";
                }else{
                    $order->payment_method = "Pay on Delivery";
                }
                $order->payment_status = false;
                $order->delivery_method = "Home Delivery";
                $order->delivery_status_desc = "Processing Order";
                $order->delivery_status = false;
                $order->delivery_date = "";
                $order->save();

                if($pay_on_delivery == null){
                    $_token = $request->input("_token");
                    $request->request->add([
                        '_token' => $_token,
                        'email' => Auth::user()->email,
                        'amount' => ''.$order->order_total,
                        'payment_method' => 'card',
                        'description' => 'Payment for food items purchase',
                        'country' => 'NG',
                        'currency' => 'NGN',
                        'firstname' => $order->customer_name,
                        'lastname' => '',
                        'metadata' => '',
                        'phonenumber' => $order->phone_no,
                        // 'paymentplan' => '',
                        'ref' => $order->cart_token,
                        'logo' => 'https://cecelia.com.ng/img/cecelia-icon.png',
                        'title' => 'Cecelia Purchase',
                    ]);

                    //This initializes payment and redirects to the payment gateway
                    //The initialize method takes the parameter of the redirect URL
                    Rave::initialize(route('callback'));
                }else{
                    return redirect("/me/orders/".$order->id)->with("alert_success", "Your order has been received.\n
                    We will get in touch with you shortly to confirm your order.\nThank you for choosing Cecelia.");
                }
            }else{
                return redirect()->back();
            }
        }else{
            // this would cause a 404 error
            Cart::findorfail(0);
        }

    }


    private $rave_key = "FLWPUBK-8cf6b442f95e61aaf2865ed548ac2e00-X";
  
        /**
     * Initialize Rave payment process
     * @return void
     */
    public function initializeRave()
    {
        //This initializes payment and redirects to the payment gateway
        //The initialize method takes the parameter of the redirect URL
        Rave::initialize(route('callback'));
    }

    /**
     * Obtain Rave callback information
     * @return void
     */
    public function raveCallback()
    {

        $_data = Rave::verifyTransaction(request()->txref);
        $data = $_data->data;
        // dd($data);
        // Get the transaction from your DB using the transaction reference (txref)
        $order = Order::where("cart_token", $data->txref)->take(1)->get();
        if(count($order) == 0){
            // transaction not found
            // redirect user to an error page with message "Inavalid transaction"
            return redirect("/me/orders/")->with("alert_failure", "We are deeply sorry, but the order you are trying to 
            make payment for could not be found on our database.\nThank you for choosing Cecelia.");
        }else{
            $order = Order::find($order[0]->id);
            // Check if you have previously given value for the transaction. If you have, redirect to your successpage else, continue
            if($order->payment_status == 1){
                // redirect user to successful page
                return redirect("/me/orders/".$order->id)->with("alert_success", "Your order has been received and your payment was processed successfully.\n
                We will get in touch with you shortly to confirm your order.\nThank you for choosing Cecelia.");
            }else{
                // Comfirm that the transaction is successful
                if($data->status == "successful"){
                    // Confirm that the chargecode is 00 or 0
                    if($data->chargecode == "00" || $data->chargecode == "0"){
                        // Confirm that the currency on your db transaction is equal to the returned currency
                        if($data->currency == "NGN"){
                            // Confirm that the db transaction amount is equal to the returned amount
                            if($data->amount >= $order->order_total){
                                // Update the db transaction record (including parameters that didn't exist before the transaction is completed. for audit purpose)
                                // Give value for the transaction
                                // Update the transaction to note that you have given value for the transaction
                                // You can also redirect to your success page from here
                                $_order = Order::find($order->id);
                                $_order->payment_method = $data->paymenttype;
                                $_order->payment_status = true;
                                $_order->save();
                                // loop through all items on the cart and decrement the stock quantity
                                foreach ($order->cartItems as $key => $item) {
                                    // find food item
                                    $food = FoodItem::find($item->item_id);
                                    $food->stock_qty = (int)$food->stock_qty - (int)$item->qty;
                                    $food->save();
                                }

                                return redirect("/me/orders/".$order->id)->with("alert_success", "Your order has been received and your payment was processed successfully.\n
                                We will get in touch with you shortly to confirm your order.\nThank you for choosing Cecelia.");
                            }
                        }
                    }else{
                        // redirect to error page
                        return redirect("/me/orders/".$order->id)->with("alert_failure", "This is quite unfortunate, but we experienced and error while processing your payment.
                        \nKindly bear with us and give it another trial.\nThank you for choosing Cecelia.");
                    }
                }else{
                    // redirect user to error
                    return redirect("/me/orders/".$order->id)->with("alert_failure", "This is quite unfortunate, but we experienced and error while processing your payment.
                    \nKindly bear with us and give it another trial.\nThank you for choosing Cecelia.");
                }
            }
        }
    }
    
    // payWithFlutterWave
    private function payWithFlutterWave($order){ 
        $query = array(
            "PBFPubKey" => $this->rave_key,
            "txref" => $order->cart_token,
            "amount" => $order->order_total,
            "currency" => "NGN",
            "customer_email" => Auth::user()->email,
            "customer_phone" => $order->phone_no,
            "redirect_url" => "https://cardsxchange.net/api/wallet/fundWalletSuccess?user_id=".Auth::user()->id."&amt=$order->order_total&token_id=$order->id&token=$order->cart_token"
        );

        $data_string = json_encode($query);
        // 'https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/hosted/pay'
        $curl = $this->curl('/market/rave/pay', 'POST', $data_string);
        $result = json_decode($curl['response']);
        dd($result);
        // return redirect($result->data->link);

    }

    private function curl($url, $method, $data_string){
        
        $ch = curl_init($url);                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                              
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));

        $response = curl_exec($ch);

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        return [
            "response" => $response
        ];
    }


}
