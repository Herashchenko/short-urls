<?php

namespace App\Helper;

class CookieHelper
{
    public const COOKIE_KEY_URL_IDS = 'url_ids';

    public static function updateCookieValue(string $key, $newValue)
    {
        setcookie($key, $newValue);
    }

    public static function getCookieValue(string $key)
    {
        return $_COOKIE[$key] ?? null;
    }
}
