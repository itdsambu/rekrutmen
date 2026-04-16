<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// if (!function_exists('encode_str')) {                                           //##++ Encode String
//     function encode_str($value, $gembok = '') {
//         $skey = (trim($gembok) == '' ? '1234567890qwerty' : $gembok);
//         if (!$value) {
//             return false;
//         }
//         $text = $value;
//         $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
//         $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
//         $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $skey, $text, MCRYPT_MODE_ECB, $iv);
//         return trim(safe_b64encode($crypttext));
//     }
//     function safe_b64encode($string) {
//         $data = base64_encode($string);
//         $data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);
//         return $data;
//     }
// }

// if (!function_exists('decode_str')) {                                           //##++ Decode String
//     function decode_str($value, $gembok = '') {
//         $skey = (trim($gembok) == '' ? '1234567890qwerty' : $gembok);
//         if (!$value) {
//             return false;
//         }
//         $crypttext = safe_b64decode($value);
//         $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
//         $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
//         $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $skey, $crypttext, MCRYPT_MODE_ECB, $iv);
//         return trim($decrypttext);
//     }
//     function safe_b64decode($string) {
//         $data = str_replace(array('-', '_'), array('+', '/'), $string);
//         $mod4 = strlen($data) % 4;
//         if ($mod4) {
//             $data .= substr('====', $mod4);
//         }
//         return base64_decode($data);
//     }
// }

if (!function_exists('encode_str')) {
    function encode_str($value, $gembok = '')
    {
        if (!$value) return false;

        $key = (trim($gembok) == '' ? '1234567890qwerty' : $gembok);
        $key = hash('sha256', $key, true); // 32 byte

        $iv = openssl_random_pseudo_bytes(16);

        $encrypted = openssl_encrypt(
            $value,
            'AES-256-CBC',
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );

        $result = base64_encode($iv . $encrypted);

        return str_replace(['+', '/', '='], ['-', '_', ''], $result);
    }
}

if (!function_exists('decode_str')) {
    function decode_str($value, $gembok = '')
    {
        if (!$value) return false;

        $keyRaw = (trim($gembok) == '' ? '1234567890qwerty' : $gembok);
        $key = hash('sha256', $keyRaw, true);

        // balikkan base64 url safe
        $data = str_replace(['-', '_'], ['+', '/'], $value);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }

        $data = base64_decode($data);

        // === COBA DECRYPT CARA BARU ===
        $iv = substr($data, 0, 16);
        $cipher = substr($data, 16);

        $result = openssl_decrypt(
            $cipher,
            'AES-256-CBC',
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );

        if ($result !== false) {
            return trim($result);
        }

        // === FALLBACK: DECRYPT CARA LAMA (mcrypt style) ===
        // ⚠️ hanya kalau data lama masih ada
        if (function_exists('mcrypt_decrypt')) {
            $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
            $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

            $old = mcrypt_decrypt(
                MCRYPT_RIJNDAEL_256,
                $keyRaw,
                $data,
                MCRYPT_MODE_ECB,
                $iv
            );

            return trim($old);
        }

        return false;
    }
}
