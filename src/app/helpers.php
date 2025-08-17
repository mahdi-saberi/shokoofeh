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

if (!function_exists('format_currency')) {
    /**
     * Format currency with Persian abbreviations (هزار، میلیون، میلیارد)
     */
    function format_currency($amount): string
    {
        if ($amount >= 1000000000) {
            return number_format($amount / 1000000000, 1) . ' میلیارد تومان';
        } elseif ($amount >= 1000000) {
            return number_format($amount / 1000000, 1) . ' میلیون تومان';
        } elseif ($amount >= 1000) {
            return number_format($amount / 1000, 0) . ' هزار تومان';
        } else {
            return number_format($amount, 0) . ' تومان';
        }
    }
}

if (!function_exists('format_currency_short')) {
    /**
     * Format currency with short Persian abbreviations (ه.ت، م.ت، م.ت)
     */
    function format_currency_short($amount): string
    {
        if ($amount >= 1000000000) {
            return number_format($amount / 1000000000, 1) . ' م.ت';
        } elseif ($amount >= 1000000) {
            return number_format($amount / 1000000, 1) . ' م.ت';
        } elseif ($amount >= 1000) {
            return number_format($amount / 1000, 0) . ' ه.ت';
        } else {
            return number_format($amount, 0) . ' ت';
        }
    }
}
