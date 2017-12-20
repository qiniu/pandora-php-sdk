<?php

namespace Pandora\Service;

use Pandora\Config;
use Pandora\Http\Client;

final class LogDbService {

    private $repoName;
    private $auth;

    public function __construct($repoName, $auth) {
        $this->repoName = $repoName;
        $this->auth = $auth;
    }

    public function searchLogs($queryString, $sortByField, $offsetFrom, $limitSize) {
        $reqPath = "/v5/repos/$this->repoName/search";
        $reqUri = "$reqPath?q=$queryString&sort=$sortByField&from=$offsetFrom&size=$limitSize";
        $contentType = '';
        $reqHeaders = array(
            'Content-Type' => $contentType,
        );
        $accessToken = $this->auth->createAccessToken('GET', $reqPath, $reqHeaders, $contentType);
        $reqHeaders['Authorization'] = $accessToken;
        $reqUrl = sprintf("%s%s", Config::LOG_DB_API_ADDRESS, $reqUri);
        $response = Client::get($reqUrl, $reqHeaders);
        return $response;
    }
    public function msearch($querybody) {
        $reqPath = "/v5/logdbkibana/msearch";
        $contentType = 'text/plain';
        $reqHeaders = array(
            'Content-Type' => $contentType,
        );
        $accessToken = $this->auth->createAccessToken('POST', $reqPath, $reqHeaders, $contentType);
        $reqHeaders['Authorization'] = $accessToken;
        $reqUrl = sprintf("%s%s", Config::LOG_DB_API_ADDRESS, $reqPath);
        $response = Client::post($reqUrl,$querybody, $reqHeaders);
        return $response;
    }
}
