<?php
if (!function_exists('get_config_item')) {
    /**
     * Get a configuration item
     *
     * @param string $item
     * @return mixed
     */
    function config($item)
    {
        $CI = &get_instance();
        return $CI->config->item($item);
    }
}
