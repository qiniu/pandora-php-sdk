<?php
require_once '../autoload.php';

use Pandora\Service\PipelineService;
use Pandora\Auth;

$accessKey = '';
$secretKey = '';
$repoName = 'uploadtest';
$auth = new Auth($accessKey, $secretKey);

$pipeline = new PipelineService($repoName, $auth);

$points = array(array("speed" => 12.3, "ip" => "1.2.3.1"));
$response = $pipeline->postData($points);
print_r($response);
