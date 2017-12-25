<?php
require_once '../autoload.php';

use Pandora\Service\PipelineService;
use Pandora\Service\LogDbExport;
use Pandora\Auth;

$accessKey = '';
$secretKey = '';
$repoName = 'uploadtest_by_phpsdk';
$exportName = 'rwx_php_exportx';
$auth = new Auth($accessKey, $secretKey);

$pipeline = new PipelineService($repoName, $auth);


$doc = array('ttname' => 'tname', 'tage' => 'tage');
$spec = new LogDbExport('rwx_phptest', $doc);
$response = $pipeline->updateExport($exportName, $spec);
print_r($response);

