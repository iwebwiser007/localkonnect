<?php

namespace App\Http\Controllers;

use App\Models\EcOrder;
use App\Models\MpStore;
use App\Models\EcCustomer;
use App\Models\EcOrderAddress;
use App\Services\KDDeliveryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \DateTime;
use \DateTimeZone;


class KDDeliveryController extends Controller
{
    protected $kdService;

    public function __construct(KDDeliveryService $kdService)
    {
        $this->kdService = $kdService;
    }

    /**
     * Create Vendor (Contact A) and Customer (Contact B) using KD Delivery API.
     *
     * @param int $orderId
     * @return \Illuminate\Http\JsonResponse
     */
    public function createContacts($orderId)
    {
        try {
            // Load Order with Store Relationship
            $order = EcOrder::find($orderId);

            // Validate Order
            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => "Order with ID {$orderId} not found in ec_orders table."
                ], 404);
            }

            // Check processed_status to ensure idempotency
            if ($order->processed_status >= 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Contacts already created for this order.'
                ]);
            }

            // Get store_id from ec_orders
            $storeId = $order->store_id;

            if (!$storeId) {
                return response()->json([
                    'success' => false,
                    'message' => "store_id is missing for order_id {$orderId} in ec_orders table."
                ], 404);
            }

            // Match store_id with mp_stores
            $vendor = MpStore::find($storeId);

            if (!$vendor) {
                return response()->json([
                    'success' => false,
                    'message' => "Vendor not found for store_id {$storeId} in mp_stores table."
                ], 404);
            }

            // Check if Vendor Contact Exists
            $contactA = $vendor->kd_contact_id;

            if (!$contactA) {
                // Create Contact A (Vendor)
                $contactAResponse = $this->kdService->createContact(
                    $vendor->name,
                    $vendor->phone,
                    $vendor->address,
                    '' // Address Line 2
                );

                // Save Contact A ID in mp_stores
                $vendor->kd_contact_id = $contactAResponse['id'];
                $vendor->save();
                $contactA = $contactAResponse['id'];
            }

            // Get Customer Address
            $customer = EcOrderAddress::where('order_id', $orderId)->first();

            if (!$customer) {
                return response()->json([
                    'success' => false,
                    'message' => "Customer address not found for order_id {$orderId} in ec_order_addresses table."
                ], 404);
            }

            // Get the customer_id using order's user_id
            $userId = $order->user_id;
            $customerRecord = EcCustomer::where('id', $userId)->first();

            if (!$customerRecord) {
                return response()->json([
                    'success' => false,
                    'message' => "Customer not found for user_id {$userId} in ec_customers table."
                ], 404);
            }

            // Check if Customer Contact Exists (kd_contact_id)
            $contactB = $customerRecord->kd_contact_id;

            if (!$contactB) {
    // Normalize phone number to exclude +91 prefix if present
    $normalizedPhone = preg_replace('/^\+91/', '', $customer->phone);

    // Create Contact B (Customer)
    $contactBResponse = $this->kdService->createContact(
        $customer->name,
        $normalizedPhone,
        $customer->address,
        $customer->zip_code
    );

    // Save Contact B ID in ec_customers table
    $customerRecord->kd_contact_id = $contactBResponse['id'];
    $customerRecord->save();
    $contactB = $contactBResponse['id'];
}


            // Update the EcOrder with contactB_id and set processed_status
            $order->kd_contact_id = $contactB;
            $order->processed_status = 1; // Mark as processed
            $order->save();

            return response()->json([
                'success' => true,
                'contactA_id' => $contactA,
                'contactB_id' => $contactB,
                'message' => 'Both contacts created successfully and saved!'
            ]);
        } catch (\Exception $e) {
            \Log::error("Error creating contacts", [
                'order_id' => $orderId,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Create Order using KD Delivery API
     *
     * @param int $orderId
     * @return \Illuminate\Http\JsonResponse
     */
public function createOrder($orderId)
{
    try {
        // Load Order with Store Relationship
        $order = EcOrder::find($orderId);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => "Order with ID {$orderId} not found in ec_orders table."
            ], 404);
        }

        \Log::info("Order ID: {$orderId}, Current processed_status: {$order->processed_status}");

        if ($order->processed_status != 1) {
            return response()->json([
                'success' => false,
                'message' => 'Order cannot be created unless processed_status is 1.',
                'current_status' => $order->processed_status
            ]);
        }
      
    $orderShipment = DB::table('ec_shipments')
    ->where('order_id', $order->id) // Match the order_id with the order's id
    ->first();

if (!$orderShipment || $orderShipment->status !== 'ready_to_be_shipped_out') { // Check if the status is not 'processing'
    return response()->json([
        'success' => false,
        'message' => 'Order cannot be created unless shipment status is "processing".',
        'current_status' => $orderShipment ? $orderShipment->status : 'not found'
    ]);
}

// Continue with order processing if status is 'processing'


        $storeId = $order->store_id;

        if (!$storeId) {
            return response()->json([
                'success' => false,
                'message' => "store_id is missing for order_id {$orderId} in ec_orders table."
            ], 404);
        }

        $vendor = MpStore::find($storeId);

        if (!$vendor) {
            return response()->json([
                'success' => false,
                'message' => "Vendor not found for store_id {$storeId} in mp_stores table."
            ], 404);
        }

        $contactA = $vendor->kd_contact_id;

        if (!$contactA) {
            $contactAResponse = $this->kdService->createContact(
                $vendor->name,
                $vendor->phone,
                $vendor->address,
                '' // Address Line 2
            );

            $vendor->kd_contact_id = $contactAResponse['id'];
            $vendor->save();
            $contactA = $contactAResponse['id'];
        }

        $customer = EcOrderAddress::where('order_id', $orderId)->first();

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => "Customer address not found for order_id {$orderId} in ec_order_addresses table."
            ], 404);
        }

        $customerId = $order->user_id;

        $customerData = EcCustomer::where('id', $customerId)->first();

        if (!$customerData) {
            return response()->json([
                'success' => false,
                'message' => "Customer not found for user_id {$customerId} in ec_customers table."
            ], 404);
        }

        $contactB = $customerData->kd_contact_id;

        if (!$contactB) {
    // Normalize phone number to remove +91, +0, or any non-numeric characters
    $normalizedPhone = preg_replace('/^(\+91|0+)/', '', $customer->phone); // Remove +91 or leading zeros
    $normalizedPhone = preg_replace('/\D/', '', $normalizedPhone); // Remove any non-digit characters
    
    // Ensure phone number is exactly 10 digits
    if (strlen($normalizedPhone) !== 10) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid phone number. Please provide a 10-digit number.',
        ]);
    }

    // Call service with the normalized phone number
    $contactBResponse = $this->kdService->createContact(
        $customer->name,
        $normalizedPhone,
        $customer->address,
        $customer->zip_code
    );

    $customerData->kd_contact_id = $contactBResponse['id'];
    $customerData->save();
    $contactB = $contactBResponse['id'];
}


        $datetime = new DateTime('now', new DateTimeZone('Asia/Kolkata'));


$orderData = [
    'vehicle_type' => 'bike',
    'today_date' => date('Y-m-d'),
    'order_amount' => $order->amount,
    'order_description' => $order->description,
    'client_pick_up_code' => '',
    'pick_up_contact' => $contactA,
    'drop_off_contact' => $contactB,
    
];



        $url = "https://api.sandbox.staging.kd-solutions.in/api/v2/tp/order";
        $apikey = "ST_5cd7a44681892bdbcdbe";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "apikey: $apikey"
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($orderData));
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            return response()->json([
                'success' => false,
                'message' => curl_error($ch)
            ], 500);
        }

        curl_close($ch);

        $responseData = json_decode($response, true);

        // Check if share_code is present
        if (isset($responseData['share_code'])) {
            \Log::info("Order created successfully for Order ID: {$orderId}", [
                'share_code' => $responseData['share_code'],
                'tracking_link' => $responseData['tracking_link'] ?? null,
                'api_order_id' => $responseData['order_id'] ?? null,
            ]);

           
            $order->processed_status = 2;

            if ($order->save()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Order created successfully and status updated to 2!',
                    'order_response' => $responseData
                ]);
            } else {
                \Log::error("Failed to update processed_status to 2 for Order ID: {$orderId}");
                return response()->json([
                    'success' => false,
                    'message' => 'Order created, but failed to update processed_status to 2.',
                ], 500);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create order.',
                'order_response' => $responseData
            ], 500);
        }
    } catch (\Exception $e) {
        \Log::error("Error creating order", [
            'order_id' => $orderId,
            'error' => $e->getMessage(),
        ]);

        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 500);
    }
}



}
