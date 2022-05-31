<?php

namespace App\Helper;

class Tools
{
    private const LENGTH = 10;
    private const KEY = 'abcdefghijklmnopqrstuvwxyz1234567890';

    /**
     * @return string
     */
    public static function createGuid(): string
    {
        $result = '';
        for ($i = 0; $i < self::LENGTH; $i++) {
            $result .= self::KEY[rand(0, strlen(self::KEY) - 1)];
        }

        return $result;
    }
}
