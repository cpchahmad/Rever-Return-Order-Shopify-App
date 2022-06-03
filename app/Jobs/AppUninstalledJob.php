<?php namespace App\Jobs;

use App\Http\Controllers\SuperAdminController;
use App\Models\EasyPost;
use App\Models\ItemSession;
use App\Models\Order;
use App\Models\OrderChecks;
use App\Models\OrderLineProduct;
use App\Models\PortalContent;
use App\Models\PortalDesign;
use App\Models\PreviousRequest;
use App\Models\Reason;
use App\Models\RefundTypes;
use App\Models\Request;
use App\Models\RequestDraftOrder;
use App\Models\RequestExchange;
use App\Models\RequestExport;
use App\Models\RequestGiftCard;
use App\Models\RequestLabel;
use App\Models\RequestProducts;
use App\Models\RequestRefund;
use App\Models\RequestSetting;
use App\Models\RequestShippingAddress;
use App\Models\RequestStatus;
use App\Models\Setting;
use App\Models\Timeline;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Osiset\ShopifyApp\Objects\Values\ShopDomain;
use stdClass;

class AppUninstalledJob implements ShouldQueue
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

        $shop= User::where('name', $this->shopDomain->toNative())->first();
        if($shop) {
    $uninstall = new SuperAdminController();
    $uninstall->ShopUninstallJob($shop);


            }
        return true;
        // Do what you wish with the data
        // Access domain name as $this->shopDomain->toNative()
    }
}
