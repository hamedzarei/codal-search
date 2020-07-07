<?php
/**
 * Created by PhpStorm.
 * User: zrhm7232
 * Date: 7/6/20
 * Time: 11:45 PM
 */

require_once 'vendor/autoload.php';

$client = new \GuzzleHttp\Client(['verify' => false ]);
//$client->setDefaultOption('verify', false);
$page = 1;
$resp = $client->get('https://search.codal.ir/api/search/v2/q?&Audited=true&AuditorRef=-1&Category=-1&Childs=true&CompanyState=-1&CompanyType=-1&Consolidatable=true&IsNotAudited=false&Length=-1&LetterType=-1&Mains=true&NotAudited=true&NotConsolidatable=true&PageNumber=1&Publisher=false&TracingNo=-1&search=false');
$resp = (string)$resp->getBody();
$resp = json_decode($resp, true);
//var_dump(array_keys($resp['Letters']));

//CompanyName
//Symbol
//۱۲۳۴۵۶۷۸۹۰
$while = true;
$pos = 'افزایش سرمایه';
while ($while) {
    foreach ($resp['Letters'] as $letter) {
        $publishDate = $letter['PublishDateTime'];
        $dateQuery = '۱۳۹۹/۰۴/۱۷';
        if (substr($publishDate, 0, strlen($dateQuery)) === $dateQuery) {
            if (strpos($letter['Title'], $pos) !== false) {
                var_dump($letter['CompanyName']);
            }
        } else {
            continue;
        }
    }
    $page++;
    if ($page > 40) $while = false;
    $resp = $client->get("https://search.codal.ir/api/search/v2/q?&Audited=true&AuditorRef=-1&Category=-1&Childs=true&CompanyState=-1&CompanyType=-1&Consolidatable=true&IsNotAudited=false&Length=-1&LetterType=-1&Mains=true&NotAudited=true&NotConsolidatable=true&PageNumber=$page&Publisher=false&TracingNo=-1&search=false");
    $resp = (string)$resp->getBody();
    $resp = json_decode($resp, true);
}
