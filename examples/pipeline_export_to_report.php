<?php
require_once '../autoload.php';

use Pandora\Service\PipelineService;
use Pandora\Service\ReportExport;
use Pandora\Auth;

$accessKey = '';
$secretKey = '';
$repoName = 'uploadtest_by_phpsdk';
$auth = new Auth($accessKey, $secretKey);

$pipeline = new PipelineService($repoName, $auth);

$dbName = 'example_database';
$tableName = 'long_lat';
$columns = array('rname' => 'tname', 'rage' => 'tage');

$spec = new ReportExport($dbName, $tableName, $columns);
$response = $pipeline->export(PipelineService::EXPORT_TYPE_REPORT, 'pandora_phpsdk_report_export', $spec);
print_r($response);

