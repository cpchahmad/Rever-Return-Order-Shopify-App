<?php

namespace App\Http\Controllers;

use App\Models\EasyPost;
use App\Models\Order;
use App\Models\RequestExchange;
use App\Models\RequestLabel;

use App\Models\Setting;
use App\Models\Timeline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class EasyPostController extends Controller
{
    public function index()
    {
        $shopfy = Auth::user();
        $easypost =  EasyPost::where('shop_id',$shopfy->id)->first();
        return view('settings.easypost')->with([
            'easy_post' => $easypost
        ]);
    }


    public function update(Request $request)
    {

        $shopfy = Auth::user();
        $easypost = EasyPost::where('shop_id',$shopfy->id)->first();
        if ($easypost == null) {
            $easypost = new EasyPost();
        }
        $easypost->name = $request->name;
        $easypost->street1 = $request->street1;
        $easypost->city = $request->city;
        $easypost->state = $request->state;
        $easypost->zip = $request->zip;
        $easypost->phone = $request->phone;
        $easypost->api_key = $request->api_key;
        $easypost->shop_id=$shopfy->id;
        $easypost->save();
        return redirect()->back();
    }

    public function resendLabel($id)
    {

        $request=\App\Models\Request::find($id);
        $label=RequestLabel::where('request_id',$id)->orderBy('created_at','desc')->first();
        $this->sendMail($label,$request);
        return back();
    }

    public function sendMail($label,$request)
    {
        $settings = Setting::where('shop_id', $request->shop_id)->first();
        $order = Order::where('id', $request->order_id)->first();
        $email=$order->email;
        if ($settings->sender_email !== null && $settings->sender_name) {

            $mail=Mail::send('emails.label', ['label' => $label, 'settings' => $settings, 'request' => $request->id, 'name' => str_replace('#', 'US', $order->order_name)], function ($m) use ($label,$request, $settings, $email,$order) {
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
}
