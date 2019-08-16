<?php
if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

use WHMCS\Database\Capsule;

//if (isset($_REQUEST) && $_REQUEST['changeip'] != null) {
//
//    $ip = $_REQUEST['changeip'];
//    if (!empty($ip) && filter_var($ip, FILTER_VALIDATE_IP)) {
//
//        update_query('tblhosting', array('domain' => $_REQUEST['changeip'],),
//            array('id' => $params["serviceid"],));
//
//        update_query('tblcustomfieldsvalues', array('value' => $_REQUEST['changeip'],),
//            array('value' => $params['customfields']['IP'], 'relid' => $params["serviceid"],));
//        $response = array(
//            'statusip'=>'changed',
//            'licenseInfo' => $api->response,
//            'successMessage' => $_LANG['changed_ip'],
//            'lang' => $_LANG
//        );
//    } else {
//        foreach ($api->response as $key => $value) {
//            if ($value != '0' && $value == "")
//                $api->response[$key] = "Not Register";
//        }
//
//        $response = array(
//            'statusip' => "DonotChanged",
//            'licenseInfo' => $api->response,
//            'wrongMessage' => $_LANG['invalidIP'],
//            'lang' => $_LANG
//        );
//    }
//} else {

if(isset($api->response['changeipok']) && $api->response['changeipok']  == true){
         update_query('tblhosting', array('domain' => $_REQUEST['changeip'],),
            array('id' => $params["serviceid"],));

        update_query('tblcustomfieldsvalues', array('value' => $_REQUEST['changeip'],),
            array('value' => $params['customfields']['IP'], 'relid' => $params["serviceid"],));
        $response = array(
            'statusip'=>'changed',
            'licenseInfo' => $api->response,
            'successMessage' => $_LANG['changed_ip'],
            'lang' => $_LANG
        );
}else{
    foreach ($api->response as $key => $value) {
        if ($value != '0' && $value == "")
            $api->response[$key] = "Not Register";
    }

//    var_dump($api->response);die;
    $response = array(
        'licenseInfo' => $api->response,
        'lang' => $_LANG
    );
}
