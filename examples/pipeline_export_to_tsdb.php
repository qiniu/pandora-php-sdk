<?php
require_once '../autoload.php';

use Pandora\Service\PipelineService;
use Pandora\Service\TsDbExport;
use Pandora\Auth;

$accessKey = '';
$secretKey = '';
$repoName = 'uploadtest_by_phpsdk';
$auth = new Auth($accessKey, $secretKey);

$pipeline = new PipelineService($repoName, $auth);


$tags = array('tagname' => 'tname');
$fields = array('fname' => 'tname', 'fage' => 'tage');

$spec = new TsDbExport('rwx_php_repo', 'rwx_php_series', $tags, $fields);
$response = $pipeline->export(PipelineService::EXPORT_TYPE_TSDB, 'rwx_php_tsdb_export', $spec);
print_r($response);