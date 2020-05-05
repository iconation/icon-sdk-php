<?php

namespace mitsosf\IconSDK;

class Serializer
{
    public static function serialize(\stdClass $transaction){
        $serializedTransaction = 'icx_sendTransaction';

        //TODO implementation
        return $serializedTransaction;
    }

    private function arrayTraverse(array $array): string
    {
        $result = '';

        $result .= '[';
        ksort($array);

        for ($j = 0; $j < count($array); $j++) {
            $value = $array[$j];
            switch (true) {
                case (is_null($value)):
                    $result .= '\0';
                    break;
                case (gettype($value) === 'string');
                    $result .= $this->escapeString($value);
                    break;
                case (gettype($value) === 'array');
                    $result .= $this->arrayTraverse($value);
                    break;
                case (gettype($value) === 'object');
                    $result .= $this->objTraverse($value);
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

    private function objTraverse(array $object): string
    {
        $result = '';
        $result .= '{';
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
                    case (gettype($value) === 'string');
                        $result .= $key . '.';
                        $result .= $this->escapeString($value);
                        break;
                    case (gettype($value) === 'array');
                        $result .= $key . '.';
                        $result .= $this->arrayTraverse($value);
                        break;
                    case (gettype($value) === 'object');
                        $result .= $key . '.';
                        $result .= $this->objTraverse($value);
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

    private function escapeString($value)
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