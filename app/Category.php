<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function subCategories(){
        return $this->hasMany('App\Subcategory', 'category_id', 'id')->orderBy('id', 'DESC');
    }
    
    public function foodItems(){
        return $this->hasMany('App\FoodItem', 'category_id', 'id')->orderBy('id', 'DESC');
    }
}
