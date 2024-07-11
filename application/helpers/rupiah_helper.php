<?php

if (!function_exists('rp')) {
    /**
     * Format number to Rupiah currency format
     *
     * @param float|int $amount
     * @return string
     */
    function rp($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}
