<?php
if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

use WHMCS\Database\Capsule;
$client = Manage_license_getClient($params);
$prices = Manage_license_setting('price');
foreach ($prices as $price) {
    if ($price->key = 'USD')
        $chanegprice = $price->value;
}

if (isset($_REQUEST)) {

    update_query('tblcustomfieldsvalues', array('value' => $api->response['listOS'][$api->response['os']],),
        array('value' => $params['customfields']['OS'], 'relid' => $params["serviceid"],));
    if(  $_REQUEST['changeip'] != null && $api->response['changeip'] == true) {
        $ip = $_REQUEST['changeip'];
//    if (!empty($ip) && filter_var($ip, FILTER_VALIDATE_IP)) {

        update_query('tblhosting', array('domain' => $_REQUEST['changeip'],),
            array('id' => $params["serviceid"],));

        update_query('tblcustomfieldsvalues', array('value' => $_REQUEST['changeip'],),
            array('value' => $params['customfields']['IP'], 'relid' => $params["serviceid"],));
    }

    $response = array(
        'statusip'=>'changed',
        'licenseInfo' => $api->response,
        'successMessage' => $_LANG['changed_ip'],
        'lang' => $_LANG
    );
//                    var_dump($api->response['listOS'][$api->response['os']]);die;

//    } else {
//
//
//        $response = array(
//            'statusip' => "DonotChanged",
//            'licenseInfo' => $api->response,
//            'wrongMessage' => $_LANG['invalidIP'],
//            'lang' => $_LANG
//        );
//    }
}
//    var_dump($_LANG['NotDownload']);die;
     $response = array(
        'licenseInfo' => $api->response,
        'lang' => $_LANG,
        'price' => $chanegprice,
        'client' => $client
    );



