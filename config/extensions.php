<?php

if (!function_exists('getStringHashCode')) {
    function getStringHashCode($string): int
    {
        $hash = 0;

        foreach (str_split($string) as $char) {
            $hash = 31 * $hash + ord($char);
        }

        return $hash;
    }
}

if (!defined('HOLDER_THEMES')) {
    define('HOLDER_THEMES', ['sky', 'vine', 'lava', 'gray', 'industrial', 'social']);
}