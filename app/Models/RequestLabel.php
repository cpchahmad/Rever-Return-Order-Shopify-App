<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestLabel extends Model
{
    use HasFactory;

    public function has_request()
    {
        return $this->belongsTo(Request::class,'request_id');
    }
}
