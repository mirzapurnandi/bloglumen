<?php

namespace App\Repositories;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Interfaces\TripayInterface;
use Illuminate\Support\Facades\Auth;

class TripayRepository implements TripayInterface
{
    // Use ResponseAPI Trait in this repository
    use ApiResponser;

    public function getPaymentChannel()
    {
        $apiKey = env('TRIPAY_API_KEY');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_FRESH_CONNECT     => true,
            CURLOPT_URL               => env('TRIPAY_LINK') . "merchant/payment-channel",
            CURLOPT_RETURNTRANSFER    => true,
            CURLOPT_HEADER            => false,
            CURLOPT_HTTPHEADER        => array(
                "Authorization: Bearer " . $apiKey
            ),
            CURLOPT_FAILONERROR       => false
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        $response = json_decode($response)->data;

        return $response ? $response : $err;
    }

    public function requestTransaction(Request $request)
    {
        $user = Auth::user();

        $apiKey = env('TRIPAY_API_KEY');
        $privateKey = env('TRIPAY_PRIVATE_KEY');
        $merchantCode = env('TRIPAY_MERCHANT_CODE');
        $merchantRef = 'TX-' . time();
        $amount = $request->price;

        $data = [
            'method'            => $request->method,
            'merchant_ref'      => $merchantRef,
            'amount'            => $amount,
            'customer_name'     => $user->name,
            'customer_email'    => $user->email,
            //'customer_phone'    => '081234567890',
            'order_items'       => [
                [
                    'name'      => $request->name_produk,
                    'price'     => $request->price,
                    'quantity'  => 1
                ]
            ],
            //'callback_url'      => 'https://domainanda.com/callback',
            //'return_url'        => 'https://domainanda.com/redirect',
            'expired_time'      => (time() + (24 * 60 * 60)), // 24 jam
            'signature'         => hash_hmac('sha256', $merchantCode . $merchantRef . $amount, $privateKey)
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_FRESH_CONNECT     => true,
            CURLOPT_URL               => env('TRIPAY_LINK') . "transaction/create",
            CURLOPT_RETURNTRANSFER    => true,
            CURLOPT_HEADER            => false,
            CURLOPT_HTTPHEADER        => array(
                "Authorization: Bearer " . $apiKey
            ),
            CURLOPT_FAILONERROR       => false,
            CURLOPT_POST              => true,
            CURLOPT_POSTFIELDS        => http_build_query($data)
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $response = json_decode($response)->data;
        return $response ? $response : $err;
    }

    public function detailTransaction($reference)
    {
        $apiKey = env('TRIPAY_API_KEY');

        $payload = [
            'reference' => $reference
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_FRESH_CONNECT     => true,
            CURLOPT_URL               => env('TRIPAY_LINK') . "transaction/detail?" . http_build_query($payload),
            CURLOPT_RETURNTRANSFER    => true,
            CURLOPT_HEADER            => false,
            CURLOPT_HTTPHEADER        => array(
                "Authorization: Bearer " . $apiKey
            ),
            CURLOPT_FAILONERROR       => false,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $response = json_decode($response)->data;
        return $response ? $response : $err;
    }
}
