<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EcomExpressController extends Controller
{
    /**
     * Fetch AWB Numbers from Ecom Express API.
     */
  public function fetchAWBNumbers($count = 1)
{
    $url = 'https://clbeta.ecomexpress.in/services/shipment/products/v2/fetch_awb';
    $username = urlencode("PHACOLITEPROLIFICPRIVATELIMITED247304");
        $password = urlencode("wWIX41YNVp");

    // Validate count
    if (!is_numeric($count) || $count <= 0) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid count value. It must be greater than 0.'
        ], 400);
    }

    // Send API request
    $response = Http::asForm()
        ->post($url, [
            'username' => $username,
            'password' => $password,
            'count' => $count,
            'type' => 'EXPP'
        ]);

    // Log response for debugging
    Log::info('Fetch AWB API Response:', ['body' => $response->json()]);

    // Handle successful responses
    if ($response->successful()) {
        $data = $response->json();

        if (isset($data['success']) && $data['success'] === true && isset($data['awb_numbers'])) {
            return response()->json([
                'success' => true,
                'awb_numbers' => $data['awb_numbers']
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $data['response']['description'] ?? 'Invalid response from API.',
            'error' => $data
        ], 400);
    }

    // Handle HTTP errors
    return response()->json([
        'success' => false,
        'message' => 'HTTP Error: ' . $response->status(),
        'error' => $response->json()
    ], 500);
}


    /**
     * Send shipment manifest to Ecom Express API.
     */
    public function sendManifest()
    {
        $url = 'https://clbeta.ecomexpress.in/services/expp/manifest/v2/expplus';

        // Authentication details
        $username = urlencode("PHACOLITEPROLIFICPRIVATELIMITED247304");
        $password = urlencode("wWIX41YNVp");

        // Fetch AWB number dynamically
        $awbNumbers = $this->fetchAWBNumbers(1);
        if (!is_array($awbNumbers) || empty($awbNumbers)) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch AWB numbers. The response was empty or invalid.'
            ], 400);
        }

        $awbNumber = $awbNumbers[0];

        // Payload
        $data = [[
            "AWB_NUMBER" => $awbNumber,
            "ORDER_NUMBER" => "12-903624",
            "PRODUCT" => "COD",
            "CONSIGNEE" => "Test shipment do not ship",
            "CONSIGNEE_ADDRESS1" => "Test shipment",
            "CONSIGNEE_ADDRESS2" => "Test shipment",
            "DESTINATION_CITY" => "Bijapur",
            "STATE" => "Chhattisgarh",
            "PINCODE" => "122012",
            "MOBILE" => "9560350578",
            "RETURN_NAME" => "Test shipment",
            "RETURN_PINCODE" => "110037",
            "PICKUP_NAME" => "Test shipment",
            "PICKUP_PINCODE" => "110037",
            "COLLECTABLE_VALUE" => 1,
            "DECLARED_VALUE" => 1,
            "ITEM_DESCRIPTION" => "Test shipment",
            "ACTUAL_WEIGHT" => 0.5,
            "INVOICE_DATE" => "2022-08-18",
            "SELLER_GSTIN" => "36XXX1230X1X6",
            "GST_TAX_BASE" => 1,
            "GST_TAX_TOTAL" => 1,
            "ITEM_CATEGORY" => "SKINCARE",
        ]];

        // API request
        $response = Http::asMultipart()
            ->withBasicAuth($username, $password)
            ->post($url, [
                'username' => $username,
                'password' => $password,
                'json_input' => json_encode($data),
            ]);

        // Handle the response
        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'message' => 'Manifest sent successfully',
                'response' => $response->json()
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to send manifest',
            'error' => $response->json()
        ], 400);
    }
}