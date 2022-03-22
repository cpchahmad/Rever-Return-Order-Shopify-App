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

class OrdersCreateJob implements ShouldQueue
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


        try {
            $order=new OrderController();
            $order->OrdersSyncWebhook($this->data->id,$this->shopDomain);
            return true;
            DB::table('error_logs')->insert([
                'message' => 'order create complete',
            ]);
        }catch (\Exception $exception)
        {
            return ;
        }
        // Do what you wish with the data
        // Access domain name as $this->shopDomain->toNative()
    }
}
