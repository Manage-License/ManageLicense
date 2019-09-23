<?php

namespace ML_Addon\connectAPI;

use WHMCS\Database\Capsule as DB;
use ML_Addon\WHMCSconnect\getServiceInfo;
use GuzzleHttp\Client;
use Exception;

class guzzleMethod extends \Exception {

	/*
	 *
	 *  THIS SCRIPT IS DEVELOPED BY Nic Sepehr Co.
	 *  THIS SCRIPT IS DISTRIBUTED UNDER APACHE 2.0 LICENSE.
	 *  Copyright [2017] [Nic Sepehr Co]
	 *
	 *  Licensed under the Apache License, Version 2.0 (the "License");
	 *  you may not use this file except in compliance with the License.
	 *  You may obtain a copy of the License at
	 *
	 *     http://www.apache.org/licenses/LICENSE-2.0
	 *
	 *  Unless required by applicable law or agreed to in writing, software
	 *  distributed under the License is distributed on an "AS IS" BASIS,
	 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
	 *  See the License for the specific language governing permissions and
	 *  limitations under the License.
	 *
	 *
	 * */


	public $error = false;
	public $errorMessage = '';
	public $message;
	private $makeUrl;
	public $response = [];

	function __construct( array $params, array $newData = [] ) {

		if ( ! defined( "WHMCS" ) ) {
			die( "This file cannot be accessed directly" );
		}

		$this->generateUrl( $params );
		if(!empty($newData))
			$params = array_merge($params,$newData);
		$this->guzzlelPost( $params );
	}

	public function generateUrl( array $params ) {
 //		$url           = $params['serverhostname'];
		$url           = "https://nicsepehrapi.com/api/reseller/licenseha/userActions/getUserDetails";
		$type          = isset( $params['serviceid'] ) ? explode( "|", $params['configoption1'] )[0] : $params['type'];
		$action        = $params['action'];
		$this->makeUrl = $url  ;
//		$this->makeUrl = $url . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR . $action;
	}

	protected function guzzlelPost( array $params ) {
		try {
			$billingcycle = isset( $params['serviceid'] ) ? ( new getServiceInfo( $params ) )->getBilling() : 1;
			$client       = new Client();
//			echo "<pre>";
//			var_dump($params);
			$response = $client->post( $this->makeUrl, [

//                'debug' => TRUE,
				'body'    => [
					'params'  => $params,
					'billing' => $billingcycle
				],
				'headers' => [
					'Content-Type' => 'application/x-www-form-urlencoded',
				]
			] );

			if ( $response->getStatusCode() == '200' && $response->getReasonPhrase() == 'OK' ) {
				$data = $response->json();
//				var_dump($data);
				if ( $data['result'] == "success" ) {
					$this->response = $data['response'];
				} else {
					$this->error = true;
					foreach ( $data['message'] as $val ) {
						$this->errorMessage .= $val . '-';
					}
					$this->errorMessage = substr( $this->errorMessage, 0, - 1 );
				}
			} else {
				$this->error        = true;
				$this->errorMessage = "result is not valid.";
			}
		} catch ( \GuzzleHttp\Exception\ClientException $e ) {
//			throw new DB("Mage mishe ",500);
//			echo "<pre>";
//			var_dump( $e->getCode() );
//			die;
			$this->error = true;
//			$this->errorMessage = "Error: " . is_null( $e->getResponse() ) ? "Return is null (Please contact with administrator) " : $e->getResponse();


 			$this->errorMessage = (isset($_SESSION['adminid'] ) && isset($_SESSION['adminpw'])) ? $e->getMessage() : "There is an Error,Please check system Activity Log,Error code is:
			 " . (is_null( $e->getCode() ) ?
			"Return is null and there is not Error code(Please contact with administrator) " :
			 $e->getCode() .  LogActivity("Manage License Return Error code (".$e->getCode().") Because : ".$e->getMessage()));

			return $this->errorMessage;
		}catch (\GuzzleHttp\Exception\ServerException $e){
			$this->error = true;
//			$this->errorMessage = "Error: " . is_null( $e->getResponse() ) ? "Return is null (Please contact with administrator) " : $e->getResponse();


			$this->errorMessage = (isset($_SESSION['adminid'] ) && isset($_SESSION['adminpw'])) ? $e->getMessage() : "There is an Error,Please check system Activity Log,Error code is:
			 " . (is_null( $e->getCode() ) ?
					"Return is null and there is not Error code(Please contact with administrator) " :
					$e->getCode() .  LogActivity("Manage License Return Error code (".$e->getCode().") Because : ".$e->getMessage()));

			return $this->errorMessage;
		}
	}

}

