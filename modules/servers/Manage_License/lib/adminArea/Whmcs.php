<?php
if ( $api->response == null ) {
	$LicenseInfo = array( "License Info" => "License Not Active!" );
} else {
	$status      = ( $api->response['status'] == "Active" || $api->response['status'] == "Reissued" ) ? "<span class=\"label active\">" . $api->response['status'] . "</span>" : "<span class=\"label closed\">" . $api->response['status'] . "</span>";
	$LicenseInfo = array(
		"License Info" =>
			" License ID: <b>" . $api->response['licenseid'] . "</b><br>
                            Product Type : <b>" . $api->response['display_name'] . "</b><br>
                    License Key: <b>" . $api->response['licensekey'] . "</b><br>
                    Status: <b>" . $status . "</b><br>
                    Domain: <b>" . $api->response['validdomain'] . "</b><br>
                    IP Address: <b>" . $api->response['validip'] . "</b><br>
                    Valid dir: <b>" . $api->response['validdirectory'] . "</b><br>
                    
                "
	);
}

