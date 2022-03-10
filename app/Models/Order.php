<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;


    public function has_shop(){
        return $this->belongsTo('App\Models\User', 'shop_id');
    }

    public function has_requests(){
        return $this->hasMany('App\Models\Request');
    }
    public function getOrderNameAttribute($value)
    {
        return str_replace('#',$this->prefix,$value);
    }
}
