<?php

namespace App\Helper;

class UrlHelper
{
    public const HTTP_PREFIX = 'http://';
    public const HTTPS_PREFIX = 'https://';

    public static function getValidUrl($url)
    {
        if (strpos($url, self::HTTP_PREFIX) === false && strpos($url, self::HTTPS_PREFIX) === false) {
            $url = self::HTTPS_PREFIX . $url;
        }

        if (self::isValidUrl($url)) {
            return $url;
        }

        return false;
    }

    /**
     * @param $url
     * @return false|int
     */
    public static function isValidUrl($url, $type = 4)
    {
        $regex = "~^(?:(?:https?|ftp|telnet)://(?:[a-zа-я0-9_-]{1,32}(?::[a-zа-я0-9_-]{1,32})?@)?)?"
            . "(?:(?:[a-zа-я0-9-]{1,128}\.)+(?:ua|com|net|org|mil|edu|arpa|gov|biz|info|aero|center|рф|[a-zа-я]{2})|(?!0)"
            . "(?:(?!0[^.]|255)[0-9]{1,3}\.){3}(?!0|255)[0-9]{1,3})(?:/[a-zа-я0-9.,_@%&?+=\~/\-\:]*)?"
            . "(?:#[^ '\"&<>]*)?$~i";

        return preg_match($regex, $url);
    }
}
