<?php

namespace Payments\Helper\Facades;

use Illuminate\Support\Facades\Facade;

class Paymob extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'YourVendor\PaymobPackage\Services\Paymob';
    }
}
