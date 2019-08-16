<?php
if ($api->response == null) {
	return array("License Info" => "License Not Active!");
} else {
	if ($api->response["status"] == "Active") {
		$status = "Active";
		$color = "color-green";
	} else {
		$status = "Inactive";
		$color = "color-pink";
	}
	if ($api->response["valid"] == "1") {
		$valid = "Valid";
	} else {
		$valid = "invalid";
	}
	if ($api->response["maxusers"] == "0") {
		$maxuser = "unlimit";
	} else {
		$maxuser = $api->response["maxusers"];
	}
	foreach ($api->response as $key => $value) {
		if ($value == '')
			$api->response[$key] = "Not Register";
	}
	$disable = $api->response['numberOfChange'] >= 4 ? 'disabled' : '';
	$viweLang = $api->response['numberOfChange'] >= 4 ? $_LANG['CP_iplimit'] : $_LANG['EnterIP'];
	$LicenseInfo= array("License Info" =>
		             "License ID: <b> " . $api->response['licenseid'] . " </b><br>
                        Status: : <b><label class='$color'>" . $status . "</label> </b><br>
                     IP: <b>" . $api->response['ip'] . "         .</b><br/>
                     Change IP: &nbsp;<input type=\"text\" name=\"changeip\" size=\"30\" 
                     class='form-control input-200' style='display: inline' value=\""
		             . $api->response['ip'] . "\" " . $disable . "> <label class=' color-green'>" . $viweLang . "</label><br>
                   hostname: <b>" . $api->response['hostname'] . "</b><br>
                    valid: <b>" . $valid . "</b><br>
                   distro: <b>" . $api->response['distro'] . "</b><br>
                    version: <b>" . $api->response['version'] . "</b><br>
                      maxusers: <b>" . $maxuser . "</b><br >
                      os: <b>" . $api->response['os'] . " " . $api->response['osver'] . "</b><br>
                    number of change: <b>" . $api->response['numberOfChange'] . "</b> Time this month<br >
                    virtualization  platform: <b>" . $api->response['envtype'] . "</b><br >"
	);
}

