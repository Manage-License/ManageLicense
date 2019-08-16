<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SSL
 *
 * @author P.Majma <pegahmajma@gmail.com>
 */
// Convert to array
$currencies = json_decode(file_get_contents("resources/country/dist.countries.json"), true);
$response = array(
    'licenseInfo' => $api->response,
    'LANG' => $_LANG,
    'post' => $_POST,
	'clientcountries' =>$currencies
);
