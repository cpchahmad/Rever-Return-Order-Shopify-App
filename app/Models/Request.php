<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;


    public function has_order(){
        return $this->belongsTo('App\Models\Order', 'order_id');
    }

    public function returnMethods()
    {
        $items=json_decode($this->items_json,true);
        $methods=[];
        foreach ($items as $item)
        {
            array_push($methods,ucwords(str_replace('_',' ',$item['return_type'])));
        }
        $methods=collect($methods)->unique();
        return $methods->toArray();
    }

    public function request_products()
    {
        return $this->hasMany(RequestProducts::class, 'request_id');
    }

    public function request_labels()
    {
        return $this->hasOne(RequestLabel::class,'request_id');
    }

    public function request_status($status)
    {
        return $this->has_statuses()->where('status',$status)->first();
    }

    public function has_statuses(){
        return $this->hasMany('App\Models\RequestStatus', 'request_id');
    }

    public function has_timelines(){
        return $this->hasMany('App\Models\Timeline');
    }

    public function request_refund()
    {
        return $this->hasMany(RequestRefund::class,'request_id');
    }


    public function payment_method_products()
    {
        $collection=collect([]);
        foreach (json_decode($this->items_json,true) as $item)
        {
            if($item['return_type']=='payment_method')
                $collection->add($item);
        }
        return $collection;

    }

    public function store_credit_products()
    {
        $collection=collect([]);
        foreach (json_decode($this->items_json,true) as $item)
        {
            if($item['return_type']=='store_credit')
                $collection->add($item);
        }
        return $collection;

    }
}
