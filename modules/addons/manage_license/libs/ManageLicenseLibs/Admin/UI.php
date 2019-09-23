<?php


namespace ML_Addon\Admin;

use ZipArchive;
use  ML_Addon\Admin\ClientInfo;
use WHMCS\Database\Capsule;
use WHMCS\Smarty;
use ML_Addon\connectAPI\guzzleMethod;
use ML_Addon\WHMCSconnect\getLang;


class UI {
	public $vars = [];
	public $info = [];
	public $error = false;
	public $massage = "error";
	public $params = [];
	public $api;
	public $response;
	public $smarty;
	public $Lang;
	public $tempName ;
	const tempUrl = ROOTDIR . DS . "modules" . DS . "addons" . DS . "manage_license" . DS . "resource" . DS . "template" . DS;


	public function __construct( array $array ) {
		$this->vars = $array;
		$this->smarty();
		$this->lang();
		if ( ! isset( $_GET['update'] ) ) {
			$this->renderServer();
		}


	}

	public function output() {

 		$this->smarty->assign( 'back', $this->Lang['back'] );
	  		echo '<div class="alert alert-info text-center">این ماژول در حال بروزرسانی است و در صورت بروزرسانی، در همین جا می توانید مشاهده و بروز رسانی کنید </div>';
		if ( version_compare( $this->vars['version'], $remoteVersion = $this->Github( false ), "<" ) ) {
			if ( isset( $_GET['update'] ) ) {
				if ( $_GET['update'] == 1 ) {
					$this->update();
					header( "Location: addonmodules.php?module=manage_license&update=success" );
				} else {
					$this->smarty->assign( 'class', 'success' );
 					$this->smarty->assign( 'Massage', $this->Lang['UpdateSuccess'] );
					$this->smarty->display( self::tempUrl . "Massage.tpl" );

					return;

				}
			} else {
				$this->smarty->assign( 'class', 'info' );
				$this->smarty->assign( 'update', [ture,$this->vars['version'],$remoteVersion] );
				$this->smarty->assign( 'Massage', $this->Lang['UpdateExist'] );
				$this->smarty->assign( 'here', $this->Lang['here'] );
				$this->smarty->display( self::tempUrl . "Massage.tpl" );

			}
		}
		if ( $this->error ) {
			$this->smarty->assign( 'class', 'danger' );
			$this->smarty->assign( 'Massage', $this->massage );
			$this->smarty->display( self::tempUrl . "Massage.tpl" );
 		} else {

			$action = isset( $_REQUEST['Action'] ) ?  $_REQUEST['Action']  : "ClientInfo";
 			$outPut = 'ML_Addon\Admin\\' . $action;

			echo ( new  $outPut() )->outPut();

		}
	}

	private function Github( bool $update ) {
		if ( $update ) {
			$url = 'https://codeload.github.com/Manage-License/ManageLicense/zip/master';
		} else {
			$url = "https://raw.githubusercontent.com/Manage-License/ManageLicense/master/modules/addons/manage_license/libs/version?" . time();
		}
		$curl = curl_init();
		curl_setopt_array( $curl, array(
			CURLOPT_HEADER         => 0,
			CURLOPT_AUTOREFERER    => 1,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL            => $url,
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => 0,
			CURLOPT_FOLLOWLOCATION => 1,
		) );
		$response = curl_exec( $curl );
		if ( curl_errno( $curl ) ) {
			return 'Failed to download archive: ' . curl_error( $ch );
		}
		curl_close( $curl );

		return $response;

	}

	private function update() {
		$file_data = $this->Github( true );
		$file_path = __DIR__ . '/master.zip';
		file_put_contents( $file_path, $file_data );

		$zip = new ZipArchive();
		$res = $zip->open( $file_path );
//
		if ( $res !== true ) {
			return "Unable to open $file_path, error code: $res";
		}
//
		$extractSubdirTo = function ( $destination, $subdir ) use ( $zip ) {
			$errors = array();
//
			// Prepare dirs
			$destination = str_replace( array( "/", "\\" ), DIRECTORY_SEPARATOR, $destination );
			//
			if ( substr( $destination, mb_strlen( DIRECTORY_SEPARATOR, "UTF-8" ) * - 1 ) != DIRECTORY_SEPARATOR ) {
				$destination .= DIRECTORY_SEPARATOR;
			}
			if ( substr( $subdir, - 1 ) != "/" ) {
				$subdir .= "/";
			}
			// Extract files
			for ( $i = 0; $i < $zip->numFiles; $i ++ ) {
				$filename = $zip->getNameIndex( $i );
				if ( substr( $filename, 0, mb_strlen( $subdir, "UTF-8" ) ) == $subdir ) {
					$relativePath = substr( $filename, mb_strlen( $subdir, "UTF-8" ) );
					$relativePath = str_replace( array( "/", "\\" ), DIRECTORY_SEPARATOR, $relativePath );
					if ( mb_strlen( $relativePath, "UTF-8" ) > 0 ) {
						if ( substr( $filename, - 1 ) == "/" )  // Directory
						{
							// New dir
							if ( ! is_dir( $destination . $relativePath ) ) {
								if ( ! @mkdir( $destination . $relativePath, 0755, true ) ) {
									$errors[ $i ] = $filename;
								}
							}
						} else {
							if ( dirname( $relativePath ) != "." ) {
								if ( ! is_dir( $destination . dirname( $relativePath ) ) ) {
									// New dir (for file)
									@mkdir( $destination . dirname( $relativePath ), 0755, true );
								}
							}
//
							// New file
							if ( @file_put_contents( $destination . $relativePath, $zip->getFromIndex( $i ) ) === false ) {
								$errors[ $i ] = $filename;
							}
						}
					}
				}
			}

			return $errors;
		};
		$result          = $extractSubdirTo( ROOTDIR, 'ManageLicense-master' );
		if ( sizeof( $result ) ) {
			$zip->close();

			return implode( ",", $result );
		}
		$zip->close();
	}

	public function renderServer() {

		$server = Capsule::table( 'tblservers' )->where( 'type', 'Manage_License' )->first();

		if ( ( ! isset( $_REQUEST['SId'] ) || ! is_numeric( $_REQUEST['SId'] ) ) && $server ) {
			up:
			header( "Location: addonmodules.php?module=manage_license&SId={$server->id}" );
			exit;

		} elseif ( isset( $_REQUEST['SId'] ) && is_numeric( $_REQUEST['SId'] ) && $server ) {
			$check = Capsule::table( 'tblservers' )->where( 'id', $_REQUEST['SId'] )->where( 'type', 'Manage_License' )->first();
			if ( ! $check ) {
				goto up;
			} else {
				if ( $check->hostname == "" || $check->username == "" || $check->password == "" ) {
					$this->error   = true;
					$this->massage = "incorrect  Hostname,Username  or Password in server Setting 
										<a class='btn btn-info' href='configservers.php?action=manage&id=$check->id' target='_blank'>Click Here</a> and check";

				} else {
					$this->info['serverhostname'] = $check->hostname;
					$this->info['serverusername'] = $check->username;
					$this->info['serverpassword'] = $this->decryptPass( $check->password );

				}
			}

		} else {
			$this->error   = true;
			$this->massage = "You must be complete setting, Please add server and go back hear  
										<a class='btn btn-info' href='configservers.php' target='_blank'>Click Here</a> ";

		}
	}

	public function decryptPass( string $password ) {
		$command  = 'DecryptPassword';
		$postData = array(
			'password2' => $password,
		);

		$results = localAPI( $command, $postData );
		if ( $results["result"] != "success" ) {
			logActivity( "error in ganarete" . $results["message"] );

			return false;
		}

		return $results["password"];
	}

	public function ServerConnect() {
		$this->api = new guzzleMethod( $this->params );

		if ( $this->api->error ) {
			$this->error   = true;
			$this->massage = $this->api->errorMessage;

			return;
		}
		$this->response = $this->api->response;


	}

	public function renderTemplte( ) {//string $temp , array $response
		$this->smarty->assign( 'response', $this->response );
 		$this->smarty->display(self::tempUrl.$this->tempName);
  	}

	public function smarty(){
		$this->smarty = new Smarty();
		$this->smarty->assign( 'lang',$this->Lang);
	}
	public function lang(){
		$this->Lang    = (new getLang())->loadLang();

	}
}