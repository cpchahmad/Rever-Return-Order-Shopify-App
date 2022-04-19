<?php

namespace App\Http\Controllers;

use App\Models\Reason;
use App\Models\ReasonsDataSet;
use App\Models\RequestCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReasonsController extends Controller
{

    //function used to show Settings/Order Detail/ Return reasons page
    public function settings_reasons(){
        $shopfy = Auth::user();
        return view('settings.reasons')->with([
            'ReasonDataSets' => ReasonsDataSet::all(),
            'reasons'=> Reason::where([
                'shop_id' => $shopfy->id,
            ])->orderBy('category_id')->get(),
            'categories' => RequestCategory::all(),
            'edit_reason' => "",
            'title'=> 'Order',
            'sub_title'=> "reasons"
        ]);
    }

//Save Reason
    public function addCustomReason(Request $request)
    {
        $status=$request->input('status');

        if($status=="update"){
            $shopfy = Auth::user();
            $edit_reason=Reason::where('id',$request->input('reason_id'))
                ->where('shop_id',$shopfy->id)
                ->update([
                    'name'=>$request->name,
                    'category_id' =>   $request->category_id
                ]);
            return redirect()->route('settings.reasons');

        }else{
            $shopfy = Auth::user();
            $reason = new Reason();
            $reason->name= $request->name;
            $reason->category_id = $request->category_id;
            $reason->shop_id = $shopfy->id;
            $reason->reason_type = 2;
            $reason->save();
            return redirect()->back();
        }

    }

    //Edit Reason
    public function settings_reasons_edit($id){

        $shopfy = Auth::user();

        $edit_reason= Reason::where([
            'id'=>$id,
            'shop_id' => $shopfy->id,
        ])->first();

        return view('settings.reasons')->with([
            'ReasonDataSets' => ReasonsDataSet::all(),
            'reasons'=> Reason::where([
                'shop_id' => $shopfy->id,
            ])->get(),
            'categories' => RequestCategory::all(),
            'edit_reason'=>$edit_reason
        ]);
    }

//Delete Reason
    public function settings_reasons_delete($id){
        $shopfy = Auth::user();
        $delete_resson=Reason::where('shop_id',$shopfy->id)
            ->where('id',$id)
            ->delete();
        return redirect()->route('settings.reasons');
    }
}
