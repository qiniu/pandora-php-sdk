<?php

namespace Pandora;

/**
 * 对提供的数据进行urlsafe的base64编码。
 *
 * @param string $data 待编码的数据，一般为字符串
 *
 * @return string 编码后的字符串
 * @link http://developer.qiniu.com/docs/v6/api/overview/appendix.html#urlsafe-base64
 */
function base64_urlSafeEncode($data) {
    $find = array('+', '/');
    $replace = array('-', '_');
    return str_replace($find, $replace, base64_encode($data));
}

/**
 * Wrapper for JSON decode that implements error detection with helpful
 * error messages.
 *
 * @param string $json    JSON data to parse
 * @param bool $assoc     When true, returned objects will be converted
 *                        into associative arrays.
 * @param int    $depth   User specified recursion depth.
 *
 * @return mixed
 * @throws \InvalidArgumentException if the JSON cannot be parsed.
 * @link http://www.php.net/manual/en/function.json-decode.php
 */
function json_decode($json, $assoc = false, $depth = 512) {
    static $jsonErrors = array(
        JSON_ERROR_DEPTH => 'JSON_ERROR_DEPTH - Maximum stack depth exceeded',
        JSON_ERROR_STATE_MISMATCH => 'JSON_ERROR_STATE_MISMATCH - Underflow or the modes mismatch',
        JSON_ERROR_CTRL_CHAR => 'JSON_ERROR_CTRL_CHAR - Unexpected control character found',
        JSON_ERROR_SYNTAX => 'JSON_ERROR_SYNTAX - Syntax error, malformed JSON',
        JSON_ERROR_UTF8 => 'JSON_ERROR_UTF8 - Malformed UTF-8 characters, possibly incorrectly encoded'
    );
    if (empty($json)) {
        return null;
    }
    $data = \json_decode($json, $assoc, $depth);
    if (JSON_ERROR_NONE !== json_last_error()) {
        $last = json_last_error();
        throw new \InvalidArgumentException(
        'Unable to parse JSON data: '
        . (isset($jsonErrors[$last]) ? $jsonErrors[$last] : 'Unknown error')
        );
    }
    return $data;
}

 