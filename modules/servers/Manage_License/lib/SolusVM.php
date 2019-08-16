<?php
if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

use WHMCS\Database\Capsule;

if (isset($_REQUEST) && $_REQUEST['changeip'] != null) {
    $ip = $_REQUEST['changeip'];

    if (!empty($ip) && filter_var($ip, FILTER_VALIDATE_IP)) {
        Capsule::table('tblhosting')->where('id', '=', $params['serviceid'])->update(
            [
                'domain' => $ip
            ]);
        $response = array(
            'licenseInfo' => "changed",
            'successMessage' => $_LANG['changed_ip_solusvm'],
            'lang' => $_LANG
        );

    }else{
        $response = array(
            'licenseInfo' => "DonotChanged",
            'wrongMessage' => $_LANG['invalidIP'],
            'lang' => $_LANG
        );
    }

}else {
    $response = array(
        'licenseInfo' => $api->response,
        'lang' => $_LANG
    );
}