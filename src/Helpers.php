<?php

namespace mitsosf\IconSDK;

class Helpers{
    /**
     * @return string
     */
    public static function getBase64TimestampInMilliseconds()
    {
        $milliseconds = round(microtime(true) * 1000000);
        $milliseconds = '0x' . dechex($milliseconds);

        return $milliseconds;
    }

    /**
     * @param $value float|int
     * @return string
     */
    public static function icxToHex($value)
    {
        return '0x' . dechex($value * 10 ** 18);
    }

    /**
     * @param $value
     * @return float|int
     */
    public static function hexToIcx($value)
    {
        return hexdec($value) / 10 ** 18;
    }

    public static function isPrivateKey($key)
    {
        $length = 64;
        if (strlen($key) !== $length) {
            return false;
        }

        if (!ctype_xdigit($key)) {
            return false;
        }

        return true;
    }

    public static function isPublicKey($key)
    {
        $length = 128;
        if (strlen($key) !== $length) {
            return false;
        }

        if (!ctype_xdigit($key)) {
            return false;
        }

        return true;
    }

    public static function isPublicAddress($address)
    {
        $length = 42;
        if (strlen($address) !== $length) {
            return false;
        }

        $parts = explode('x', $address);
        $last_part = array_pop($parts);
        $first_part = $parts[0] . 'x';

        if ($first_part !== 'hx' && strlen($first_part) !== $length - 40) {
            return false;
        }

        if (!ctype_xdigit($last_part) && strlen($last_part) !== $length - 2) {
            return false;
        }

        return true;
    }
}