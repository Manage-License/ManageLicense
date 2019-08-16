<?php

use WHMCS\Database\Capsule as DB;
$dir = dirname(__FILE__);
add_hook('AfterShoppingCartCheckout', 1, function ($vars) {
    $servicids = $vars["ServiceIDs"];
//    die(json_encode($servicids));
//    var_dump($vars);die;
    foreach ($servicids as $servicid) {
        $billing = DB::table("tblhosting")->where("id", $servicid)->first();
        $result = DB::table("tblhostingconfigoptions")->where("relid", $servicid)->get();
        foreach ($result as $item) {
            $res = DB::table("mod_manage_license_products")
                ->where("option", $item->configid)->first();
            $res2 = DB::table("tblproductconfigoptionssub")
                ->where("id", $item->optionid)->first();
            if ($res && $res2->optionname != "None") {
                DB::table("mod_manage_license_ap")
                    ->insert([
                        "serviceid" => $servicid,
                        "userid" => $_SESSION["uid"],
                        "options" => (string)$item->configid,
                        "suboptions" => (string)$item->optionid,
                        'status' => 'pending',
                        "name" => (string)$res->name,
                        "billing" => $billing->billingcycle,
                        "lastDate" => (string)date("m")
                    ]);
            }
        }
    }
});

add_hook("AfterModuleCreate", 1, function ($vars) {
    $vars["params"]["action"] = "create";
//    die(json_encode($vars["params"]['accountid'] ));
    if ($vars["params"]['accountid'] == "9187") {
//        var_dump(json_encode($vars["params"]["model"]["billingcycle"]));die;
        checkRequest($vars);
        gatData($vars);
    }
});
add_hook('AfterModuleSuspend', 1, function ($vars) {
    $vars["params"]["action"] = "suspend";
    if ($vars["params"]['accountid'] == "9187") {
        gatData($vars);
    }
});

add_hook('AfterModuleUnsuspend', 1, function ($vars) {
    $vars["params"]["action"] = "unsuspend";
    if ($vars["params"]['accountid'] == "9187") {

        gatData($vars);
    }
});

add_hook('PreModuleTerminate', 1, function ($vars) {
    $vars["params"]["action"] = "terminate";
    if ($vars["params"]['accountid'] == "9187") {

        gatData($vars);
    }
});

add_hook('AdminAreaFooterOutput', 1, function ($vars) {
    return <<<HTML
<script type="text/javascript" src="../modules/addons/manage_license/js/functions.js">
</script>
HTML;
});
add_hook('AdminAreaFooterOutput', 1, function ($vars) {
    return <<<HTML
<script type="text/javascript" src="../modules/servers/Manage_License/js/script.js">
</script>
HTML;
});
add_hook('AdminAreaFooterOutput', 1, function ($vars) {
    return <<<HTML
<script type="text/javascript" src="../modules/servers/Manage_License/js/sweetalert.min.js">
</script>
HTML;
});

add_hook('AdminAreaHeadOutput', 1, function($vars) {
    return <<<HTML
    <link href="../modules/addons/manage_license/css/custom.css" rel="stylesheet" type="text/css" />
HTML;

});


//add_hook('AfterModuleChangePackage', 1, function($vars) {
//    if ($vars["params"]['accountid'] == "8694") {
//        var_dump($vars);die;
//    }
//});

function generateUrl(array $params)
{
//    $url = $params['serverhostname'];
//    $type = 'addon';
//    die(json_encode($params));
    $action = $params['action'];
//    $type = $params['type'];
    $type = explode("|", $params['configoption1'])[0];
    if ($params["serviceid"] == "9187") {
//    var_dump($url . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR . $action . '.php');die;
        $url = "http://nicsepehrapi.com/api/reseller/licenseha";
    }
    return $url . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR . $action;
}

function DecryptPassword(string $password)
{
    $res = DB::table("tbladmins")->where("roleid", "1")->first();
    $command = 'DecryptPassword';
    $postData = array(
        'password2' => $password,
    );
    $adminUsername = (string)$res->username; // Optional for WHMCS 7.2 and later

    $results = localAPI($command, $postData, $adminUsername);
    if ($results["result"] != "success") {
        logActivity("error in ganarete" . $results["message"]);
        return false;
    }
    return $results["password"];
}

function gatData($vars)
{

    $res = DB::table("tblservers")->where('id', "17")->first();
    if ($res) {
        if ($vars["params"]["serverpassword"] = DecryptPassword($res->password)) {
            $vars["params"]["serverusername"] = (string)$res->username;
            $vars["params"]["serverhostname"] = (string)$res->hostname;
//            var_dump($vars["params"]["serverusername"]);die;
            $res1 = DB::table("tblhosting")
                ->where("id", $vars["params"]["serviceid"])->first();
            $vars['billing'] = $res1->billingcycle;
            $vars["params"]["customfields"]["IP"] = $res1->dedicatedip;
        } else
            logActivity("error in password please contact with admin");
    }
    $q = DB::table("mod_manage_license_ap")
        ->where("serviceid", $vars["params"]["serviceid"])->get();
//    die(json_encode($q));
    foreach ($q as $item) {
        $vars["params"]["configoption1"] = (string)$item->name;
        $url = generateUrl($vars["params"]);
//        die($url);
        $vars = setConfigOptions($vars);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($vars));
        $response = curl_exec($ch);
//       die($response);
//        if (curl_error($ch)) {
//            die('Unable to connect: ' . curl_errno($ch) . ' - ' . curl_error($ch));
//        }
        curl_close($ch);
    }
}

function setConfigOptions($vars)
{
    if (isset($vars["params"]["configoptions"]["LiteSpeed"])) {
//        $vars["params"]["configoptions"]["Caching"] = 'LSCache Standard';
//        array_merge($vars["params"]["configoptions"]["Caching"], $a);
        array_merge($vars["params"]["configoptions"], $vars["params"]["configoptions"]["Caching"]);
        $vars["params"]["configoptions"]["Caching"] = (string)"LSCache Standard";
//    var_dump($vars["params"]["configoptions"]["Caching"]);die;
    }
    if (isset($vars["params"]["configoptions"]["SolusVM"])) {

        array_merge($vars["params"]["configoptions"], $vars["params"]["configoptions"]["Slaves"]);
        array_merge($vars["params"]["configoptions"], $vars["params"]["configoptions"]["Mini Slaves"]);
        array_merge($vars["params"]["configoptions"], $vars["params"]["configoptions"]["Micro Slaves"]);
        $vars["params"]["configoptions"]["Slaves"] = 0;
        $vars["params"]["configoptions"]["Mini Slaves"] = 0;
        $vars["params"]["configoptions"]["Micro Slaves"] = 0;

    }
    return $vars;

}


function checkRequest($vars)
{
//    die(json_encode($vars["params"]["model"]["dedicatedip"]));
    $configOptions = $vars["params"]["configoptions"];
//    die(json_encode($configOptions));
    foreach ($configOptions as $key => $value) {
        if ($value != "None") {
            $res = DB::table("mod_manage_license_ap")
                ->where("serviceid", $vars["params"]["accountid"])
                ->where("userid", $vars["params"]["userid"])
                ->where("name", 'like', "$key%")
                ->first();
            $options = DB::table("tblproductconfigoptions")
                ->where("optionname", $key)->first();
            $suboptions = DB::table("tblproductconfigoptionssub")
                ->where("optionname", $value)->first();
            if (!$res) {
                logActivity(json_encode($configOptions));

                try {
                    DB::table("mod_manage_license_ap")->insert([
                        'serviceid' => $vars["params"]["accountid"],
                        'userid' => $vars["params"]["userid"],
                        'options' => $options->id,
                        'suboptions' => $suboptions->id,
                        'status' => 'pending',
                        'name' => $key . '|' . $value,
                        'billing' => $vars["params"]["model"]["billingcycle"],
                    ]);
                } catch (Exception $exception) {
                    logActivity("error in " . $exception->getMessage());
                }
            } else {
                if ($res->name != ($key . '|' . $value)) {
                    DB::table("mod_manage_license_ap")
                        ->where("serviceid", $vars["params"]["accountid"])
                        ->where("userid", $vars["params"]["userid"])
                        ->where("name", 'like', "$key%")->update([
                            'name' => $key . '|' . $value
                        ]);
                }
                if ($res->billing != $vars["params"]["model"]["billingcycle"]) {
                    DB::table("mod_manage_license_ap")
                        ->where("serviceid", $vars["params"]["accountid"])
                        ->where("userid", $vars["params"]["userid"])
                        ->where("name", 'like', "$key%")->update([
                            'billing' => $vars["params"]["model"]["billingcycle"]
                        ]);
                }
                if ($res->suboptions != $suboptions->suboptions) {
                    DB::table("mod_manage_license_ap")
                        ->where("serviceid", $vars["params"]["accountid"])
                        ->where("userid", $vars["params"]["userid"])
                        ->where("name", 'like', "$key%")->update([
                            'suboptions' => $suboptions->id
                        ]);
                }


                if ($res->ip == "" || $vars["params"]["model"]["dedicatedip"] != $res->ip) {
//                    $ip = DB::table("tblhosting")->where("id", $res->serviceid)->select("dedicatedip")->first();
                    DB::table("mod_manage_license_ap")
                        ->where("serviceid", $vars["params"]["accountid"])
                        ->where("userid", $vars["params"]["userid"])->update([
                            'ip' => $vars["params"]["model"]["dedicatedip"]
                        ]);
                }

            }
        }
    }
}
