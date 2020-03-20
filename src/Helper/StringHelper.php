<?php

namespace App\Helper;

class StringHelper extends AbstractHelper
{
    /**
     * @param string $text
     * @return string
     */
    public static function className(string $text): string
    {
        return preg_replace_callback(
            '/(_)([a-z])/',
            function ($matches) {
                return strtoupper($matches[2]);
            },
            ucwords($text)
        );
    }
}