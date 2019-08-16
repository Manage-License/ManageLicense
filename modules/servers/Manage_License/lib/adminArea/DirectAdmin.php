<?php
if ($api->response == null) {
	return array("License Info" => "License Not Active!");
} else {
	$status = $api->response['active'] == "Y" ? "<span class=\"label active\">Active</span>" : "<span class=\"label closed\">" . $api->response['active'] . "</span>";
	$verify = $api->response['verified'] == "Y" ? "<span class=\"label active\">verified</span>" : "<span class=\"label closed\">" . $api->response['verified'] . "</span>";
	$LicenseInfo = "Service ID : <b>" . $api->response ['serviceid'] . "</b><br>
                        License ID : <b>" . $api->response ['lid'] . "</b><br>
                    Client ID : <b>" . $api->response ['cid'] . "</b><br>
                    License IP: <b>" . $api->response ['ip'] . "</b><br>
                    License Operation System: <b>" . $api->response['listOS'][$api->response ['os']] . "</b><br>
                    License Name: <b>" . $api->response ['nameinlicense'] . "</b><br> 
                    Status: <b>$status</b><br>
                    Verify: <b>$verify</b><br>
                    Last Download: <b>" . date('Y-m-d', $api->response['dtime']) . "</b><br>";
	if ($api->response['verified'] == "Y") {
		$LicenseInfo .= "<div class='row'> 
                        <div class='col-md-4' > Change IP:
                        <div class='input-group'>
                        <input type = \"text\" name=\"changeIP\" id='changeIP' size=\"25\" class='form-control ' style='display: inline' value=\"" . $api->response['ip'] . "\" /> 
                            <div class=\"input-group-btn\">
                                <button type='button' onclick='actions.change_ip(\"change-ip\")'  class='btn btn-default'>save</button>
                            </div>
                        </div>
                       
                        </div>";
		$LicenseInfo .= "<div class='col-md-4'> 
                        Change Name: <div class='input-group'>
                            <input type=\"text\" id='txtChangeName' name=\"ChangeName\" class='form-control'  value=\"" . $api->response['nameinlicense'] . "\"> 
                           <div class=\"input-group-btn\">
                             <button class='btn btn-default' onclick='actions.change_name(\"ChangeName\")' type='button'>Save</button>
                        </div>
                      </div>
                        
                        <label class='label label-danger changeName' style='display: none;position: absolute'></label> 
                        </div>";
		$LicenseInfo .= "<div class='col-md-4'>
                        Change OS:<div class='input-group'>
                         <select  name=\"ChangeOs\" class='form-control '  id='sltChangeOs'>";
		foreach ($api->response['listOS'] as $key => $value) {
			if ($api->response['os'] == $key)
				$LicenseInfo .= "<option value=\"" . $key . "\" selected>" . $value . "</option>";
			else
				$LicenseInfo .= "<option value=\"" . $key . "\">" . $value . "</option>";
		}
		$LicenseInfo .= "</select>
                        <div class=\"input-group-btn\">
                        <button class='btn btn-default' type='button' onclick='actions.change_os(\"ChangeOs\")'>Save</button>
                        </div>
                        </div>
                         <label class='label label-danger ChangeOs'  style='display: none;position: absolute'></label> ";
		$LicenseInfo .= " </div></div><br>";
	}
 }

