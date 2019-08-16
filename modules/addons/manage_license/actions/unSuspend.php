<?php
$vars = $_POST['variable'];
include  "actions.php";
include(dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/init.php");


if (!isset($_SESSION["uid"]) || !is_numeric($_SESSION["uid"])) {
    die("This file cannot be accessed directly");
}


if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}
use WHMCS\Database\Capsule as DB;

$actions = new actions();
$vars["action"] = "unsuspend";

$actions->generateUrl($vars);
$res = DB::table("tblservers")->where('id', "17")->first();
$actions->params["billing"] = $vars["billing"];
$actions->params["params"]["serverpassword"] = $actions->decryptPass($res->password);
$actions->params["params"]["username"] = $vars["licensekay"];
$actions->params["params"]["serverusername"] = (string)$res->username;
$actions->params["params"]["serverhostname"] = (string)$res->hostname;
$actions->params["params"]["serviceid"] = $vars["serviceid"];
$actions->params["params"]["configoption1"] = $vars["name"];
$actions->params["params"]["customfields"]["IP"] = $vars["ip"];

if ( explode("|", $vars["name"])[0] == "SolusVM"){
    $actions->params["params"]["configoptions"]["Slaves"] = 0;
    $actions->params["params"]["configoptions"]["Mini Slaves"] = 0;
    $actions->params["params"]["configoptions"]["Micro Slaves"] = 0;
}
$response=$actions->curl();
$res=json_decode($response);
if ($res->result== "error"){
    echo $response;
}
else if ($res->result== "success"){
    DB::table("mod_manage_license_ap")->where("id",$vars["id"])->update([
        "status"=>"Active"
    ]);
    echo "true";
}


