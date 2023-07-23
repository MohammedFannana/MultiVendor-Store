<?php

// This class beacuse coins
namespace App\Helpers;

use NumberFormatter;

class Currency
{
    // ... conver array to argument
    public function __invoke(...$params)
    {
        return static::format(...$params);
    }

    public static function format($amount, $currency = null)
    {
        // (lang)

        $formatter = new NumberFormatter(config('app.locale'), NumberFormatter::CURRENCY);

        if ($currency === null) {
            $currency = 'USD';
        }
        return $formatter->formatCurrency($amount, $currency);
    }
}
