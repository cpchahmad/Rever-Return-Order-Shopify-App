<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestCategory extends Model
{
    public function reasons()
    {
        return $this->hasMany(Reason::class,'category_id')->where('category_id',$this->id);
//        return $this->hasMany(Reason::class,'category_id' ,'id');
    }
}
