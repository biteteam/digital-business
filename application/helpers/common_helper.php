<?php

// ------------------------------------------------------------------------

if (!function_exists('is_active')) {
    function is_active($pathPatterns)
    {
        $currentUrl = current_url();
        foreach ($pathPatterns as $pattern) {
            // Replace wildcard * with regex equivalent
            $pattern = str_replace('*', '.*', preg_quote(base_url($pattern), '/'));
            if (preg_match("/^{$pattern}/", $currentUrl)) {
                return true;
            }
        }
        return false;
    }
}


// ------------------------------------------------------------------------

if (!function_exists('to_array')) {
    function to_array($object)
    {
        return json_decode(json_encode($object), true);
    }
}

if (!function_exists('to_object')) {
    function to_object($array)
    {
        return json_decode(json_encode($array), false);
    }
}
