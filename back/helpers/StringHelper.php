<?php

namespace Helpers;

class StringHelper
{
    public static function token()
    {
        mt_srand();
        return strtoupper(hash('sha256', uniqid(mt_rand())));
    }

    public static function password($str)
    {
        return mb_convert_case(hash('sha256', $str), MB_CASE_UPPER);
    }

    public static function newGuid()
    {
        // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
        $data = random_bytes(16);
        assert(strlen($data) == 16);

        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    public static function parentFolderByClass($classname)
    {
        $arr = explode('\\', $classname);
        unset($arr[count($arr) - 1]);
        return implode('\\', $arr);
    }

    public static function removeInvisibleCharacters($str)
    {
        return preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $str);
    }
    public static function formatCpfCnpj($cpfCnpj)
    {
        $cpfCnpj = self::onlyNumber($cpfCnpj);
        if (strlen($cpfCnpj) == 11) {
            return preg_replace("/([\d]{3})([\d]{3})([\d]{3})([\d]{2})/", "$1.$2.$3-$4", $cpfCnpj);
        } else if (strlen($cpfCnpj) == 14) {
            return preg_replace("/([\d]{2})([\d]{3})([\d]{3})([\d]{4})([\d]{2})/", "$1.$2.$3/$4-$5", $cpfCnpj);
        }
        return $cpfCnpj;
    }
    public static function uri($str, $separator = '-', $lowercase = FALSE)
    {
        if ($separator === 'dash') {
            $separator = '-';
        } elseif ($separator === 'underscore') {
            $separator = '_';
        }

        $q_separator = preg_quote($separator, '#');

        $trans = array(
            '&.+?;' => '',
            '[^\w\d _-]' => '',
            '\s+' => $separator,
            '(' . $q_separator . ')+' => $separator
        );

        $str = strip_tags($str);
        foreach ($trans as $key => $val) {
            $str = preg_replace('#' . $key . '#iu', $val, $str);
        }

        if ($lowercase === TRUE) {
            $str = strtolower($str);
        }

        return trim(trim($str, $separator));
    }
    public static function removeAccents($string = NULL)
    {
        $find = array(
            'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í',
            'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á',
            'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô',
            'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', '}', ']', '°', '+', '(', ')', '*', '#', '@', '!', '#', '$', '%', '¨', ':', '’', '‘', ',', '.', ':', 'º'
        );
        $replace = array(
            'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i',
            'i', 'i', 'd', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 's', 'a', 'a',
            'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o',
            'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '', '', '', ' ', '', '', ''
        );
        return str_replace($find, $replace, $string);
    }
    public static function onlyNumber($str)
    {
        return preg_replace("/[^0-9]/", "", $str);
    }
    public static function escapeSequenceDecode($str)
    {

        // [U+D800 - U+DBFF][U+DC00 - U+DFFF]|[U+0000 - U+FFFF]
        $regex = '/\\\u([dD][89abAB][\da-fA-F]{2})\\\u([dD][c-fC-F][\da-fA-F]{2})
              |\\\u([\da-fA-F]{4})/sx';

        return preg_replace_callback($regex, function ($matches) {

            if (isset($matches[3])) {
                $cp = hexdec($matches[3]);
            } else {
                $lead = hexdec($matches[1]);
                $trail = hexdec($matches[2]);

                // http://unicode.org/faq/utf_bom.html#utf16-4
                $cp = ($lead << 10) + $trail + 0x10000 - (0xD800 << 10) - 0xDC00;
            }

            // https://tools.ietf.org/html/rfc3629#section-3
            // Characters between U+D800 and U+DFFF are not allowed in UTF-8
            if ($cp > 0xD7FF && 0xE000 > $cp) {
                $cp = 0xFFFD;
            }

            // https://github.com/php/php-src/blob/php-5.6.4/ext/standard/html.c#L471
            // php_utf32_utf8(unsigned char *buf, unsigned k)

            if ($cp < 0x80) {
                return chr($cp);
            } else if ($cp < 0xA0) {
                return chr(0xC0 | $cp >> 6) . chr(0x80 | $cp & 0x3F);
            }

            return html_entity_decode('&#' . $cp . ';');
        }, $str);
    }

    public static function sanitizeFileName($string): string
    {

        $sanitized_string = preg_replace('/[\/\:*?"<>|]/', '', $string);
        return trim($sanitized_string);
    }
    public static function formatCep($cep)
    {
        $cep = self::onlyNumber($cep);
        if (strlen($cep) == 8) {
            return preg_replace("/([\d]{2})([\d]{3})([\d]{3})/", "$1.$2-$3", $cep);
        }
        return '';
    }
    public static function formatTelefoneOuCelular($telefoneOuCelular)
    {
        $telefoneOuCelular = self::onlyNumber($telefoneOuCelular);
        if (strlen($telefoneOuCelular) == 10) {
            return preg_replace("/([\d]{2})([\d]{4})([\d]{4})/", "($1) $2-$3", $telefoneOuCelular);
        } else if (strlen($telefoneOuCelular) == 11) {
            return preg_replace("/([\d]{2})([\d]{5})([\d]{4})/", "($1) $2-$3", $telefoneOuCelular);
        }
        return '';
    }

    public static function null($var)
    {
        if (is_null($var) || (!is_double($var) && !is_int($var) && !is_bool($var) && trim($var) == '')) {
            return null;
        }

        return strval($var);
    }
}
