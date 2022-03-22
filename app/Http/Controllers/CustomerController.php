<?php

namespace App\Http\Controllers;

use App\Models\ItemSession;
use App\Models\Order;
use App\Models\OrderLineProduct;
use App\Models\Payment;
use App\Models\PortalContent;
use App\Models\PortalDesign;
use App\Models\PreviousRequest;
use App\Models\Reason;
use App\Models\ReasonsDataSet;
use App\Models\RefundTypes;
use App\Models\RequestCategory;
use App\Models\RequestExchange;
use App\Models\RequestProducts;
use App\Models\RequestSetting;
use App\Models\RequestShippingAddress;
use App\Models\RequestStatus;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{


    public function __construct()
    {

        try {
            $request = \Illuminate\Support\Facades\Request::all();
            $order_name = '#' . preg_replace("/[^0-9]/", "", $request['order_name']);
            $order_email = $request['email'];

            $shop_name = $request['shop'];
            $shop = User::where('name', $shop_name)->first();
//            $settings = Setting::where('shop_id', $shop->id)->first();
            // $order = Order::where([
            //     'order_name' => $order_name,
            //     'email' => $order_email,
            //     'shop_id' => $shop->id
            // ])->first();
            // if ($order) {
            //     $session = App\ItemSession::where('order_id', $order->id)->first();
            //     Session::put('items', collect(json_decode($session->session, true)));
            // }
        } catch (\Exception $exception) {

        }

    }

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


                if(!in_array(str_replace('#','US',$login_check->order_name),$exchange_orders) && RequestExchange::where('order_id',$login_check->order_id)->exists())
                {


                    return view('customer.no-exchange')->render();
                }


                $login_check_json = json_decode($login_check->order_json);




//                if ($r_settings->exclude_non_us_order == true && $login_check_json->shipping_address->country_code !== 'US') {
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
                $requests = \App\Models\Request::where('order_id', $order->id)->cursor();

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


                    $line_product = OrderLineProduct::where('product_id', $line->product_id)->first();

                    if ($line_product === null) {
                        $product_detail = $shop->api()->rest('GET', '/admin/products/' . $lineItem->product_id . '.json')['body']['product'];
                        $product_detail = json_decode(json_encode($product_detail), FALSE);
                        $order_line_product = OrderLineProduct::where('product_id', $lineItem['product_id'])->first();
                        if ($order_line_product === null) {
                            $order_line_product = new OrderLineProduct();
                            $order_line_product->product_id = $lineItem['product_id'];
                            $order_line_product->shop_id = $shop->id;

                            $order_line_product->product_json = json_encode($product_detail);
                            $order_line_product->save();
                        }

                    }
                    $line_product = OrderLineProduct::where('product_id', $line->product_id)->first();
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

                   ;
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




                $requests = \App\Models\Request::where([
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

            dd($exception);
            return back();
        }
    }


    public function confirmRequest(Request $request)
    {

        $r_request=null;
        try {


            $order = Order::where([
                'order_name' => '#' . str_replace('US', '', $request->order_name),
                'email' => $request->email
            ])->first();


            if ($this->checkCustomerBlock($order->email, $order->shop_id)) {
                return view('customer.block')->render();
            }
            $lines = collect(json_decode($order->order_json)->line_items);

            $shop = $order->shop_id;
            $settings = Setting::where('shop_id', $shop)->first();
            $request_settings = RequestSetting::where('shop_id', $shop)->first();

            $r_details = json_decode($request->input('product'));



            $order_detail = json_decode($order->order_json);

            $line_items = $order_detail->line_items;
            $total_amount = 0;
//        if ($this->checkCustomerBlock($order->email, $shop)) {
//            return view('customer.block')->with([
//                'order' => $order,
//                'design' => $design,
//                'settings' => $settings,
//                'back' => null,
//                'new_request' => http_build_query(array(
//                    'shop' => $shop,
//                    'order' => $order->order_name,
//                    'email' => $order->email
//                ))
//            ])->render();
////            return response()->json($html);
//        }
            $return_product_amount = [];
//        dd(Session::all());
//        foreach ($r_details as $r_product) {
//
//            foreach ($line_items as $item) {
//                if ($r_product->id == $item->id) {
//                    $item_price = $item->price;
//                    $r_quantity = (int)$r_product->quantity;
//                    $return_product_amount[$item->id] = $item_price * $r_quantity;
//                    $total_amount += $return_product_amount[$item->id];
//                }
//            }
//        }
//        $amount_json = json_encode($return_product_amount);
            $exchange_items = [];
            $products = [];


            foreach (Session::get('items') as $singleItem) {
                if ($singleItem['return_type'] === 'exchange') {
                    $product = OrderLineProduct::where('product_id', $singleItem['product_id'])->first();
                    $product = json_decode($product->product_json);
                    $discount_allocations = $lines->whereIn('id', $singleItem['id'])->first();
                    $t_disc = 0;
                    if ($discount_allocations !== null) {
                        $discount_allocations = $discount_allocations->discount_allocations;
                        foreach ($discount_allocations as $disc) {
                            $t_disc += floatval($disc->amount);
                        }
                    }
                    foreach ($product->variants as $var) {
                        if ($var->id == $singleItem['exchange_variant_id']) {
                            $total_amount -= (floatval($var->price) - $t_disc) * $singleItem['quantity'];
                            $total_amount += floatval($singleItem['price']) * $singleItem['quantity'];
                        }
                    }

                } else {
                    $total_amount += floatval($singleItem['price']);

                }



                $its['id'] = intval($singleItem['id']);
                $its['quantity'] = $singleItem['quantity'];
                $its['reason'] = $singleItem['quantity'];
                $its['return_type'] = $singleItem['return_type'];
                $reason = ReasonsDataSet::find($singleItem['return_reason']);



                if($reason==null)
                {
                    $reason=ReasonsDataSet::first();

                }
                $its['return_type'] = $reason->name;




                if (isset($singleItem['exchange_variant_id']) && $singleItem['exchange_variant_id']) {
                    $its['exchange_item'] = $singleItem['exchange_variant_id'];
                }

                array_push($products, $its);
                $product_price[intval($singleItem['id'])] = floatval($singleItem['price']);
            }



            $r_request = new \App\Models\Request();
            $r_request->shop_id = $shop;
            $r_request->order_id = $order->id;
            if ($request_settings && $request_settings->auto_approval == true) {
                $r_request->status = 1;
            } else {
                $r_request->status = 0;
            }

            $r_request->product = json_encode($products);
//        $r_request->addition_information = $request->input('additional_information');
            $r_request->product_prices = json_encode($product_price);
            $r_request->request_amount = $total_amount;
            $payment_ids = Payment::first();
            $r_request->payment_id = json_encode($payment_ids);
            $r_request->return_product_image = $request->input('image');
            $r_request->items_json = json_encode(Session::get('items'));
            $r_request->save();


            $status = new RequestStatus();
            $status->request_id = $r_request->id;
            $status->request_id = $r_request->id;
            $status->status = 0;
            $status->save();
            if ($request_settings && $request_settings->auto_approval == true) {
                $status->status = 1;
                $status->save();
            }


//        app('app\Http\Controllers\OrdersController')->EmailTemplate();

            $rq_order = new OrderController();
//            $rq_order->EmailTemplate($r_request);
            $order_product_image_data = json_decode($order->products_json);


//            $qr_code_path = QrCode::format('png')
//                ->size(150)
//                ->generate("$r_request->id-$order->order_name", public_path() . "/qrcodes/$r_request->id-" . str_replace("#", '', $order->order_name) . ".png");
//            $r_request->qr_code = "/qrcodes/$r_request->id-" . str_replace("#", '', $order->order_name) . ".png";
            $r_request->save();

            // Save Pdf

            $shop_detail = User::where('id', $shop)->first();


//            $pdf = $pdf->loadView('pdf', [
//                "settings" => $settings,
//                "order" => $order,
//                "request" => $r_request,
//                'shop_details' => $shop_detail
//
//            ])->save(public_path() . '/request_pdf/' . str_replace("#", '', $order->order_name) . '_' . $r_request->id . '_file.pdf');
//            $r_request->request_pdf = '/request_pdf/' . str_replace("#", '', $order->order_name) . '_' . $r_request->id . '_file.pdf';
            $r_request->save();

            //Save Request Products


            if ($order_detail->shipping_address !== null) {
                $shipping_address = $order_detail->shipping_address;
                $ship=RequestShippingAddress::where('request_id',$r_request->id)->first();
                if($ship===null)
                {
                    $ship = new RequestShippingAddress();
                }
                $ship->request_id = $r_request->id;
                $ship->first_name = $shipping_address->first_name;
                $ship->last_name = $shipping_address->last_name;
                $ship->address1 = $shipping_address->address1;
                $ship->phone = $shipping_address->phone;
                $ship->city = $shipping_address->city;
                $ship->zip = $shipping_address->zip;
                $ship->province = $shipping_address->province;
                $ship->country = $shipping_address->country;
                $ship->save();
            }

            foreach (Session::get('items') as $r_items) {
                $request_product = new RequestProducts();
                $item_price = $r_items['price'];
                $r_quantity = (int)$r_items['quantity'];
                $return_product_amount = $item_price * $r_quantity;

                $request_product->line_item_id = $r_items['id'];
                $request_product->variant_id = $r_items['variant_id'];
                $request_product->product_id = $r_items['product_id'];
                $request_product->product_name = $r_items['title'];
                $request_product->return_type = $r_items['return_type'];
                $request_product->reason = ReasonsDataSet::find($r_items['return_reason'])->name;
                $request_product->shop_id = $shop;
                $request_product->order_id = $order->order_name;
                $request_product->request_id = $r_request->id;
                $product = OrderLineProduct::where('product_id', $r_items['product_id'])->first();
                $product = json_decode($product->product_json);
                foreach ($product->variants as $vr) {
                    if ($vr->id == $r_items['variant_id']) {
                        $request_product->product_sku = $vr->sku;
                    }
                }

                $request_product->product_quantity = $r_quantity;
                $request_product->return_amount = $return_product_amount;

                foreach ($order_product_image_data as $image) {
                    if ($image->id == $r_items['variant_id']) {
                        if ($image->id != null) {
                            $request_product->product_image = $image->image;
                        } else {
                            $request_product->product_image = "Not";
                        }
                    }
                }
                $request_product->save();
            }


            if (Session::has('items')) {
                Session::forget('items');
                $session = ItemSession::where('order_id', $order->id)->first();
                if ($session) {
                    $session->delete();
                }
            }

            $order_ = new OrderController();
            $order_->EmailTemplate($r_request);
            $easy = new EasyPostController();
            $easy->createShipment($r_request->id, $order->id);
            return redirect(proxy(route('request.labeling', $r_request->id)));
        } catch (\Exception $exception) {
            return redirect(proxy(route('request.labeling', $r_request->id)));
        } finally {
            return redirect(proxy(route('request.labeling', $r_request->id)));
        }
    }


    public function updateAddress($id,Request $request)
    {
        $ship=RequestShippingAddress::find($id);
        $ship->first_name = $request->first_name;
        $ship->last_name = $request->last_name;
        $ship->address1 = $request->address;
        $ship->phone = $request->phone;
        $ship->city = $request->city;
        $ship->zip = $request->zip;
        $ship->province = $request->state;
        $ship->country = $request->country;
        $ship->save();
        return response()->json($ship);
    }


    public function Labeling($request_id)
    {
        $r_request = \App\Models\Request::find($request_id);


        $order = Order::find($r_request->order_id);

        $items = json_decode($r_request->items_json, true);

        $lines = collect(json_decode($order->order_json)->line_items);

        $exchange_items = [];
        foreach ($items as $item) {
            if ($item['return_type'] == "exchange") {
                $product = OrderLineProduct::where('product_id', $item['product_id'])->first();
                $product = json_decode($product->product_json);
                $discount_allocations = $lines->whereIn('id', $item['id'])->first();
                $t_disc = 0;
                if ($discount_allocations !== null) {
                    $discount_allocations = $discount_allocations->discount_allocations;
                    foreach ($discount_allocations as $disc) {
                        $t_disc += floatval($disc->amount);
                    }
                }

                foreach ($product->variants as $variant) {
                    if ($variant->id == $item['exchange_variant_id']) {
                        $it['title'] = $product->title;
                        $it['price'] = $variant->price - $t_disc;
                        $it['options'] = [];
                        array_push($it['options'], $variant->option1);
                        array_push($it['options'], $variant->option2);
                        array_push($it['options'], $variant->option3);
//                        if ($variant->option1) {
//                            array_push($it['options'], $variant->option1);
//                        }
//                        if ($variant->option2) {
//                            array_push($it['options'], $variant->option2);
//                        }
//                        if ($variant->option3) {
//                            array_push($it['options'], $variant->option3);
//                        }
                        foreach ($product->images as $image) {
                            if ($image->id == $variant->image_id)
                                $it['image'] = $image->src;
                        }
                        if (!isset($it['image']))
                            $it['image'] = $product->image->src;
                    }
                }
                array_push($exchange_items, $it);
            }
        }
        if (Session::has('items'))
            Session::forget('items');
        $label_date = $r_request->request_labels;
        if ($label_date == null) {
            $label_date = Carbon::createFromTimeString($r_request->created_at)->addDays(30)->toFormattedDateString();
        } else {
            $label_date = Carbon::createFromTimeString($label_date->created_at)->addDays(30)->toFormattedDateString();
        }

//        dd($label_date);
        return view('customer.confirm_request')->with([
            'items' => $items,
            'exchange_items' => $exchange_items,
            'shop' => $r_request->shop_id,
            'order' => $order,
            'date' => $label_date,
            'user' => User::find($order->shop_id),
            'request' => $r_request
        ]);
    }

    public function addToSelection($order_id, $line_id, Request $request)
    {
        try {
            $order = Order::find($order_id);

            if ($this->checkCustomerBlock($order->email, $order->shop_id)) {
                return view('customer.block')->render();
            }
            $r_settings = RequestSetting::where('shop_id', $order->shop_id)->first();

            $lines = json_decode($order->order_json);
            $lines = $lines->line_items;

            foreach ($lines as $line) {

                if ($line_id == $line->id) {
                    $data = array();
                    $data['id'] = $line_id;
                    $data['order_id'] = $order_id;
                    $data['variant_id'] = $line->variant_id;
                    $data['title'] = $line->title;
                    $data['quantity'] = $line->quantity;
                    $data['options'] = [];
                    $data['product_id'] = $line->product_id;
                    $data['price'] = $line->price;

                    if (count($line->discount_allocations)) {
                        foreach ($line->discount_allocations as $disc) {
                            $data['price'] -= floatval($disc->amount);
                        }
                    }
                    $color_options = [];
                    $line_product = OrderLineProduct::where('product_id', $line->product_id)->first();
                    $line_product = json_decode($line_product->product_json);
                    $product_tags = explode(',', str_replace(' ', '', $line_product->tags));
                    $allow_methods = [];

                    $exchange_product_tags = explode(',', $r_settings->exchange_product_tags);
                    $payment_product_tags = explode(',', $r_settings->payment_product_tags);
                    $store_product_tags = explode(',', $r_settings->store_product_tags);
//                    foreach (explode($product_tags,',') as $tag) {
//                        if()
//                    }
//                    dd($exchange_product_tags);
                    if (count(array_intersect($exchange_product_tags, $product_tags))) {
                        array_push($allow_methods, 'exchange');
                    }
                    if (count(array_intersect($payment_product_tags, $product_tags))) {
                        array_push($allow_methods, 'payment_method');
                    }
                    if (count(array_intersect($store_product_tags, $product_tags))) {
                        array_push($allow_methods, 'store_credit');
                    }

                    if (count($allow_methods) == 0) {

                        $allow_methods = ['exchange', 'payment_method', 'store_credit'];
                    }

                    $product_options = $line_product->options;

                    $variants = [];
                    $color_variants = [];
                    if (count($product_options)) {

                        $color_options = $product_options[0]->values;
                    }


                    foreach ($line_product->variants as $variant) {
                        if ($variant->id == $line->variant_id) {
                            array_push($data['options'], $variant->option1);
                            array_push($data['options'], $variant->option2);
                            array_push($data['options'], $variant->option3);
                            $v['id'] = $variant->id;
                            $v['id'] = $variant->id;
                            array_push($variants, $v);
                            $src = null;

                        }
                        if (count($color_options)) {
                            foreach ($color_options as $color_option) {
                                if ($variant->option1 == $color_option) {
                                    foreach ($line_product->images as $Image) {
                                        if ($variant->image_id == $Image->id) {
                                            array_push($color_variants, [
                                                'variant_id' => $variant->id,
                                                'color' => $variant->option1,
                                                'image' => $Image->src
                                            ]);
                                        }
                                    }
                                }

                            }
                        }
                    }
                    $temp = [];
                    $datas = [];
                    foreach ($color_variants as $col_v) {

                        if (count($datas) > 0) {
                            if (!in_array($col_v['color'], $datas)) {
                                array_push($temp, $col_v);
                                array_push($datas, $col_v['color']);

                            }
                        } else {
                            array_push($temp, $col_v);
                            array_push($datas, $col_v['color']);

                        }
                    }
                    $color_variants = $temp;

                    $image_id = null;
                    foreach ($line_product->variants as $single_variant) {
                        if ($single_variant->id == $data['variant_id'])
                            $image_id = $single_variant->image_id;
                    }
                    foreach (json_decode($order->line_images, true) as $im) {
                        if ($im['line_id'] == $line->id) {
                            $data['image'] = $im['image'];
                        }

                    }
                }
            }


//        if ($request->session()->has('items')) {
//            $cart = $request->session()->get('items', collect([]));
//            foreach ($cart as $item)
//            {
//                if ($item['id']==$line_id)
//                {
////                    return redirect()->back();
//                    return view('customer.return_popup')->with([
//                        'shop'=>$order->has_shop,
//                        'order'=>$order,
//                        'line_item'=>$data
//                    ]);
//                }
//            }
//            $cart->push($data);
//        } else {
//            $cart = collect([$data]);
//            $request->session()->put('items', $cart);
//        }

//        $new_col=[];

//        foreach ($color_variants as $color_variant)
//        {
//            foreach ($color_variants as $key=>$col_)
//            {
//                if($col_['color']==$color_variant['color'])
//                {
//                    unset($color_variants[$key]);
//                }
//            }
//        }

            $color_variants = array_unique($color_variants, SORT_REGULAR);

            label:
            $temp = [];
            foreach ($color_variants as $color) {
                array_push($temp, $color);
            }
            $color_variants = $temp;
            for ($i = 0; $i < count($color_variants); $i++) {
                for ($j = $i + 1; $j < count($color_variants); $j++) {
                    if ($color_variants[$i]['color'] == $color_variants[$j]['color']) {
                        unset($color_variants[$i]);
                        goto label;
                    }
                }
            }
            $exchange_reasons = RequestCategory::where('name', 'Exchange')->first();
            $refund_reasons = RequestCategory::where('name', 'Refund')->first();



            return view('customer.return_popup')->with([
                'shop' => $order->has_shop,
                'order' => $order,
                'line_item' => $data,
                'exchange_reasons' => $exchange_reasons->reasons,
                'refund_reasons' => $refund_reasons->reasons,
                'product_options' => $product_options,
                'color_variants' => $color_variants,
                'allow_methods' => $allow_methods
            ]);
        } catch (\Exception $exception) {
            return redirect()->back();
        }

    }


    public function removeItem($order_id, $id)
    {
        $items = Session::get('items');


        try {

            Session::forget('items');
            if ($items == null) {
                $sess = ItemSession::where('order_id', $order_id)->first();
                $items = json_decode($sess->session, true);
            }
            $its = [];
            foreach ($items as $key => $item) {
                if ($item['id'] != $id) {
                    array_push($its, $item);
                }
            }
            Session::put('items', collect($its));
            $itemSession = ItemSession::where('order_id', $order_id)->first();
            if ($itemSession === null) {
                $itemSession = new ItemSession();
                $itemSession->order_id = $order_id;
            }
            $itemSession->session = json_encode(collect($its));
            $itemSession->save();
            return redirect()->back();

        } catch (\Exception $exception) {
            Session::put('items', collect($items));
            return redirect()->back();
        }
    }


    public function addToSelectionSubmit($order_id, $line_id, Request $request)
    {
        $order = Order::find($order_id);
        try {
            if ($this->checkCustomerBlock($order->email, $order->shop_id)) {
                return view('customer.block')->render();
            }
            $lines = json_decode($order->order_json);
            $lines = $lines->line_items;
            foreach ($lines as $line) {
                if ($line_id == $line->id) {
                    $data = array();
                    $data['id'] = $line_id;
                    $data['order_id'] = $order_id;
                    $data['variant_id'] = $line->variant_id;
                    $data['title'] = $line->title;
                    $data['quantity'] = $line->quantity;
                    $data['options'] = [];
                    $data['exchange_options'] = [];
                    $data['product_id'] = $line->product_id;
                    $data['price'] = $line->price * $line->quantity;
                    $data['return_type'] = $request->return_type;
                    $data['return_reason'] = $request->return_reason;
                    if (count($line->discount_allocations)) {
                        foreach ($line->discount_allocations as $disc) {
                            $data['price'] -= floatval($disc->amount);
                        }
                    }
                    if ($request->return_type == 'exchange') {
                        $data['exchange_variant_id'] = json_decode(json_encode($this->checkVariantStock($request)), true)['original']['variant_id'];
                        if ($request->input('option1'))
                            array_push($data['exchange_options'], $request->option1);
                        if ($request->input('option2'))
                            array_push($data['exchange_options'], $request->option2);
                        if ($request->input('option3'))
                            array_push($data['exchange_options'], $request->option3);

                    }
                    if ($request->input('refund')) {
                        $data['return_type'] = $request->input('refund');
                    }

                    $line_product = OrderLineProduct::where('product_id', $line->product_id)->first();
                    $line_product = json_decode($line_product->product_json);

                    foreach ($line_product->variants as $variant) {
                        if ($variant->id == $line->variant_id) {
                            array_push($data['options'], $variant->option1);
                            array_push($data['options'], $variant->option2);
                            array_push($data['options'], $variant->option3);
                            foreach ($line_product->images as $image) {
                                if ($image->id == $variant->image_id)
                                    $data['image'] = $image->src;
                            }
                        }

                    }

//                dd($line_product);

                }
            }
            $session = ItemSession::where('order_id', $order->id)->first();
            if ($session) {
                Session::put('items', collect(json_decode($session->session, true)));
            }

            if ($request->session()->has('items') && count($request->session()->get('items'))) {
                $cart = $request->session()->get('items', collect([]));
                foreach ($cart as $item) {
                    if ($item['id'] == $line_id) {
                        goto redirect;
                    }
                }
                $cart->push($data);
            } else {
                $cart = collect([$data]);
                $request->session()->put('items', $cart);
            }
            $itemSession = ItemSession::where('order_id', $order->id)->first();
            if ($itemSession === null) {
                $itemSession = new ItemSession();
                $itemSession->order_id = $order->id;
            }
            $itemSession->session = json_encode(Session::get('items'));
            $itemSession->save();
        } catch (\Exception $exception) {

            goto redirect;
        }
        redirect:
        $user = User::find($order->shop_id);
        $order_name = str_replace('#', '', $order->order_name);
        return redirect(proxy(route('customer.login.post', ['shop' => $user->name, 'order_name' => $order_name, 'email' => $order->email])));
    }


    public function appendRefund(Request $request)
    {
        $amount = $request->amount;
        $allowed_methods = explode(',', $request->allow_methods);
        return view('customer.append_refund_method')->with([
            'amount' => $amount,
            'allowed_methods' => $allowed_methods
        ])->render();
    }


    public function checkVariantStock(Request $request)
    {
        $option1 = $request->option1;
        $option2 = $request->option2;
        $product_id = $request->product_id;
        $quantity = $request->quantity;
        $product = OrderLineProduct::where('product_id', $product_id)->first();
        $product = json_decode($product->product_json);
        foreach ($product->variants as $variant) {
            if ($variant->option1 && $variant->option2) {
                if ($variant->option1 == $option1 && $variant->option2 == $option2) {
                    if ($variant->inventory_quantity >= $quantity) {
                        return response()->json([
                            'stat' => 'found',
                            'variant_id' => $variant->id,
                            'stock' => $variant->inventory_quantity
                        ]);
                    } else {
                        return response()->json([
                            'stat' => 'out of stock',
                            'variant_id' => $variant->id,
                            'stock' => $variant->inventory_quantity
                        ]);
                    }
                }
            } else {
                return response()->json([
                    'stat' => 'not found',
                    'variant_id' => $variant->id
                ]);
            }
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


    public function itemsSelectedSubmit(Request $request)
    {
        $order = Order::where([
            'order_name' => '#' . str_replace('US', '', $request->order_name),
            'email' => $request->email
        ])->first();
        try {
            if ($this->checkCustomerBlock($order->email, $order->shop_id)) {
                return view('customer.block')->render();
            }
            $items = Session::get('items');
            $exchange_items = [];
            $lines = collect(json_decode($order->order_json)->line_items);
            foreach ($items as $item) {
                if ($item['return_type'] == "exchange") {
                    $product = OrderLineProduct::where('product_id', $item['product_id'])->first();
                    $product = json_decode($product->product_json);
                    $discount_allocations = $lines->whereIn('id', $item['id'])->first();
                    $t_disc = 0;
                    if ($discount_allocations !== null) {
                        $discount_allocations = $discount_allocations->discount_allocations;
                        foreach ($discount_allocations as $disc) {
                            $t_disc += floatval($disc->amount);
                        }
                    }
//                    $line_discount
                    foreach ($product->variants as $variant) {
                        if ($variant->id == $item['exchange_variant_id']) {
                            $it['title'] = $item['title'];
                            $it['price'] = ($variant->price - $t_disc) * $item['quantity'];
                            $it['options'] = [];
                            if ($variant->option1) {
                                array_push($it['options'], $variant->option1);
                            }
                            if ($variant->option2) {
                                array_push($it['options'], $variant->option2);
                            }
                            if ($variant->option3) {
                                array_push($it['options'], $variant->option3);
                            }
                            foreach ($product->images as $image) {
                                if ($image->id == $variant->image_id)
                                    $it['image'] = $image->src;
                            }
                            if (!isset($it['image']))
                                $it['image'] = $product->image->src;

                        }
                    }
                    $it['exchange_options'] = $item['exchange_options'];
                    array_push($exchange_items, $it);
                }
            }
            if (count($items) == 0)
                return back();
            return view('customer.review_items')->with([
                'items' => $items,
                'exchange_items' => $exchange_items,
                'shop' => $request->shop,
                'order' => $order,
                'user' => User::find($order->shop_id)
            ]);
        } catch (\Exception $exception) {
            dd($exception);
            $user = User::find($order->shop_id);
            $order_name = str_replace('#', '', $order->order_name);
            return redirect(proxy(route('customer.login.post', ['shop' => $user->name, 'order_name' => $order_name, 'email' => $order->email])));
        }
    }


}
