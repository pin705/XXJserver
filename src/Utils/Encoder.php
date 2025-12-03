<?php

namespace XXJ\Utils;

class Encoder
{
    public function encode(string $string = '', string $skey = 'cxphp'): string
    {
        $strArr = str_split(base64_encode($string));
        $strCount = count($strArr);
        foreach (str_split($skey) as $key => $value) {
            if ($key < $strCount) {
                $strArr[$key] .= $value;
            }
        }
        return str_replace(['=', '+', '/'], ['O0O0O', 'o000o', 'oo00o'], join('', $strArr));
    }

    public function decode(string $string = '', string $skey = 'cxphp'): string
    {
        $strArr = str_split(str_replace(['O0O0O', 'o000o', 'oo00o'], ['=', '+', '/'], $string), 2);
        $strCount = count($strArr);
        foreach (str_split($skey) as $key => $value) {
            if ($key <= $strCount && isset($strArr[$key]) && $strArr[$key][1] === $value) {
                $strArr[$key] = $strArr[$key][0];
            }
        }
        return base64_decode(join('', $strArr));
    }
}
