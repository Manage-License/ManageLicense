<?php

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

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

use WHMCS\Database\Capsule as DB;

class manageLicense
{

    public $error = false;
    public $errorMessage = '';
    public $message;
    private $makeUrl;
    public $response = [];

    function __construct(array $params, array $newData = [])
    {
        $this->generateUrl($params);
        $this->guzzlelPost($params);
    }

    public function generateUrl(array $params)
    {
        $url = $params['serverhostname'];
        $type = explode("|", $params['configoption1'])[0];
        $action = $params['action'];
        $this->makeUrl = $url . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR . $action;
     }
    protected function guzzlelPost(array $params)
    {
        try {
            $billingcycle = DB::table('tblhosting')
                ->select('billingcycle')
                ->where('id', $params['serviceid'])
                ->first();
            $client = new GuzzleHttp\Client();
            $response = $client->post($this->makeUrl, [

//                'debug' => TRUE,
                'body' => [
                    'params' => $params,
                    'billing' => $billingcycle->billingcycle
                ],
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ]
            ]);

            if ($response->getStatusCode() == '200' && $response->getReasonPhrase() == 'OK') {
                $data = $response->json();
                if ($data['result'] == "success") {
                    $this->response = $data['response'];
                } else {
                    $this->error = true;
                    foreach ($data['message'] as $val) {
                        $this->errorMessage .= $val . '-';
                    }
                    $this->errorMessage = substr($this->errorMessage, 0, -1);
                }
            } else {
                $this->error = true;
                $this->errorMessage = "result is not valid.";
            }
        } catch (Exception $e) {
             $this->error = true;
            $this->errorMessage = "Error: " . is_null($e->getResponse()) ? "Return is null (Please contact with administrator) " : $e->getResponse();
            return $this->errorMessage;
        }
    }
}
