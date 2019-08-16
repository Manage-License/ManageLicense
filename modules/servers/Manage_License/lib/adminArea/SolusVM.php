<?php
if ( $api->response == null ) {
	$LicenseInfo = array( "License Info" => "License Not Active!" );
} else {
	$status      = $api->response['status'] == "Active" ? "<span class=\"label active\">" . $api->response['status'] . "</span>" : "<span class=\"label closed\">" . $api->response['status'] . "</span>";
	$LicenseInfo = array(
		"License Info" =>
			"License ID : <b>" . $api->response['licenseid'] . "</b><br>
                        Product Name : <b>" . $api->response['product'] . "</b><br>
                    License Key: <b>" . $api->response['licensekey'] . "</b><br>
                    Status: <b>" . $status . "</b><br>
                    Number of Slaves: <b>" . $api->response['slaves'] . "</b><br>
                    Number of Mini slaves: <b>" . $api->response['minislaves'] . "</b><br>
                    Number of Micro slaves: <b>" . $api->response['microslaves'] . "</b><br>
                    
                "
	);
}

