<?php
include "actions.php";
//inclu (dirname(dirname(dirname(dirname(__FILE__))))."/init.php");
include_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . "/init.php");
//echo WHMCS;die;


//if (!isset($_SESSION["uid"]) || !is_numeric($_SESSION["uid"])) {
//    die("This file cannot be accessed directly1");
//}


if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}


use WHMCS\Database\Capsule as DB;

$actions = new actions();
$serviceid = $_POST["serviceid"];
$name = $_POST["name"];

$result = DB::table("mod_manage_license_products")->where("id", $name)->first();
if ($result) {
    $host = DB::table("tblhosting")->where("id", $serviceid)->first();
    if ($host) {
        $lastP = DB::table("mod_manage_license_ap")->where("name", $result->name)->where("serviceid", $serviceid)->get();
        if ($lastP) {
            $actions->addErrorCode(["101", "license is exist"]);
        }
        if ($actions->result) {
            $userid = $host->userid;
            $billingcycle = $host->billingcycle;
            try {
                DB::table("mod_manage_license_ap")->insert([
                    'serviceid' => $serviceid,
                    'status' => 'Pending',
                    'userid' => $userid,
                    'options' => $result->option,
                    'suboptions' => $result->suboption,
                    'name' => $result->name,
                    'ip' => $host->dedicatedip,
                    'billing' => $billingcycle,
                    'lastDate' => date("Y-m-d")
                ]);
            } catch (Exception $exception) {
                $actions->addErrorCode(["103", "error in insert query"]);
            }
            if ($actions->result) {
                $actions->output = "create successful";
            }
        }
    } else {
        $actions->addErrorCode(["100", "error in find serviceid"]);
    }
} else {
    $actions->addErrorCode(["100", "error in find product"]);
}

echo $actions->updateRecord();