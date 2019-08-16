<?php
if ($api->response == null) {
	$LicenseInfo = array("License Info" => "License Not Active!");
} else {
	$status = $api->response['status'] == "Active" ? "<span class=\"label active\">" . $api->response['status'] . "</span>" : "<span class=\"label closed\">" . $api->response['status'] . "</span>";

	$LicenseInfo = array("License Info" =>
		             "license id : <b>" . $api->response ['license_id'] . "</b><br>
                    License type: <b>" . $api->response ['license_type'] . "</b><br>
                    License IP: <b>" . $api->response ['server_ip'] . "</b><br>
                    License Key: <b>" . $api->response['license_serial'] . "</b><br>
                    Status: <b>$status</b><br>
                    Exp date: <b>" . $api->response['next_due_date'] . "</b><br>
                    billing cycle: <b>" . $api->response ['billing_cycle'] . "</b><br>
                    modules: <b>" . $api->response['modules'] . "</b><br>"
	);
}

