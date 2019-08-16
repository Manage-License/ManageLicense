<?php




use WHMCS\Database\Capsule as DB;

class actions
{
    public $url;
    public $params = array();
    public $result=true;
    public $output;
    public $response;
    public $errorCode;



    function curl()
    {
        logActivity("url".$this->url);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->params));
        $response = curl_exec($ch);
        if (curl_error($ch)) {
            return ('Unable to connect: ' . curl_errno($ch) . ' - ' . curl_error($ch));
        }
        curl_close($ch);
        return $response;
    }

    function generateUrl(array $params)
    {
        $type = ($params["type"] == "") ? explode("|", $params['name'])[0] : $params["type"];


        $action = $params['action'];
        $url = "https://nicsepehrapi.com/api/reseller/licenseha";
        $this->url = $url . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR . $action;
    }

    function DecryptPassword(string $password)
    {
        $res = DB::table("tbladmins")->where("roleid", "1")->first();
        $command = 'DecryptPassword';
        $postData = array(
            'password2' => $password,
        );
        $adminUsername = (string)$res->username; // Optional for WHMCS 7.2 and later

        $results = localAPI($command, $postData, $adminUsername);
        if ($results["result"] != "success") {
            logActivity("error in ganarete" . $results["message"]);
            return false;
        }
        return $results["password"];
    }

    function gatData($vars)
    {
        $res = DB::table("tblservers")->where('id', "17")->first();
        if ($res) {
            if ($vars["params"]["serverpassword"] = DecryptPassword($res->password)) {
                $vars["params"]["serverusername"] = (string)$res->username;
                $vars["params"]["serverhostname"] = (string)$res->hostname;
//            var_dump($vars["params"]["serverusername"]);die;
                $res1 = DB::table("tblhosting")
                    ->where("id", $vars["params"]["serviceid"])->first();
                $vars['billing'] = $res1->billingcycle;
                $vars["params"]["customfields"]["IP"] = $res1->dedicatedip;
            } else
                logActivity("error in password please contact with admin");
        }
        $q = DB::table("mod_manage_license_ap")
            ->where("serviceid", $vars["params"]["serviceid"])->get();
//    die(json_encode($q));
        foreach ($q as $item) {
            $vars["params"]["configoption1"] = (string)$item->name;
            $url = generateUrl($vars["params"]);
            $vars = setConfigOptions($vars);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($vars));
            $response = curl_exec($ch);
//       die($response);
            if (curl_error($ch)) {
                die('Unable to connect: ' . curl_errno($ch) . ' - ' . curl_error($ch));
            }
            curl_close($ch);
        }
    }

    function setConfigOptions($vars)
    {
        if (isset($vars["params"]["configoptions"]["LiteSpeed"])) {
//        $vars["params"]["configoptions"]["Caching"] = 'LSCache Standard';
//        array_merge($vars["params"]["configoptions"]["Caching"], $a);
            array_merge($vars["params"]["configoptions"], $vars["params"]["configoptions"]["Caching"]);
            $vars["params"]["configoptions"]["Caching"] = (string)"LSCache Standard";
//    var_dump($vars["params"]["configoptions"]["Caching"]);die;
        }
        if (isset($vars["params"]["configoptions"]["SolusVM"])) {

            array_merge($vars["params"]["configoptions"], $vars["params"]["configoptions"]["Slaves"]);
            array_merge($vars["params"]["configoptions"], $vars["params"]["configoptions"]["Mini Slaves"]);
            array_merge($vars["params"]["configoptions"], $vars["params"]["configoptions"]["Micro Slaves"]);
            $vars["params"]["configoptions"]["Slaves"] = 0;
            $vars["params"]["configoptions"]["Mini Slaves"] = 0;
            $vars["params"]["configoptions"]["Micro Slaves"] = 0;

        }
        return $vars;

    }


    function checkRequest($vars)
    {
//    die(json_encode($vars["params"]["model"]["dedicatedip"]));
        $configOptions = $vars["params"]["configoptions"];
        foreach ($configOptions as $key => $value) {
            if ($value != "None") {
                $res = DB::table("mod_manage_license_ap")
                    ->where("serviceid", $vars["params"]["accountid"])
                    ->where("userid", $vars["params"]["userid"])
                    ->where("name", 'like', "$key%")
                    ->first();
                $options = DB::table("tblproductconfigoptions")
                    ->where("optionname", $key)->first();
                $suboptions = DB::table("tblproductconfigoptionssub")
                    ->where("optionname", $value)->first();
                if (!$res) {
                    try {
                        DB::table("mod_manage_license_ap")->insert([
                            'serviceid' => $vars["params"]["accountid"],
                            'userid' => $vars["params"]["userid"],
                            'options' => $options->id,
                            'suboptions' => $suboptions->id,
                            'status' => 'pending',
                            'name' => $key . '|' . $value,
                            'billing' => $vars["params"]["model"]["billingcycle"],
                        ]);
                    } catch (Exception $exception) {
                        logActivity("error in " . $exception->getMessage());
                    }
                } else {
                    if ($res->name != ($key . '|' . $value)) {
                        DB::table("mod_manage_license_ap")
                            ->where("serviceid", $vars["params"]["accountid"])
                            ->where("userid", $vars["params"]["userid"])
                            ->where("name", 'like', "$key%")->update([
                                'name' => $key . '|' . $value
                            ]);
                    }
                    if ($res->billing != $vars["params"]["model"]["billingcycle"]) {
                        DB::table("mod_manage_license_ap")
                            ->where("serviceid", $vars["params"]["accountid"])
                            ->where("userid", $vars["params"]["userid"])
                            ->where("name", 'like', "$key%")->update([
                                'billing' => $vars["params"]["model"]["billingcycle"]
                            ]);
                    }
                    if ($res->suboptions != $suboptions->suboptions) {
                        DB::table("mod_manage_license_ap")
                            ->where("serviceid", $vars["params"]["accountid"])
                            ->where("userid", $vars["params"]["userid"])
                            ->where("name", 'like', "$key%")->update([
                                'suboptions' => $suboptions->id
                            ]);
                    }


                    if ($res->ip == "" || $vars["params"]["model"]["dedicatedip"] != $res->ip) {
//                    $ip = DB::table("tblhosting")->where("id", $res->serviceid)->select("dedicatedip")->first();
                        DB::table("mod_manage_license_ap")
                            ->where("serviceid", $vars["params"]["accountid"])
                            ->where("userid", $vars["params"]["userid"])->update([
                                'ip' => $vars["params"]["model"]["dedicatedip"]
                            ]);
                    }

                }
            }
        }
    }

    function validateVars($variable)
    {
//        $variable=mysql_escape_string($variable);
//        $variable=mysql_real_escape_string($variable);
        $variable = htmlentities($variable);
        $variable = htmlspecialchars($variable);
        return $variable;
    }

    function decryptPass(string $password)
    {
        $res = DB::table("tbladmins")->where("roleid", "1")->first();
        $command = 'DecryptPassword';
        $postData = array(
            'password2' => $password,
        );
        $adminUsername = (string)$res->username; // Optional for WHMCS 7.2 and later

        $results = localAPI($command, $postData, $adminUsername);
        if ($results["result"] != "success") {
            logActivity("error in ganarete" . $results["message"]);
            return false;
        }
        return $results["password"];
    }

    public function addErrorCode(array $errCode)
    {
        foreach ($errCode as $key => $value) {
            $this->errorCode[$key] = $value;
        }
        $this->result = false;
    }
    public function updateRecord()
    {
        if ($this->result == true) {
            $response = array(
                "result" => "success",
                "message" => $this->output,
            );
        } else {
            $response = array(
                "result" => "error",
                "message" => $this->errorCode,
            );
        }
        return json_encode($response);
    }
}
