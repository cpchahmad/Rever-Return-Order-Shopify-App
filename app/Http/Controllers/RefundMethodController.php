<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RefundMethodController extends Controller
{

/*    public function index(){
        $shopfy = Auth::user();
        $shop_detail=User::where('id',$shopfy->id)->first();
        return view('settings.refund-list')->with([
            'refunds'=> Payment::where('shop_id', $shopfy->id)->get(),
            'edit_refund'=> "",
            'title' => "Method",
            'sub_title' => 'custom_method',
            'shop_details'=>$shop_detail
        ]);
    }

    public function AddRefund(Request $request){
        $shopfy = Auth::user();
        $status=$request->input('status');
        if($status=="update"){
            $edit_payment=Payment::where('id',$request->input('refund_id'))
                ->where('shop_id',$shopfy->id)
                ->update([
                    'name'=>$request->input('name'),
                    'description'=> $request->input('description'),
                    'price' =>   $request->input('price')
                ]);
            return redirect()->route('orders.refund.list');

        }else{
            $refund = new Payment();
            $refund->name=$request->input('name');
            $refund->description = $request->input('description');
            $refund->price = $request->input('price');
            $refund->shop_id = $shopfy->id;
            $refund->save();
            return redirect()->back();
        }

    }*/


    //function of view of Settings/Return Label/Mail
    public function ReturnDetails(){
        $shop = Auth::user();
        $settings=Setting::where('shop_id', $shop->id)->first();
        return view('settings.confirmation-slip')->with([
            'settings'=>$settings,
            'title'=> "Confirmation",
            'sub_title' => 'confirmation_slip'
        ]);

    }

    //function for saving Return Label/Mail content
    public function ReturnDetailsSave(Request $request){

        $shop = Auth::user();
        $settings=$this->has_Settings();

        if($settings == null){
            $save_settings=new Setting();

            $save_settings->shop_id=$shop->id;
            $save_settings->label_subject=$request->input('subject');
            $save_settings->label_message=$request->input('message');

            $save_settings->save();

            return back();

        }else{

            $settings->label_subject=$request->input('subject');
            $settings->label_message=$request->input('message');
            $settings->save();

             return back();
        }
    }


    //General function
    public function has_settings()
    {
        $shopfy = Auth::user();
        $has_settings = Setting::where('shop_id', $shopfy->id)->first();
        return $has_settings;
    }

/*    //    Edit Refund
    public function EditRefund($id){
        $shopfy = Auth::user();
        $shop_details=User::where('id', $shopfy->id)->first();
        $edit_payment= Payment::where([
            'id'=>$id,
            'shop_id' => $shopfy->id,
        ])->first();
        return view('settings.refund-list')->with([
            'refunds'=> Payment::where('shop_id', $shopfy->id)->get(),
            'edit_refund'=>$edit_payment,
            'shop_details'=>$shop_details
        ]);


    }

    //    Delete Refund
    public function DeleteRefund($id){
        $shopfy = Auth::user();

        $delete_resson=Payment::where('shop_id',$shopfy->id)
            ->where('id',$id)
            ->delete();
        return redirect()->route('orders.refund.list');
    }*/
}
