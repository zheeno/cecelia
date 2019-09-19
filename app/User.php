<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function orders(){
        return $this->hasMany('App\Order', 'user_id')->orderBy('id', 'DESC');
    }
    public function pendingOrders(){
        return $this->hasMany('App\Order', 'user_id')->where('delivery_status', false)->orderBy('id', 'DESC');
    }
    
    // for middlewares
    public function isAdmin(){
        if($this->permission == '755'){
            return true;
        }else{
            return false;
        }
    }
}
