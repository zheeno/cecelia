<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    public function category(){
        return $this->belongsTo('App\Category');
    }
    
    public function foodItems(){
        return $this->hasMany('App\FoodItem', 'sub_category_id', 'id')->orderBy('id', 'DESC');
    }
}
