<?php

namespace iconation\IconSDK\Utils;

use iconation\IconSDK\Transaction;

class Serializer
{
    public static function serialize(Transaction $transaction, bool $hashed = false)
    {
        $resultStr = self::objTraverse($transaction->getTransactionParamsObject());

        $resultStringReplaced = substr(substr($resultStr, 1), 0, -1);
        $result = 'icx_sendTransaction.' . $resultStringReplaced;

        if ($hashed) {
            $result = hash('sha3-256', $result);
        }

        return $result;
    }

    private static function arrayTraverse(array $array): string
    {
        $result = '';
        $result .= '[';
        ksort($array);

        foreach ($array as $value){
            switch (true) {
                case (is_null($value)):
                    $result .= '\0';
                    break;
                case (gettype($value) === 'string' || gettype($value) === 'integer');
                    $result .= self::escapeString($value);
                    break;
                case (gettype($value) === 'array');
                    $result .= self::arrayTraverse($value);
                    break;
                case (gettype($value) === 'object');
                    $result .= self::objTraverse($value);
                    break;
                default:
                    break;
            }
            $result .= '.';
        }

        if (substr($result, -1) === '.') {
            $result = substr($result, 0, -1);
        }
        $result .= ']';
        return $result;
    }

    private static function objTraverse(\stdClass $object): string
    {
        $result = '';
        $result .= '{';
        $object = (array)json_decode(json_encode($object));
        ksort($object);
        $keys = array_keys($object);
        if (count($keys) > 0) {
            for ($i = 0; $i < count($keys); $i++) {
                $key = $keys[$i];
                $value = $object[$key];
                switch (true) {
                    case (is_null($value)):
                        $result .= $key . '.';
                        $result .= '\0';
                        break;
                    case (gettype($value) === 'string' || gettype($value) === 'integer');
                        $result .= $key . '.';
                        $result .= self::escapeString($value);
                        break;
                    case (gettype($value) === 'array');
                        $result .= $key . '.';
                        $result .= self::arrayTraverse($value);
                        break;
                    case (gettype($value) === 'object');
                        $result .= $key . '.';
                        $result .= self::objTraverse($value);
                        break;
                    default:
                        break;
                }
                $result .= '.';
            }
            $result = substr($result, 0, -1);
            $result .= '}';
        } else {
            $result .= '}';
        }
        return $result;
    }

    private static function objToArray(\stdClass $obj): array
    {
        $result = array();
        foreach ($obj as $key=>$value){
            $result[$key] = $value;
        }
        return $result;
    }

    private static function escapeString($value)
    {
        $newString = $value;
        $newString = is_array(explode('\\', $newString)) ? implode('\\\\', explode('\\', $newString)) : $newString;
        $newString = is_array(explode('.', $newString)) ? implode('\\.', explode('.', $newString)) : $newString;
        $newString = is_array(explode('{', $newString)) ? implode('\\{', explode('{', $newString)) : $newString;
        $newString = is_array(explode('}', $newString)) ? implode('\\}', explode('}', $newString)) : $newString;
        $newString = is_array(explode('[', $newString)) ? implode('\\[', explode('[', $newString)) : $newString;
        $newString = is_array(explode(']', $newString)) ? implode('\\]', explode(']', $newString)) : $newString;
        return $newString;
    }
}