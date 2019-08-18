<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnitMeasure extends Model
{
    //
    public function foodItems(){
        return $this->hasMany('App\FoodItem', 'unit_measure_id', 'id')->orderBy('id', 'DESC');
    }
}
