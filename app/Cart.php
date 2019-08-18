<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    
    public function FoodItem(){
        return $this->belongsTo('App\FoodItem', 'item_id', 'id');
    }

    public function order(){
        return $this->belongsTo('App\Order', 'token', 'cart_token');
    }

    
}
