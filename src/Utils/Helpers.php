<?php

namespace iconation\IconSDK\Utils;

class Helpers{
    /**
     * @return string
     */
    public static function getBase64TimestampInMilliseconds(): string
    {
        $milliseconds = round(microtime(true) * 1000000);
        return '0x' . dechex($milliseconds);
    }

    /**
     * @param string $value
     * @param int $decimals
     * @return string
     */
    public static function icxToHex($value, $decimals = 18): string
    {
        return '0x' . self::bcdechex(bcmul($value, 10**$decimals));
    }

    /**
     * @param string $value
     * @param int $decimals
     * @return string
     */
    public static function hexToIcx(string $value, int $decimals = 18): string
    {
        $value = gmp_init($value, '16');
        return bcdiv(gmp_strval($value), 10**18, $decimals);
    }

    public static function isPrivateKey($key): bool
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

    public static function isPublicKey($key): bool
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

    public static function isPublicAddress($address): bool
    {
        $length = 42;
        if (strlen($address) !== $length) {
            return false;
        }

        $parts = explode('x', $address);
        $last_part = array_pop($parts);
        $first_part = $parts[0] . 'x';

        if ($first_part !== 'hx') {
            return false;
        }

        if (!ctype_xdigit($last_part) || strlen($last_part) !== $length - 2) {
            return false;
        }

        return true;
    }

    public static function bcdechex($dec): string
    {
        $hex = '';
        do {
            $last = bcmod($dec, 16);
            $hex = dechex($last).$hex;
            $dec = bcdiv(bcsub($dec, $last), 16);
        } while($dec>0);
        return $hex;
    }
}