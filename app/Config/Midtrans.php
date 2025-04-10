<?php

namespace Config;

use Midtrans\Config;

class Midtrans
{
    public static $serverKey;
    public static $clientKey;
    public static $isProduction;

    public static function init()
    {
        self::$serverKey = env('MIDTRANS_SERVER_KEY');
        self::$clientKey = env('MIDTRANS_CLIENT_KEY');
        self::$isProduction = env('MIDTRANS_IS_PRODUCTION');

        Config::$serverKey = self::$serverKey;
        Config::$isProduction = self::$isProduction;
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }
}

Midtrans::init();
