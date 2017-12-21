<?php
namespace Pandora\Service;

use Pandora\Config;
use Pandora\Http\Client;

final class PipelineService {

    private $repoName;
    private $auth;

    public function __construct($repoName, $auth) {
        $this->repoName = $repoName;
        $this->auth = $auth;
    }

    public function postData(array $points) {

        $path = "/v2/repos/$this->repoName/data";
        $body = $this->buildBody($points);

        return $this->post($path, null, $body);
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

    private function post($path, $headers, $body) {

        if (!isset($headers['Content-Type'])) {
            $headers['Content-Type'] = "text/plain";
        }
        $contentType = $headers['Content-Type'];

        $accessToken = $this->auth->createAccessToken('POST', $path, $headers, $contentType);
        $headers['Authorization'] = $accessToken;

        $url = Config::PIPELINE_API_ADDRESS . $path;

        return Client::post($url, $body, $headers);
    }
}
