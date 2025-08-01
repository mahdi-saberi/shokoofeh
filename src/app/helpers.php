<?php

use App\Helpers\PersianDateHelper;

if (!function_exists('persian_date')) {
    /**
     * Convert date to Persian (Jalali) format
     */
    function persian_date($date, string $format = 'Y/m/d'): string
    {
        return PersianDateHelper::toPersian($date, $format);
    }
}

if (!function_exists('persian_date_for_humans')) {
    /**
     * Convert date to Persian human readable format
     */
    function persian_date_for_humans($date): string
    {
        return PersianDateHelper::toPersianForHumans($date);
    }
}

if (!function_exists('persian_weekday')) {
    /**
     * Get Persian weekday name
     */
    function persian_weekday($date): string
    {
        return PersianDateHelper::getPersianWeekday($date);
    }
}
