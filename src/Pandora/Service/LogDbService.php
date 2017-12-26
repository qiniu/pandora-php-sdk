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

    /**
     * @param string $queryString   查询表达式  eg: field1:field_val
     * @param string $sortByField   指定排序的字段   eg: field1:asc,field2:desc
     * @param int $offsetFrom    返回的日志开始的位置
     * @param int $limitSize     返回的数据数量
     * @param array $fields  指定只返回哪些字段 eg: array("field1", "field2", ...)
     * @return \Pandora\Http\Response
     *
     * 参考 https://qiniu.github.io/pandora-docs/#/api/logdb?id=%e6%9f%a5%e8%af%a2%e6%97%a5%e5%bf%97
     */
    public function searchLogs($queryString, $sortByField, $offsetFrom, $limitSize, array $fields = array()) {
        $path = "/v5/repos/$this->repoName/search";

        $params = array(
            'query' => $queryString,
            'sort' => $sortByField,
            'from' => $offsetFrom,
            'size' => $limitSize,
        );

        if (count($fields) != 0) {
           $params['fields'] = implode(',', $fields);
        }

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

        $url = Config::LOG_DB_API_ADDRESS . $path;

        return Client::request($method, $url, $body, $headers);
    }
}
