<?php

if (!function_exists('get_setting')) {
    /**
     * Get setting value by key
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function get_setting($key, $default = null)
    {
        $db = \Config\Database::connect();
        $setting = $db->table('settings')->where('key', $key)->get()->getRow();
        
        return $setting ? $setting->value : $default;
    }
}
