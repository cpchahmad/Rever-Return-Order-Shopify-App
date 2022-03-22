<?php

namespace App\Http\Controllers;

use App\Models\EasyPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HelperController extends Controller
{
    public function getapikey($shop_id){

        $shop=Auth::user();

        $easypost = EasyPost::where('shop_id',$shop->id)->first();

        if ($easypost)
            \EasyPost\EasyPost::setApiKey($easypost->api_key);
        return $easypost;


    }
}
