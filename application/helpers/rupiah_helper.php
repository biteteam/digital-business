<?php

if (!function_exists('rp')) {
    /**
     * Format number to Rupiah currency format
     *
     * @param float|int $amount
     * @return string
     */
    function rp($amount, $isAmountOnly = false)
    {
        if ($isAmountOnly) return number_format($amount, 0, ',', '.');
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}



if (!function_exists('convertWeight')) {
    function convertWeight($grams)
    {
        if ($grams >= 1000) {
            $kilograms = $grams / 1000;
            return round($kilograms, 2) . ' kg';
        } elseif ($grams >= 1) {
            return $grams . ' gram';
        } else {
            $milligrams = $grams * 1000;
            return round($milligrams, 2) . ' mg';
        }
    }
}
