<?php

namespace Usermp\LaravelLogin\app\Http\Services;

class Helpers
{
    /**
     * @param $phone_number
     * @return string
     */
    public static function cleanPhoneNumber($phone_number): string
    {
        $length = strlen($phone_number);
        if (strlen($length > 9 )){
            $phone_number = "09" . substr($phone_number, -9, 9);
        }
        return $phone_number;
    }

    public static function otp(int $count = 6): string
    {
        $otp = '';
        $digits = '0123456789';
        for ($i = 0; $i < $count; $i++) {
            $otp .= $digits[random_int(0, strlen($digits) - 1)];
        }
        return $otp;
    }
    public static function extractNumbersAed($text) {
        preg_match_all('/\d+(?:,\d+)?/', $text, $matches);
        return str_replace(",",'',$matches[0][0]);
    }

    public static function roundUpPrice($price, $roundingAmount)
    {
        return ceil($price / 1000) * $roundingAmount;
    }

}
