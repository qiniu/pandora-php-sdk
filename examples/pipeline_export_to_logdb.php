<?php
/**
 * Created by IntelliJ IDEA.
 * User: wf
 * Date: 2017/12/22
 * Time: 下午4:08
 */

require_once '../autoload.php';

use Pandora\Service\PipelineService;
use Pandora\Service\LogDbExport;
use Pandora\Auth;

$accessKey = 'bjtWBQXrcxgo7HWwlC_bgHg81j352_GhgBGZPeOW';
$secretKey = '';
$repoName = 'uploadtest_by_phpsdk';
$auth = new Auth($accessKey, $secretKey);

$pipeline = new PipelineService($repoName, $auth);


$doc = array('name' => '#tname', 'age' => '#tage');
$spec = new LogDbExport('rwx_phptest', $doc);
$response = $pipeline->export(PipelineService::EXPORT_TYPE_LOGDB, "rwx_php_export", $spec);
print_r($response);
