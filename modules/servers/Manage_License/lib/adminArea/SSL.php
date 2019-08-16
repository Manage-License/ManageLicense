<?php

if ($api->response == null) {
	$LicenseInfo = array("License Info" => "License Not Active!");
} else {
	$arr = array();
	foreach ($api->response['admin'] as $key => $item) {
		//License ID: <b>" . $item['serviceId'] . "</b><br>
		$info = "license Status: <b>" . $item['status'] . "</b><br>
                                SSL ID: <b>" . $item['id'] . "</b><br>";

		$LicenseInfo['License Info' . ++$key] = $info;
//                        array_push($arr, $info);
	}
//                    return array("License Info" =>
//                        " License ID: <b>" . $api->response['serviceId'] . "</b><br>
//                        license Status: <b>" . $api->response['status'] . "</b><br>
//                        Remote ID: <b>" . $api->response['remoteId'] . "</b><br>"
//                        );
//	return $arr;
}

