<?php
$vars = $_POST['variable'];
include  "actions.php";
//include(dirname(dirname(dirname(dirname(__FILE__))))."/init.php");
include(dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/init.php");


//if (!isset($_SESSION["uid"]) || !is_numeric($_SESSION["uid"])) {
//    die("This file cannot be accessed directly");
//}

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}
use WHMCS\Database\Capsule as DB;

$actions = new actions();
$vars["action"] = "terminate";

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

$response=$actions->curl();
$res=json_decode($response);
DB::table("mod_manage_license_ap")->where("id",$vars["id"])->delete();
echo "true";
if ($res->result== "error"){
    logActivity('service_id:'.$vars["serviceid"].'has error :'.$res->message)
 ;
}




