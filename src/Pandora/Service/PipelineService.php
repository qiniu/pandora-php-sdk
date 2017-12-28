<?php
namespace Pandora\Service;

use Pandora\Config;
use Pandora\Http\Client;

final class PipelineService {

    const EXPORT_WHENCE_OLDEST = 'oldest';
    const EXPORT_WHENCE_NEWST = 'newst';

    const EXPORT_TYPE_HTTP = 'http';
    const EXPORT_TYPE_LOGDB = 'logdb';
    const EXPORT_TYPE_MONGO = 'mongo';
    const EXPORT_TYPE_TSDB = 'tsdb';
    const EXPORT_TYPE_STORAGE = 'kodo';
    const EXPORT_TYPE_REPORT = 'report';

    private $repoName;
    private $auth;
    private $gzipPostData = false;
    private $gzipLevel = 9;

    public function __construct($repoName, $auth) {
        $this->repoName = $repoName;
        $this->auth = $auth;
    }

    public function enablePostDataGzip() {
        $this->gzipPostData = true;
    }

    public function setGzipLevel($level) {
       $this->gzipLevel = $level;
    }

    /**
     * @param  $schema
     * @param array() $options array("withIP" => "xx")
     * @param string $region
     * @return \Pandora\Http\Response
     */
    public function createRepo(array $schema, $options = null, $region = 'nb') {

        $params = array(
            'schema' => $schema,
            'region' => $region
        );

        if (isset($options)) {
            $params['options'] = $options;
        }

        $path = "/v2/repos/$this->repoName";
        $body = json_encode($params);
        $headers['Content-Type'] = 'application/json';

        return $this->post($path, $body, $headers);
    }

    /**
     * @param $type   "http|logdb|mongo|tsdb|kodo|report"
     * @param $exportName
     * @param $spec
     * @param string $whence  oldest|newest
     * @return \Pandora\Http\Response
     */
    public function export($type, $exportName, $spec, $whence = 'oldest') {

        $path = "/v2/repos/$this->repoName/exports/$exportName";

        $params = array(
            'type' => $type,
            'spec' => $spec,
            'whence' => $whence
        );
        $body = json_encode($params);
        $headers['Content-Type'] = 'application/json';

        return $this->post($path, $body, $headers);
    }

    public function updateExport($exportName, $spec) {
        $path = "/v2/repos/$this->repoName/exports/$exportName";

        $params = array(
            'spec' => $spec,
        );
        $body = json_encode($params);
        $headers['Content-Type'] = 'application/json';

        return $this->put($path, $body, $headers);
    }

    public function postData(array $points) {

        $path = "/v2/repos/$this->repoName/data";
        $body = $this->buildBody($points);
        $headers['Content-Type'] = 'text/plain';

        if ($this->gzipPostData) {
            $headers['Content-Encoding'] = 'gzip';
            $body = gzencode($body, $this->gzipLevel);
        }

        return $this->post($path, $body, $headers);
    }

    private function buildBody(array $points) {

        $pointArr = array();
        foreach ($points as $point) {
            $pointLine = $this->buildPoint($point);
            array_push($pointArr, $pointLine);
        }

        return implode("\n", $pointArr);
    }

    private function buildPoint(array $point) {

        $fieldArr = array();
        foreach ($point as $key => $val) {
            if (is_array($val)) {
                $val = \Pandora\json_decode($val);
            }
            $field = $key . "=" . $this->escape($val);
            array_push($fieldArr, $field);
        }

        return implode("\t", $fieldArr);
    }

    private function escape($str) {
        return str_replace(array("\n", "\t"),  array('\\n', '\\t'), $str);
    }

    private function post($path, $body, $headers) {
       return $this->request("POST", $path, $body, $headers);
    }

    private function put($path, $body, $headers) {
        return $this->request("PUT", $path, $body, $headers);
    }

    private function request($method, $path, $body, $headers) {

        $contentType  = $headers['Content-Type'];
        $accessToken = $this->auth->createAccessToken($method, $path, $headers, $contentType);
        $headers['Authorization'] = $accessToken;

        $url = Config::PIPELINE_API_ADDRESS . $path;

        return Client::request($method, $url, $body, $headers);
    }
}
