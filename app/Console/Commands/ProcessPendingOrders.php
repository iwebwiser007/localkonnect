<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EcOrder;
use App\Http\Controllers\KDDeliveryController;

class ProcessPendingOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:process-pending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process pending orders to create contacts and delivery orders';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Get all orders with processed_status less than 2
        $pendingOrders = EcOrder::where('processed_status', '<', 2)->get();

        if ($pendingOrders->isEmpty()) {
            $this->info('No pending orders to process.');
            return 0;
        }

        $kdController = new KDDeliveryController(app('App\Services\KDDeliveryService'));

        foreach ($pendingOrders as $order) {
            try {
                // Process Contacts
                if ($order->processed_status < 1) {
                    $kdController->createContacts($order->id);
                    $this->info("Contacts created for Order ID: {$order->id}");
                }

                // Process Order
                if ($order->processed_status == 1) {
                    $kdController->createOrder($order->id);
                    $this->info("Order created for Order ID: {$order->id}");
                }
            } catch (\Exception $e) {
                \Log::error("Error processing order ID {$order->id}: " . $e->getMessage());
                $this->error("Error processing Order ID: {$order->id}");
            }
        }

        $this->info('Pending orders processed successfully!');
        return 0;
    }
}
