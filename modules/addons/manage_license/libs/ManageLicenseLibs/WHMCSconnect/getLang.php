<?php
/*
 * This code is generated in NicSepehr Company.
 * The Public Api for nicsepehr system. * 
 * @author Rouhollah Talebian  <HostBaran@gmail.com>
 * @date 8/11/2019
 * @Description    getLang.php
 *
 */

/*
 * This code is generated in NicSepehr Company.
 * The Public Api for nicsepehr system. *
 * @author Rouhollah Talebian <HostBaran@gmail.com>
 * @date 8/10/2019
 * @Description    getLang.php
 *
 */

namespace ML_Addon\WHMCSconnect;

class  getLang {
	const ROOTDIR = ROOTDIR;
	/*
	 * @var dir
	 */
	static protected $dir;
	/*
	 * @var clientLang
	 */
	static protected $clientLang;

	/*
	 * @params None
	 */

	public static function getSessionLan() {
		return strtolower( $_SESSION['Language'] );

	}

	public static function loadLang() {
		self::$dir = ROOTDIR . DS . 'modules' . DS . 'addons' . DS . 'manage_license';
		$language  = self::$dir . DS . 'lang' . DS . self::getSessionLan() . '.php';

		if ( ! file_exists( $language ) ) {
			$language = self::$dir . DS . 'lang' . DS . 'english.php';
		}

		include_once( $language );

		return $_LANG;
	}


}

