<?php
if (!function_exists('get_settings')) {
    /**
     * Get all autoload settings
     */
    function get_settings() {
        return \App\Models\Setting::autoload()->pluck('value', 'key');
    }

    /**
     * Retrieve only value of a single row.
     *
     * @param string $key key of the setting
     * @return mixed
     */
    function get_setting($key) {
        return \App\Models\Setting::whereKey($key)->value('value');
    }
}