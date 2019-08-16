<?php
if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}
use WHMCS\Database\Capsule ;

if($params['domain'] == '' || $params['domain'] == 'Not Registered'){
     Capsule::table('tblhosting')->where('id', '=', $params['serviceid'])->update(
         [
             'domain' => $api->response['server_ip']
         ]);


 }
$response =    array(
    'licenseInfo' => $api->response,
    'lang' => $_LANG
);