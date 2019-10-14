<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Subcategory;
use App\FoodItem;
use App\UnitMeasure;
use App\Cart;
use App\Order;
use App\User;
use App\Recipe;



class ConsoleController extends Controller
{
    // open console dashboard
    public function dashboard(){
        // get all categories
        $categories = Category::all();
        // get all users
        $users = User::all();
        // get food items
        $foodItems = FoodItem::all();
        // get all orders
        $orders = Order::all();
        // loop through to find pending and processed orders
        $pending = 0; $processed = 0;
        foreach ($orders as $key => $order) {
            if($order->delivery_status == false){
                $pending++;
            }else{
                $processed++;
            }
        }
        return view('console/dashboard')->with('params', [
            'categories' => $categories,
            'users' => $users,
            'foodItems' => $foodItems,
            'orders' => [
                "all" => count($orders),
                "pending" => $pending,
                "processed" => $processed
            ]
        ]);
    }

    // newRecipe
    public function newRecipe(Request $request){
        $title = $request->input("rec_title");
        $image = $request->input("rec_image");
        $steps = $request->input("rec_steps");

        // check if recipe already exists
        $r_check = Recipe::orderBy('id', 'DESC')->take(1)->get();
        if(count($r_check) == 0){
            $recipe = new Recipe();
        }else{
            $recipe = Recipe::find($r_check[0]->id);
        }

        $recipe->title = $title;
        $recipe->image_url = $image;
        $recipe->steps = nl2br($steps);
        $recipe->save();

        return redirect()->back()->with('alert_success', 'You have successfully added a new recipe for the week');
    }

    // getSubCat
    public function getSubCat(Request $request){
        $cat_id = $request->input('cat_id');
        $sub_cats = Subcategory::where('category_id', $cat_id)->orderBy('sub_category_name', 'ASC')->get();
        $response = '<select style="font-size: 18px;font-weight:800" name="sub_cat_id" class="transparent border-0 pad-0" required>';

        foreach ($sub_cats as $key => $sub_cat) {
            $response .=  '<option value="'.$sub_cat->id.'" >'.$sub_cat->sub_category_name.'</option>';
        }
        $response .= '</select>';
        return $response;
    }

    public function categories(Request $request){
        $q = $request->input('q');
        $input = $request->input();

        if($q != null){
            // search for food items
            $keywords = explode(" ", $q);
            $categories = Category::where(function($query) use($keywords){
                foreach ($keywords as $key => $keyword){
                    if($keyword != ''){
                        $query->where("category_name", 'LIKE', "%".$keyword."%")
                        ->orWhere("description", 'LIKE', "%".$keyword."%");
                    }
                }
            })->orderBy('category_name', 'ASC')->paginate(20);
        }else{
            $categories = Category::orderBy('category_name', 'ASC')->paginate(20);
        }
        $categories->appends($input);

        return view('console/categories')->with('params', [
            'categories' => $categories
        ]);
    }

    public function addCategory(Request $request){
        $name = $request->input('cat_name');
        $desc = $request->input('desc');
        $cover = $request->input('cover_image');
        if(strlen($cover) == 0){
            $cover = "";
        }
        // check if category exists
        $cat_check = Category::where('category_name', $name)->take(1)->get();
        if(count($cat_check) == 0){
            $cat = new Category();
            $cat->category_name = $name;
            $cat->description = $desc;
            $cat->cover_image = $cover;
            $cat->save();
            return redirect(route('console.categories'))->with('alert_success', 'You have added <strong>'.$name.'</strong> to the category list');
        }else {
            return redirect(route('console.categories'))->with('alert_failure', 'A category with the name <strong>'.$name.'</strong> already exists');
        }

    }

    public function openCategory($id){
        $cat = Category::findorfail($id);

        return view('console/categoryPage')->with('params', [
            "category" => $cat
        ]);
    }

    public function addSubCategory(Request $request){
        $cat_id = $request->input('cat_id');
        $name = $request->input('sub_cat_name');
        $desc = $request->input('desc');
        $cover = $request->input('cover_image');
        if(strlen($cover) == 0){
            $cover = "";
        }
        $sub_check = Subcategory::where('sub_category_name', $name)->where('category_id', $cat_id)->take(1)->get();
        if(count($sub_check) == 0){
            $subCat = new Subcategory();
            $subCat->category_id = $cat_id;
            $subCat->sub_category_name = $name;
            $subCat->description = $desc;
            $subCat->cover_image = $cover;
            $subCat->save();
            return redirect('/console/categories/'.$cat_id)->with('alert_success', 'Subcategory <strong>'.$name.'</strong> has been created');
        }else{
            return redirect('/console/categories/'.$cat_id)->with('alert_failure', 'Subcategory <strong>'.$name.'</strong> already exists');
        }
    }

    public function updateCategory(Request $request){
        $cat_id = $request->input('cat_id');
        $name = $request->input('cat_name');
        $desc = $request->input('desc');
        $cover = $request->input('cover_image');
        if(strlen($cover) == 0){
            $cover = "";
        }
        // check if category exists
        $cat = Category::findorfail($cat_id);
        $cat->category_name = $name;
        $cat->description = $desc;
        $cat->cover_image = $cover;
        $cat->save();
        return redirect('/console/categories/'.$cat_id)->with('alert_success', 'Changes have been applied');
    }

    public function deleteCategory(Request $request){
        $cat_id = $request->input('cat_id');

        // delete all sub categories related to the category
        $subCats = Subcategory::where('category_id', $cat_id)->get();
        foreach ($subCats as $key => $sub) {
            $subCat = Subcategory::find($sub->id);
            $subCat->forceDelete();
        }

        // delete all food items related to the category
        $foods = FoodItem::where('category_id', $cat_id)->get();
        foreach ($foods as $key => $food) {
            $foodItem = FoodItem::find($food->id);
            $foodItem->forceDelete();
        }

        // delete category

        $cat = Category::findorfail($cat_id);
        $catName = $cat->category_name;
        $cat->forceDelete();
        
        return redirect(route('console.categories'))->with('alert_success', 'You have successfully removed <strong>'.$catName.'</strong> from category list and all related data from the database');
    }

    public function openSubcategory($cat_name, $sub_cat_id){
        // get subcategory
        $subCat = Subcategory::findorfail($sub_cat_id);
        // get units
        $units = UnitMeasure::all();
        return view('console/subcategory')->with('params', [
            "sub_category" => $subCat,
            "units" => $units
        ]);
    }


    public function addFoodItem(Request $request){
        $sub_cat_id = $request->input("sub_cat_id");
        $item_name = $request->input("item_name");
        $item_image = $request->input("item_image");
        $item_desc = $request->input("item_desc");
        $price = $request->input("price");
        $tax = $request->input("tax");
        $unit = $request->input("unit");
        $stock = $request->input("stock");
        // get subcategory
        $subCat = Subcategory::findorfail($sub_cat_id);
        // check that the food item hasn't been added for the sub category
        $food_check = FoodItem::where("item_name", $item_name)->where("sub_category_id", $sub_cat_id)->take(1)->get();
        if(count($food_check) == 0){
            $food = new FoodItem();
            $food->category_id = $subCat->category->id;
            $food->sub_category_id = $sub_cat_id;
            $food->item_name = $item_name;
            $food->item_image = $item_image;
            $food->description = $item_desc;
            $food->price = floatval($price);
            $food->tax = $this->floatValue(($tax / 100));
            $food->unit_measure_id = $unit;
            $food->stock_qty = floatval($stock);
            $food->save();
            return redirect('/console/categories/'.$subCat->category->category_name.'/'.$subCat->id)->with('alert_success', 'The food item <b>'.$item_name.'</b> to the subcategory'); 
        }else{
            return redirect('/console/categories/'.$subCat->category->category_name.'/'.$subCat->id)->with('alert_failure', 'The food item <b>'.$item_name.'</b> already exists within the subcategory <b>'.$subCat->sub_category_name.'</b>');
        }
    }

    // inventoryManager
    public function inventoryManager(Request $request){
        $q = $request->input('q');
        $input = $request->input();

        if($q != null){
            // search for food items
            $keywords = explode(" ", $q);
            $foods = FoodItem::where(function($query) use($keywords){
                foreach ($keywords as $key => $keyword){
                    if($keyword != ''){
                        $query->where("item_name", 'LIKE', "%".$keyword."%")
                        ->orWhere("description", 'LIKE', "%".$keyword."%");
                    }
                }
            })->orderBy('item_name', 'ASC')->paginate(20);
        }else{
            // get food items
            $foods = FoodItem::orderBy("item_name", "ASC")->paginate(20);
        }
        $foods->appends($input);
        // get units
        $units = UnitMeasure::all();

        return view('/console/inventoryManager')->with('params', [
            "foodItems" => $foods,
            "units" => $units
        ]);
    }

    // inventoryManagerItem
    public function inventoryManagerItem($item_id){
        $food = FoodItem::findorfail($item_id);
        // get units
        $units = UnitMeasure::all();
        $cats = Category::all();

        return view('console/inventoryItem')->with('params', [
            "foodItem" => $food,
            "units" => $units,
            "categeories" => $cats
        ]);
    }

    // updateInventoryItem
    public function  updateInventoryItem(Request $request){
        $item_id = $request->input('item_id');
        $item_name= $request->input('item_name');
        $item_image= $request->input('item_image');
        $unit_id = $request->input('unit_id');
        $item_price = $request->input('item_price');
        $item_tax = $request->input('item_tax');
        $cat_id = $request->input('cat_id');
        $sub_cat_id = $request->input('sub_cat_id');
        $stock_qty = $request->input('stock_qty');

        $foodItem = FoodItem::findorfail($item_id);

        $foodItem->item_name = $item_name;
        $foodItem->item_image = $item_image;
        $foodItem->category_id = $cat_id;
        $foodItem->sub_category_id = $sub_cat_id;
        $foodItem->price = $this->floatValue($item_price);
        $foodItem->tax = $this->floatValue(($item_tax / 100));
        $foodItem->stock_qty = $stock_qty;
        $foodItem->unit_measure_id = $unit_id;
        $foodItem->save();

        return redirect('/console/inventory/'.$item_id)->with(
            'alert_success',
            'Changes have been applied'
        );
    }

    public function floatValue($val){
        $val = str_replace(",",".",$val);
        $val = preg_replace('/\.(?=.*\.)/', '', $val);
        return floatval($val);
    }

    // orderManager
    public function orderManager(Request $request){
        $input = $request->input();
        $q = $request->input('q');
        if($q != null){
            // search for food items
            $keywords = explode(" ", $q);
            $orders = Order::where(function($query) use($keywords){
                foreach ($keywords as $key => $keyword){
                    if($keyword != ''){
                        $query->where("cart_token", 'LIKE', "%".$keyword."%")
                        ->orWhere("customer_name", 'LIKE', "%".$keyword."%")
                        ->orWhere("customer_email", 'LIKE', "%".$keyword."%")
                        ->orWhere("phone_no", 'LIKE', "%".$keyword."%");
                    }
                }
            })->orderBy('id', 'DESC')->paginate(20);
        }else{
            // get food items
            $orders = Order::orderBy("id", "DESC")->paginate(20);
        }
        $orders->appends($input);

        return view('/console/orderManager')->with('params', [
            "orders" => $orders
        ]);
    }

    // openOrder
    public function openOrder($id){
        // get order
        $order = Order::findorfail($id);
        
        return view('/console/orderPage')->with('params', [
            "order" => $order
        ]);
    }

    // updateDeliveryStatus
    public function updateDeliveryStatus(Request $request){
        $order_id = $request->input('order_id');
        $del_status = $request->input('del_status');
        $del_status_desc = $request->input('del_status_desc');

        $order = Order::findorfail($order_id);
        $order->delivery_status = $del_status;
        if($del_status == 0){
            $order->delivery_status_desc = $del_status_desc;
        }else{
            $order->delivery_status_desc = "Order has been fulfiled";
        }
        $order->save();

        return redirect('/console/orders/'.$order_id)->with('alert_success', 'Changes have been applied');
    }

    // newMeasureUnit
    public function newMeasureUnit(Request $request){
        $unit_name = $request->input('unit_name');
        // check if unit already exists
        $unit_check = UnitMeasure::where('name', $unit_name)->take(1)->get();
        if(count($unit_check) == 0){
            $unit = new UnitMeasure();
            $unit->name = $unit_name;
            $unit->symbol = "";
            $unit->description = "";
            $unit->save();
            return redirect()->back()->with('alert_success', 'You have successfully added a new Unit Measurement');
        }else{
            return redirect()->back()->with('alert_failure', 'Failed to add new Unit Measurement');
        }
    }

    public function userManager(Request $request){
        $input = $request->input();
        $users = User::orderBy("name", "ASC")->paginate(20);
        $users->appends($input);
        return view("console/userManager")->with("params", [
            "users" => $users
        ]);
    }

    public function modUser(Request $request){
        $id = $request->input('user_id');
        $user = User::findorfail($id);
        if($user->isAdmin()){
            $user->permission = "700";
        }else{
            $user->permission = "755";
        }

        $user->save();
        return redirect("/console/users/$id")->with("alert_success", "User's details have been updated successfully");
    }

    public function userPage($id){
        $user = User::findorfail($id);

        return view("console/userPage")->with("params", [
            "user" => $user
        ]);
    }
}
