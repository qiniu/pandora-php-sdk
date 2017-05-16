<?php

require_once '../autoload.php';

use Pandora\Service\LogDbService;
use Pandora\Auth;

$accessKey = 'accesskey';
$secretKey = 'secretKey';
$repoName = 'kodo_z0_req_io';
$auth = new Auth($accessKey, $secretKey);

$logDb = new LogDbService($repoName, $auth);
$queryString = 'machine:xs273';
$sortByField = 'timestamp:asc';
$offsetFrom = 0;
$sizeLimit = 10;
#$response = $logDb->searchLogs($queryString, $sortByField, $offsetFrom, $sizeLimit);
$response = $logDb->msearch('your msearch string');
print_r($response);
