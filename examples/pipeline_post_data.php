<?php
/**
 * Created by IntelliJ IDEA.
 * User: wf
 * Date: 2017/12/20
 * Time: 下午9:02
 */

require_once '../autoload.php';

use Pandora\Service\PipelineService;
use Pandora\Auth;

$accessKey = 'bjtWBQXrcxgo7HWwlC_bgHg81j352_GhgBGZPeOW';
$secretKey = 'pCav6rTslxP2SIFg0XJmAw53D9PjWEcuYWVdUqAf';
$repoName = 'uploadtest';
$auth = new Auth($accessKey, $secretKey);

$pipeline = new PipelineService($repoName, $auth);

$points = array(array("speed" => 12.3, "ip" => "1.2.3.1"));
$response = $pipeline->postData($points);
print_r($response);
