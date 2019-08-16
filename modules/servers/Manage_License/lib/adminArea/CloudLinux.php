<?php
//$licenseType = explode( "|", $params['configoption1'] )[1];
//if ( $licenseType == "CloudLinux" ) {
var_dump($api->response);
	$LicenseInfo = array(
		"License Info: " =>
			"OS : <b>" . $api->response['server_info']
			. "</b><br>IP :<b>" . $api->response['ip']
			. "</b><br>Last Check :<b>" . $api->response['last_checkin'] . "</b>" .
			"<hr><div class='' > Change IP:
                        <div class='input-group col-md-4'>
                        <input type = \"text\" name=\"changeIP\" id='changeIP'  class='form-control ' value=\"" . $api->response['ip'] . "\" /> 
                            <div class=\"input-group-btn\">
                                <button type='button' onclick='actions.cloud_change_ip()'  class='btn btn-default'>save</button>
                            </div>
                        </div>"
	);

//} else if ( $licenseType == "KernelCare" ) {
//	$LicenseInfo = array( "License Info: " => $api->response['status'] );
//} else if ( $licenseType == "Imunify360" ) {
//	$LicenseInfo = array( "License Info: " => $api->response['status'] );
//}

