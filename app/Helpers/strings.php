<?php
if(!function_exists('to_persian_numbers')) {
    /**
     * convert latin number to persian
     *
     * @param string $string
     *   string that we want change number format
     *
     * @return formated string
     */
    function to_persian_numbers($string) {
        return str_replace(range(0, 9), ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'], $string);
    }
}

if (!function_exists('to_latin_numbers')) {
    /**
     * convert persian number to latin
     *
     * @param string $string
     *   string that we want change number format
     *
     * @return formated string
     */
    function to_latin_numbers($string) {
        return str_replace(['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'], range(0, 9), $string);
    }
}
