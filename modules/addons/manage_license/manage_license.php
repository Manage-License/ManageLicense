<?php
//include_once( ROOTDIR . "/init.php" );

if ( ! defined( "DS" ) ) {
	define( 'DS', DIRECTORY_SEPARATOR );
}
$dir = ROOTDIR.DS.'modules' . DS . 'addons' . DS . 'manage_license' . DS;
if ( ! defined( "WHMCS" ) ) {
	die( "This file cannot be accessed directly" );
}
require_once($dir."libs".DS."bootstrap.php");

use ML_Addon\Admin\UI;
use Illuminate\Database\Capsule\Manager as DB;

//require_once dirname( __FILE__ ) . "/extra/LicenseList.php";

function manage_license_config() {
	return array(
		"name"        => "Manage License",
		"description" => "For manage all product reserved",
		"version"     => "4.0.1",
		"language"    => "english",
 		"author" => "Great world Lovers",
	);

}

function manage_license_activate() {
	try {
		if (!DB::schema()->hasTable('mod_manage_license_subproduct'))
			DB::schema()->create( 'mod_manage_license_subproduct', function ( $table ) {
			$table->increments( 'id' );
			$table->integer( 'name' );
			$table->integer( 'gid' );
		} );
		if (!DB::schema()->hasTable('mod_manage_license_ap'))
			DB::schema()->create( 'mod_manage_license_ap', function ( $table ) {
			$table->increments( 'id' );
			$table->integer( 'serviceid' );
			$table->integer( 'licenseid' )->nullable();
			$table->integer( 'userid' );
			$table->integer( 'options' );
			$table->integer( 'suboptions' );
			$table->string( 'name', 60 )->nullable();;
			$table->string( 'ip', 17 );
			$table->string( 'licensekey', 50 )->nullable();
			$table->string( 'billing', 20 );
//			$table->string('ip', 100);
			$table->enum( 'status', [
				'Pending',
				'Active',
				'Suspended',
				'Reissue',
				'Hardsuspended'
			] )->default( 'Pending' );
			$table->dateTime( 'lastDate' )->default( date( "Y-m-d", time() ) );
		} );
		if (!DB::schema()->hasTable('mod_manage_license_productOptions'))
			DB::schema()->create( 'mod_manage_license_productOptions', function ( $table ) {
			$table->increments( 'id' );
			$table->integer( 'product_id' );
			$table->string( 'configKey', 100 );
			$table->string( 'configValue', 100 );
		} );
		if (!DB::schema()->hasTable('mod_manage_license_products'))
			DB::schema()->create( 'mod_manage_license_products', function ( $table ) {
			$table->increments( 'id' );
			$table->string( 'option', 20 );
			$table->string( 'suboption', 20 );
			$table->string( 'name', 50 )->nullable();
			$table->string( 'ip', 25 )->nullable();
			$table->string( 'licensekey', 50 )->nullable();

		} );
		if (!DB::schema()->hasTable('mod_manage_license_settings'))
			DB::schema()->create( 'mod_manage_license_settings', function ( $table ) {
			$table->increments( 'id' );
			$table->string('name', 100);
			$table->string('key', 100);
			$table->string('value', 100);


		} );

	} catch ( Exception $e ) {
		return array( 'status' => 'UnSuccess', 'description' => 'there is An error: ' . $e->getMessage() );
	}

	return array( 'status' => 'success', 'description' => 'Addon has been successfully activated' );
}

function manage_license_deactivate() {
	try{
		DB::schema()->dropIfExists('mod_manage_license_settings');
		DB::schema()->dropIfExists('mod_manage_license_ap');
		DB::schema()->dropIfExists('mod_manage_license_products');
		DB::schema()->dropIfExists('mod_manage_license_productOptions');
		DB::schema()->dropIfExists('mod_manage_license_subproduct');
	}catch (Exception $e){
		return array( 'status' => 'UnSuccess', 'description' => 'there is An error: ' . $e->getMessage() );

	}
	# Return Result
	return array( 'status' => 'success', 'description' => 'Addon deactivated successfully.' );
}

function manage_license_output( array $vars ) {

echo (new UI($vars))->output();

}


function manage_license_clientarea( $vars ) {
	$language = strtolower( $_SESSION['Language'] );
	$lang     = dirname( __FILE__ ) . DS . 'lang' . DS . $language . '.php';
//var_dump($lang);die;
	if ( ! file_exists( $lang ) ) {
		$lang = dirname( __FILE__ ) . DS . 'lang' . DS . 'farsi.php';
	}
	include( $lang );
	$template = "template/";
	if ( isset( $_GET["action"] ) ) {
		if ( isset( $_GET["id"] ) ) {
			if ( $_GET['action'] == "active" ) {
//                die(json_encode($vars));
				$res  = DB::table( "tblservers" )->where( 'id', "17" )->first();
				$res1 = DB::table( "mod_manage_license_ap" )->where( "id", $_GET["id"] )->first();
//                die(json_encode($res1->serviceid));
				if ( $res && $res1 ) {
					if ( $res1->ip == "" ) {
						$ip = DB::table( "tblhosting" )->where( "id", $res1->serviceid )->select( "dedicatedip" )->first();
//                        die(json_encode( $ip));
						DB::table( "mod_manage_license_ap" )
						  ->where( "serviceid", $res1->serviceid )
						  ->where( "userid", $res1->userid )->update( [
								'ip' => $ip->dedicatedip
							] );
						$res1 = DB::table( "mod_manage_license_ap" )->where( "id", $_GET["id"] )->first();
//                        die(json_encode(  $res1->ip));
					}
					$vars["params"]["serverpassword"]     = decryptPass( $res->password );
					$vars["params"]["serverusername"]     = (string) $res->username;
					$vars["params"]["serverhostname"]     = (string) $res->hostname;
					$vars["params"]["actions"]            = "getLicenseInfo";
					$vars["params"]["serviceid"]          = $res1->serviceid;
					$vars["params"]["userid"]             = $res1->userid;
					$vars["billing"]                      = $res1->billing;
					$vars["params"]["serviceName"]        = $res1->name;
					$vars["params"]["customfields"]["IP"] = $res1->ip;
					$vars["params"]['configoption1']      = $res1->name;
					$vars["params"]["id"]                 = $res1->id;
//                    die(json_encode($vars["params"]));

				} else {

					logActivity( "error in password please contact with admin" );

					return array(
						'templatefile'      => $template . 'error',
						'templateVariables' => array(
							'errorMessage' => "access denied"
						),
					);
				}
				$url = urlGenerate( $vars["params"] );
//                die(json_encode($vars["params"]));
//                die( $url);
				$vars = setConfigOptions( $vars );
				$ch   = curl_init();
				curl_setopt( $ch, CURLOPT_URL, $url );
				curl_setopt( $ch, CURLOPT_POST, 1 );
				curl_setopt( $ch, CURLOPT_TIMEOUT, 30 );
				curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
				curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $vars ) );
				$response = curl_exec( $ch );
				if ( curl_error( $ch ) ) {
					die( 'Unable to connect: ' . curl_errno( $ch ) . ' - ' . curl_error( $ch ) );
				}

				curl_close( $ch );
				$result = json_decode( $response );
//                die(json_encode($response));
				if ( $result->result == "success" ) {
					$res = DB::table( "mod_manage_license_ap" )->where( "id", $_GET["id"] )
					         ->update( [
						         "ip"         => $result->response->ip,
						         "status"     => "Active",
						         "licensekey" => $result->response->licensekey
					         ] );
				} elseif ( $result->result == "error" ) {
//                    die(json_encode($result->message));
					foreach ( (array) $result->message as $item ) {
						$message = $item;
					}

					//logActivity($message);
					return array(
						'templatefile'      => $template . 'error',
						'templateVariables' => array(
							'errorMessage' => $message
						),
					);
				}
			}
		}
	}

	$res = DB::table( "tblhosting" )->where( "tblhosting.userid", $_SESSION["uid"] )
	         ->select( 'tblhosting.billingcycle', 'tblhosting.domain', 'mod_manage_license_ap.*' )
	         ->join( 'mod_manage_license_ap', 'tblhosting.id', '=', 'mod_manage_license_ap.serviceid' )
//        ->rawgroupBy("mod_manage_license_ap.serviceid")->get();
             ->groupBy( 'mod_manage_license_ap.serviceid' )
	         ->get();

	$output = "";
	if ( $res ) {
		foreach ( $res as $re ) {
//            die(json_encode($re));die;
			$output .= "<div class=\"dataTables_info\" style='margin-top: 25px;'>" . $_LANG["domain"] . "= $re->serviceid</div>";
			$output .= "<table class=\"table table-list dataTable no-footer dtr-inline\">
            <thead>
            <tr role=\"row\">
                <th>Product/Service</th>
                <th class=\"sorting\" rowspan=\"1\" colspan=\"1\">Billing</th>
                <th class=\"sorting\" rowspan=\"1\" colspan=\"1\">licenseKey  </th>
                <th class=\"sorting\" rowspan=\"1\" colspan=\"1\">  ip</th>
                <th class=\"sorting_asc\">Status</th>
            </tr></thead>";
			$res2   = DB::table( "mod_manage_license_ap" )->where( "serviceid", $re->serviceid )->get();

			foreach ( $res2 as $item ) {

				$output .= "  <tbody><tr>
                    <td class=\"sorting_1 text-center\"><strong>$item->name </strong></td>
                    <td class=\"sorting_1 text-center\"><strong>$re->billingcycle </strong></td>
                    <td class=\"sorting_1 text-center\"><strong>$item->licensekey </strong></td>
                    <td class=\"sorting_1 text-center\"><strong>$item->ip </strong></td>
                    <td class=\"text-center\">
                       ";
				if ( is_null( $item->licensekey ) && $item->status != "Active" ) {
					$output .= "<a href=\"?m=manage_license&action=active&id=$item->id\" class=\"btn btn-success \">Active</a>";
				} else {
					$output .= "<span class=' alert-success'> Activated</span>";
				}

				$output .= "</td>
                </tr></tbody>";
			}
			$output .= "</table>";

		}
	} else {

		return array(
			'templatefile'      => $template . 'error',
			'templateVariables' => array(
				"errorMessge" => "no any license"
			),


		);
	}
	$_SESSION["serviceid"] = $res[0]->serviceid;

	return array(
		'templatefile'      => $template . 'home',
		'templateVariables' => array(
			'res'     => $output,
			'session' => $_SESSION
		),
	);

}


function activeLicense( $id ) {
	$query = DB::table( "tblproductconfigoptions" )->where( "id", $id )
	           ->first();
	switch ( $query->optionname ) {
		case 'cPanel':
			$Product = [ "None", "For Dedicate", "For VPS" ];
			$query1  = DB::table( "tblproductconfigoptionssub" )
			             ->where( "configid", $id )->get();

			foreach ( $query1 as $value ) {
				if ( in_array( $value->optionname, $Product ) ) {
					if ( $value->optionname != "None" ) {
						DB::table( "mod_manage_license_products" )
						  ->insert( [
							  "option"    => $query->id,
							  'suboption' => $value->id,
							  'name'      => $query->optionname . '|' . $value->optionname
						  ] );

					}
				} else {
					header( "location:?module=manage_license&action=error&message=$value->optionname license not exist in my license" );

					return;
				}
			}
			header( 'location:?module=manage_license&action=success&message=your license is active' );
			break;
		case 'Plesk':
			$Product = [
				"None",
				"Host VPS",
				"Admin VPS",
				"Pro VPS",
				"Admin Dedicate",
				"Host Dedicate",
				"Pro Dedicate"
			];
			$query1  = DB::table( "tblproductconfigoptionssub" )
			             ->where( "configid", $id )->get();

			foreach ( $query1 as $value ) {
				if ( in_array( $value->optionname, $Product ) ) {
					if ( $value->optionname != "None" ) {
						DB::table( "mod_manage_license_products" )
						  ->insert( [
							  "option"    => $query->id,
							  'suboption' => $value->id,
							  'name'      => $query->optionname . '|' . $value->optionname
						  ] );
					}
				} else {
					header( "location:?module=manage_license&action=error&message=$value->optionname license not exist in my license" );

					return;
				}
			}
			header( 'location:?module=manage_license&action=success&message=your license is active' );

			break;
		case SolusVM:
			$Product = [
				"None",
				"Enterprise",
				"Enterprise Slave Only",
				"SolusVM Slave for test"
			];
			$query1  = DB::table( "tblproductconfigoptionssub" )
			             ->where( "configid", $id )->get();

			foreach ( $query1 as $value ) {
				if ( in_array( $value->optionname, $Product ) ) {
					if ( $value->optionname != "None" ) {
						DB::table( "mod_manage_license_products" )
						  ->insert( [
							  "option"    => $query->id,
							  'suboption' => $value->id,
							  'name'      => $query->optionname . '|' . $value->optionname
						  ] );
					}
				} else {
					header( "location:?module=manage_license&action=error&message=$value->optionname license not exist in my license" );

					return;
				}
			}
			header( 'location:?module=manage_license&action=success&message=your license is active' );

			break;
		case 'CloudLinux':
			$Product = [
				"None",
				"With cPanel",
				"Without cPanel",
				"Imunify360",
				"KernelCare",
				"CloudLinux",
			];
			$query1  = DB::table( "tblproductconfigoptionssub" )
			             ->where( "configid", $id )->get();

			foreach ( $query1 as $value ) {
				if ( in_array( $value->optionname, $Product ) ) {
					if ( $value->optionname != "None" ) {
						DB::table( "mod_manage_license_products" )
						  ->insert( [
							  "option"    => $query->id,
							  'suboption' => $value->id,
							  'name'      => $query->optionname . '|' . $value->optionname
						  ] );
					}
				} else {
					header( "location:?module=manage_license&action=error&message=$value->optionname license not exist in my license" );

					return;
				}
			}
			header( 'location:?module=manage_license&action=success&message=your license is active' );

			break;
		case 'Whmcs':
			$Product = [
				"None",
				"Starter",
				"Plus",
				"Professional",
				"Business",
			];
			$query1  = DB::table( "tblproductconfigoptionssub" )
			             ->where( "configid", $id )->get();

			foreach ( $query1 as $value ) {
				if ( in_array( $value->optionname, $Product ) ) {
					if ( $value->optionname != "None" ) {
						DB::table( "mod_manage_license_products" )
						  ->insert( [
							  "option"    => $query->id,
							  'suboption' => $value->id,
							  'name'      => $query->optionname . '|' . $value->optionname
						  ] );
					}
				} else {
					header( "location:?module=manage_license&action=error&message=$value->optionname license not exist in my license" );

					return;
				}
			}
			header( 'location:?module=manage_license&action=success&message=your license is active' );

			break;
		case 'LiteSpeed':
			$Product = [
				"None",
				"Site Owner Plus",
				"Site Owner",
				"Web Host Lite",
				" Web Host Essential",
				"Web Host Professional",
				"Web Host Enterprise",
				"Web Host Elite",
			];
			$query1  = DB::table( "tblproductconfigoptionssub" )
			             ->where( "configid", $id )->get();
			foreach ( $query1 as $value ) {
				if ( in_array( $value->optionname, $Product ) ) {
					if ( $value->optionname != "None" ) {
						DB::table( "mod_manage_license_products" )
						  ->insert( [
							  "option" => $query->id,

							  'suboption' => $value->id,
							  'name'      => $query->optionname . '|' . $value->optionname
						  ] );
					}
				} else {
					header( "location:?module=manage_license&action=error&message=$value->optionname license not exist in my license" );

					return;
				}
			}
			header( 'location:?module=manage_license&action=success&message=your license is active' );
	}
}

function deactivateLicense( $id ) {
	DB::table( "mod_manage_license_products" )->where( "option", $id )->delete();
	header( "location:?module=manage_license&show=deleteSuccess" );
}

function activeAddon( $id ) {
	$res = Capsule::table( "mod_manage_license_settings" )->where( "key", "=", 'addon' )->get();

	if ( ! $res ) {
		Capsule::insert( "INSERT INTO `mod_manage_license_settings` 
(`id`, `name`,`key`,`value`) VALUES (NULL, 'addon_auto' ,'addon','$id')" );
	} else {
		Capsule::table( 'mod_manage_license_settings' )
		       ->where( 'key', 'addon' )
		       ->update( [
			       'value' => $id
		       ] );
	}
}

//function manage_license_sidebar() {
//
//
//	$code = '
//
//
//        <div class="panel-group" id="accordion">
//            <div class="panel panel-default">
//                <div class="panel-heading">
//                    <h4 class="panel-title">
//                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><span
//                                    class="glyphicon glyphicon-folder-close">
//</span>Main</a>
//                    </h4>
//                </div>
//                <div id="collapseOne" class="panel-collapse collapse in">
//                    <div class="panel-body">
//                        <table class="table table-hover table-striped">
//                            <tr>
//                                <td>
//                                    <span class="glyphicon glyphicon-pencil text-primary"></span><a
//                                            href="addonmodules.php?module=manage_license">Addon Home</a>
//                                </td>
//                            </tr>
//                            <tr>
//                                <td>
//                                    <span class="glyphicon glyphicon-flash text-success"></span><a
//                                            href="addonmodules.php?module=manage_license&action=invoices">Invoices</a>
//                                </td>
//                            </tr>
//                            <tr>
//                                <td>
//                                    <span class="glyphicon glyphicon-flash text-success"></span><a
//                                            href="addonmodules.php?module=manage_license&action=userdetails">User Details</a>
//                                </td>
//                            </tr>
//
//                        </table>
//                    </div>
//                </div>
//            </div>
//            <div class="panel panel-default">
//                <div class="panel-heading">
//                    <h4 class="panel-title">
//                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><span
//                                    class="glyphicon glyphicon-th">
//                            </span>Licenses List</a>
//                    </h4>
//                </div>
//                <div id="collapseTwo" class="panel-collapse collapse">
//                    <div class="panel-body">
//                        <table class="table">
//                            <tr>
//                                <td>
//                                    <a href="addonmodules.php?module=manage_license&action=SolusVM">SolusmVM</a>
//                                </td>
//                            </tr>
//                            <tr>
//                                <td>
//                                    <a href="addonmodules.php?module=manage_license&action=Whmcs">WHMCS</a>
//                                </td>
//                            </tr>
//                            <tr>
//                                <td>
//                                    <a href="addonmodules.php?module=manage_license&action=LiteSpeed">LiteSpeed</a>
//                                </td>
//                            </tr>
//                            <tr>
//                                <td>
//                                    <a href="addonmodules.php?module=manage_license&action=CloudLinux">CloudLinux</a>
//                                </td>
//                            </tr>
//                            <tr>
//                                <td>
//                                    <a href="addonmodules.php?module=manage_license&action=Imunify360">Imunify360</a>
//                                </td>
//                            </tr>
//                            <tr>
//                                <td>
//                                    <a href="addonmodules.php?module=manage_license&action=KernelCare">KernelCare</a>
//                                </td>
//                            </tr>
//                            <tr>
//                                <td>
//                                    <a href="addonmodules.php?module=manage_license&action=cPanel">cPanel</a>
//                                </td>
//                            </tr>
//                        </table>
//                    </div>
//                </div>
//            </div>
//</div>';
//
//	return $code;
//}

//function decryptPass( string $password ) {
//	$res           = DB::table( "tbladmins" )->where( "roleid", "1" )->first();
//	$command       = 'DecryptPassword';
//	$postData      = array(
//		'password2' => $password,
//	);
//	$adminUsername = (string) $res->username; // Optional for WHMCS 7.2 and later
//
//	$results = localAPI( $command, $postData, $adminUsername );
//	if ( $results["result"] != "success" ) {
//		logActivity( "error in ganarete" . $results["message"] );
//
//		return false;
//	}
//
//	return $results["password"];
//}

function urlGenerate( array $params ) {
	$url    = $params['serverhostname'];
	$type   = 'addon';
	$action = $params['actions'];
	if ( $params["serviceid"] == "9187" ) {
		$url = "http://nicsepehrapi.com/api/reseller/licenseha";
	}

	return $url . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR . $action;


}