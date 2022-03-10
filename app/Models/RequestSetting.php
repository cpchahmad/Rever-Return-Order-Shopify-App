<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestSetting extends Model
{
    public function setValidReturnDateAttribute($string)
    {
        $this->attributes['valid_return_date']=$string;
    }
}
