<?php

namespace App\Helpers;

use App\Models\Configuration;

class GeneralHelper
{
    static public function currencyFormatter($value, $currency = null, $country = null)
    {
        return Configuration::getValue('currency_symbol') . ' ' . GeneralHelper::allowDecimal($value, $country);
    }

    static public function allowDecimal($value, $country)
    {
        if (Configuration::getValue('decimal') == 'true') {
            return number_format($value, 2);
        } else {
            return number_format($value);
        }
    }
}
