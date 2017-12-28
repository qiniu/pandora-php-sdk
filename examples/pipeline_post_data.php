<?php
require_once '../autoload.php';

use Pandora\Service\PipelineService;
use Pandora\Auth;

$accessKey = '';
$secretKey = '';
$repoName = 'uploadtest';
$auth = new Auth($accessKey, $secretKey);

$pipeline = new PipelineService($repoName, $auth);
$pipeline->enablePostDataGzip();

$points = array(array("speed" => 13.3, "ip" => "f.2.3.x"));
$response = $pipeline->postData($points);
print_r($response);
