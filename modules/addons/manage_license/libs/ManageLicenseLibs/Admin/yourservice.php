<?php


namespace ML_Addon\Admin;

use WHMCS\User\AdminLog;
use WHMCS\User\Admin;

class yourservice extends UI {
	const tempName = "yourservice.tpl";
	private $serverConnect;


	public function __construct() {
		$this->lang();
		$this->smarty();
		$this->renderServer();
		$this->tempName = self::tempName;
		$this->params = $this->info;
		$this->params['serviceid'] =   1;
		$this->params['action'] =   'listUserLicenses';
		$this->ServerConnect();
	}

	public function outPut() {

		if ( $this->error ) {
			return '<div class="alert alert-danger text-center">' . $this->massage . '</div>';
		} else {
			echo  $this->renderTemplte();

		}
	}
}