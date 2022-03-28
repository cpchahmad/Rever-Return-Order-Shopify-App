<?php

namespace App\Http\Controllers;

use App\Models\EasyPost;
use App\Models\Order;
use App\Models\OrderChecks;
use App\Models\OrderLineProduct;
use App\Models\Payment;
use App\Models\PreviousRequest;
use App\Models\Reason;
use App\Models\ReasonsDataSet;
use App\Models\RefundTypes;
use App\Models\RequestCategory;
use App\Models\RequestExchange;
use App\Models\RequestExport;
use App\Models\RequestLabel;
use App\Models\RequestProducts;
use App\Models\RequestRefund;
use App\Models\RequestSetting;
use App\Models\RequestStatus;
use App\Models\Setting;
use App\Models\Timeline;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Cyberduck\LaravelExcel\ExporterFacade;
use Cyberduck\LaravelExcel\Importer\Csv;
use Cyberduck\LaravelExcel\Serialiser\BasicSerialiser;
use Illuminate\Support\Facades\File;
use Session;



class OrderController extends Controller
{

    public function Dashboard(Request $request)
    {
        $current = $request->input('type');


        $shopfy = Auth::user();
        $easypost=EasyPost::where('shop_id',$shopfy->id)->first();
        $current_status = 0;
        if ($current) {
            if ($current == 'requested') {
                $current_status = 0;
            }
            if ($current == 'approved') {
                $current_status = 1;
            }
            if ($current == 'received') {
                $current_status = 2;
            }
            if ($current == 'refunded') {
                $current_status = 3;
            }
            if ($current == 'declined') {
                $current_status = 4;
            }
        } else {
            $current_status = 0;

        }


        $requests1 = \App\Models\Request::with('has_order')
            ->where([
                'status' => 0,
                'shop_id' => $shopfy->id,
            ])->orderBy('id', 'DESC')->paginate(30);

        $requests2 = \App\Models\Request::with('has_order')
            ->where([
                'status' => 1,
                'shop_id' => $shopfy->id,
            ])->orderBy('id', 'DESC')->paginate(30);


        $requests3 = \App\Models\Request::with('has_order')
            ->where([
                'status' => 2,
                'shop_id' => $shopfy->id,
            ])->orderBy('id', 'DESC')->paginate(30);

        $requests4 = \App\Models\Request::with('has_order')
            ->where([
                'status' => 3,
                'shop_id' => $shopfy->id,
            ])->orderBy('id', 'DESC')->paginate(30);


        $requests5 = \App\Models\Request::with('has_order')
            ->where([
                'status' => 4,
                'shop_id' => $shopfy->id,
            ])->orderBy('id', 'DESC')->paginate(30);


//        $requests->appends(['type' => $current]);

        $r_settings=RequestSetting::where('shop_id',$shopfy->id)->first();
//
        $return_type = RefundTypes::where('shop_id', $shopfy->id)->cursor();
        $methods = Payment::where('shop_id', $shopfy->id)->cursor();
        return view('index')->with([
            'request_count' => \App\Models\Request::where(['shop_id' => $shopfy->id, 'status' => 0])->count(),
            'approved_count' => \App\Models\Request::where(['shop_id' => $shopfy->id, 'status' => 1])->count(),
            'received_count' => \App\Models\Request::where(['shop_id' => $shopfy->id, 'status' => 2])->count(),
            'refund_count' => \App\Models\Request::where(['shop_id' => $shopfy->id, 'status' => 3])->count(),
            'current_status' => $current_status,
            'requests1' => $requests1,
            'requests2' => $requests2,
            'requests3' => $requests3,
            'requests4' => $requests4,
            'requests5' => $requests5,
            'return_types' => $return_type,
            'methods' => $methods,
            'r_settings'=>$r_settings,
            'easypost'=>$easypost
        ]);
    }



    public function Settings()
    {
        $shopfy = Auth::user();
        $has_settings = Setting::where('shop_id', $shopfy->id)->first();
        return view('settings.logo')->with([
            'settings' => $has_settings
        ]);
    }


    public function settings_logo()
    {
        $shopfy = Auth::user();
        $has_settings = Setting::where('shop_id', $shopfy->id)->first();
        return view('settings.logo')->with([
            'settings' => $has_settings,
            'title' => "Portal",
            'sub_title' => "logo",
        ]);
    }

    public function settings_logo_post(Request $request)
    {
        $shopfy = Auth::user();

        $has_settings = Setting::where('shop_id', $shopfy->id)->first();


        if ($has_settings) {
            $setting = Setting::find($has_settings->id);
        } else {
            $setting = new Setting();
        }
        if ($request->file('logo')) {
            $file = $request->file('logo');
            $name = $file->getClientOriginalName();
            $n_name = "shop_" . $shopfy->id . "_" . $name;
            $file->move(public_path() . '/logos/', $n_name);
            $setting->logo = $n_name;
        }

        if ($request->file('background')) {
            $background = $request->file('background');
            $ext = $background->getClientOriginalName();
            $lname = "shop_" . $shopfy->id . "_" . $ext;
            $background->move(public_path() . '/logos/', $lname);
            $setting->background = $lname;
        }


        $setting->shop_id = $shopfy->id;
        $setting->save();

        return redirect()->back();
    }







    public function ProductExclusion()
    {

        $shop = Auth::user();
        $has_settings = Setting::where('shop_id', $shop->id)->first();
        return view('settings.tags-block')->with([
            'settings' => $has_settings,
            'title' => 'General'
        ]);

    }

    public function ProductExclusionSave(Request $request)
    {
        $shop = Auth::user();

        $has_settings = Setting::where('shop_id', $shop->id)->first();

        if ($has_settings == null) {
            $settings_save = new Setting();
            $settings_save->shop_id = $shop->id;
            $settings_save->block_products = $request->input('block_tags');
            $settings_save->save();
            return back();


        } else {

            $has_settings->block_products = $request->input('block_tags');
            $has_settings->save();
            return back();
        }


    }


    public function ProductReturn()
    {
        $request_settings = RequestSetting::where('shop_id', Auth::id())->first();

        return view('settings.product_return')->with([
            'settings' => $request_settings
        ]);
    }


    public function ProductReturnSave(Request $request)
    {
        $request_settings = RequestSetting::where('shop_id', Auth::id())->first();
        if ($request_settings == null) {
            $request_settings = new RequestSetting();
            $request_settings->shop_id = Auth::id();
        }
        $request_settings->exchange_product_tags = $request->exchange_product_tags;
        $request_settings->payment_product_tags = $request->payment_product_tags;
        $request_settings->store_product_tags = $request->store_product_tags;
        $request_settings->save();
        return back();
    }





    public function loadPrevious()
    {
        return view('settings.import');
    }

    public function savePrevious(Request $request)
    {
        $shop = Auth::user();
        $file = $request->file('file');


        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $tempPath = $file->getRealPath();
        $fileSize = $file->getSize();
        $mimeType = $file->getMimeType();

        // Valid File Extensions
        $valid_extension = array("csv");

        // 2MB in Bytes
        $maxFileSize = 2097152;

        // Check file extension
        if(in_array(strtolower($extension),$valid_extension)){

            // Check file size
            if($fileSize <= $maxFileSize){

                // File upload location
                $location = 'uploads';

                // Upload file
                $file->move($location,$filename);

                // Import CSV to Database
                $filepath = public_path($location."/".$filename);

                // Reading file
                $file = fopen($filepath,"r");

                $importData_arr = array();
                $i = 0;

                while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {


                    $num = count($filedata );

                    // Skip first row (Remove below comment if you want to skip the first row)
//                    if($i == 0){
//                        $i++;
//                        continue;
//                    }
                    for ($c=0; $c < $num; $c++) {
                        $importData_arr[$i][] = $filedata [$c];
                    }
                    $i++;
                }


                fclose($file);


                // Insert to MySQL database
                foreach($importData_arr as $importData){

                    $t=PreviousRequest::where('order_number',$importData[0])->first();
                    if ($t===null) {
                        $t=new PreviousRequest();
                    }
                    $t->shop_id=$shop->id;
                    $t->order_number=$importData[0];
                    if ($importData[12]!=="") {
                        $t->status=3;
                    }elseif($importData[10]!=="") {
                        $t->status=2;
                    }elseif($importData[9]!=="") {
                        $t->status=1;
                    }else {
                        $t->status=0;
                    }
                    $t->save();


                }





                Session::flash('message','Import Successful.');

            }else{
                Session::flash('message','File too large. File must be less than 2MB.');

            }

        }else{
            Session::flash('message','Invalid File Extension.');

        }
        return back();

    }



    public function OrderRefundType()
    {

        $shop = Auth::user();

        $built_refund_types = RefundTypes::where('shop_id', Null)->cursor();
        $refund_types_select = RefundTypes::where('shop_id', $shop->id)
            ->where('return_assigning', '!=', null)
            ->cursor();
        $refund_types = RefundTypes::where('shop_id', $shop->id)
            ->where('return_assigning', null)
            ->cursor();

        return view('settings.refund-type')->with([
            'custom_types' => $refund_types,
            'built_types' => $built_refund_types,
            'selected' => $refund_types_select,
            'title' => 'Order',
            'sub_title' => "return_type"
        ]);

    }

    public function BuiltRefundTypeSave(Request $request)
    {
        $shop = Auth::user();

        $return_type = $request->input('built_type');
        $update_check = App\RefundTypes::where('shop_id', $shop->id)
            ->where('return_assigning', '!=', null)
            ->delete();

//      if(count($update_check)>0){
//          $exist_ids=[];
//          foreach ($update_check as $check){
//            array_push($exist_ids,$check->return_assigning);
//          }
//      }

        if ($return_type != null) {
            foreach ($return_type as $r_type) {

                $built_type = App\RefundTypes::where('id', $r_type)->first();
                $assign_check = App\RefundTypes::where('shop_id', $shop->id)
                    ->where('return_assigning', $built_type->id)
                    ->first();

                if ($assign_check == null) {
                    $custom_assign = new App\RefundTypes();
                    $custom_assign->shop_id = $shop->id;
                    $custom_assign->return_type = $built_type->return_type;
                    $custom_assign->return_assigning = $built_type->id;
                    $custom_assign->save();
                }

            }
        }

        return back();
    }




    public function OrderRefundTypesave(Request $request)
    {

        $shop = Auth::user();
        if ($request->input('type') != null) {
            $custom_type = new RefundTypes();
            $custom_type->shop_id = $shop->id;
            $custom_type->return_type = $request->input('type');
            $custom_type->save();
        }

        return back();

    }

    public function OrderReturnTypeEdit($id)
    {
        $shop = Auth::user();
        $return_type = RefundTypes::where('id', $id)
            ->where('shop_id', $shop->id)->first();

        return view('settings.refund-type')->with([
            'edit_type' => $return_type

        ]);

    }

    public function OrderReturnTypeEdited(Request $request)
    {

        $return_type = RefundTypes::where('id', $request->input('type_id'))
            ->update([
                'return_type' => $request->input('type')
            ]);
        return redirect()->route('orders.return.type');

    }

    public function OrderReturnTypeDelete($id)
    {

        $return_type = RefundTypes::where('id', $id)
            ->delete();
        return back();

    }

    public function has_settings()
    {
        $shopfy = Auth::user();

        $has_settings = Setting::where('shop_id', $shopfy->id)->first();

        return $has_settings;
    }

    public function AddCustomationText()
    {

        $settings = $this->has_settings();

        return view('settings.custom-text')->with([
            'settings' => $settings,
            'title' => "Order",
            'sub_title' => "CustomText"
        ]);
    }

    public function AddCustomationTextSave(Request $request)
    {
        $shop = Auth::user();
        $settings = $this->has_Settings();

        if ($settings == null) {
            $save_settings = new Setting();
            $save_settings->shop_id = $shop->id;
            $save_settings->exchange_text = $request->input('custom_text');
            $save_settings->save();
            return back();

        } else {
            $settings->exchange_text = $request->input('custom_text');
            $settings->save();
            return back();
        }
    }


    public function sendTestLabel($type)
    {

        $settings = Setting::where('shop_id', Auth::id())->first();

        $label = RequestLabel::whereHas('has_request')->first();

        $requests = \App\Models\Request::where('shop_id', Auth::id())->first();

        if ($settings->receiver_email == null) {
            $email = $settings->sender_email;
        } else {
            $email = $settings->receiver_email;

        }

        try {
            if ($type == 'confirm') {
                Mail::send('emails.label', ['requests'=>$requests,'label' => $label, 'settings' => $settings, 'request' => 1, 'name' => str_replace('#', 'US', 1001)], function ($m) use ($label, $settings, $email) {
                    $m->from($settings->sender_email, $settings->sender_name);
                    $m->attach($label->label, [
                        'as' => $label->tracking_code
                    ]);
                    $m->to('zain.irfan4442@gmail.com')->subject(($settings->label_subject) ? $settings->label_subject . ' Order US' . str_replace('#', '', 1001) . ' - Request No#1 ' : 'Return Label for Order US' . str_replace('#', '', 1001) . ' - Request No#1');
                });
            } else if ($type == 'expire') {
                $data = [
                    'request_created_at' => $label->created_at,
                    'order_name' => 'US1001',
                    'request_id' => 1,
                    'label'=>$label
                ];
                $data = (object)$data;

                Mail::send('emails.label_expired', ['data' => $data, 'label' => $label, 'settings' => $settings, 'request' => 1, 'name' => str_replace('#', 'US', 1001)], function ($m) use ($label, $settings, $email) {
                    $m->from($settings->sender_email, $settings->sender_name);
                    $m->attach($label->label, [
                        'as' => $label->tracking_code
                    ]);
                    $m->to($email)->subject(($settings->label_expired_subject) ? $settings->label_expired_subject . ' Order US' . str_replace('#', '', 1001) . ' - Request No#1 ' : 'Return Label for Order US' . str_replace('#', '', 1001) . ' - Request No#1');
                });
            } else if ($type == 'reminder') {
                $data = [
                    'request_created_at' => $label->created_at,
                    'order_name' => 'US1001',
                    'request_id' => 1,
                    'label'=>$label
                ];
                $data = (object)$data;
                Mail::send('emails.package_remider', ['data' => $data, 'label' => $label, 'settings' => $settings, 'request' => 1, 'name' => str_replace('#', 'US', 1001)], function ($m) use ($label, $settings, $email) {
                    $m->from($settings->sender_email, $settings->sender_name);
                    $m->attach($label->label, [
                        'as' => $label->tracking_code
                    ]);
                    $m->to($email)->subject(($settings->package_reminder_subject) ? $settings->package_reminder_subject . ' Order US' . str_replace('#', '', 1001) . ' - Request No#1 ' : 'Return Label for Order US' . str_replace('#', '', 1001) . ' - Request No#1');
                });
            }
            return true;
        } catch (\Exception $exception) {
dd($exception);
            flash('Some thing went wrong')->error();
            return false;
        }

    }

    public function EmailReminder()
    {
        return view('settings.email-reminder')->with([
            'settings' => $this->has_settings(),
            "title" => "Email",
            'sub_title' => "email-reminder"
        ]);
    }

    public function EmailReminderSave(Request $request)
    {
        $settings = Setting::where('shop_id', Auth::id())->first();
        if ($settings == null) {
            $settings = new Setting();
            $settings->shop_id = Auth::id();
        }
        $settings->package_reminder_subject = $request->subject;
        $settings->reminder_after = $request->reminder_after;
        $settings->package_reminder_body = $request->body;
        $settings->save();
        return back();
    }

    public function EmailExpired()
    {
        return view('settings.email-expired')->with([
            'settings' => $this->has_settings(),
            "title" => "Email",
            'sub_title' => "email-expired"
        ]);
    }

    public function EmailExpiredSave(Request $request)
    {
        $settings = Setting::where('shop_id', Auth::id())->first();
        if ($settings == null) {
            $settings = new Setting();
            $settings->shop_id = Auth::id();
        }
        $settings->label_expired_subject = $request->subject;
//        $settings->reminder_after=$request->reminder_after;
        $settings->label_expired_body = $request->body;
        $settings->save();
        return back();
    }


    public function EmailGeneral()
    {
        $shopfy = Auth::user();
        return view('settings.email-general')->with([
            'settings' => $this->has_settings(),
            "title" => "Email",
            'sub_title' => "email_general"
        ]);
    }


    public function EmailGeneralSave(Request $request)
    {
        if ($this->has_settings()) {
            $setting = Setting::find($this->has_settings()->id);
        } else {
            $setting = new Setting();
        }
        $setting->sender_email = $request->input('sender_email');
        $setting->receiver_email = $request->input('receiver_email');
        $setting->sender_name = $request->input('sender_name');
        $setting->sender_username = $request->input('sender_username');
        $setting->sender_password = $request->input('sender_password');
        $setting->save();
        return redirect()->back();
    }


    public function EmailWorkFlow()
    {
        return view('settings.email-workflow')->with([
            'settings' => $this->has_settings(),
            "title" => "Email",
            'sub_title' => "email_workflow"
        ]);
    }

    public function EmailWorkFlowSave(Request $request)
    {
        $shopfy = Auth::user();
        $has_settings = Setting::where('shop_id', $shopfy->id)->first();

        if ($has_settings) {
            $setting = Setting::find($has_settings->id);
        } else {
            $setting = new Setting();
        }


        $rq_customer = ($request->input('rq_customer') ? 1 : 0);
        $rq_admin = ($request->input('rq_admin') ? 1 : 0);
        $ap_customer_approved = ($request->input('ap_customer_approved') ? 1 : 0);
        $ap_customer_rejected = ($request->input('ap_customer_rejected') ? 1 : 0);
        $rc_customer_product = ($request->input('rc_customer_product') ? 1 : 0);
        $rf_customer_product = ($request->input('rf_customer_product') ? 1 : 0);

        $setting->rq_customer = $rq_customer;
        $setting->rq_admin = $rq_admin;
        $setting->ap_customer_approved = $ap_customer_approved;
        $setting->ap_customer_rejected = $ap_customer_rejected;
        $setting->rc_customer_product = $rc_customer_product;
        $setting->rf_customer_product = $rf_customer_product;
        $setting->shop_id = $shopfy->id;
        $setting->save();
        return redirect()->back();
    }


    public function Editor(Request $request)
    {
        $setting = $this->has_settings();
        $type = $request->input('type');
        if ($type == 'rq_customer') {
            $send = $setting->request_email;
            $title = 'Request Customer Template';
            $subject = 'rq_customer_subject';
            $content = 'rq_customer_template';
        }

        if ($type == 'rq_admin') {
            $send = $setting->deny_email;
            $title = 'Request Admin Template';
            $subject = 'rq_admin_subject';
            $content = 'rq_admin_template';
        }

        if ($type == 'ap_customer_approval') {
            $send = $setting->approve_email;
            $title = "Customer Request Approved";
            $subject = 'ap_approval_subject';
            $content = 'ap_approval_template';
        }

        if ($type == 'ap_customer_rejected') {

            $title = "Customer Request Rejected";
            $subject = 'ap_reject_subject';
            $content = 'ap_reject_template';
        }
        if ($type == 'rc_customer_product') {
            $send = $setting->received_email;
            $title = "Received Customer Product";
            $subject = 'rc_received_subject';
            $content = 'rc_received_template';
        }
        if ($type == 'rf_customer_product') {
            $send = $setting->finished_email;
            $title = "Customer Product Refunded";
            $subject = 'rf_product_subject';
            $content = 'rf_product_template';
        }

        return view('settings.templates.add')->with([
            'title' => $title,
            'subject' => $subject,
            'content' => $content,
            'settings' => $setting,
            'send' => $send
        ]);
    }


    public function EditorSave(Request $request)
    {


        if ($this->has_settings()) {
            $setting = Setting::find($this->has_settings()->id);
        } else {
            $setting = new Setting();
        }
        if ($request->input('rq_customer_template')) {
            if ($request->input('email_enabled')) {
                $setting->request_email = $request->input('email_enabled');
            } else {
                $setting->request_email = false;
            }
            $setting->rq_customer_subject = $request->input('rq_customer_subject');
            $setting->rq_customer_template = $request->input('rq_customer_template');
        }
        if ($request->input('rq_admin_template')) {
            if ($request->input('email_enabled')) {
                $setting->deny_email = $request->input('email_enabled');
            } else {
                $setting->deny_email = false;
            }
            $setting->rq_admin_subject = $request->input('rq_admin_subject');
            $setting->rq_admin_template = $request->input('rq_admin_template');
        }
        if ($request->input('ap_approval_template')) {
            if ($request->input('email_enabled')) {
                $setting->approve_email = $request->input('email_enabled');
            } else {
                $setting->approve_email = false;
            }
            $setting->ap_approval_subject = $request->input('ap_approval_subject');
            $setting->ap_approval_template = $request->input('ap_approval_template');
        }
        if ($request->input('ap_reject_template')) {
            if ($request->input('email_enabled')) {
                $setting->request_email = $request->input('email_enabled');
            } else {
                $setting->rq_customer_subject = false;
            }
            $setting->ap_reject_subject = $request->input('ap_reject_subject');
            $setting->ap_reject_template = $request->input('ap_reject_template');
        }
        if ($request->input('rc_received_template')) {
            if ($request->input('email_enabled')) {
                $setting->received_email = $request->input('email_enabled');
            } else {
                $setting->received_email = false;
            }
            $setting->rc_received_subject = $request->input('rc_received_subject');
            $setting->rc_received_template = $request->input('rc_received_template');
        }
        if ($request->input('rf_product_template')) {
            if ($request->input('email_enabled')) {
                $setting->finished_email = $request->input('email_enabled');
            } else {
                $setting->finished_email = false;
            }
            $setting->rf_product_subject = $request->input('rf_product_subject');
            $setting->rf_product_template = $request->input('rf_product_template');
        }
        $setting->save();
        return redirect()->back();
    }


    public function sendTestEmail($status)
    {
        $settings = Setting::where('shop_id', Auth::id())->first();
        Mail::send('emails.testing', ['status' => $status, 'name' => 'US1001', 'settings' => $settings], function ($m) use ($settings, $status) {
            $m->from($settings->sender_email, $settings->sender_name);

            if ($settings->receiver_email == null) {
                $email = $settings->sender_email;
            } else {
                $email = $settings->receiver_email;
            }

            if ($status == 0) {
                $m->to($email)->subject(($settings->rq_customer_subject) ? $settings->rq_customer_subject : 'You Requested For a Return');
            } else if ($status == 1) {
                $m->to($email)->subject(($settings->ap_approval_subject) ? $settings->ap_approval_subject : 'Request Approved');
            } else if ($status == 2) {
                $m->to($email)->subject(($settings->rc_received_subject) ? $settings->rc_received_subject : 'Package Received');
            } else if ($status == 3) {
                $m->to($email)->subject(($settings->rf_product_subject) ? $settings->rf_product_subject : 'Request Completed');
            } else if ($status == 4) {
                $m->to($email)->subject(($settings->rq_admin_subject) ? $settings->rq_admin_subject : 'Request Rejected');
            }
        });
        return $status;
    }

    public function emailflowupdate(Request $request)
    {
        $shop = Auth::user();

        $settings = Setting::where('shop_id', $shop->id)->first();
        if ($request->input('request_email')) {
            $settings->request_email = $request->input('request_email');
        } else {
            $settings->request_email = false;
        }
        if ($request->input('approve_email')) {
            $settings->approve_email = $request->input('approve_email');
        } else {
            $settings->approve_email = false;
        }

        if ($request->input('received_email')) {
            $settings->received_email = $request->input('received_email');
        } else {
            $settings->received_email = false;
        }

        if ($request->input('finished_email')) {
            $settings->finished_email = $request->input('finished_email');
        } else {
            $settings->finished_email = false;
        }

        if ($request->input('deny_email')) {
            $settings->deny_email = $request->input('deny_email');
        } else {
            $settings->deny_email = false;
        }
        $settings->save();
        return response()->json($request->all());
    }

    public function EmailExport()
    {
        return view('settings.email-export')->with([
            'settings' => $this->has_settings(),
            "title" => "Email",
            'sub_title' => "email-export"
        ]);
    }


    public function EmailExportSave(Request $request)
    {
        $settings = Setting::where('shop_id', Auth::id())->first();
        if ($settings == null) {
            $settings = new Setting();
            $settings->shop_id = Auth::id();
        }
        $settings->export_subject = $request->subject;
        $settings->export_body = $request->body;
        $settings->save();
        return back();
    }


    public function synchronization($next = null)
    {
        $shopfy = Auth::user();



        $shop = User::where('id', $shopfy->id)->first();



        try {
            $count = $shopfy->api()->rest('GET', '/admin/orders/count.json')['body']['count'];



            $orders = $shopfy->api()->rest('GET', '/admin/orders.json', [
                'limit'=>250,
                'page_info'=>$next
            ]);




            $test = [];

            if(isset($orders['body']['orders'])) {
                $orders = $orders['body']['orders'];


                array_push($test, $orders);


                foreach ($orders as $shop_order) {

                    $order_check = OrderChecks::where('order_id', $shop_order->id)->first();

                    if ($order_check == null) {
                        $order_Save = new OrderChecks();
                        $order_Save->order_id = $shop_order->id;
                        $order_Save->order_name = '#' . $shop_order->order_number;
                        $order_Save->email = $shop_order->email;
                        $order_Save->shop_id = $shop->id;
                        $order_Save->save();
                    }else
                    {
                        continue;
                    }
                    $order_in = Order::where('order_id', $shop_order->id)->first();
                    if ($order_in == null) {

                        $this->OrdersSyncWebhook($shop_order->id, $shopfy->name);
                    }

                }
            }




        } catch (\Exception $exception) {

            dd($exception);
            return back();
        }

    }


    public function OrdersSyncWebhook($id, $shop)
    {
        $shopfy = User::where('name', $shop)->first();

        DB::table('error_logs')->insert([
            'message' => 'order create 1',
        ]);
        $order = $shopfy->api()->rest('GET', '/admin/orders/' . $id . '.json')['body']['order'];

        $order = json_decode(json_encode($order), FALSE);
        $checks = $order;

        $order_check = Order::where('order_name', '#' . $checks->order_number)->first();


        if ($order_check != null) {
            return "";
        }

        DB::table('error_logs')->insert([
            'message' => 'order create 2',
        ]);

        $orders_items = $order->line_items;
        $products_ids = [];
        $products = [];
        $line_images = [];

        foreach ($orders_items as $item) {
            if ($item->product_id !== null) {
                DB::table('error_logs')->insert([
                    'message' => 'order create 3',
                ]);

                $product_detail = $shopfy->api()->rest('GET', '/admin/products/' . $item->product_id . '.json');
//                dd($product_detail);
                if(isset($product_detail['body']['product']))
                {
                    $product_detail=$product_detail['body']['product'];
                    $product_detail = json_decode(json_encode($product_detail), FALSE);
                    $order_line_product = OrderLineProduct::where('product_id', $item->product_id)->first();
                    if ($order_line_product === null) {
                        $order_line_product = new OrderLineProduct();
                        $order_line_product->product_id = $item->product_id;
                        $order_line_product->shop_id = $shopfy->id;

                        $order_line_product->product_json = json_encode($product_detail);
                        $order_line_product->save();
                    }
                    if (count($product_detail->images) > 1) {
                        foreach ($product_detail->images as $product_image) {
                            if (count($product_image->variant_ids)) {
                                foreach ($product_image->variant_ids as $ids) {
                                    if ($item->variant_id == $ids)
                                        array_push($line_images, [
                                            'line_id' => $item->id,
                                            'image' => $product_image->src
                                        ]);
                                }
                            }
                        }
                    } else {
                        array_push($line_images, [
                            'line_id' => $item->id,
                            'image' => $product_detail->image->src
                        ]);
                    }
                    $product_images = $shopfy->api()->rest('GET', '/admin/products/' . $item->product_id . '/images.json')['body']['images'];
                    $product_images = json_decode(json_encode($product_images), FALSE);

                    if (isset($product_images)) {

                        if (isset($item->variant_id) && $item->variant_id!==null) {

                            $variant = $shopfy->api()->rest('GET', '/admin/variants/' . $item->variant_id . '.json');
                            if (isset($variant['body']['variant']))
                            {
                                $variant=$variant['body']['variant'];
                                $variant = json_decode(json_encode($variant), FALSE);

                                if (isset($variant->image_id)) {


                                    foreach ($product_images as $image) {
                                        if ($image->id == $variant->image_id)
                                            array_push($products, [
                                                'id' => $variant->id,
                                                'image' => $image->src
                                            ]);
                                    }
                                }
                                else
                                {
                                    foreach ($product_images as $image) {
                                        array_push($products, [
                                            'id' => $image->id,
                                            'image' => $image->src
                                        ]);
                                    }
                                }
                            }else
                            {
                                foreach ($product_images as $image) {
                                    array_push($products, [
                                        'id' => $image->id,
                                        'image' => $image->src
                                    ]);
                                }
                            }
                        } else {
                            foreach ($product_images as $image) {
                                array_push($products, [
                                    'id' => $image->id,
                                    'image' => $image->src
                                ]);
                            }

                        }
                    }
                }
            }
        }


        DB::table('error_logs')->insert([
            'message' => 'order create 4',
        ]);

        $products_json = json_encode($products);


        $order_db = new Order();
        $order_db->order_id = $order->id;
        $order_db->order_name = '#' . $order->order_number;
        $order_db->email = $order->email;
        $order_db->prefix = preg_replace('/[0-9]+/', '', $order->name);
        $order_db->order_json = json_encode($order);
        $order_db->products_json = $products_json;
        $order_db->shop_id = $shopfy->id;
        $order_db->line_images = json_encode($line_images);
        $order_db->save();

        DB::table('error_logs')->insert([
            'message' => 'order create 6',
        ]);

    }


    public function singleRequest($id)
    {
        $shopfy = Auth::user();
        $request = \App\Models\Request::where(['shop_id' => $shopfy->id, 'id' => $id])->first();
        $shop_detail = User::where('id', $shopfy->id)->first();
        $easypost=EasyPost::where('shop_id',$shopfy->id)->first();

        $exchange=RequestExchange::where('request_id',$id)->first();
        if($exchange!==null && $exchange->order_id!==null)
        {
            $message=Timeline::where('request_id',$id)->where('message','like','%Exchange Order%')->first();
            if($message==null)
            {
                $exchangeOrder=Order::where('order_id',$exchange->order_id)->first();
                if($exchangeOrder)
                {
                    $message = new Timeline();
                    $message->message = 'Exchange Order Created: '.$exchangeOrder->order_name;
                    $message->request_id = $id;
                    $message->save();
                }
            }
        }
        $order_line_products = [];
        $all_products = $request->has_order->order_json;
        $all_products = json_decode($all_products, true);
        foreach ($all_products['line_items'] as $line_item) {
            $order_line_products[$line_item['id']] = json_decode(OrderLineProduct::where('product_id', $line_item['product_id'])->first()->product_json, true);
        }


        return view('invoice')->with([
            'request' => $request,
            'selected_products' => json_decode($request->product, true),
            'all_products' => $all_products['line_items'],
            'shop_details' => $shop_detail,
            'order_line_products' => $order_line_products,
            'shop_id'=>Auth::user()->id,
            'easypost'=>$easypost

        ]);
    }


    public function DeleteComment($id)
    {

        $data = explode('-', $id);
        $shop = Auth::user();
        $delete_comment = Timeline::where('id', $data[0])
            ->where('request_id', $data[1])->delete();
        return back();

    }


    public function timeline_submit(Request $request)
    {

        if ($request->input('comment_id') != null) {


            $update_comment = Timeline::where('id', $request->input('comment_id'))
                ->where('request_id', $request->input('request_id'))
                ->update([
                    'message' => $request->input('message')
                ]);

        } else {
            $message = new Timeline();
            $message->message = $request->input('message');
            $message->request_id = $request->input('request_id');
            $message->save();
        }


        return redirect()->back();
    }

    public function Filtration(Request $request)
    {
        $shop = Auth::user();
        $status = $request->input('status');
        $easypost=EasyPost::where('shop_id',$shop->id)->first();
        if ($request->input('type')) {
            $type = RefundTypes::where('id', $request->input('type'))->first();
            $requests = \App\Models\Request::where(['shop_id' => $shop->id, 'status' => $status])->cursor();
            $requests_data = [];
            foreach ($requests as $reqt) {
                $request_products = json_decode($reqt->product);
                foreach ($request_products as $product) {
                    if ($product->return_type == $type->return_type) {
                        if (!in_array($reqt, $requests_data)) {
                            array_push($requests_data, $reqt);
                        }
                    }
                }
            }
        }
        if ($request->input('method')) {
            $method = Payment::where('id', $request->input('method'))->first();
            $requests = \App\Models\Request::where(['shop_id' => $shop->id, 'status' => $status])->cursor();
            $requests_data = [];
            foreach ($requests as $reqt) {
                $payments = json_decode($reqt->payment_id);
                if ($payments->name == $method->name) {
                    if (!in_array($reqt, $requests_data)) {
                        array_push($requests_data, $reqt);
                    }
                }
            }
        }


        $return_type = RefundTypes::where('shop_id', $shop->id)->cursor();
        $methods = Payment::where('shop_id', $shop->id)->cursor();
        return view('index')->with([
            'request_count' => \App\Models\Request::where(['shop_id' => $shop->id, 'status' => 0])->count(),
            'approved_count' => \App\Models\Request::where(['shop_id' => $shop->id, 'status' => 1])->count(),
            'received_count' => \App\Models\Request::where(['shop_id' => $shop->id, 'status' => 2])->count(),
            'refund_count' => \App\Models\Request::where(['shop_id' => $shop->id, 'status' => 3])->count(),
            'current_status' => $status,
            'requests' => $requests_data,
            'return_types' => $return_type,
            'methods' => $methods,
            'easypost'=>$easypost

        ]);

    }

    public function RequestStatus($id, Request $r)
    {
        $request = \App\Models\Request::find($id);


        $status = $r->input('type');

        $r_status = new RequestStatus();
        $r_status->request_id = $id;
        if ($status == 'approved') {
            $request->status = 1;
            $r_status->status = 1;
            if ($request->request_labels) {

                if ($request->request_labels->status == "delivered") {
                    goto received;
                }
            }
        }
        if ($status == 'received') {
            received:
            try {

                $request->status = 2;
                $r_status->status = 2;
                $this->adjustInventory($request);
            } catch (\Exception $exception) {
                file_put_contents('Received.txt', json_encode($exception));
                flash('Some Thing Went Wrong')->error();
                return redirect()->back();
            }
        }
        if ($status == 'refunded') {
            try {


                $request->status = 3;
                $r_status->status = 3;
            } catch (\Exception $exception) {
                flash('Some Thing Went Wrong')->error();
                return redirect()->back();
            }
        }
        if ($status == 'delete') {
            $request->status = 4;
            $r_status->status = 4;
        }
        $request->save();
        $r_status->save();
        $this->EmailTemplate($request);


        if ($status == 'delete') {
            return redirect()->route('dashboard');
        } else {
            return redirect()->back();
        }
    }


    public function EmailTemplate($r)
    {


        $settings = Setting::where('shop_id', $r->shop_id)->first();


        $order = Order::where('id', $r->order_id)->first();
        if ($settings->sender_email !== null && $settings->sender_name) {

            try {
                Mail::send('emails.general', ['request' => $r, 'name' => $order->order_name, 'settings' => $settings], function ($m) use ($r, $settings, $order) {
                    $m->from($settings->sender_email, $settings->sender_name);
//                if($r->request_labels && ($r->status!=2 && $r->status!=3 && $r->status!=4)){
//                    $m->attach($r->request_labels->label);
//                };
                    if ($r->status == 0 && $settings->request_email) {
                        $m->to($order->email)->subject(($settings->rq_customer_subject) ? $settings->rq_customer_subject : 'You Requested For a Return');
                    } else if ($r->status == 1 && $settings->approve_email) {
                        $m->to($order->email)->subject(($settings->ap_approval_subject) ? $settings->ap_approval_subject : 'Request Approved');
                    } else if ($r->status == 2 && $settings->received_email) {
                        $m->to($order->email)->subject(($settings->rc_received_subject) ? $settings->rc_received_subject : 'Package Received');
                    } else if ($r->status == 3 && $settings->finished_email) {
                        $m->to($order->email)->subject(($settings->rf_product_subject) ? $settings->rf_product_subject : 'Request Completed');
                    } else if ($r->status == 4 && $settings->deny_email) {
                        $m->to($order->email)->subject(($settings->rq_admin_subject) ? $settings->rq_admin_subject : 'Request Rejected');
                    }
                });
            }catch (\Exception $exception) {
                dd($exception);

            } finally {

                return true;
            }
        } else {
            flash('Email Credentials Not Found!')->error();
        }
    }


    public function create_draft($request_id, $order_id, $line_items, $note = 'Exchange')

    {


        $shopfy = Auth::user();
        $line_items = $line_items->toArray();
        $request = \App\Models\Request::where(['shop_id' => $shopfy->id, 'id' => $request_id])->first();

        $shop_detail = User::where('id', $shopfy->id)->first();

        $ext_discount=0;

        $order_line_products = [];
        $all_products = $request->has_order->order_json;


        $all_products = json_decode($all_products, true);

        foreach ($all_products['line_items'] as $line_item) {
            if (in_array($line_item['id'], $line_items)) {
                if(isset($line_item['discount_allocations']) && is_array($line_item['discount_allocations']) && count($line_item['discount_allocations'])) {
                    foreach ($line_item['discount_allocations'] as $application) {
                        $ext_discount+=floatval($application['amount']);
                    }
                }
                $order_line_products[$line_item['id']] = json_decode(OrderLineProduct::where('product_id', $line_item['product_id'])->first()->product_json, true);

            }
        }


        //draft order

        try {
            $amount = 0;

            $arr = [];
            $items = json_decode($request->items_json, true);
            foreach ($items as $item) {

                if ($item['return_type'] == 'exchange') {
                    array_push($arr, [
                        'variant_id' => $item['exchange_variant_id'],
                        'quantity' => $item['quantity']

                    ]);
                    $amount += $item['price'];
                }
            }

            $label_fee = 0;
            $label = RequestLabel::where('request_id', $request->id)->first();
//            if ($label && $label->fees_applied == false) {
////                $amount -= floatval($label->fees);
//            }
            $amount+=$ext_discount;

            $prev_order = Order::find($request->order_id);
            $order_json = json_decode($prev_order->order_json, true);



            $shipping_address = $order_json['shipping_address'];

//            if ($request->shipping_address) {
//                $shipping_address = $request->shipping_address->toArray();
//            }

            $order = $shopfy->api()->rest('POST', '/admin/draft_orders.json', [
                "draft_order" => [
                    "email" => $prev_order->email,
                    "note" => 'Order Created in Exchange of Some Products of Order ' . $prev_order->order_name,
                    "total_discounts" => floatval($request->value) * -1,
                    "financial_status" => "pending",
                    "send_receipt" => true,
                    "applied_discount" => [
                        "description" => 'Amount deducted on the behalf of Exchange',
                        "value" => ($amount),
                        "amount" => ($amount),
                        "value_type" => "fixed_amount",
                        "title" => "Exchange Order Discount"
                    ],
                    "line_items" => $arr,
                    "customer" => [
                        "id" => $order_json['customer']['id']
                    ],
//                    "shipping_lines" => [
//                        [
//                            "custom" => true,
//                            "price" => floatval(100) / 100,
//                            "title" => "Standard Shipping"
//                        ]
//                    ],
                    "shipping_address" => [
                        "first_name" => $shipping_address['first_name'],
                        "last_name" => $shipping_address['last_name'],
                        "address1" => $shipping_address['address1'],
                        "address2"=>(isset($shipping_address['address2'])?$shipping_address['address2']:""),
                        "phone" => $shipping_address['phone'],
                        "city" => $shipping_address['city'],
                        "province" => $shipping_address['province'],
                        "country" => $shipping_address['country'],
                        "zip" => $shipping_address['zip']
                    ],
                ]
            ]);


            if ($order !== null) {
                $order = $order['body']['draft_order'];
                $order = json_decode(json_encode($order, false));
                $request_exchange = new RequestExchange();
                $request_exchange->draft_order_id = $order->id;
                $request_exchange->email = $order->email;
                $request_exchange->name = $order->name;
                $request_exchange->status = $order->status;
                $request_exchange->total_price = $order->total_price;
                $request_exchange->subtotal_price = $order->subtotal_price;
                $request_exchange->total_tax = $order->total_tax;
                if (isset($order->applied_discount->amount))
                    $request_exchange->applied_discount = $order->applied_discount->amount;
                else $request_exchange->applied_discount = 0;
                $request_exchange->draft_json = json_encode($order);
                $request_exchange->request_id = $request_id;
                $request_exchange->save();

            }
//            $label->fees_applied = true;
            if($label) {
                $label->save();
            }
            return $order;
        } catch (\Exception $exception) {
//            file_put_contents('Received.txt', json_encode($exception));
            flash($exception->getMessage())->error();
            return null;
        }

    }


    public function complete_draft($orderId)
    {
        try {
            $shop = Auth::user();
            $draft = $shop->api()->rest('PUT', '/admin/draft_orders/' . $orderId . '/complete.json',
                [
                    "send_receipt" => true,
                ]);
            if ($draft['errors'] == true) {
                $draft = $shop->api()->rest('GET', '/admin/draft_orders/' . $orderId . '.json');
            }


            $request_exchange = RequestExchange::where('draft_order_id', $orderId)->first();
            if (isset($draft['body']['draft_order']) && $request_exchange) {
                $draft = json_decode(json_encode($draft['body']['draft_order']), FALSE);
                $request_exchange->draft_json = json_encode($draft);
                if(isset($draft->order_id)) {
                    $request_exchange->order_id=$draft->order_id;
                }
                $request_exchange->save();
                return response()->json($request_exchange);
            } else {
                return response()->json(false);
            }
        }catch ( \Exception $exception) {
            flash($exception->getMessage())->error();
            return response()->json(false);
        }
    }


    public function Analytics($custom_date = '', $message = '')
    {
        $shopfy = Auth::user();
        $shop = User::where('id', $shopfy->id)->first();

        if ($custom_date == "") {
            $date = date('Y-m-d');
            $message_data = "Today";
        } else {
            $date = $custom_date;
            $message_data = $message;
        }

        $request = \App\Models\Request::where("shop_id", $shopfy->id)
            ->where("created_at", "like", "%" . $date . "%")->count();

        $refund = RequestProducts::where("shop_id", $shopfy->id)
            ->where("created_at", "like", "%" . $date . "%")
            ->where('return_type', 'payment_method')->count();

        $exchange = RequestProducts::where("shop_id", $shopfy->id)
            ->where("created_at", "like", "%" . $date . "%")
            ->where('return_type', 'exchange')->count();
        $store_credit = RequestProducts::where("shop_id", $shopfy->id)
            ->where("created_at", "like", "%" . $date . "%")
            ->where('return_type', 'store_credit')->count();

        $amount = \App\Models\Request::where("shop_id", $shopfy->id)
            ->where("created_at", "like", "%" . $date . "%")->sum('request_amount');

        $return_products = RequestProducts::select('*', DB::raw('group_concat(product_sku) as product_sku,group_concat(reason) as reason
        ,group_concat(return_type) as return_type,group_concat(variant_id) as variant_id,group_concat(product_quantity) as product_quantity'))
            ->where("shop_id", $shopfy->id)
            ->where("created_at", "like", "%" . $date . "%")
            ->groupBy('product_id')
            ->get();

//
//            $return_reasons= App\Reason::with('has_skus')
////                ->where("created_at","like","%".$date."%")
//                ->where('shop_id',$shopfy->id)
//                ->where(DB::raw('request_products.id','=','1'))
//                ->get();
//        dd(date('Y-m-d',strtotime(Carbon::now()->subDay(1))));
        $shopfy_id = $shopfy->id;
        $return_reasons = Reason::where('shop_id', $shopfy->id)
            ->with(array('has_skus' => function ($query) use ($date, $shopfy_id) {
                $query->where("created_at", "like", "%" . $date . "%")
                    ->where('shop_id', $shopfy_id);
            }))->cursor();
        $datasets = [];
        $current = 0;
//        if($request->input('values') && $request->input('values')==-1)
//        {

        $labels = ['12AM-3AM', '3AM-6AM', '6AM-9AM', '9AM-12PM', '12PM-3PM', '3PM-6PM', '6PM-9PM', '9PM-12AM'];

        foreach ($labels as $label) {
            $start = Carbon::yesterday()->add($current, 'hour')->format('Y-m-d H-i-s');
            $current += 3;
            $end = Carbon::yesterday()->add($current, 'hour')->format('Y-m-d H-i-s');
            $datasets['exchange'][$label] = RequestProducts::where("shop_id", $shopfy->id)
                ->where('return_type', 'exchange')
                ->whereBetween('created_at', [$start, $end])
                ->count();
            $datasets['payment_method'][$label] = RequestProducts::where("shop_id", $shopfy->id)
                ->where('return_type', 'payment_method')
                ->whereBetween('created_at', [$start, $end])
                ->count();
            $datasets['store_credit'][$label] = RequestProducts::where("shop_id", $shopfy->id)
                ->where('return_type', 'store_credit')
                ->whereBetween('created_at', [$start, $end])
                ->count();
        }

//        }
        $exports = RequestExport::where('shop_id', $shopfy->id)->orderBy('created_at', 'desc')->cursor();

        return view('anaylatics')->with([
            'today_request' => $request,
            'today_amount' => $amount,
            'today_refund' => $refund,
            'today_exchange' => $exchange,
            'total_store_credit' => $store_credit,
            'return_products' => $return_products,
            'return_reasons' => $return_reasons,
            'shop_details' => $shop,
            'date' => $message_data,
            'datasets' => $datasets,
            'exports' => $exports


        ]);
    }


    public function FilterAnalytics(Request $request)
    {
        $shop_domain = $request->input('shop');
        $shopfy = Auth::user();

        $type = $request->input('type');
        $datasets = [];
        $current = 0;
        if ($request->input('values') && $request->input('values') == -1) {

            $labels = ['12AM-3AM', '3AM-6AM', '6AM-9AM', '9AM-12PM', '12PM-3PM', '3PM-6PM', '6PM-9PM', '9PM-12AM'];

            foreach ($labels as $label) {
                $start = Carbon::yesterday()->add($current, 'hour')->format('Y-m-d H-i-s');
                $current += 3;
                $end = Carbon::yesterday()->add($current, 'hour')->format('Y-m-d H-i-s');
                $datasets['exchange'][$label] = RequestProducts::where("shop_id", $shopfy->id)
                    ->where('return_type', 'exchange')
                    ->whereBetween('created_at', [$start, $end])
                    ->count();
                $datasets['payment_method'][$label] = RequestProducts::where("shop_id", $shopfy->id)
                    ->where('return_type', 'payment_method')
                    ->whereBetween('created_at', [$start, $end])
                    ->count();
                $datasets['store_credit'][$label] = RequestProducts::where("shop_id", $shopfy->id)
                    ->where('return_type', 'store_credit')
                    ->whereBetween('created_at', [$start, $end])
                    ->count();
            }

        } elseif ($request->input('values') && $request->input('values') == 7) {
            $labels = [];
            for ($i = 7; $i >= 1; $i--) {
                array_push($labels, Carbon::today()->subDays($i)->format('l'));
            }
            $current = 7;
            foreach ($labels as $label) {
                $start = Carbon::today()->subDays($current)->format('Y-m-d H-i-s');
                --$current;
                $end = Carbon::today()->subDays($current)->format('Y-m-d H-i-s');
                $datasets['exchange'][$label] = RequestProducts::where("shop_id", $shopfy->id)
                    ->where('return_type', 'exchange')
                    ->whereBetween('created_at', [$start, $end])
                    ->count();
                $datasets['payment_method'][$label] = RequestProducts::where("shop_id", $shopfy->id)
                    ->where('return_type', 'payment_method')
                    ->whereBetween('created_at', [$start, $end])
                    ->count();
                $datasets['store_credit'][$label] = RequestProducts::where("shop_id", $shopfy->id)
                    ->where('return_type', 'store_credit')
                    ->whereBetween('created_at', [$start, $end])
                    ->count();
            }
        } elseif ($request->input('values') && $request->input('values') == 30) {
            $labels = ['30 days', '24 days', '18 days', '15 days', '12 days', '6 days', 'Today'];
            $current = 30;
            foreach ($labels as $label) {
                $start = Carbon::today()->subDays($current)->format('Y-m-d H-i-s');
                $current -= 6;
                $end = Carbon::today()->subDays($current)->format('Y-m-d H-i-s');
                $datasets['exchange'][$label] = RequestProducts::where("shop_id", $shopfy->id)
                    ->where('return_type', 'exchange')
                    ->whereBetween('created_at', [$start, $end])
                    ->count();
                $datasets['payment_method'][$label] = RequestProducts::where("shop_id", $shopfy->id)
                    ->where('return_type', 'payment_method')
                    ->whereBetween('created_at', [$start, $end])
                    ->count();
                $datasets['store_credit'][$label] = RequestProducts::where("shop_id", $shopfy->id)
                    ->where('return_type', 'store_credit')
                    ->whereBetween('created_at', [$start, $end])
                    ->count();
            }
        } else if ($request->input('values') && $request->input('values') == 90) {
            $labels = ['90 days', '75 days', '60 days', '45 days', '30 days', '15 days', 'today'];
            $current = 90;
            foreach ($labels as $label) {
                $start = Carbon::today()->subDays($current)->format('Y-m-d H-i-s');
                $current -= 15;
                $end = Carbon::today()->subDays($current)->format('Y-m-d H-i-s');
                $datasets['exchange'][$label] = RequestProducts::where("shop_id", $shopfy->id)
                    ->where('return_type', 'exchange')
                    ->whereBetween('created_at', [$start, $end])
                    ->count();
                $datasets['payment_method'][$label] = RequestProducts::where("shop_id", $shopfy->id)
                    ->where('return_type', 'payment_method')
                    ->whereBetween('created_at', [$start, $end])
                    ->count();
                $datasets['store_credit'][$label] = RequestProducts::where("shop_id", $shopfy->id)
                    ->where('return_type', 'store_credit')
                    ->whereBetween('created_at', [$start, $end])
                    ->count();
            }
        } else if ($request->input('values') && $request->input('values') == 'y') {
            $labels = [];
            for ($i = 11; $i >= 0; $i--) {
                array_push($labels, Carbon::now()->subMonth($i)->format('M'));
            }
            $current = 11;
//            dd(Carbon::now()->subMonth(12));
            foreach ($labels as $label) {
                $start = Carbon::now()->subMonth($current)->format('Y-m-d H-i-s');
                $current -= 1;
                $end = Carbon::now()->subMonth($current)->format('Y-m-d H-i-s');
                $datasets['exchange'][$label] = RequestProducts::where("shop_id", $shopfy->id)
                    ->where('return_type', 'exchange')
                    ->whereBetween('created_at', [$start, $end])
                    ->count();
                $datasets['payment_method'][$label] = RequestProducts::where("shop_id", $shopfy->id)
                    ->where('return_type', 'payment_method')
                    ->whereBetween('created_at', [$start, $end])
                    ->count();
                $datasets['store_credit'][$label] = RequestProducts::where("shop_id", $shopfy->id)
                    ->where('return_type', 'store_credit')
                    ->whereBetween('created_at', [$start, $end])
                    ->count();
            }
        }
//        dd($datasets);

//        dd(Carbon::today()->format('l'));
        if ($type == 'non-custom') {

            $subdays = $request->input('values');

            if ($subdays == "1") {
                return redirect()->route('analytics');
            } elseif ($subdays == "-1") {
                $previous_date = date('Y-m-d', strtotime(Carbon::yesterday()));
                $message = "Yesterday";
                $view = $this->Analytics($previous_date, $message);
                return $view;
            } elseif ($subdays == "7" || $subdays == "30" || $subdays == "90") {

                if ($subdays == "7") {
                    $message = "Last 7 Days";

                } elseif ($subdays == "30") {
                    $message = "Last 30 Days";

                } elseif ($subdays == "90") {
                    $message = "Last 90 Days";

                }

                $request = \App\Models\Request::where("shop_id", $shopfy->id)
                    ->where("created_at", ">", Carbon::now()->subDays($subdays))->count();

                $refund = RequestProducts::where("shop_id", $shopfy->id)
                    ->where("created_at", ">", Carbon::now()->subDays($subdays))
                    ->where('return_type', 'payment_method')->count();

                $exchange = RequestProducts::where("shop_id", $shopfy->id)
                    ->where("created_at", ">", Carbon::now()->subDays($subdays))
                    ->where('return_type', 'exchange')->count();

                $store_credit = RequestProducts::where("shop_id", $shopfy->id)
                    ->where("created_at", ">", Carbon::now()->subDays($subdays))
                    ->where('return_type', 'store_credit')->count();

                $amount = \App\Models\Request::where("shop_id", $shopfy->id)
                    ->where("created_at", ">", Carbon::now()->subDays($subdays))->sum('request_amount');

                $return_products = RequestProducts::select('*', DB::raw('group_concat(product_sku) as product_sku,group_concat(reason) as reason
        ,group_concat(return_type) as return_type,group_concat(variant_id) as variant_id,group_concat(product_quantity) as product_quantity'))
                    ->where("shop_id", $shopfy->id)
                    ->where("created_at", ">", Carbon::now()->subDays($subdays))
                    ->groupBy('product_id')
                    ->cursor();

                $return_reasons = Reason::with(array('has_skus' => function ($query) use ($subdays) {
                    $query->where("created_at", ">", Carbon::now()->subDays($subdays));
                }))->where("shop_id", $shopfy->id)->cursor();


            } elseif ($subdays == "m") {
                $message = "Last Month";

                $request = \App\Models\Request::where("shop_id", $shopfy->id)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->whereMonth('created_at', Carbon::now()->subMonth()->month)->count();

                $refund = RequestProducts::where("shop_id", $shopfy->id)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->whereMonth('created_at', Carbon::now()->subMonth()->month)
                    ->where('return_type', 'Refund')->count();

                $exchange = RequestProducts::where("shop_id", $shopfy->id)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->whereMonth('created_at', Carbon::now()->subMonth()->month)
                    ->where('return_type', 'Exchange')->count();
                $store_credit = RequestProducts::where("shop_id", $shopfy->id)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->whereMonth('created_at', Carbon::now()->subMonth()->month)
                    ->where('return_type', 'store_credit')->count();

                $amount = \App\Models\Request::where("shop_id", $shopfy->id)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->whereMonth('created_at', Carbon::now()->subMonth()->month)->sum('request_amount');

                $return_products = RequestProducts::select('*', DB::raw('group_concat(product_sku) as product_sku,group_concat(reason) as reason
        ,group_concat(return_type) as return_type,group_concat(variant_id) as variant_id,group_concat(product_quantity) as product_quantity'))
                    ->where("shop_id", $shopfy->id)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->whereMonth('created_at', Carbon::now()->subMonth()->month)
                    ->groupBy('product_id')
                    ->cursor();

                $return_reasons = Reason::with(array('has_skus' => function ($query) {
                    $query->whereYear('created_at', Carbon::now()->year)
                        ->whereMonth('created_at', Carbon::now()->subMonth()->month);
                }))->where("shop_id", $shopfy->id)->cursor();


            } elseif ($subdays == "y") {
                $message = "Last Year";
                $request = \App\Models\Request::where("shop_id", $shopfy->id)
                    ->whereYear('created_at', Carbon::now()->subYear()->year)
                    ->count();

                $refund = RequestProducts::where("shop_id", $shopfy->id)
                    ->whereYear('created_at', Carbon::now()->subYear()->year)
                    ->where('return_type', 'Refund')->count();

                $exchange = RequestProducts::where("shop_id", $shopfy->id)
                    ->whereYear('created_at', Carbon::now()->subYear()->year)
                    ->where('return_type', 'Exchange')->count();

                $store_credit = RequestProducts::where("shop_id", $shopfy->id)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->whereYear('created_at', Carbon::now()->subYear()->year)
                    ->where('return_type', 'store_credit')->count();

                $amount = \App\Models\Request::where("shop_id", $shopfy->id)
                    ->whereYear('created_at', Carbon::now()->subYear()->year)->sum('request_amount');

                $return_products = RequestProducts::select('*', DB::raw('group_concat(product_sku) as product_sku,group_concat(reason) as reason
        ,group_concat(return_type) as return_type,group_concat(variant_id) as variant_id,group_concat(product_quantity) as product_quantity'))
                    ->where("shop_id", $shopfy->id)
                    ->whereYear('created_at', Carbon::now()->subYear()->year)
                    ->groupBy('product_id')
                    ->cursor();

                $return_reasons = Reason::with(array('has_skus' => function ($query) {
                    $query->whereYear('created_at', Carbon::now()->subYear()->year);
                }))->where("shop_id", $shopfy->id)->cursor();
            }

        } elseif ($type == 'custom') {
            $message = "Custom";

            $dates = explode('-', $request->input('values'));
            $starting_date = str_replace(' ', '', $dates[0]);
            $starting_date = str_replace('/', '-', $starting_date);
            $starting_date = date('Y-m-d', strtotime($starting_date));
            $ending_date = str_replace(' ', '', $dates[1]);
            $ending_date = str_replace('/', '-', $ending_date);
            $ending_date = date('Y-m-d', strtotime($ending_date));

            $request = \App\Models\Request::where("shop_id", $shopfy->id)
                ->whereBetween(DB::raw('date(created_at)'), [$starting_date, $ending_date])->count();

            $refund = RequestProducts::where("shop_id", $shopfy->id)
                ->whereBetween(DB::raw('date(created_at)'), [$starting_date, $ending_date])
                ->where('return_type', 'Refund')->count();

            $exchange = RequestProducts::where("shop_id", $shopfy->id)
                ->whereBetween(DB::raw('date(created_at)'), [$starting_date, $ending_date])
                ->where('return_type', 'Exchange')->count();
            $store_credit = RequestProducts::where("shop_id", $shopfy->id)
                ->whereBetween(DB::raw('date(created_at)'), [$starting_date, $ending_date])
                ->where('return_type', 'store_credit')->count();

            $amount = \App\Models\Request::where("shop_id", $shopfy->id)
                ->whereBetween(DB::raw('date(created_at)'), [$starting_date, $ending_date])->sum('request_amount');

            $return_products = RequestProducts::select('*', DB::raw('group_concat(product_sku) as product_sku,group_concat(reason) as reason
        ,group_concat(return_type) as return_type,group_concat(variant_id) as variant_id,group_concat(product_quantity) as product_quantity'))
                ->whereBetween(DB::raw('date(created_at)'), [$starting_date, $ending_date])
                ->groupBy('product_id')
                ->cursor();

            $return_reasons = Reason::with(array('has_skus' => function ($query) use ($starting_date, $ending_date) {
                $query->whereBetween(DB::raw('date(created_at)'), [$starting_date, $ending_date]);
            }))->where("shop_id", $shopfy->id)->cursor();
        }
        $exports = RequestExport::where('shop_id', $shopfy->id)->orderBy('created_at', 'desc')->cursor();
        return view('anaylatics')->with([
            'today_request' => $request,
            'today_amount' => $amount,
            'today_refund' => $refund,
            'today_exchange' => $exchange,
            'total_store_credit' => $store_credit,
            'return_products' => $return_products,
            'return_reasons' => $return_reasons,
            'shop_details' => $shopfy,
            'date' => $message,
            'datasets' => $datasets,
            'exports' => $exports


        ]);
    }


    public function createCSV(Request $request)
    {


        try {
            $csv = ExporterFacade::make('Csv');
            if ($request->input('date') !== 'custom') {

                $date = Carbon::today()->subDays($request->input('date'))->format('Y-m-d');
                $start = $date;
                $end = Carbon::today()->format('Y-m-d');
                $requests = \App\Models\Request::where('created_at', '>=', $date)->cursor();

            } else {

//            $start=Carbon::cr
                $request->validate([
                    'start_date' => 'required',
                    'end_date' => 'required'
                ]);
                $start = $request->start_date;
                $end = $request->end_date;
                $requests = \App\Models\Request::whereBetween('created_at', [$start, $end])->cursor();
            }

            $yourCollection = [];
            foreach ($requests as $req) {

                $order = $req->has_order;
//            $statuses=$req->has_statuses()->pluck('created_at','status');
                $label = $req->request_labels;
                if ($req->status == 0) {
                    $status = 'Requested';
                } elseif ($req->status == 1) {
                    $status = 'Approved';
                } elseif ($req->status == 2) {
                    $status = 'Package Received';
                } elseif ($req->status == 3) {
                    $status = 'Refunded';
                } else {
                    $status = 'Denied';
                }

                $item_json = collect(json_decode($req->items_json, true));
                $returntypes = $item_json->pluck('return_type')->toArray();
                $return_reasons = Reason::whereIn('id', $item_json->pluck('return_reason')->toArray())->pluck('name')->toArray();
//            $it=[
                foreach ($req->request_products as $req_pro) {
                    $request_exchange = RequestExchange::where('request_id', $req->id)->first();
                    $refunded_at = (isset($req->request_status(3)->created_at) ? $req->request_status(3)->created_at->format('Y-m-d') : null);
                    $it = [];
                    $it['Order Number'] = str_replace('#', 'US', $order->order_name);
                    $it['Return Number'] = 'Return #' . $req->id;
                    $it['Email'] = $order->email;
                    $it['Status'] = $status;
                    $it['Product'] = $req_pro->product_name;
                    $it['Quantity'] = $req_pro->product_quantity;
                    $it['Sku'] = $req_pro->product_sku;
                    $it['Return Reasons'] = $req_pro->reason;
                    $it['Return Types'] = $req_pro->return_type;
                    if ($refunded_at !== null) {

                        if ($req_pro->return_type == 'exchange' && $request_exchange !== null) {
                            $draft = json_decode($request_exchange->draft_json);

                            $dorder = Order::where('order_id', $draft->order_id)->first();

                            if ($dorder && $draft) {

                                $it['Notes'] = 'Exchange Order  ' . str_replace('#', 'US', $dorder->order_name) . ' placed at ' . $refunded_at;

                            } else {
                                $it['Notes'] = '';
                            }
                        } elseif ($req_pro->return_type == 'payment_method') {
                            $it['Notes'] = 'Refunded on ' . $refunded_at . ' to original payment method';
                        } else if ($req_pro->return_type == 'store_credit') {
                            $it['Notes'] = 'Refunded on ' . $refunded_at . ' to store credit';
                        } else {
                            $it['Notes'] = '';
                        }
                    } else {
                        $it['Notes'] = '';
                    }
                    $it['Tracking Carrier'] = (isset($label->carrier) ? $label->carrier : '');
                    $it['Tracking Number'] = (isset($label->tracking_code) ? $label->tracking_code : '');
                    $it['Ordered At'] = $order->created_at->format('Y-m-d');
                    $it['Requested At'] = (isset($req->request_status(0)->created_at) ? $req->request_status(0)->created_at->format('Y-m-d') : '');
                    $it['Approved At'] = (isset($req->request_status(1)->created_at) ? $req->request_status(1)->created_at->format('Y-m-d') : '');
                    $it['Package Received At'] = (isset($req->request_status(2)->created_at) ? $req->request_status(2)->created_at->format('Y-m-d') : '');
                    $it['Refunded At'] = $refunded_at;
//            ];
                    array_push($yourCollection, $it);
                }
            }



            $csv->load(collect($yourCollection))->setSerialiser(new BasicSerialiser());

            $path = 'exports/' . uniqid() . '.' . $csv->getType();

            $csv->save($path);

            $export = new RequestExport();
            $export->file = $path;
            $export->name = $request->name;
            $export->send_to = $request->send_to;
            $export->start_date = $start;
            $export->end_date = $end;
            $export->shop_id = Auth::id();
            $export->save();
//        dd($export);
            $settings = Setting::where('shop_id', Auth::id())->first();
            Mail::send('emails.export', ['export' => $export, 'settings' => $settings], function ($m) use ($export, $settings) {
                $m->from($settings->sender_email, $settings->sender_name);
                $m->attach($export->file);
                $m->to($export->send_to)->subject(($settings->export_subject) ? $settings->export_subject : 'Your Export');
            });
            flash('Email sent at ' . $export->send_to)->success();
            return back();
        } catch (\Exception $exception) {

            flash($exception->getMessage())->error();
        }
    }


    public function UpdateOrder($id, $shop)
    {
        $shopfy = User::where('name', $shop)->first();


        $order = $shopfy->api()->rest('GET', '/admin/orders/' . $id . '.json')['body']['order'];
        $order = json_decode(json_encode($order), FALSE);
        $checks = $order;

        $order_check = Order::where('order_id', $id)->first();


        $orders_items = $order->line_items;
        $products_ids = [];
        $products = [];
        $line_images = [];

        foreach ($orders_items as $item) {
            $product_detail = $shopfy->api()->rest('GET', '/admin/products/' . $item->product_id . '.json')['body']['product'];
            $product_detail = json_decode(json_encode($product_detail), FALSE);
            $order_line_product = OrderLineProduct::where('product_id', $item->product_id)->first();
            if ($order_line_product === null) {
                $order_line_product = new OrderLineProduct();
                $order_line_product->product_id = $item->product_id;
                $order_line_product->shop_id = $shopfy->id;

                $order_line_product->product_json = json_encode($product_detail);
                $order_line_product->save();
            }
            if (count($product_detail->images) > 1) {
                foreach ($product_detail->images as $product_image) {
                    if (count($product_image->variant_ids)) {
                        foreach ($product_image->variant_ids as $ids) {
                            if ($item->variant_id == $ids)
                                array_push($line_images, [
                                    'line_id' => $item->id,
                                    'image' => $product_image->src
                                ]);
                        }
                    }
                }
            } else {
                array_push($line_images, [
                    'line_id' => $item->id,
                    'image' => $product_detail->image->src
                ]);
            }
            $product_images = $shopfy->api()->rest('GET', '/admin/products/' . $item->product_id . '/images.json')['body']['images'];
            $product_images = json_decode(json_encode($product_images), FALSE);
            if (isset($product_images)) {
                if (isset($item->variant_id)) {
                    $variant = $shopfy->api()->rest('GET', '/admin/variants/' . $item->variant_id . '.json')['body']['variant'];
                    $variant = json_decode(json_encode($variant), FALSE);
                    if (isset($variant->image_id)) {
                        foreach ($product_images as $image) {
                            if ($image->id == $variant->image_id)
                                array_push($products, [
                                    'id' => $variant->id,
                                    'image' => $image->src
                                ]);
                        }
                    }


                    else {
                        foreach ($product_images as $image) {
                            array_push($products, [
                                'id' => $image->id,
                                'image' => $image->src
                            ]);
                        }

                    }


                } else {
                    foreach ($product_images as $image) {
                        array_push($products, [
                            'id' => $image->id,
                            'image' => $image->src
                        ]);
                    }

                }
            }
        }


        $products_json = json_encode($products);


        $order_check->order_id = $order->id;
        $order_check->order_name = '#' . str_replace('US', '', $order->order_number);
        $order_check->email = $order->email;
        $order_check->order_json = json_encode($order);
        $order_check->products_json = $products_json;
        $order_check->shop_id = $shopfy->id;
        $order_check->line_images = json_encode($line_images);
        $order_check->save();


    }


    public function requestRefund($id)
    {
        $request = \App\Models\Request::find($id);

        $request_products = $request->request_products();

        if (count($request_products->where('return_type', 'payment_method')->get())) {

            $amount = 0;
            $items = json_decode($request->items_json, true);
            foreach ($items as $it) {
                if ($it['return_type'] == 'payment_method') {
                    $amount += floatval($it['price']);
                }
            }
            $label = RequestLabel::where('request_id', $request->id)->first();
            if ($label && $label->fees_applied == false && isset($label->fees)) {
//                $amount += floatval($label->fees);
            }
            if ($this->Transaction($request->id, $amount)) {
//                $label->fees_applied = true;
                $request->refunded=true;
                $request->save();
                if($label) {
                    $label->save();
                }
            }
        }
        return back();
    }

    public function Transaction($request_id, $amount)
    {
        $request = \App\Models\Request::find($request_id);


        try {
            $shop = Auth::user();
            $items = json_decode($request->items_json, true);
            $lines = [];
            foreach ($items as $line) {
                if ($line['return_type'] == 'payment_method') {
                    $l['line_item_id'] = $line['id'];
                    $l['quantity'] = $line['quantity'];
                    array_push($lines, $l);
                }

            }
            $transaction = $shop->api()->rest('GET', '/admin/orders/' . $request->has_order->order_id . '/transactions.json');
            $transactions = $transaction['body']['transactions'];
            if (count($transactions)) {
                $refund = $shop->api()->rest('post', '/admin/orders/' . $request->has_order->order_id . '/refunds.json', [
                    'refund' => [
                        "notify" => true,
                        'refund_line_items' => $lines,
                        'transactions' => [
                            [
                                "parent_id" => $transactions[0]['id'],
                                "amount" => $amount,
                                "kind" => "refund",
                                "gateway" => $transactions[0]['gateway']
                            ]
                        ]
                    ]
                ]);
                $refund = json_decode(json_encode($refund), FALSE);
                $req_refund = new RequestRefund();
//                $req_refund->line_item_detail=json_encode($refund->refund_line_items);
//                $req_refund->currency=$refund->currency;
                $req_refund->order_id = $request->order_id;
//                $req_refund->parent_id=$transactions[0]['id'];
                $req_refund->request_id = $request->id;
                $req_refund->refunded_json = json_encode($refund);
                $req_refund->save();
                return $refund;
            } else {
                flash('Some Thing Went Wrong With Refund')->error();
                return redirect()->back();
            }
        } catch (\Exception $exception) {
            flash('Some Thing Went Wrong With Refund')->error();
            return false;
        }
    }
    public function markStoreCredit($id)
    {
        $request=\App\Models\Request::find($id);
        $request->store_credited=true;
        $request->save();
        $rest=new \App\Models\Request([
            'message'=>'Gift card issued at '.Carbon::today()->format('Y-m-d H:i:s'),
            'request_id'=>$id
        ]);
        $this->timeline_submit($rest);
        return back();

//        App\Request::whereHas('request_labels',function($lebel){$lebel->where('status','delivered');})->update(['store_credited'=>true]);
    }
}
