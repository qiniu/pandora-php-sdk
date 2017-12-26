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
        $path = "/v5/repos/$this->repoName/search";

        $params = array(
            'query' => $queryString,
            'sort' => $sortByField,
            'from' => $offsetFrom,
            'size' => $limitSize,
        );

        $params = json_encode($params);
        return $this->post($path, $params, 'application/json');
    }

    public function msearch($querybody) {
        $path = "/v5/logdbkibana/msearch";
        return $this->post($path, $querybody, 'text/plain');
    }

    private function post($path, $body, $contentType) {
        return $this->request("POST", $path, $body, $contentType);
    }

    private function request($method, $path, $body, $contentType) {

        $headers['Content-Type'] = $contentType;
        $accessToken = $this->auth->createAccessToken($method, $path, $headers, $contentType);
        $headers['Authorization'] = $accessToken;

        $url = Config::PIPELINE_API_ADDRESS . $path;

        return Client::request($method, $url, $body, $headers);
    }
}
