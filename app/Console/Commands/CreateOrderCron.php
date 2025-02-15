<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\KDDeliveryController;
use App\Models\EcOrder;  // Import the EcOrder model

class CreateOrderCron extends Command
{
    protected $signature = 'create:orders';  // Command name
    protected $description = 'Create contacts and orders based on processed_status';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Fetch orders with processed_status 0 or 1
        $orders = EcOrder::whereIn('processed_status', [0, 1])->get();

        // Loop through each order and check processed_status
        foreach ($orders as $order) {
            if ($order->processed_status == 0) {
                // If processed_status is 0, call createContacts method
                $this->info("Processing createContacts for orderId: {$order->id}");

                // Instantiate the controller and call the createContacts method
                $controller = new KDDeliveryController();
                $controller->createContacts($order->id);
            } elseif ($order->processed_status == 1) {
                // If processed_status is 1, call createOrder method
                $this->info("Processing createOrder for orderId: {$order->id}");

                // Instantiate the controller and call the createOrder method
                $controller = new KDDeliveryController();
                $controller->createOrder($order->id);
            }
        }
    }
}
