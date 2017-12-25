<?php
require_once '../autoload.php';

use Pandora\Service\PipelineService;
use Pandora\Service\HttpExport;
use Pandora\Auth;

$accessKey = 'bjtWBQXrcxgo7HWwlC_bgHg81j352_GhgBGZPeOW';
$secretKey = '';
$repoName = 'uploadtest_by_phpsdk';
$auth = new Auth($accessKey, $secretKey);

$pipeline = new PipelineService($repoName, $auth);

$spec = new HttpExport('https://requestb.in', '/1kbyipz1');
$response = $pipeline->export(PipelineService::EXPORT_TYPE_HTTP, "httpnamebyphpsdk", $spec);
print_r($response);
