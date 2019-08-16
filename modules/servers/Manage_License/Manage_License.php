<?php
if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}
use WHMCS\Database\Capsule as DB;

if (!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);

GLOBAL $dir;
GLOBAL $language;

$dir = ROOTDIR.DS.'modules' . DS . 'servers' . DS . 'Manage_License' . DS;
$language = strtolower($_SESSION['Language']);
$language = $dir . DS . 'lang' . DS . $language . '.php';

if (!file_exists($language))
$language = $dir . DS . 'lang' . DS . 'english.php';

require_once($dir . 'lib' . DS . 'MLclass.php');

function Manage_License_MetaData()
{
    return array(
        'DisplayName' => 'Manage License Module',
        'APIVersion' => '1.0',
        'RequiresServer' => 0
    );
}

function Manage_License_ConfigOptions()
{
    return array(
        'Licene Name' => array(
            'Type' => 'dropdown',
            'Loader' => 'manage_license_loadProducts',
            'SimpleMode' => true,
            'Description' => 'Select one License. ',
        ),
    );
}

function manage_license_loadProducts(array $params)
{
    $params["action"] = "accessibility";
    $params['configoption1'] = "setting|getProducts";

    $api = new manageLicense($params);
    if ($api->error == true) {
        logActivity($api->errorMessage);
        return array("Error"=>"error Please check Log Activity");
    }
    return $api->response;
}

function Manage_License_CreateAccount(array $params)
{
    try {
        if ($params['addonId'] == 0) {
            $api = new manageLicense($params);
            if ($api->error == true) {
                return $api->errorMessage;
            }
            switch (explode("|", $params['configoption1'])[0]) {
                case 'cPanel':
	            case "CloudLinux":
                    DB::table('tblhosting')->where('id', '=', $params['serviceid'])->update(['domain' => $params["customfields"]["IP"]]);
                    return 'success';
                    break;
                case 'DirectAdmin':
                case 'Plesk':
                case 'LiteSpeed':
                    DB::table('tblhosting')->where('id', '=', $params['serviceid'])->update(
                        ['username' => $api->response['licensekey'],
                            'domain' => $api->response['server_ip']
                        ]);
                    break;
                case 'SolusVM':
	            case 'Whmcs':
	            DB::table('tblhosting')->where('id', '=', $params['serviceid'])->update(['username' => $api->response['licensekey']]);
                    break;
                case 'SSL':
                    if($params['domain'] == "")
                        DB::table('tblhosting')->where('id', '=', $params['serviceid'])->update(['domain' => $params["customfields"]["Domain"]]);
                    break;
	            default:
		            return 'success';

            }
        }
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
            'Manage_License', __FUNCTION__, $params, $e->getMessage(), $e->getTraceAsString()
        );
        return $e->getMessage();
    }
    return 'success';
}

function Manage_License_SuspendAccount(array $params)
{
    if ($params['addonId'] == 0) {

        try {
            $api = new manageLicense($params);

            if ($api->error == true) {
                return $api->errorMessage;
            }

        } catch (Exception $e) {
             logModuleCall(
                'Manage_License', __FUNCTION__, $params, $e->getMessage(), $e->getTraceAsString()
            );
            return $e->getMessage();
        }
    }
    return "success";
}

function Manage_License_UnsuspendAccount(array $params)
{
    try {
        if ($params['addonId'] == 0) {
            $api = new manageLicense($params);
            if ($api->error == true) {
                return $api->errorMessage;
            }
            if ((explode("|", $params['configoption1'])[0]) == "CloudLinux") {
                DB::table('tblhosting')->where('id', '=', $params['serviceid'])->update(
                    [
                        'username' => $api->response['licensekey'],
                        'domain' => $api->response['server_ip']
                    ]);
            }
        }
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
            'Manage_License', __FUNCTION__, $params, $e->getMessage(), $e->getTraceAsString()
        );
        return $e->getMessage();
    }
 }

function Manage_License_TerminateAccount(array $params)
{
    // action is (terminate)
    try {
        if ($params['addonId'] == 0) {
            $api = new manageLicense($params);
            if ($api->error == true) {
                return $api->errorMessage;
            }

        }
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
            'Manage_License', __FUNCTION__, $params, $e->getMessage(), $e->getTraceAsString()
        );
        return $e->getMessage();
    }
    return 'success';
}

function Manage_License_Renew(array $params)
{
    try {

        if ($params['addonId'] == 0) {
            $api = new manageLicense($params);
            if ($api->error == true) {
                return $api->errorMessage;
            }
        }

    } catch (Exception $e) {
        logModuleCall(
            'Manage_License', __FUNCTION__, $params, $e->getMessage(), $e->getTraceAsString()
        );
        return $e->getMessage();
    }
    return 'success';

}

function Manage_License_ChangePackage(array $params)
{
    try {

        $check = false;

        switch (explode("|", $params['configoption1'])[0]) {
            case 'SSL':
            case 'cPanel':
            case 'DirectAdmin':
            	break;
            default:
                $check = true;
                break;
        }

        if ($check) {
            if ($params['addonId'] == 0) {
                $api = new manageLicense($params);
                if ($api->error == true) {
                    return $api->errorMessage;
                }
            }
        }

    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
            'Manage_License', __FUNCTION__, $params, $e->getMessage(), $e->getTraceAsString()
        );
        return $e->getMessage();
    }
    return 'success';
}

function Manage_License_AdminCustomButtonArray($params)
{
    switch (explode("|", $params['configoption1'])[0]) {
        case 'Whmcs':
        case 'SolusVM':
            return array(
                "Reissue" => "Reissue",
            );
            break;
        default:
            return 'dont needed';
    }
}

function Manage_License_Reissue(array $params)
{
    try {

        if ($params['addonId'] == 0) {
            $api = new manageLicense($params);
            if ($api->error == true) {
                return $api->errorMessage;
            }
	        return 'success';

        }
    } catch (Exception $e) {
        logModuleCall(
            'Manage_License', __FUNCTION__, $params, $e->getMessage(), $e->getTraceAsString()
        );
        return $e->getMessage();
    }
}

function Manage_License_ClientAreaCustomButtonArray($params)
{
//	$language = strtolower($_SESSION['Language']);
//	$lang = __DIR__. DS . 'lang' . DS . $language . '.php';
//
//	if (!file_exists($lang))
//		$lang = __DIR__ . DS . 'lang' . DS . 'farsi.php';
	include($GLOBALS['language']);

    switch (explode("|", $params['configoption1'])[0]) {
        case 'SolusVM':
        case 'Whmcs':
            return array(
                $_LANG['reissue'] => "Reissue");
            break;
        case 'DirectAdmin':
            $api = new manageLicense($params);
            if ($api->error == true) {
                return $api->errorMessage;
            }
            return array(
                $_LANG['SyncDirectadminLicense'] => "SyncDirectadminLicense");
            break;
        default:
            return 'dont needed';
    }


}//ooo

function Manage_License_AdminServicesTabFields(array $params)
{
    if ($_GET["sendType"] == "ajax") {
        if ($_POST["type"] == "change-ip") {
            ob_clean();
            $r = Manage_License_change_ip($params);
            exit($r);
        } elseif ($_POST["type"] == "ChangeName") {
            ob_clean();
            $r = Manage_License_ChangeName($params);
            exit($r);
        } elseif ($_POST["type"] == "ChangeOs") {
            ob_clean();
            $r = Manage_License_ChangeOs($params);
            exit($r);
        }
        return "success";

    }

    include_once($GLOBALS['language']);
    try {
        if ($params['addonId'] == 0) {
            $api = new manageLicense($params);
             if ($api->error == true) {
                return array("Licenses Error" => $api->errorMessage);
            }
        }
        $type = explode("|", $params['configoption1'])[0];
        require_once $GLOBALS['dir']."lib".DS."adminArea".DS .$type.".php";
//  	    switch () {
//
//
//            case 'Plesk':
//            case 'cPanel':
//                break;
//            case 'DirectAdmin':
////                die( "DirectAdmin");
//                break;
//            case 'CloudLinux':
//                break;
//            //end
//
//            case'LiteSpeed':
//                break;
//            case 'SolusVM':
//                break;
//            case 'Whmcs':
//                break;
//            case 'SSL':
//
//                break;
//            default:
//
//                return array("");
//                break;
//        }
return $LicenseInfo;
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
            'Manage_License', __FUNCTION__, $params, $e->getMessage(), $e->getTraceAsString()
        );
        // In an error condition, simply return no additional fields to display.
    }

    return array();
}

function Manage_License_AdminServicesTabFieldsSave(array $params)
{
    // action is (AdminServicesTabFieldsSave)
    // Fetch form submission variables.
	try{
    switch ($type = explode("|", $params['configoption1'])[0]) {
        case "cPanel":

            if ($params['domain'] != $_REQUEST['changeip'] && !empty($_REQUEST['changeip'])) {
                $params['changeip'] = $_REQUEST['changeip'];
                $params['action'] = "AdminServicesTabFields";
                try {
//            echo "<pre>";
//            var_dump($params);
                    if ($params['addonId'] == 0) {
                        $api = new manageLicense($params);
                        if ($api->error == true) {
                            //die($api->errorMessage);
                        } else {
                            update_query('tblhosting', array('domain' => $_REQUEST['changeip'],),
                                array('id' => $params["serviceid"],));

                            update_query('tblcustomfieldsvalues', array('value' => $_REQUEST['changeip'],),
                                array('value' => $params['customfields']['IP'], 'relid' => $params["serviceid"],));
                        }
                    }
                } catch (Exception $e) {
                    logModuleCall(
                        'Manage_License', __FUNCTION__, $params, $e->getMessage(), $e->getTraceAsString()
                    );
                }


            }

            break;

//        case "DirectAdmin":
////            logActivity(json_encode($_REQUEST));die;
//            $params['action'] = "AdminServicesTabFields";
//            if ($params['domain'] != $_REQUEST['changeIP'] && !empty($_REQUEST['changeIP'])) {
//                $params['form_post']['changeIP'] = $_REQUEST['changeIP'];
//            }
//            $params['form_post']['ChangeName'] = $_REQUEST['ChangeName'];
//            $params['form_post']['ChangeOs'] = $_REQUEST['ChangeOs'];
////            logActivity(json_encode($params['form_post']['ChangeName']));die;
//
//            $api = new manageLicense($params);
//            if ($api->error == true) {
//                logActivity("error");
//                //return $api->errorMessage;
//            } else {
//                if ($api->response['ip'] == $_REQUEST['changeIP']) {
//                    update_query('tblhosting', array('domain' => $_REQUEST['changeIP'],),
//                        array('id' => $params["serviceid"],));
//
//                    update_query('tblcustomfieldsvalues', array('value' => $_REQUEST['changeIP'],),
//                        array('value' => $params['customfields']['IP'], 'relid' => $params["serviceid"],));
//                }
//
//            }
////                    var_dump($api->response['listOS'][$api->response['os']]);die;
//            update_query('tblcustomfieldsvalues', array('value' => $api->response['listOS'][$api->response['os']],),
//                array('value' => $params['customfields']['OS'], 'relid' => $params["serviceid"],));
//
//            break;

    }
    $originalFieldValue = isset($_REQUEST['Manage_License_original_uniquefieldname']) ? $_REQUEST['Manage_License_original_uniquefieldname'] : '';
    $newFieldValue = isset($_REQUEST['Manage_License_uniquefieldname']) ? $_REQUEST['Manage_License_uniquefieldname'] : '';

    // Look for a change in value to avoid making unnecessary service calls.
//    if ($originalFieldValue != $newFieldValue) {
//        try {
//            if ($params['addonId'] == 0) {
//                $api = new manageLicense($params);
//                if ($api->error == true) {
//                    return $api->errorMessage;
//                }
//            }
        } catch (Exception $e) {
            logModuleCall(
                'Manage_License', __FUNCTION__, $params, $e->getMessage(), $e->getTraceAsString()
            );
        }
//    }
}

//function Manage_License_ServiceSingleSignOn(array $params)
//{
//    // action is (ServiceSingleSignOn)
//    try {
//
////        if ($params['addonId'] == 0) {
////            $api = new manageLicense($params);
////            if ($api->error == true) {
////                return $api->errorMessage;
////            }
////        }
//        return array();
//
//    } catch (Exception $e) {
//        // Record the error in WHMCS's module log.
//        logModuleCall(
//            'Manage_License', __FUNCTION__, $params, $e->getMessage(), $e->getTraceAsString()
//        );
//
//        return array(
//            'success' => false,
//            'errorMsg' => $e->getMessage(),
//        );
//    }
//}

//function Manage_License_AdminSingleSignOn(array $params)
//{
//    // Action is (AdminSingleSignOn) it's in server setting when you want to loggedin.
//    try {
//        return array();
//        if ($params['addonId'] == 0) {
//            $api = new manageLicense($params);
//            if ($api->error == true) {
//                return $api->errorMessage;
//            }
//        }
//        $response = array();
//
//        return array(
//            'success' => true,
//            'redirectTo' => $response['redirectUrl'],
//        );
//    } catch (Exception $e) {
//        // Record the error in WHMCS's module log.
//        logModuleCall(
//            'Manage_License', __FUNCTION__, $params, $e->getMessage(), $e->getTraceAsString()
//        );
//
//        return array(
//            'success' => false,
//            'errorMsg' => $e->getMessage(),
//        );
//    }
//}

function Manage_License_ClientArea(array $params)
{

    if ($params['addonId'] == 0) {
require ($GLOBALS['language']);
        try {
//$errorTem= $GLOBALS['dir'].'templates'.DS.'error.tpl';
//var_dump($GLOBALS['language']);
	        if ($params['status'] != "Active"){
//		        var_dump($params['status']);

		        return array(
			        'tabOverviewReplacementTemplate' => 'error.tpl',
			        'templateVariables' => array(
				        'lang' => $_LANG,
				        'er' => $_LANG[$params['status']]

			        ),
		        );
	        }
//
//            if ($params['status'] == "Suspended") {
//                return array(
//                    'tabOverviewReplacementTemplate' => 'error.tpl',
//                    'templateVariables' => array(
//                        'lang' => $_LANG,
//                        'er' => $_LANG['Suspended']
//
//                    ),
//                );
//            }
//            if ($params['status'] == "Pending") {
//                return array(
//                    'tabOverviewReplacementTemplate' => 'error.tpl',
//                    'templateVariables' => array(
//                        'lang' => $_LANG,
//                        'er' => $_LANG['Pending']
//
//                    ),
//                );
//            }
//            if ($params['status'] == "terminate") {
//                return array(
//                    'tabOverviewReplacementTemplate' => 'error.tpl',
//                    'templateVariables' => array(
//                        'lang' => $_LANG,
//                        'er' => $_LANG['terminate']
//                    ),
//                );
//            }
//            if ($params['status'] == "cancelled") {
//                return array(
//                    'tabOverviewReplacementTemplate' => 'error.tpl',
//                    'templateVariables' => array(
//                        'lang' => $_LANG,
//                        'er' => $_LANG['cancelled']
//                    ),
//                );
//            }
//            if ($params['status'] == "Fraud") {
//                return array(
//                    'tabOverviewReplacementTemplate' => 'error.tpl',
//                    'templateVariables' => array(
//                        'lang' => $_LANG,
//                        'er' => $_LANG['Fraud']
//                    ),
//                );
//            }
            if (isset($_REQUEST['changeData']) && $_REQUEST['changeData'] != '') {

//                var_dump($_POST); die;
                if (isset($_REQUEST['changeip']) && $_REQUEST['changeip'] != '') {

                    $ip = $_REQUEST['changeip'];

                    if (!empty($ip) && filter_var($ip, FILTER_VALIDATE_IP)) {
                        if ((explode("|", $params['configoption1'])[0] == "cPanel" ||
                                explode("|", $params['configoption1'])[0] == "DirectAdmin" ||
                                explode("|", $params['configoption1'])[0] == "CloudLinux") &&
                            $params['domain'] != $_REQUEST['changeip']) {
                            if (explode("|", $params['configoption1'])[0] == "DirectAdmin") {
                                $client = Manage_license_getClient($params);
                                $prices = Manage_license_setting('price');
                                foreach ($prices as $price) {
                                    if ($price->key = 'USD')
                                        $chanegprice = $price->value;
                                }
                                if (!$client["client"]["credit"] >= $chanegprice) {
                                    goto error;
                                }
                            }
                            $params["form_post"]['changeIP'] = $params['changeip'] = $_REQUEST['changeip'];
                        }else
                        goto error;
                    } else
                        goto error;
                } else {
                    if ((explode("|", $params['configoption1'])[0]) != "SSL") {
                        logActivity("Your Customer try to change IP with fake IP service IP is: " .
                            $params['serviceid'] . " Fake IP: " . $_REQUEST['changeip']);
                        error:
                        return array(
                            'tabOverviewReplacementTemplate' => 'error.tpl',
                            'templateVariables' => array(
                                'usefulErrorHelper' => $_LANG['wrongip'],
                                'er' => $_LANG['wrongip'],
	                            'errorTrue' => true
                            ),
                        );
                    }
                }
            }
            if (explode("|", $params['configoption1'])[0] == "SSL") {
                $params["form_get"] = $_GET ? $_GET : '';
                $params["form_post"] = $_POST ? $_POST : '';
            }
            if (explode("|", $params['configoption1'])[0] == "DirectAdmin" && isset($_POST['ChangeName'])) {

                $params["form_post"] = $_POST ? $_POST : '';
            }
//            logActivity("changeIPResult".json_encode());
            $api = new manageLicense($params);
            if ($api->error == true) {
                logActivity("Error massage in serviceID " . $params['serviceid'] . " is" . $api->errorMessage);
                return array(
                    'tabOverviewReplacementTemplate' => 'error.tpl',
                    'templateVariables' => array(
                        'usefulErrorHelper' => $_LANG['ContactAdmin'],
                        'er' => $api->errorMessage,
                         'errorTrue' => true

                    ),
                );
            }

            if ($api->response["changeip"] == "True") {
                Manage_License_changeIpCredit($params, $api->response["lid"], $api->response["ip"]);
            }
            if ($api->response["changeip"] == "False") {
                goto error;
            }
            switch ($type = explode("|", $params['configoption1'])[0]) {
                case "Whmcs":
                case "SolusVM":
                case "LiteSpeed":
                case "DirectAdmin":
                case "Plesk":
                case "cPanel":
	            case "SSL":
                    $templateFile = "templates" . DS . $type . ".tpl";
                    break;
                case 'CloudLinux':
                    $licenseType = explode("|", $params['configoption1'])[1];
                    if ($licenseType == "CloudLinux") {
                        $templateFile = 'templates/CloudLinux.tpl';
                    } else if ($licenseType == "KernelCare") {
                        $templateFile = 'templates/KernelCare.tpl';
                    } else if ($licenseType == "Imunify360") {
                        $templateFile = 'templates/Imunify.tpl';
                    }
                    break;
//                case "SSL":
//                    $templateFile = 'templates/SSL.tpl';
//                    break;

            }
            include "lib" . DS . $type . ".php";
//            var_dump($response);die;
//inja
//            $response=$params['status'];
            return array(
                'tabOverviewReplacementTemplate' => $templateFile,
                'templateVariables' => $response

            );
        } catch
        (Exception $e) {
            logModuleCall(
                'Manage_License', __FUNCTION__, $params, $e->getMessage(), $e->getTraceAsString()
            );
//            var_dump("asd");die;
            return array(
                'tabOverviewReplacementTemplate' => 'error.tpl',
                'templateVariables' => array(
                    'usefulErrorHelper' => $e->getMessage(),
                    'lang' => $_LANG,
                    'errorTrue' => true


                ),
            );
        }


    }

}

function Manage_License_checkCredit($params)
{
    $command = "getclientsdetails";
//    $adminuser = "apiadmin";
    $creditvalues["clientid"] = $params["userid"];
    $creditvalues["stats"] = true;
    $creditvalues["responsetype"] = "json";

    $results = localAPI($command, $creditvalues);
    $currencies = DB::table('mod_manage_license_settings')->where("name", "priceIP")->pluck('value', 'key');
    $currencies["USD"] = $currencies["USD"];
    $credit = intval($results["client"]["credit"]);
    if ($credit >= $currencies["USD"])
        return true;

    return false;

}//ok

function Manage_License_changeIpCredit($params, $lid, $ip, $oldip = null)
{
//    if(_checkCredit($params) == true){
    $command = "createinvoice";
//    $adminuser = "apiadmin";
    $values["userid"] = $params["userid"];
    $values["date"] = date("Ymd");
    $values["duedate"] = date("Ymd");
    $values["paymentmethod"] = "irangateway";
    $values["sendinvoice"] = true;
    $values["itemdescription1"] = "Ip change for licence " . $lid . " form" . $oldip . " to " . $ip . ".";
    $currencies = DB::table('mod_manage_license_settings')->where("name", "priceIP")->pluck('value', 'key');
    $values["itemamount1"] = $currencies["USD"];
    $results = localAPI($command, $values);

    $command = "applycredit";
//    $adminuser = "apiadmin";
    $applyvalues["invoiceid"] = $results["invoiceid"];
    $applyvalues["amount"] = "full";

    $results = localAPI($command, $applyvalues);
    update_query('tblinvoiceitems',
        array(
            'relid' => $params["serviceid"],
            'type' => "Hosting",
        ),
        array(
            'invoiceid' => $results["invoiceid"],
            'userid' => $params["userid"],
        )
    );

    return true;
//    }
    return false;
}

function Manage_license_getClient($params)
{
    $command = "getclientsdetails";
    $creditvalues["clientid"] = $params["userid"];
    $creditvalues["stats"] = true;
    $creditvalues["responsetype"] = "json";

    $results = localAPI($command, $creditvalues);
    return $results;
}

function Manage_license_setting(string $name)
{
    $res = DB::table("mod_manage_license_settings")->where("name", $name)->get();

    if ($res) {
        return $res;
    }
    return false;
}

function Manage_License_change_ip(array $params)
{

    $license = explode("|", $params['configoption1'])[0];
    switch ($license) {
        case "DirectAdmin":
            {
                if ($params['domain'] != $_REQUEST['changeIP'] && !empty($_REQUEST['changeIP'])) {
                    $params['changeIP'] = $_REQUEST['changeIP'];
                    $params['action'] = "changeIp";
                    $api = new manageLicense($params);
                    if ($api->error == true) {
                        //return $api->errorMessage;
                        return "False";

                    } else {
                        if ($api->response['ip'] == $_REQUEST['changeIP']) {
                            update_query('tblhosting', array('domain' => $_REQUEST['changeIP'],),
                                array('id' => $params["serviceid"],));

                            update_query('tblcustomfieldsvalues', array('value' => $_REQUEST['changeIP'],),
                                array('value' => $params['customfields']['IP'], 'relid' => $params["serviceid"],));
                        }
                        return "True";

                    }
//        var_dump($api->response['listOS'][$api->response['os']]);die;
//                    update_query('tblcustomfieldsvalues', array('value' => $api->response['listOS'][$api->response['os']],),
//                        array('value' => $params['customfields']['OS'], 'relid' => $params["serviceid"],));

                } else {
                    echo "noChange";
                }
            }
        case 'CloudLinux':
            {
                if (!empty($_REQUEST['changeIP'])) {
                    $params['changeIP'] = $_REQUEST['changeIP'];
                    $params['action'] = "changeIp";

                    $api = new manageLicense($params);
                    if ($api->error == true) {
                        echo json_encode($api);
                    } else {
	                    logActivity($api->response);
                        if ($api->response['chageipok']) {
                            update_query('tblhosting', array('domain' => $_REQUEST['changeIP'],),
                                array('id' => $params["serviceid"],));

                            update_query('tblcustomfieldsvalues', array('value' => $_REQUEST['changeIP'],),
                                array('value' => $params['customfields']['IP'], 'relid' => $params["serviceid"],));

                            return "True";
                        }
                    }
                } else {
                    echo "noChange";
                }
            }
    }
    return 0;
}

function Manage_License_ChangeName(array $params)
{
    $license = explode("|", $params['configoption1'])[0];
    switch ($license) {
        case "DirectAdmin":
            {
                $params['ChangeName'] = $_REQUEST['ChangeName'];
                $params['action'] = "ChangeName";
                $api = new manageLicense($params);
                if ($api->error == true) {
//                    logActivity("error1" . json_encode($api));
                    return "False";
                } else {
                    return "True";
                }
            }
    }
}

function Manage_License_ChangeOs(array $params)
{
    $license = explode("|", $params['configoption1'])[0];
    switch ($license) {
        case "DirectAdmin":
            {
                $params['new_os'] = $_REQUEST['new_os'];
                $params['action'] = "ChangeOs";
                $api = new manageLicense($params);
                if ($api->error == true) {
//                    logActivity("error1" . json_encode($api));
                    return "False";
                } else {
                    update_query('tblcustomfieldsvalues', array('value' => $api->response['listOS'][$api->response['os']],),
                        array('value' => $params['customfields']['OS'], 'relid' => $params["serviceid"],));
                    return "True";
                }
            }
    }
}
