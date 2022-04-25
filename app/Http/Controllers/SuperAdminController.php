<?php

namespace App\Http\Controllers;

use App\Models\EasyPost;
use App\Models\ItemSession;
use App\Models\Order;
use App\Models\OrderChecks;
use App\Models\OrderLineProduct;
use App\Models\PortalContent;
use App\Models\PortalDesign;
use App\Models\PreviousRequest;
use App\Models\Reason;
use App\Models\RefundTypes;
use App\Models\RequestDraftOrder;
use App\Models\RequestExchange;
use App\Models\RequestExport;
use App\Models\RequestGiftCard;
use App\Models\RequestLabel;
use App\Models\RequestProducts;
use App\Models\RequestRefund;
use App\Models\RequestSetting;
use App\Models\RequestShippingAddress;
use App\Models\RequestStatus;
use App\Models\Setting;
use App\Models\Timeline;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminController extends Controller
{
//Super Admin logout
    public function logout(){

        Auth::logout();
        return redirect('/admin');
    }

//Super Admin View
    public function index(){
        $user=User::where('is_admin','0')->get();
        return view('admin.index',compact('user'));

    }


    public function ShopUninstallJob($shop){
        $orders=Order::where('shop_id',$shop->id)->get();
        foreach ($orders as $order){

            ItemSession::where('order_id',$order->id)->delete();

        }
        OrderLineProduct::where('shop_id',$shop->id)->delete();
        Order::where('shop_id',$shop->id)->delete();
        OrderChecks::where('shop_id',$shop->id)->delete();
        $requests= \App\Models\Request::where('shop_id',$shop->id)->get();

        foreach ($requests as $request){

            RequestStatus::where('request_id',$request->id)->delete();
            RequestShippingAddress::where('request_id',$request->id)->delete();
            RequestRefund::where('request_id',$request->id)->delete();
            RequestLabel::where('request_id',$request->id)->delete();
            RequestGiftCard::where('request_id',$request->id)->delete();
            RequestExchange::where('request_id',$request->id)->delete();
            RequestDraftOrder::where('request_id',$request->id)->delete();
            Timeline::where('request_id',$request->id)->delete();

            Request::where('id',$request->id)->delete();



        }


        Reason::where('shop_id',$shop->id)->delete();
        RequestProducts::where('shop_id',$shop->id)->delete();
        RequestSetting::where('shop_id',$shop->id)->delete();
        RefundTypes::where('shop_id',$shop->id)->delete();
        RequestExport::where('shop_id',$shop->id)->delete();
        PreviousRequest::where('shop_id',$shop->id)->delete();
        PortalDesign::where('shop_id',$shop->id)->delete();
        PortalContent::where('shop_id',$shop->id)->delete();
        EasyPost::where('shop_id',$shop->id)->delete();
        Setting::where('shop_id',$shop->id)->delete();
        User::where('id',$shop->id)->forceDelete();

    }
}
