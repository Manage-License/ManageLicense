<?php
include "actions.php";
//include(dirname(dirname(dirname(dirname(__FILE__))))."/init.php");
include(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . "/init.php");


//if (!isset($_SESSION["uid"]) || !is_numeric($_SESSION["uid"])) {
//    die("This file cannot be accessed directly");
//}

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

use WHMCS\Database\Capsule as DB;

$serviceid = $_POST["serviceid"];
$userid = $_POST["userid"];
$licensekey = $_POST["licensekey"];
$ip = $_POST["$ip"];
$query = "select * from mod_manage_license_ap";
$merg = 0;
logActivity($serviceid);
if ($serviceid != "") {
    $query .= " WHERE serviceid like '%$serviceid%'";
    $merg = 1;
}
if ($userid != "") {
    if ($merg)

        $query .= " AND userid like '%$userid%' ";
    else
        $query .= " WHERE userid like '%$userid%'";

    $merg = 1;
}
if ($licensekey != "") {
    if ($merg)
        $query .= " AND licensekay like '%$licensekey%'";
    else
    $query .= " where licensekay like '%$licensekey%'";

}
logActivity($query);
$res = DB::select($query);

//("mod_manage_license_ap")
//    ->where("serviceid","like", "%$serviceid%")
//    ->where("userid","like","%$userid%")
//    ->where("licensekay","like","%$licensekey%")
//    ->where("ip","like","%$ip%")
//    ->get();
//
//echo  json_encode($res);
//die;
$output = "";

if ($res) {
    $output = "<tr><td colspan=\"100%\" style=\"text-align: center;background-color: cyan\">$serviceid</td></tr>";
    foreach ($res as $re) {
        $output .= "<tr>
                <td>$re->name</td>
                <td>$re->ip</td>
                <td>$re->licensekay</td>
                <td>$re->status</td>
                <td>$re->lastDate</td>
                <td>";
        if ($re->status == "") {
            $output .= "<a href='#' class='btn btn-info'>check status</a> &nbsp;";
            $output .= "<a href='#' class='btn btn-info' onclick='functions.active(" . json_encode($re) . ")'>Active</a>";
        } else {
            if ($re->status == "Active") {
                $output .= "<a  onclick='functions.suspend(" . json_encode($re) . ")' class='btn btn-danger'>Suspended</a>&nbsp;";
                $output .= "<a  onclick='functions.terminate(" . json_encode($re) . ")' class='btn btn-danger'>terminated</a>";
            } else if ($re->status == "Suspended") {
                $output .= "<a  onclick='functions.unSuspend(" . json_encode($re) . ")'  class='btn btn-info'>UnSuspended</a>";
                $output .= "<a  onclick='functions.terminate(" . json_encode($re) . ")' class='btn btn-info'>terminated</a>";

            } else if ($re->status == "Pending") {
                $output .= "<a  class='btn btn-info' onclick='functions.active(" . json_encode($re) . ")'>Active</a>";
            }
        }
        $output .= "</td></tr>";
    }

} else {
    $output = "<tr><td colspan='100%'>no license</td></tr>";
}

echo $output;