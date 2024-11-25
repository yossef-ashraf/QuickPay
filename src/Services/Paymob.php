<?php

namespace Payments\Helper\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Exception;

class Paymob
{
    private $paymob_secret_key;
    private $paymob_public_key;
    private $paymob_hmac;
    public $currency;
    private $paymob_methods;

    public function __construct()
    {
        $this->paymob_public_key = config('paymob.public_key');
        $this->paymob_secret_key = config('paymob.secret_key');
        $this->paymob_hmac = config('paymob.hmac');
        $this->paymob_methods = config('paymob.methods');
        $this->currency = config('paymob.currency');
    }

    public function pay($amount, $user_id, $user_first_name, $user_last_name, $user_email, $user_phone, $source)
    {
        // الكود كما هو هنا
        $special_reference = uniqid('order_');
        $billing_data = [
            "first_name" => $user_first_name,
            "last_name" => $user_last_name,
            "phone_number" => $user_phone,
            "email" => $user_email,
            // باقي البيانات
        ];

        $request_data = [
            'amount' => $amount * 100,
            'currency' => $this->currency,
            'payment_methods' => $this->paymob_methods,
            'special_reference' => $special_reference,
            'billing_data' => $billing_data,
            'customer' => [
                'first_name' => $user_first_name,
                'last_name' => $user_last_name,
                'email' => $user_email,
            ],
            'redirection_url' => 'https://your_redirect_url',
            'notification_url' => 'https://your_notification_url',
        ];

        // إرسال الطلب إلى Paymob
        $response = Http::withHeaders([
            'Authorization' => 'Token ' . $this->paymob_secret_key,
            'Content-Type' => 'application/json',
        ])->post('https://accept.paymob.com/v1/intention/', $request_data);

        if ($response->successful()) {
            $client_secret = $response->json()['client_secret'];
            $payment_url = "https://accept.paymob.com/unifiedcheckout/?publicKey={$this->paymob_public_key}&clientSecret={$client_secret}";

            return [
                'payment_id' => $special_reference,
                'redirect_url' => $payment_url,
            ];
        }

        return [
            'payment_id' => $special_reference,
            'redirect_url' => '',
        ];
    }

    public function verify(Request $request): array
    {
        // الكود كما هو هنا ...
    }
}
