<?php
if ($api->response == null) {
	return array("License Info" => "License Not Active!");
} else {
 	$products = "";
	$cnt = 1;
	foreach ($api->response['items'] as $item) {
		$products .= $cnt . "- " . str_replace("-", " ", substr($item['item'], 0, -3)) . "<br>";
		$cnt++;
	}

	$status = strtolower($api->response['status']) == "active" ? "<span class=\"label active\">" . $api->response['status'] . "</span>" : "<span class=\"label closed\">" . $api->response['status'] . "</span>";

	$extentions = "";
	if ($api->response['extentions'] == null) {
		$extentions .= "No active extention found.";
	} else {
		foreach ($api->response['extentions'] as $extention) {
			$extStatus = $extention['status'] == "Active" ? "<span class=\"label active\">" . $extention['status'] . "</span>" : "<span class=\"label closed\">" . $extention['status'] . "</span>";
			$extentions .= "Ext title : <b>" . $extention['pname'] . "</b><br>" .
			               "Key Id : <b>" . $extention['keyid'] . "</b><br>" .
			               "Key Number : <b>" . $extention['keynumber'] . "</b><br>" .
			               "license key : <b>" . $extention['licensekey'] . "</b><br>" .
			               "Status : <b>" . $extStatus . "</b><br><br>";
		}
	}

	$LicenseInfo = array("License Info" =>
		             "license Type :<br> <b>" . $products . "</b>" .
		             "Key Id : <b>" . $api->response['keyIdentifiers']['keyId'] . "</b><br>" .
		             "Key Number : <b>" . $api->response['keyIdentifiers']['keyNumber'] . "</b><br>" .
		             "license key : <b>" . $api->response['keyIdentifiers']['activationCode'] . "</b><br>" .
		             "Status : <b>" . $status . "</b><br>", "Extention(s)" => $extentions

	);

}