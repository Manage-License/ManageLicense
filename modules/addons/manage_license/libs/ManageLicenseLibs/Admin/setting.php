<?php


namespace ML_Addon\Admin;

use http\Env\Response;
use WHMCS\User\AdminLog;
use WHMCS\User\Admin;
use WHMCS\Product;
use WHMCS\Database\Capsule as DB;
use ML_Addon\WHMCSconnect\getProducts;

class setting extends UI {
	const tempName = "setting.tpl";
	private $serverConnect = true;



	public function __construct() {
  		$this->lang();
		$this->smarty();
		$this->renderServer();
		$this->tempName = self::tempName;
		$this->params = $this->info;
		$this->params['action'] =   'setting';
		$this->Callfunction();
		if($this->serverConnect)
		$this->ServerConnect();
	}

	public function outPut() {

		if ( $this->error ) {
			return '<div class="alert alert-danger text-center">' . $this->massage . '</div>';
		} else {
			echo  $this->renderTemplte();

		}
	}

	private function Callfunction(){
		if(!isset($_REQUEST['Sub'])){
			$this->serverConnect = false;
			$this->Products();


		}elseif($_REQUEST['Sub'] == 'Products'){
			$this->Products();
		}elseif($_REQUEST['Sub'] == 'Option'){
			$this->Option();
		}elseif($_REQUEST['Sub'] == 'Reseller'){
			$this->Reseller();
		}
 }

private function Products(){

	if(!isset($_REQUEST['subAction']) || $_REQUEST['subAction'] !="Add" ){
		$this->serverConnect = false;
		$this->response  = new getProducts();

	}else{

	}
}
private function Option(){

}
private function Reseller(){

}
}