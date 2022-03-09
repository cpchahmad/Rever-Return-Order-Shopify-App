<?php

namespace App\Http\Controllers;

use App\Models\PortalContent;
use App\Models\PortalDesign;
use App\Models\PreviousRequest;
use App\Models\Reason;
use App\Models\RefundTypes;
use App\Models\RequestSetting;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function create_block()
    {
        $shop = Auth::user();
        $settings = Setting::where('shop_id', $shop->id)->first();
        return view('settings.customer_block')->with([
            'settings' => $settings
        ]);
    }

    public function update_block(Request $request)
    {
        $shop = Auth::user();

        $has_settings = Setting::where('shop_id', $shop->id)->first();
        if ($has_settings == null) {
            $settings_save = new Setting();
            $settings_save->shop_id = $shop->id;
            $settings_save->block_customers = $request->input('block_tags');
            $settings_save->save();
            return back();


        } else {

            $has_settings->block_customers = $request->input('block_tags');
            $has_settings->save();
            return back();
        }
    }


    public function loginshow(Request $request)
    {


//        $domain='centricwear.myshopify.com';
        $domain='teststoreintegrate.myshopify.com';
        if (Auth::check()) {
            return redirect()->route('analytics');
        }

        if ($domain != null) {

            $shop = User::where('name', $domain)->first();
            if ($shop == null) {

                return view('errors.404');
            }

        } else {
            return view('errors.404');

        }


        $content = PortalContent::where('shop_id', $shop->id)
            ->orderby('id', 'desc')
            ->first();
        $design = PortalDesign::where('shop_id', $shop->id)
            ->first();
        $has_settings = Setting::where('shop_id', $shop->id)->first();



        return view('customer.login')->with([
            'domain' => $shop->name,
            'settings' => $has_settings,
            'content' => $content,
            'design' => $design,
            'error'=>$request->input('error')
        ])->render();
//        }

        // return view('customer.login')->with([
        //          'domain' => $shop->shopify_domain,
        //          'settings' => $has_settings,
        //          'content'=>$content,
        //          'design'=>$design
        //      ]);
        return response($html)->withHeaders(['Content-Type' => 'application/liquid']);


    }


    public function login(Request $request)
    {
        try {
            $order_name = '#' . preg_replace("/[^0-9]/", "", $request->input('order_name'));
            $prev=str_replace('#','US',$order_name);
            $shop_name = $request->input('shop');

            $prev=PreviousRequest::where('order_number',$prev)->first();

            if ($prev!==null)
            {
                return view('customer.request_block')->render();
            }

            $order_email = $request->input('email');
            $shop = User::where('name', $shop_name)->first();


            if ($this->checkCustomerBlock($order_email, $shop->id)) {
                return view('customer.block')->render();
            }
            $settings = Setting::where('shop_id', $shop->id)->first();
            $r_settings = RequestSetting::where('shop_id', $shop->id)->first();
            $login_check = Order::where([
                'order_name' => $order_name,
                'email' => $order_email,
                'shop_id' => $shop->id
            ])->first();

            $special_orders=explode(',',$r_settings->special_orders);
            $exclude_orders=explode(',',$r_settings->exclude_orders);
            $exchange_orders=explode(',',$r_settings->exchange_orders);


            if ($login_check !== null) {

                if(!in_array(str_replace('#','US',$login_check->order_name),$exchange_orders) && App\RequestExchange::where('order_id',$login_check->order_id)->exists())
                {
                    return view('customer.no-exchange')->render();
                }

                $login_check_json = json_decode($login_check->order_json);

                if ($r_settings->exclude_non_us_order == true && $login_check_json->shipping_address->country_code !== 'US') {
                    return back();
                }
                $design = PortalDesign::where('shop_id', $shop->id)
                    ->first();


                $order = Order::where([
                    'order_name' => $order_name,
                    'shop_id' => $shop->id
                ])->first();
                $r_items = [];
                $request_ids = [];
                $requests = App\Request::where('order_id', $order->id)->cursor();
                foreach ($requests as $re) {
                    $req_items = json_decode($re->items_json, true);
                    foreach ($req_items as $its) {
                        array_push($r_items, $its['id']);
                        $request_ids[$its['id']] = $re->id;
                    }

                }

                //dd($req_items);

                $lines = json_decode($order->order_json);
                $order_json = $lines;
                $lines = $lines->line_items;
                $line_items = [];

                foreach ($lines as $key => $line) {
                    $lineItem['id'] = $line->id;
                    $lineItem['variant_id'] = $line->variant_id;
                    $lineItem['title'] = $line->title;
                    $lineItem['quantity'] = $line->quantity;
                    $lineItem['product_id'] = $line->product_id;
                    $lineItem['price'] = $line->price * $line->quantity;
                    if (count($line->discount_allocations)) {
                        foreach ($line->discount_allocations as $disc) {
                            $lineItem['price'] -= floatval($disc->amount);
                        }
                    }
                    $line_product = App\OrderLineProduct::where('product_id', $line->product_id)->first();
                    if ($line_product === null) {
                        $product_detail = $shop->api()->rest('GET', '/admin/products/' . $lineItem->product_id . '.json')['body']['product'];
                        $product_detail = json_decode(json_encode($product_detail), FALSE);
                        $order_line_product = App\OrderLineProduct::where('product_id', $lineItem['product_id'])->first();
                        if ($order_line_product === null) {
                            $order_line_product = new App\OrderLineProduct();
                            $order_line_product->product_id = $lineItem['product_id'];
                            $order_line_product->shop_id = $shop->id;

                            $order_line_product->product_json = json_encode($product_detail);
                            $order_line_product->save();
                        }

                    }
                    $line_product = App\OrderLineProduct::where('product_id', $line->product_id)->first();
                    $line_product = json_decode($line_product->product_json);
//                dd($line_product);

                    foreach (json_decode($order->line_images, true) as $im) {
                        if ($im['line_id'] == $line->id) {
                            $lineItem['image'] = $im['image'];
                        }

                    }
                    if (!isset($line_product->tags)) {
                        $line_product = $line_product->body->product;
                    }

                    $tags = $line_product->tags;
                    $product_tags = explode(',', str_replace(' ', '', $tags));
                    $excludes = explode(',', $settings->block_products);

                    foreach ($excludes as $exclude) {
                        if (in_array($exclude, $product_tags)) {
                            $lineItem['blocked'] = true;
                            goto quit;
                        } else
                            $lineItem['blocked'] = false;
                    }
                    quit:
                    if (in_array($line->id, $r_items)) {
                        $lineItem['unavailable'] = true;
                        $lineItem['request_id'] = $request_ids[$line->id];
                    } else {
                        $lineItem['unavailable'] = false;
                    }
                    foreach ($line_product->variants as $variant) {
                        if ($variant->id == $line->variant_id) {
                            $lineItem['options'] = [];
                            if ($variant->option1)
                                array_push($lineItem['options'], $variant->option1);
                            if ($variant->option2)
                                array_push($lineItem['options'], $variant->option2);
                            if ($variant->option3)
                                array_push($lineItem['options'], $variant->option3);
                        }
                    }
                    array_push($line_items, $lineItem);
                }


                $requests = \App\Request::where([
                    'shop_id' => $shop->id,
                    'order_id' => $order->id
                ])->where('status', '!=', 4)->orderBy('id', 'DESC')->cursor();


                $back["shop_domain"] = $shop->shopify_domain;
                if ($this->checkCustomerBlock($order_email, $shop->id)) {
                    $html = view('customer.block')->with([
                        'order' => $order,
                        'requests' => $requests,
                        'design' => $design,
                        'settings' => $settings,
                        'back' => $back,
                        'new_request' => http_build_query(array(
                            'shop' => $shop->id,
                            'order' => $order->order_name,
                            'email' => $order->email
                        ))
                    ])->render();
                    return $html;

                }
                $date = Carbon::createFromDate($order_json->created_at);

                if ($r_settings !== null && $r_settings->valid_return_date !== null) {
                    $date = $date->addDays($r_settings->valid_return_date);

                } else {

                    $date = $date->addDays(30)->format('Y-m-d');
                }
//                if()
                $returnable = true;
                if ($date->lessThan(Carbon::today())) {
                    $returnable = false;
                }
                if (!$returnable && in_array(str_replace('#','US',$order->order_name),$special_orders))
                {
                    $returnable = true;
                }
                if (in_array(str_replace('#','US',$order->order_name),$exclude_orders))
                {
                    $returnable = false;
                }
                //dd(Session::get('items'));
                $date = $date->englishMonth . ' ' . $date->day . ', ' . $date->year;

                $html = view('customer.request-details')->with([
                    'order' => $order,
                    'requests' => $requests,
                    'line_items' => $line_items,
                    'requests' => $requests,
                    'returnable' => $returnable,
                    'design' => $design,
                    'settings' => $settings,
                    'r_settings' => $r_settings,
                    'date' => $date,
                    'back' => $back,
                    'new_request' => http_build_query(array(
                        'shop' => $shop->id,
                        'order' => $order->order_name,
                        'email' => $order->email
                    ))

                ])->render();

                return $html;
                $result = [];
                $result['code'] = '200';
                $result['data'] = $html;

                return response()->json($result);

            } else {

                return redirect(proxy(route('home',['error'=>'incorrect'])));
            }


        } catch (\Exception $exception) {

            return back();
        }
    }



    public function checkCustomerBlock($email, $shop_id)
    {
//        dd($email,$shop_id);
        $has_settings = Setting::where('shop_id', $shop_id)->first();
        if ($has_settings != null) {
            foreach (explode(',', $has_settings->block_customers) as $cust) {
                if ($email == $cust)
                    return true;
            }
            return false;
        } else
            return false;
    }



}
