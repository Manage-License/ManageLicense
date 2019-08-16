<?php


namespace ML_Addon\Admin;

use ZipArchive;

class UI {
	public $vars = [];
	public $error = false;
	public $massage = "error";


	public function __construct( array $array ) {
		$this->vars = $array;


	}


	public function output() {
		if ( version_compare( $this->vars['version'], $remoteVersion = $this->Github( false ) ) ) {
			if ( isset( $_GET['update'] ) ) {
				if ( $_GET['update'] == 1 ) {
					$this->update();
					header( "Location: addonmodules.php?module=manage_license&update=success" );
				} else {
					echo '<div class="alert alert-success text-center">Thanks,Your System Updated Successfully</div>';
				}
			} else {
				$output = '<div class="alert alert-info text-center">';
				$output .= "New update is available (Current version:" . $this->vars['version'] . ", Latest version: $remoteVersion)&nbsp;";
				$output .= 'click <a href="addonmodules.php?module=manage_license&update=1"><strong>here</strong></a> to update.';
				$output .= '</div>';
				echo $output;
			}
		}
		if ( $this->error ) {
			echo $this->massage;
		} else {
			echo $this->vars['version'];
			var_dump( $this->Github( false ) );
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
//
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
//       $subdir = str_replace(array("/", "\\"), "/", $subdir);
//
			if ( substr( $destination, mb_strlen( DIRECTORY_SEPARATOR, "UTF-8" ) * - 1 ) != DIRECTORY_SEPARATOR ) {
				$destination .= DIRECTORY_SEPARATOR;
			}
//
			if ( substr( $subdir, - 1 ) != "/" ) {
				$subdir .= "/";
			}
//
			// Extract files
			for ( $i = 0; $i < $zip->numFiles; $i ++ ) {
				$filename = $zip->getNameIndex( $i );
//
				if ( substr( $filename, 0, mb_strlen( $subdir, "UTF-8" ) ) == $subdir ) {
					$relativePath = substr( $filename, mb_strlen( $subdir, "UTF-8" ) );
					$relativePath = str_replace( array( "/", "\\" ), DIRECTORY_SEPARATOR, $relativePath );
//
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
}