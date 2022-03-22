<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{
    use HasFactory;


    protected $fillable = [
        'name', 'category_id', 'shop_id', 'reason_type', 'status',
    ];


    public function has_skus(){

        return $this->hasMany('App\Models\RequestProducts','reason','name');
    }
    public function category()
    {
        return $this->belongsTo(RequestCategory::class,'category_id');
    }
}
