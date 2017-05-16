<?php

namespace Pandora;

final class Auth {

    public $accessKey;
    public $secretKey;

    public function __construct($accessKey, $secretKey) {
        $this->accessKey = $accessKey;
        $this->secretKey = $secretKey;
    }

    function createAccessToken($reqMethod, $resourceUri, $headers = array(), $contentType = "", $contentMd5 = "") {
        $expires = time() + 3600;
        $qiniuHeaderPrefix = "X-Qiniu-";
        $qiniuHeaderKeys = array();
        $qiniuHeadersFiltered = array();
        //format qiniu headers
        foreach ($headers as $key => $val) {
            if (0 === strpos($key, $qiniuHeaderPrefix)) {
                array_push($qiniuHeaderKeys, $key);
            }
        }
        //sort keys
        sort($qiniuHeaderKeys);
        foreach ($qiniuHeaderKeys as $key) {
            array_push($qiniuHeadersFiltered, sprintf("%s:%s", strtolower(trim($key)), trim($headers[$key])));
        }

        $qiniuHeaders = implode("\n", $qiniuHeadersFiltered);
        if (!empty($qiniuHeaders)) {
            $qiniuHeaders = "\n" . $qiniuHeaders;
        }

        $tokenDesc = array(
            'resource' => $resourceUri,
            'expires' => $expires,
            'contentMD5' => $contentMd5,
            'contentType' => $contentType,
            'headers' => $qiniuHeaders,
            'method' => $reqMethod
        );

        $tokenDescJson = json_encode($tokenDesc);
        $encodedTokenDesc = base64_urlSafeEncode($tokenDescJson);
        $sign = hash_hmac('sha1', $encodedTokenDesc, $this->secretKey, TRUE);
        $encodedSign = base64_urlSafeEncode($sign);
        $accessToken = "Pandora $this->accessKey:$encodedSign:$encodedTokenDesc";
        return $accessToken;
    }

}
