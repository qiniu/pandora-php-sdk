<?php
require_once '../autoload.php';

use Pandora\Service\PipelineService;
use Pandora\Service\StorageExport;
use Pandora\Auth;

$accessKey = '';
$secretKey = '';
$repoName = 'uploadtest_by_phpsdk';
$auth = new Auth($accessKey, $secretKey);

$pipeline = new PipelineService($repoName, $auth);

$accMail = 'tswork@qiniu.com';
$bucket = 'tslog';
$fields = array('storage_name' => 'tname', 'storage_age' => 'tage');

$spec = new StorageExport($accMail, $bucket, $accessKey, $fields);
$response = $pipeline->export(PipelineService::EXPORT_TYPE_STORAGE, 'pandora_phpsdk_storage_export', $spec);
print_r($response);
