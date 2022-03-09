<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RefundMethodController extends Controller
{
    public function ReturnDetails(){
        $shop = Auth::user();
        $settings=Setting::where('shop_id', $shop->id)->first();
        return view('settings.confirmation-slip')->with([
            'settings'=>$settings,
            'title'=> "Confirmation",
            'sub_title' => 'confirmation_slip'
        ]);

    }

    public function ReturnDetailsSave(Request $request){

        $shop = Auth::user();
        $settings=$this->has_Settings();


        if($settings == null){
            $save_settings=new Setting();

            $save_settings->shop_id=$shop->id;
            $save_settings->label_subject=$request->input('subject');
            $save_settings->label_message=$request->input('message');
//                $save_settings->seller_instruction=$request->input('seller_instruction');
            $save_settings->save();

            return back();

        }else{

            $settings->label_subject=$request->input('subject');
            $settings->label_message=$request->input('message');
            $settings->save();

            return back();
        }

    }
}
