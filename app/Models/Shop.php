<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shop extends Model
{
    use SoftDeletes;


    public function has_orders(){
        return $this->hasMany('App\Models\Order');
    }
    public function has_setting(){
        return $this->belongsTo('App\Models\Setting');
    }
}
