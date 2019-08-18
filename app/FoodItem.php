<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodItem extends Model
{
   
    public function category(){
        return $this->belongsTo('App\Category');
    }

    public function subcategory(){
        return $this->belongsTo('App\Subcategory', 'sub_category_id', 'id');
    }

    public function unit(){
        return $this->belongsTo('App\UnitMeasure', 'unit_measure_id', 'id');
    }

    public function cartItems(){
        // holds a list all entries of the selected food item
        // which is in all users carts 
        return $this->hasMany('App\Cart', 'item_id', 'id')->orderBy('id', 'DESC');
    }
}
