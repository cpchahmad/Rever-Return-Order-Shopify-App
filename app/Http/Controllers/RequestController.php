<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\RequestExchange;
use App\Models\RequestProducts;
use App\Models\RequestSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{

    public function DeclineRequestDeletion()
    {
        $shop = Auth::user();

        $request_setting = RequestSetting::where('shop_id', $shop->id)->first();
        return view('settings.request-decline')->with([
            'r_settings' => $request_setting,
            'title' => 'General',
            'sub_title' => 'keeping'
        ]);

    }

    public function DeclineRequestDeletionSave(Request $request)
    {

        $shop = Auth::user();
        $request_setting = RequestSetting::where('shop_id', $shop->id)->first();
        $request_decline = $request->input('decline');
        $request_finished = $request->input('finished');


        if ($request_setting == null) {
            $request_setting = new RequestSetting();
            if ($request_decline == '0') {

                $request_setting->decline_status = $request_decline;

            } else {
                $request_setting->decline_status = $request_decline;
                $request_setting->decline_month = $request->input('decline-time');
            }
            if ($request_finished == '0') {

                $request_setting->finish_status = $request_finished;

            } else {
                $request_setting->finish_status = $request_finished;
                $request_setting->finish_month = $request->input('finished-time');
            }
            if ($request->input('auto_approval') && $request->input('auto_approval') == 1) {
                $request_setting->auto_approval = $request->auto_approval;
            } else {
                $request_setting->auto_approval = 0;
            }
            if ($request->input('exclude_non_us_order') && $request->input('exclude_non_us_order') == 1) {
                $request_setting->exclude_non_us_order = $request->exclude_non_us_order;
            } else {
                $request_setting->exclude_non_us_order = 0;
            }

            $request_setting->shop_id = $shop->id;
            $request_setting->save();

        } else {
            if ($request->input('auto_approval') && $request->input('auto_approval') == 1) {
                $request_setting->auto_approval = $request->auto_approval;
            } else {
                $request_setting->auto_approval = 0;
            }
            if ($request->input('exclude_non_us_order') && $request->input('exclude_non_us_order') == 1) {
                $request_setting->exclude_non_us_order = $request->exclude_non_us_order;
            } else {
                $request_setting->exclude_non_us_order = 0;
            }
            if ($request_decline == '0') {

                $request_setting->decline_status = $request_decline;

            } else {
                $request_setting->decline_status = $request_decline;
                $request_setting->decline_month = $request->input('decline-time');
            }
            if ($request_finished == '0') {

                $request_setting->finish_status = $request_finished;

            } else {
                $request_setting->finish_status = $request_finished;
                $request_setting->finish_month = $request->input('finished-time');
            }

            $request_setting->save();

        }
        return back();
    }


    //function used to show Settings/General/ Request Policy page
    public function RequestPolicy()
    {
        $r_settings = RequestSetting::where('shop_id', Auth::id())->first();

        return view('settings.request_policy')->with([
            'r_settings' => $r_settings
        ]);
    }

    //function used to save Request Policy page data
    public function RequestPolicyUpdate(Request $request)
    {

        $r_settings = RequestSetting::where('shop_id', Auth::id())->first();

        if ($r_settings === null) {
            $r_settings = new RequestSetting();
        }
        $r_settings->return_able_text = $request->input('return_able_text');
        $r_settings->valid_return_date = $request->input('valid_return_date');

        if ($request->input('noreturn_enabled')) {
            $r_settings->display_block_product = $request->input('noreturn_enabled');
        } else {
            $r_settings->display_block_product = false;
        }

        if ($request->input('special_orders')) {
            $r_settings->special_orders = $request->input('special_orders');
        } else {
            $r_settings->special_orders = false;
        }
        if ($request->input('exclude_orders')) {
            $r_settings->exclude_orders = $request->input('exclude_orders');
        } else {
            $r_settings->exclude_orders = null;
        }
        if ($request->input('exchange_orders')) {
            $r_settings->exchange_orders = $request->input('exchange_orders');
        } else {
            $r_settings->exchange_orders = null;
        }

        $r_settings->shop_id=Auth::id();
        $r_settings->save();
        return back();
    }


    //function used to show decline request
    public function DeclineRequests()
    {
        $shop = Auth::user();

        $decline_request = \App\Models\Request::where('shop_id', $shop->id)
            ->where('status', 4)->cursor();
        return view('settings.decline-requests')->with([
            'decline_request' => $decline_request
        ]);

    }



    public function SearchRequest(Request $request)
    {


        $key = strtolower($request->id);
        $key = str_replace('us', '', $key);
        $current_status = $request->input('statics');
        $criteria = $request->input('criteria');
        $shop = Auth::user();
        $order_ids = Order::where('shop_id', $shop->id)->where(function ($query) use ($key) {
            $query->orWhere('order_name', 'like', '%' . $key . '%');
            $query->orWhere('email', 'like', '%' . $key . '%');
        })->pluck('id');
        if ($criteria != 5) {
            $requests = \App\Models\Request::where('shop_id', $shop->id)
                ->whereIn('order_id', $order_ids)->get();
        } else {
            $requests = \App\Models\Request::whereIn('order_id', $order_ids)->get();
        }
        $methods = Payment::where('shop_id', $shop->id)->cursor();
        return view('append_requests')->with([
            'requests' => $requests,
            'methods' => $methods,
            'current_status' => $current_status
        ])->render();
    }

//Delete Decine request
    public function DeleteRequestDelete($id)
    {
        $shop = Auth::user();


        try {
            $delete_request_product = RequestProducts::where('request_id', $id)->delete();
            $exchange_prod=RequestExchange::where('request_id',$id)->delete();
            $decline_request = \App\Models\Request::where('shop_id', $shop->id)
                ->where('id', $id)->delete();
        }catch (\Exception $exception)
        {
            return redirect()->route('dashboard');
        }
        return redirect()->route('dashboard');

    }

    public function DeclineRequestDelete($id)
    {
        $shop = Auth::user();


        try {
//            $delete_request_product = RequestProducts::where('request_id', $id)->delete();
//            $exchange_prod=RequestExchange::where('request_id',$id)->delete();
            $decline_request = \App\Models\Request::where('shop_id', $shop->id)
                ->where('id', $id)->first();

            $decline_request->status=4;
            $decline_request->save();
        }catch (\Exception $exception)
        {
            return redirect()->route('dashboard');
        }
        return redirect()->route('dashboard');

    }

//Change Request Item Status
    public function changeRequestItem($id,$item_id)
    {
        $request=\App\Models\Request::find($id);

        $requestProduct=RequestProducts::where([
            'request_id'=>$id,
            'line_item_id'=>$item_id
        ])->first();

        if ($request && $requestProduct)
        {
            if ($requestProduct->return_type=='payment_method')
            {
                $requestProduct->return_type='store_credit';
            }elseif($requestProduct->return_type=='store_credit')
            {
                $requestProduct->return_type='payment_method';

            }
            $requestProduct->save();
            $itemJson=json_decode($request->items_json,true);

            $itemJs=[];
            foreach ($itemJson as $item)
            {
                if (isset($item['return_type']) && $item['id']==$item_id && $item['return_type']=='payment_method')
                {
                    $item['return_type']='store_credit';
                }elseif(isset($item['return_type']) && $item['id']==$item_id && $item['return_type']=='store_credit')
                {

                    $item['return_type']='payment_method';
                }
                array_push($itemJs,$item);
            }
            $request->items_json=json_encode($itemJs);
            $request->save();
        }

        return back();
    }



//Customer login check
    public function customerlogin(Request $request){
        $url=$request->shopurl;
        $shopurl=$url;
        $disallowed = array('http://', 'https://');
        foreach($disallowed as $d) {
            if(strpos($url, $d) === 0) {
                $shopurl= str_replace($d, '', $url);
            }
        }
        $shopurl=explode('/',$shopurl);

        return redirect('/authenticate?shop='.$shopurl[0]);

    }


    //Customer logout
    public function customerlogout(Request $request) {
        Auth::logout();
        return redirect('/shop-login');
    }
}
