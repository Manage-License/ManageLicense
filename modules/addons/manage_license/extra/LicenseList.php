<?php

use Illuminate\Database\Capsule\Manager as DB;

function userDetails()
{
    $res = DB::table("tblservers")->where('id', "17")->first();
    $params["params"]["serverpassword"] = decryptPass($res->password);
    $params["params"]["serverusername"] = (string)$res->username;
    $params["params"]["serverhostname"] = (string)$res->hostname;
    $url = $params['params']['serverusername']."/userActions/getUserDetails";
    $params['params']['addon'] = 1;

    $params['configoptions']['Caching'] = 1;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $data = json_decode(curl_exec($ch));
    curl_close($ch);
    var_dump($data);die;

    if ($data->response->stats->productsnumother < 10)
        $role = "stater";
    else if ($data->response->stats->productsnumother < 20)
        $role = "pro";
    else if ($data->response->stats->productsnumother < 50)
        $role = "enterprise";
    else
        $role = "unlimit";

//var_dump($data->response->stats);die;
    $smarty = new Smarty();
    $smarty->assign("user", $data->response);
    $smarty->assign('role', $role);
    $smarty->display(dirname(__FILE__) . "/template/userdetails.tpl");
}

function Invoice_List()
{
    $res = DB::table("tblservers")->where('id', "17")->first();
    $params["params"]["serverpassword"] = decryptPass($res->password);
    $params["params"]["serverusername"] = (string)$res->username;
    $params["params"]["serverhostname"] = (string)$res->hostname;
    $url = $params['params']['serverusername']."/userActions/listUserInvoices";
    $params['params']['addon'] = 1;

    //    $params['params'][key($uniqueKey)] = $uniqueKey[key($uniqueKey)];
    $params['configoptions']['Caching'] = 1;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $data = json_decode(curl_exec($ch));
//    var_dump( $data->response->invoices->invoice);die;
    curl_close($ch);
    $sumInvoices = 0;

    foreach ($data->response->invoices->invoice as $invoice) {
        $sumInvoices += $invoice->subtotal;
    }
    $smarty = new Smarty();
    $smarty->assign('Invoices', $data->response->invoices->invoice);
    $smarty->assign('total', $sumInvoices);

    $smarty->display(dirname(__FILE__) . "/template/invoices.tpl");

}

function License_List($type)
{
    $licenseTypes = array(
        'WS_L_SM' => 'Site Owner',
        'WS_L_S' => 'Site Owner Plus',
        'WS_L_1M' => 'Web Host Lite',
        'WS_L_1' => 'Web Host Essential',
        'WS_L_2' => 'Web Host Professional ',
        'WS_L_4' => 'Web Host Enterprise',
        'WS_L_X' => 'Web Host Elite',
        'WS_L_U' => 'Old Ultra VPS',
        'WS_L_V' => 'Old VPS',
        'WS_L_1' => 'Old 1-CPU',
        'WS_L_2' => 'Old 2-CPU',
        'WS_L_4' => 'Old 4-CPU',
        'WS_L_8' => 'Old 8-CPU',
    );
    $response = listLicenses_Action($type);

    $smarty = new Smarty();
    $smarty->assign('Licenses', $response->response);
    if ($type == "LiteSpeed")
        $smarty->assign('types', $licenseTypes);


    $smarty->display(dirname(__FILE__) . "/template/{$type}.tpl");
}

function listLicenses_Action($type)
{
    $res = DB::table("tblservers")->where('id', "17")->first();
    $params["params"]["serverpassword"] = decryptPass($res->password);
    $params["params"]["serverusername"] = (string)$res->username;
    $params["params"]["serverhostname"] = (string)$res->hostname;
    $url = $params['params']['serverusername']."/userActions/listUserLicenses";
    $params['params']['addon'] = 1;
    $params['params']['type'] = $type;
    //    $params['params'][key($uniqueKey)] = $uniqueKey[key($uniqueKey)];
    $params['configoptions']['Caching'] = 1;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $data = json_decode(curl_exec($ch));
//    $data = curl_exec($ch);
//    var_dump($data);die;
    curl_close($ch);

    return $data;

    // var_dump($vars);

}