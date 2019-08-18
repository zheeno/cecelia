<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    
    public function cartItems(){
        return $this->hasMany('App\Cart', 'token', 'cart_token')->orderBy('id', 'DESC');
    }
    
    public function user(){
        return $this->belongsTo('App\User');
    }
    
}
