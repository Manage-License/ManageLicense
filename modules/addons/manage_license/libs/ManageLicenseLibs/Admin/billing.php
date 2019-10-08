<?php


namespace ML_Addon\Admin;

use WHMCS\User\AdminLog;
use WHMCS\User\Admin;

class billing extends UI {
	const tempName = "billing.tpl";




	public function __construct() {
		$this->lang();
		$this->smarty();
		$this->renderServer();
		$this->tempName = self::tempName;
		$this->params = $this->info;
		$this->params['sub'] =   $_GET['Sub'] ;
		$this->params['action'] =   'listUserInvoices';
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