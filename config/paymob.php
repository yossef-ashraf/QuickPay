<?php

return [
    'public_key' => env('PAYMOB_PUBLIC_KEY', 'your_public_key'),
    'secret_key' => env('PAYMOB_SECRET_KEY', 'your_secret_key'),
    'hmac' => env('PAYMOB_HMAC', 'your_hmac_key'),
    'methods' => [],
    'currency' => 'EGP',
];
