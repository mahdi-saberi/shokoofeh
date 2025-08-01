<?php

namespace App\Helpers;

use Carbon\Carbon;

class PersianDateHelper
{
    /**
     * Persian month names
     */
    private static array $persianMonths = [
        1 => 'فروردین',
        2 => 'اردیبهشت',
        3 => 'خرداد',
        4 => 'تیر',
        5 => 'مرداد',
        6 => 'شهریور',
        7 => 'مهر',
        8 => 'آبان',
        9 => 'آذر',
        10 => 'دی',
        11 => 'بهمن',
        12 => 'اسفند'
    ];

    /**
     * Convert Gregorian date to Persian (Jalali) date
     */
    public static function toPersian($date, string $format = 'Y/m/d'): string
    {
        if (!$date) {
            return '';
        }

        // Ensure we have a Carbon instance
        if (!$date instanceof Carbon) {
            $date = Carbon::parse($date);
        }

        // Get Gregorian date components
        $gy = $date->year;
        $gm = $date->month;
        $gd = $date->day;

        // Convert to Persian
        $persian = self::gregorianToPersian($gy, $gm, $gd);

        // Format the date based on the format string
        return self::formatPersianDate($persian, $format, $date);
    }

    /**
     * Convert Persian date to human readable format
     */
    public static function toPersianForHumans($date): string
    {
        if (!$date) {
            return '';
        }

        // Ensure we have a Carbon instance
        if (!$date instanceof Carbon) {
            $date = Carbon::parse($date);
        }

                $now = Carbon::now();

        // If date is in the future, show as future
        if ($date->gt($now)) {
            return 'در آینده';
        }

        $diffInSeconds = abs($now->diffInSeconds($date));
        $diffInMinutes = abs($now->diffInMinutes($date));
        $diffInHours = abs($now->diffInHours($date));
        $diffInDays = abs($now->diffInDays($date));

        if ($diffInSeconds < 60) {
            return 'چند ثانیه پیش';
        } elseif ($diffInMinutes < 60) {
            return intval($diffInMinutes) . ' دقیقه پیش';
        } elseif ($diffInHours < 24) {
            return intval($diffInHours) . ' ساعت پیش';
        } elseif ($diffInDays < 30) {
            return intval($diffInDays) . ' روز پیش';
        } elseif ($diffInDays < 365) {
            $months = intval($diffInDays / 30);
            return $months . ' ماه پیش';
        } else {
            $years = intval($diffInDays / 365);
            return $years . ' سال پیش';
        }
    }

    /**
     * Convert Gregorian to Persian (Jalali) calendar
     */
    private static function gregorianToPersian(int $gy, int $gm, int $gd): array
    {
        $g_d_m = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];

        if ($gy <= 1600) {
            $jy = 0;
            $gy -= 621;
        } else {
            $jy = 979;
            $gy -= 1600;
        }

        if ($gm > 2) {
            $gy2 = $gy + 1;
        } else {
            $gy2 = $gy;
        }

        $days = (365 * $gy) + (intval(($gy2 + 3) / 4)) - (intval(($gy2 + 99) / 100)) +
                (intval(($gy2 + 399) / 400)) - 80 + $gd + $g_d_m[$gm - 1];

        $jy += 33 * intval($days / 12053);
        $days %= 12053;

        $jy += 4 * intval($days / 1461);
        $days %= 1461;

        if ($days > 365) {
            $jy += intval(($days - 1) / 365);
            $days = ($days - 1) % 365;
        }

        if ($days < 186) {
            $jm = 1 + intval($days / 31);
            $jd = 1 + ($days % 31);
        } else {
            $jm = 7 + intval(($days - 186) / 30);
            $jd = 1 + (($days - 186) % 30);
        }

        return [$jy, $jm, $jd];
    }

    /**
     * Format Persian date based on format string
     */
    private static function formatPersianDate(array $persian, string $format, Carbon $carbonDate): string
    {
        [$jy, $jm, $jd] = $persian;

        $replacements = [
            'Y' => $jy,
            'y' => substr($jy, -2),
            'm' => sprintf('%02d', $jm),
            'n' => $jm,
            'd' => sprintf('%02d', $jd),
            'j' => $jd,
            'F' => self::$persianMonths[$jm],
            'M' => substr(self::$persianMonths[$jm], 0, 3),
            'H' => $carbonDate->format('H'),
            'i' => $carbonDate->format('i'),
            's' => $carbonDate->format('s'),
            'A' => $carbonDate->format('A') === 'AM' ? 'ق.ظ' : 'ب.ظ',
            'a' => $carbonDate->format('A') === 'AM' ? 'ق.ظ' : 'ب.ظ',
        ];

        $result = $format;
        foreach ($replacements as $search => $replace) {
            $result = str_replace($search, $replace, $result);
        }

        return $result;
    }

    /**
     * Get Persian weekday name
     */
    public static function getPersianWeekday(Carbon $date): string
    {
        $weekdays = [
            0 => 'یکشنبه',
            1 => 'دوشنبه',
            2 => 'سه‌شنبه',
            3 => 'چهارشنبه',
            4 => 'پنج‌شنبه',
            5 => 'جمعه',
            6 => 'شنبه'
        ];

        return $weekdays[$date->dayOfWeek];
    }
}
