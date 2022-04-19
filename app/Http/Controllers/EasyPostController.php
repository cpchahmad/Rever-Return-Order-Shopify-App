<?php

namespace App\Http\Controllers;

use App\Models\EasyPost;
use App\Models\Order;
use App\Models\RequestExchange;
use App\Models\RequestLabel;
use EasyPost\Address;
use EasyPost\CustomsInfo;
use EasyPost\CustomsItem;
use EasyPost\Parcel;
use EasyPost\Shipment;
use App\Models\Setting;
use App\Models\Timeline;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EasyPostController extends Controller
{

//General Function
    public function __construct()
    {
        $this->helper=new HelperController();
    }

//View of sencloud in settinngs tab
    public function index()
    {
        $shopfy = Auth::user();
        $easypost =  EasyPost::where('shop_id',$shopfy->id)->first();
        return view('settings.easypost')->with([
            'easy_post' => $easypost
        ]);
    }

//Function for updating Logistics information
    public function update(Request $request)
    {
        $shopfy = Auth::user();
        $easypost = EasyPost::where('shop_id',$shopfy->id)->first();
        if ($easypost == null) {
            $easypost = new EasyPost();
        }
        $easypost->name = $request->name;
        $easypost->country = $request->country;
        $easypost->street1 = $request->street1;
        $easypost->city = $request->city;
        $easypost->state = $request->state;
        $easypost->zip = $request->zip;
        $easypost->phone = $request->phone;
        $easypost->api_key = $request->api_key;
        $easypost->api_secretkey = $request->api_secretkey;
        $easypost->shop_id=$shopfy->id;
        $easypost->save();
        return redirect()->back();
    }


    //function for sending label by email
    public function resendLabel($id)
    {
        $request=\App\Models\Request::find($id);
        $label=RequestLabel::where('request_id',$id)->orderBy('created_at','desc')->first();

        $this->sendMail($label,$request);
        return back();
    }

    //Email General function
    public function sendMail($label,$request)
    {
        $settings = Setting::where('shop_id', $request->shop_id)->first();
        $easypost = EasyPost::where('shop_id', $request->shop_id)->first();

        $requests=\App\Models\Request::where('id',$request->id)->where('shop_id',$request->shop_id)->first();

        $order = Order::where('shop_id',$request->shop_id)->where('id', $request->order_id)->first();
        $email=$order->email;
        if ($settings->sender_email !== null && $settings->sender_name) {

            $mail=Mail::send('emails.label', ['easypost'=>$easypost,'requests'=>$requests,'label' => $label, 'settings' => $settings, 'request' => $request->id, 'name' => str_replace('#', 'US', $order->order_name)], function ($m) use ($label,$request, $settings, $email,$order) {
                $m->from($settings->sender_email, $settings->sender_name);
                $m->attach($label->label, [
                    'as' => $label->tracking_code
                ]);
                $m->to($email)->subject(($settings->label_subject) ? $settings->label_subject . ' Order US' . str_replace('#', '', $order->order_name) . ' - Request No#'.$request->id.' ' : 'Return Label for Order US' . str_replace('#', '', $order->order_name) . ' - Request No#1');
            });
            $l= RequestLabel::find($label->id);
            $l->email_sent=true;
            $l->save();
        } else {

            flash('Email Credentials Not Found!')->error();
        }
    }


    //function for manual exchange
    public function manualExchange($id)
    {
        $re=\App\Models\Request::find($id);
        $order_ = new OrderController();
        if (count($re->request_products()->where('return_type', 'exchange')->get())) {

            $request_exchange = $order_->create_draft($re->id, $re->order_id, $re->request_products()->where('return_type', 'Exchange')->pluck('line_item_id'), 'Store Credit');

            if ($request_exchange !== null) {
                $exchange = RequestExchange::where('request_id', $re->id)->first();
                $request_exchange = $order_->complete_draft($exchange->draft_order_id);
                try {
                    $order=Auth::user()->api()->rest('GET','/admin/orders/'.$exchange->order_id.'.json');
                    if (isset($order['body']['order']))
                    {
                        $order=json_decode(json_encode($order['body']['order']),FALSE);
                        $message = new Timeline();
                        $message->message = 'Exchange Order Created: '.$order->name;
                        $message->request_id = $id;
                        $message->save();
                        file_put_contents('EasyPostException.txt',json_encode($message));
                    }
                }catch (\Exception $exception)
                {
                    file_put_contents('EasyPostException.txt',json_encode($exception));
                }

            }
        }
        return back();
    }

//Function used when we create shipping label
    public function createShipment($request_id,$order_id,$shop_id)
    {

        $r_request=\App\Models\Request::find($request_id);

        $easypost=EasyPost::where('shop_id',$r_request->shop_id)->first();

        $connection = new \Picqer\Carriers\SendCloud\Connection($easypost->api_key,$easypost->api_secretkey );
        $sendcloudClient = new \Picqer\Carriers\SendCloud\SendCloud($connection);

        $et= $sendcloudClient->shippingMethods()->all();
        $et=$et[0]->id;
        $order = Order::find($order_id);


        $order = json_decode($order->order_json);

        $parcel = $sendcloudClient->parcels();

        $parcel->shipment=$et; // Shipping method, get possibilities from $sendCloud->shippingMethods()->all()

        $parcel->name =$order->shipping_address->first_name . ' ' . $order->shipping_address->last_name;
        $parcel->company_name = $order->shipping_address->company;
        $parcel->address =$order->shipping_address->address1;
        $parcel->city = $order->shipping_address->city;
        $parcel->postal_code =$order->shipping_address->zip;
        $parcel->country = $order->shipping_address->country_code;

        $parcel->order_number = $order->name;



        $parcel->requestShipment = true; // Specifically needed to create a shipment after adding the parcel

        try {
            $parcel->save();

            $label=RequestLabel::where('request_id',$request_id)->first();
            if($label==null)
                $label=new RequestLabel();
            $label->tracking_code=$parcel->tracking_number;
            $label->parcel_id=$parcel->id;
            $label->destination=$order->shipping_address->country_code;
            $label->zip=$order->shipping_address->zip;
            $label->tracking_url=$parcel->tracking_url;
            $label->carrier=$parcel->carrier['code'];

            $label->request_id=$request_id;
            $label->order_id=$order_id;
            $parcel = $sendcloudClient->parcels()->find($parcel->id);
            $labelUrl = $parcel->getPrimaryLabelUrl();
            $documentDownloader = new \Picqer\Carriers\SendCloud\DocumentDownloader($connection);
            $labelContents = $documentDownloader->getDocument($labelUrl, 'pdf');
            $label_name = time().'_label.pdf';
            $label->label=asset('label/'.$label_name);
            $label->save();
            Storage::disk('public')->put('label/'.$label_name,$labelContents);

            $this->sendMail($label,$r_request);

            return redirect()->back();
        } catch (SendCloudApiException $e) {
            throw new Exception($e->getMessage());
        }
    }

}
