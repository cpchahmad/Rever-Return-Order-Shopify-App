<?php namespace App\Jobs;

use App\Http\Controllers\OrderController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Osiset\ShopifyApp\Objects\Values\ShopDomain;
use stdClass;

class OrdersUpdateJob implements ShouldQueue
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
        $this->shopDomain = ShopDomain::fromNative($this->shopDomain);
//            DB::table('error_logs')->insert([
//
//                'message' => 'order update webhook'. $this->shopDomain->toNative(),
//
//            ]);
        try {
            $order = new OrderController();
            $order->UpdateOrder($this->data->id, $this->shopDomain->toNative());



            return true;
        } catch (\Exception $exception) {

            DB::table('error_logs')->insert([

                'message' => 'order update catch webhook'.$exception->getMessage(),

            ]);
            return;
        }


        // Do what you wish with the data
        // Access domain name as $this->shopDomain->toNative()
    }
}
