<?php

namespace App\Helper;

class UserAgentHelper
{
    public static function getBrowser(string $userAgent) {
        $browser = 'Unknown';

        if (preg_match('/MSIE/i', $userAgent) && !preg_match('/Opera/i', $userAgent)) {
            $browser = 'Internet Explorer';
        } elseif (preg_match('/Firefox/i', $userAgent)) {
            $browser = 'Mozilla Firefox';
        } elseif (preg_match('/OPR/i', $userAgent)) {
            $browser = 'Opera';
        } elseif (preg_match('/Chrome/i', $userAgent) && !preg_match('/Edge/i', $userAgent)) {
            $browser = 'Google Chrome';
        } elseif (preg_match('/Safari/i', $userAgent) && !preg_match('/Edge/i', $userAgent)) {
            $browser = 'Apple Safari';
        } elseif (preg_match('/Netscape/i', $userAgent)) {
            $browser = 'Netscape';
        } elseif (preg_match('/Edge/i', $userAgent)) {
            $browser = 'Edge';
        } elseif (preg_match('/Trident/i', $userAgent)) {
            $browser = 'Internet Explorer';
        }

        return $browser;
    }

    public static function getPlatform(string $userAgent)
    {
        $platform = 'Unknown';

        if (preg_match('/linux/i', $userAgent)) {
            $platform = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $userAgent)) {
            $platform = 'mac';
        } elseif (preg_match('/windows|win32/i', $userAgent)) {
            $platform = 'windows';
        }

        return $platform;
    }
}
