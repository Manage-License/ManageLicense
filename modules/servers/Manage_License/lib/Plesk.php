<?php
if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

use WHMCS\Database\Capsule;

$cnt = 1;
$products = "";
foreach ($api->response['items'] as $item) {
    $products .= "<p>" . $cnt . "- " . ucfirst(ltrim(strtolower(str_replace(array("-", "FT"), " ", substr($item['item'], 0, -3))))) . "</p>";
    $cnt++;
}

foreach ($api->response['extentions'] as $item) {
    $products .= "<p>" . ucfirst(ltrim(strtolower(str_replace(array("-", "ADD", "1M"), " ", substr($item['pname'], 0, -3))))) . "</p>";
    $cnt++;
}


for ($i = 0; $i < count($api->response['extentions']);$i++) {

    $api->response['extentions'][$i]['pname'] = ucfirst(ltrim(strtolower(str_replace(array("-", "ADD"), " ", substr($api->response['extentions'][$i]['pname'], 0, -3)))));
}
$response = array(
    'listItems' => $products,
    'licenseInfo' => $api->response,
    'lang' => $_LANG
);