<?php namespace App\Jobs;

use App\Models\OrderLineProduct;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Osiset\ShopifyApp\Objects\Values\ShopDomain;
use stdClass;

class ProductUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Shop's myshopify domain
     *
     * @var ShopDomain|string
     */
    public $shopDomain;

    /**
     * The webhook data
     *
     * @var object
     */
    public $data;

    /**
     * Create a new job instance.
     *
     * @param string   $shopDomain The shop's myshopify domain.
     * @param stdClass $data       The webhook data (JSON decoded).
     *
     * @return void
     */
    public function __construct($shopDomain, $data)
    {
        $this->shopDomain = $shopDomain;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Convert domain
//        $this->shopDomain = ShopDomain::fromNative($this->shopDomain);
        $this->shopDomain = ShopDomain::fromNative($this->shopDomain);


        try {

            $shop=User::where('name',$this->shopDomain->toNative())->first();
            $product=OrderLineProduct::where('product_id',$this->data->id)->where('shop_id',$shop->id)->first();
            if($product==null)
            {
                $product=new OrderLineProduct();
                $product->product_id=$this->data->id;
                $product->shop_id=$shop->id;
            }
            $product->product_json=json_encode($this->data);
            $product->save();

            return true;
        }catch (\Exception $exception)
        {
            return true;
        }

        // Do what you wish with the data
        // Access domain name as $this->shopDomain->toNative()
    }
}
