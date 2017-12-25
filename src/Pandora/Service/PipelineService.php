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

    public function __construct($repoName, $auth) {
        $this->repoName = $repoName;
        $this->auth = $auth;
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
        $params = json_encode($params);

        return $this->post($path, $params, 'application/json');
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
        $params = json_encode($params);

        return $this->post($path, $params, 'application/json');
    }

    public function updateExport($exportName, $spec) {
        $path = "/v2/repos/$this->repoName/exports/$exportName";

        $params = array(
            'spec' => $spec,
        );
        $params = json_encode($params);

        return $this->put($path, $params, 'application/json');
    }

    public function postData(array $points) {

        $path = "/v2/repos/$this->repoName/data";
        $body = $this->buildBody($points);

        return $this->post($path, $body, 'text/plain');
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
        return str_replace(array("\n", "\r"),  array('\\n', '\\t'), $str);
    }

    private function post($path, $body, $contentType) {
       return $this->request("POST", $path, $body, $contentType);
    }

    private function put($path, $body, $contentType) {
        return $this->request("PUT", $path, $body, $contentType);
    }

    private function request($method, $path, $body, $contentType) {

        $headers['Content-Type'] = $contentType;
        $accessToken = $this->auth->createAccessToken($method, $path, $headers, $contentType);
        $headers['Authorization'] = $accessToken;

        $url = Config::PIPELINE_API_ADDRESS . $path;

        return Client::request($method, $url, $body, $headers);
    }
}
