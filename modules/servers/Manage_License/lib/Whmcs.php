<?php
if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}
use WHMCS\Database\Capsule ;

    $info = explode(',',$api->response['validdomain']);
    if($params['domain'] != $info[0]){
    Capsule::table('tblhosting')->where('id', '=', $params['serviceid'])->update(
        [
            'domain' => $info[0]
        ]);


}
$response =    array(
    'licenseInfo' => $api->response,
    'lang' => $_LANG
);