<?php


require_once(dirname(dirname(dirname(dirname(__FILE__))))."/init.php");

//require_once("functions.php");
if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}


use WHMCS\Database\Capsule as DB;


$products = DB::table("mod_manage_license_ap")->groupBy("serviceid")->get();
$res = '<form id="frmSearch">
<fieldset class="form-border fieldset">
<legend class=\'legend\'>Search</legend>
    <div CLASS="col-md-2">
      <div class="form-group">
     <input type="text" class="form-control" placeholder="pleas insert serviceid" id="searchserviceid">
     </div>
    </div> <div    CLASS="col-md-2">
      <div class="form-group">
     <input type="text" class="form-control"  placeholder="please insert userid" id="userid">
     </div>
    </div> <div    CLASS="col-md-2">
      <div class="form-group">
     <input type="text" class="form-control" placeholder="please insert licensekey" id="licensekey">
     </div>
    </div> <div    CLASS="col-md-2">
      <div class="form-group">
     <input type="text" class="form-control" placeholder="please insert ip" id="ip">
     </div>
    </div><div    CLASS="col-md-2">
      <div class="form-group">
     <input type="submit" class="btn btn-primary" value=\'search\' onclick=\'functions.searchResult(event)\'>
     
     </div>
    </div>
    </fieldset>
    </form>
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover text-center" id="tblUsersLicese">
    
        <thead>
        <tr style="background-color: #b0f8f8">
            <th class="text-center">license name</th>
            <th class="text-center"  >ip</th>
            <th class="text-center"  >licensekey</th>
            <th class="text-center"  >Status</th>
            <th class="text-center"  >lastDate</th>
            <th class="text-center" >action</th>
        </tr>
        </thead>
        <tbody>';
foreach ($products as $product) {
    $user=DB::table("tblclients")->where("id",$product->userid)->first();
    $res .= "<tr>
<td colspan='3' style='text-align: center;background-color: cyan'>Serviceid: $product->serviceid</td>
<td colspan='3' style='text-align: center;background-color: cyan'>userName: $user->firstname. $user->lastname</td>
</tr>";
    $serviceGroups = DB::table("mod_manage_license_ap")->where("serviceid", $product->serviceid)->get();
    foreach ($serviceGroups as $p) {



        $res .= "<tr style=\"border-color: #00fbfb\">
            <td>
            <a href='clientsservices.php?userid=" . $p->userid . "&id=" . $p->serviceid . "'> $p->name</a>
            </td>
            <td ondblclick='functions.changeip(".$p->id.")' id='tdip".$p->id."'>$p->ip</td>
            <td>$p->licensekey</td>
            <td>$p->status</td>
            <td>$p->lastDate</td>
            <td>";
        if ($p->status == "") {
            $res .= "<a href='#' class='btn btn-primary'>check status</a> &nbsp;";
            $res .= "<a href='#' class='btn btn-primary' onclick='functions.active(" . json_encode($p) . ")'>Active</a>";
        } else {
            if ($p->status == "Active") {
                $res .= "<a  onclick='functions.suspend(" . json_encode($p) . ")' class='btn btn-danger'>Suspended</a>&nbsp;";
                $res .= "<a  onclick='functions.terminate(" . json_encode($p) . ")' class='btn btn-danger'>terminated</a>";
            } else if ($p->status == "Suspended") {
                $res .= "<a  onclick='functions.unSuspend(" . json_encode($p) . ")'  class='btn btn-primary'>UnSuspended</a>";
                $res .= "<a  onclick='functions.terminate(" . json_encode($p) . ")' class='btn btn-primary'>terminated</a>";

            } else if ($p->status == "Pending") {
                $res .= "<a  class='btn btn-primary' onclick='functions.active(" . json_encode($p) . ")'>Active</a>";
            }
        }

        $res .= "</td>";
    }
}
$res .= '</tbody>
    </table>
</div>';
return $res;

