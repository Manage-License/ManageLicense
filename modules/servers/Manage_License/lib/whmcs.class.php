<?php
require_once "Client.php";

/*
 * Define autoloader.
 * @param string $className
 * */
function __autoload($className)
{
    include 'class'. $className . 'inc';
}


class WHMCS
{
    public $url;
    public $username;
    public $password;
    public $accesskey;
    private $localApi;
    private $results;
    public $message;
    public $errorMessage;
    public $error = false;


    public  function __construct($url = 'http://whmcs.com/include/api.php',
                                $username = 'username', $password = 'password', $accesskey = '',
                                $localApi = false)
    {
        $this->url = $url;
        $this->username = $username;
        $this->password = $password;
        $this->accesskey = $accesskey;
        $this->localApi = $localApi;
    }


    public function authenticate($username, $password)
    {
        $response = $this->api("validatelogin",
            array("email" => $username, "password2" => $password));
        if ($response->userid) {
            $this->message;
        }
        $this->error = true;
        $this->errorMessage;
    }


    public function getDomains($uid = 0, $domainId = 0, $domain = '', $start = 0, $limit = 0)
    {
        if ($limit <= 0) {
            $limit = 9999;
        }

        $params['limitnum'] = $limit;
        $params['limitstart'] = $start;

        if ($uid > 0) {
            $params['clientid'] = $uid;
        }

        if ($domainId > 0) {
            $params['domainid'] = $domainId;
        }

        if ($domain) {
            $params['domain'] = $domain;
        }

        $response = $this->api("getclientsdomains", $params);

        if ($response->result == 'error') {
            throw new WhmcsException("WHMCS complained: " . $response->message);
        }

        return $response;
    }

    public function getDomainNameservers($domainId)
    {
        $params['domainid'] = $domainId;
        $response = $this->api("domaingetnameservers", $params);

        if ($response->result == 'error') {
            throw new WhmcsException("WHMCS complained: " . $response->message);
        }
        return $response;
    }


    public function getDomainLock($domainId)
    {
        $params['domainid'] = $domainId;
        $response = $this->api("domaingetlockingstatus", $params);

        if ($response->result == 'error') {
            throw new WhmcsException("WHMCS complained: " . $response->message);
        }

        return $response;
    }


    public function getDomainWHOIS($domainId)
    {
        $params['domainid'] = $domainId;
        $response = $this->api("domaingetwhoisinfo", $params);

        if ($response->result == 'error') {
            throw new WhmcsException("WHMCS complained: " . $response->message);
        }

        return $response;
    }


    public function getProducts($pid = 0, $gid = 0, $module = null)
    {
        if ($pid > 0) {
            $params['pid'] = $pid;
        }

        if ($gid > 0) {
            $params['gid'] = $gid;
        }

        if ($module != null) {
            $params['module'] = $module;
        }

        $response = $this->api("getproducts", $params);

        if ($response->result == 'error') {
            throw new WhmcsException("WHMCS complained: " . $response->message);
        }

        return $response;
    }


    public function getServices($uid = 0, $serviceId = 0, $domain = '',
                                $productId = 0, $serviceUsername = '', $limitstart = 0, $limit = 0)
    {
        if ($limit <= 0) {
            $limit = 9999;
        }

        $params['limitnum'] = $limit;
        $params['limitstart'] = $limitstart;

        if ($uid > 0) {
            $params['clientid'] = $uid;
        }

        if ($serviceId > 0) {
            $params['serviceid'] = $serviceId;
        }

        if ($domain) {
            $params['domain'] = $domain;
        }

        if ($productId) {
            $params['pid'] = $productId;
        }

        if ($serviceUsername) {
            $params['username2'] = $serviceUsername;
        }
        $response = $this->api("getclientsproducts", $params);

        if ($response->result == 'error') {
            throw new WhmcsException("WHMCS complained: " . $response->message);
        }

        return $response;
    }


    public function getTransactions($uid = 0, $invoiceId = 0, $transactionId = 0)
    {
        if ($uid > 0) {
            $params['clientid'] = $uid;
        }

        if ($invoiceId > 0) {
            $params['invoiceid'] = $invoiceId;
        }

        if ($transactionId > 0) {
            $params['transid'] = $transactionId;
        }

        $response = $this->api("gettransactions", $params);

        if ($response->result == 'error') {
            throw new WhmcsException("WHMCS complained: " . $response->message);
        }

        return $response;
    }


    public function getEmails($uid, $filter = '', $filterdate = '', $start = 0, $limit = 0)
    {
        $params['clientid'] = $uid;

        if ($filter) {
            $params['subject'] = $filter;
        }

        if ($filterdate) {
            $params['date'] = $filterdate;
        }

        if (!$limit <= 0) {
            $limit = 9999;
        }

        $params['limitnum'] = $limit;
        $params['limitstart'] = $start;

        $response = $this->api("getemails", $params);

        if ($response->result == 'error') {
            throw new WhmcsException("WHMCS complained: " . $response->message);
        }

        return $response;
    }


    public function addCredit($data)
    {
        $attributes = array("clientid", "description", "amount");

        foreach ($attributes as $k) {
            $credit[$k] = $data[$k];
        }

        if (!$credit['clientid'] || !$credit['description'] || !$credit['amount']) {
            throw new WhmcsException("Required fields missing.");
        }

        $response = $this->api("addcredit", $credit);

        if ($response->result == 'error') {
            throw new WhmcsException("WHMCS complained: " . $response->message);
        }

        return $response;
    }


    public function getCredits($uid)
    {
        return $this->api("getcredits", array("clientid" => $uid));
    }


    public function updateClient($uid = 0, $update)
    {
        $attributes = array("firstname", "lastname", "companyname", "email", "address1",
            "address2", "city", "state", "postcode", "country", "phonenumber", "password2", "credit",
            "taxexempt", "notes", "cardtype", "cardnum", "expdate", "startdate", "issuenumber",
            "language", "customfields", "status", "latefeeoveride", "overideduenotices", "disableautocc");

        foreach ($attributes as $k) {
            if (isset($update[$k])) {
                $params[$k] = $update[$k];
            }
        }

        $params['clientid'] = $uid;

        $response = $this->api("updateclient", $params);

        if ($response->result == 'error') {
            throw new WhmcsException("WHMCS complained: " . $response->message);
        }

        return $response;
    }


    public function addClient($data)
    {
        $attributes = array("firstname", "lastname", "companyname",
            "email", "address1", "address2", "city", "state", "postcode", "country", "phonenumber",
            "password2", "currency", "clientip", "language", "groupid", "securityqid", "securityqans",
            "notes", "cctype", "cardnum", "expdate", "startdate", "issuenumber", "customfields",
            "noemail", "skipvalidation");

        foreach ($attributes as $k) {
            $customer[$k] = $data[$k];
        }
        if ($customer['skipvalidation'] != true) {
            if (!$customer['firstname'] || !$customer['lastname'] ||
                !$customer['email'] || !$customer['address1'] || !$customer['city'] ||
                !$customer['state'] || !$customer['postcode'] || !$customer['country'] ||
                !$customer['phonenumber'] || !$customer['password2']) {
                throw new WhmcsException("Required fields missing.");
            }
        }

        $response = $this->api("addclient", $customer);
        if ($response->result == 'error') {
            throw new WhmcsException("WHMCS complained: " . $response->message);
        }
        return $response;
    }

    public function getClient($clientid = 0, $email = '')
    {
        if ($clientid > 0) {
            $params = array("clientid" => $clientid);
        } elseif ($email) {
            $params = array("email" => $email);
        } else {
            $this->error = true;
            $this->errorMessage;
        }
        $params['stats'] = true;
        $response = $this->api("getclientsdetails", $params);
        if ($response->result == 'error') {
            throw new WhmcsException("WHMCS complained: " . $response->message);
        }
        return $response;
    }

    public function addContact($data)
    {
        $attributes = array("clientid", "firstname", "lastname", "companyname", "email", "address1",
            "address2", "city", "state", "postcode", "country", "phonenumber", "password2",
            "permissions", "generalemails", "productemails", "domainemails", "invoiceemails",
            "supportemails", "skipvalidation");
        foreach ($attributes as $k) {
            $contact[$k] = $data[$k];
        }
        if ($contact['skipvalidation'] != true) {
            if (!$contact['clientid'] || !$contact['firstname'] || !$contact['lastname'] ||
                !$contact['email'] || !$contact['address1'] || !$contact['city'] ||
                !$contact['state'] || !$contact['postcode'] || !$contact['country'] ||
                !$contact['phonenumber'] || !$contact['password2']) {
                throw new WhmcsException("Required fields missing.");
            }
        }
        $response = $this->api("addcontact", $contact);
        if ($response->result == 'error') {
            throw new WhmcsException("WHMCS complained: " . $response->message);
        }
        return $response;
    }


    public function getInvoice($invoiceid)
    {
        return $this->api("getinvoice", array("invoiceid" => $invoiceid));
    }


    public function getInvoices($uid = 0, $status = '', $start = 0, $limit = 0)
    {
        if ($uid > 0) {
            $params['userid'] = $uid;
        }

        if ($status == "Unpaid" || $status == "Paid" || $status == "Refunded" ||
            $status == "Cancelled" || $status == "Collections")
        {
            $params['status'] = $status;
        }
        if (!$limit <= 0)
        {
            $limit = 9999;
        }

        $params['limitnum'] = $limit;
        $params['limitstart'] = $start;
        $response = $this->api("getinvoices", $params);

        if ($response->result == 'error') {
            throw new WhmcsException("WHMCS complained: " . $response->message);
        }
        return $response;
    }


    public function createInvoice($data)
    {
        $attributes = array("userid", "date", "duedate", "paymentmethod",
            "sendinvoice",
            // optional
            "taxrate", "taxrate2", "notes", "sendinvoice",
            "autoapplycredit");

        foreach ($attributes as $a) {
            if (!empty($params[$a])) {
                $params[$a] = $data[$a];
            }
        }

        for ($i = 0; $i < count($data['items']); $i++) {
            $params['itemdescription' . $i] = $data['items'][$i]['description'];
            $params['itemamount' . $i] = $data['items'][$i]['amount'];
            $params['itemtaxed' . $i] = $data['items'][$i]['taxed'];
        }

        $response = $this->api("createinvoice", $params);

        if ($response->result == 'error') {
            throw new WhmcsException("WHMCS complained: " . $response->message);
        }

        return $response;
    }


    public function addInvoicePayment($invoiceid, $txid, $amount = 0, $gateway, $date = '')
    {
        if ($amount > 0) {
            $params['amount'] = $amount;
        }

        if ($date) {
            $params['date'] = $date;
        }

        $params['transid'] = $txid;
        $params['gateway'] = $gateway;
        $params['invoiceid'] = $invoiceid;

        $response = $this->api("addinvoicepayment", $params);

        if ($response->result == 'error') {
            throw new WhmcsException("WHMCS complained: " . $response->message);
        }

        return $response;
    }


    public function getOrders($uid = 0, $orderId = 0, $status = '', $start = 0, $limit = 0)
    {
        if ($uid > 0) {
            $params['userid'] = $uid;
        }

        if ($orderId > 0) {
            $params['id'] = $invoiceId;
        }

        if ($status == "Pending" || $status == "Active" || $status == "Fraud" || $status == "Cancelled") {
            $params['status'] = $status;
        }

        if (!$limit <= 0) {
            $limit = 9999;
        }

        $params['limitnum'] = $limit;
        $params['limitstart'] = $start;

        $response = $this->api("getorders", $params);

        if ($response->result == 'error') {
            throw new WhmcsException("WHMCS complained: " . $response->message);
        }

        return $response;
    }


    public function addOrder($uid, $productdata, $paymentmethod, $clientip,
                             $promocode = null, int $affid = null, $noemail = false, $noinvoice = false,
                             $noinvoiceemail = false, $otherparams = null)
    {
        if ($promocode) {
            $params['promocode'] = $promocode;
        }
        if ($affid) {
            $params['affid'] = $affid;
        }
        if ($noemail) {
            $params['noemail'] = "true";
        }
        if ($noinvoice) {
            $params['noinvoice'] = "true";
        }
        if ($noinvoiceemail) {
            $params['noinvoiceemail'] = "true";
        }

        $params['clientid'] = $uid;
        $params['paymentmethod'] = $paymentmethod;
        $params['clientip'] = $clientip;

        $i = 0;
        foreach ($productdata as $product) {
            foreach ($product as $key => $val) {
                if ($key == "customfields" || $key == "configoptions" || $key == "domainfields") {
                    $val = base64_encode(serialize($val));
                }
                $params[$key . '[' . $i . ']'] = $val;
            }
            $i++;
        }

        if (isset($otherparams)) {
            foreach ($otherparams as $key => $val) {
                $params[$key] = $val;
            }
        }

        $response = $this->api('addorder', $params);
        if ($response->result == 'error') {
            throw new WhmcsException("WHMCS complained: " . $response->message);
        }
        return $this->message;
    }

    public function acceptOrder(int $orderid, int $serverid = null, string $serviceusername = null,
                                string $servicepassword = null, string $registrar = null,
                                bool$autosetup = null, bool $sendregistrar = null, bool $sendemail = null)
    {
        if ($serverid) {
            $params['serverid'] = $serverid;
        }
        if ($serviceusername) {
            $params['serviceusername'] = $serviceusername;
        }
        if ($servicepassword) {
            $params['servicepassword'] = $servicepassword;
        }
        if ($registrar) {
            $params['registrar'] = $registrar;
        }
        if ($autosetup) {
            $params['autosetup'] = $autosetup;
        }
        if ($sendemail) {
            $params['sendemail'] = $sendemail;
        }
        if ($sendregistrar) {
            $params['sendregistrar'] = $sendregistrar;
        }

        $params['orderid'] = $orderid;

        $response = $this->api('acceptorder', $params);

        if ($response->result == 'error') {
            throw new WhmcsException("WHMCS complained: " . $response->message);
        }

        return $response;
    }


    public function getStats($params)
    {
        $response = $this->api("getstats", $params);
        if ($response->result == 'error') {
            throw new WhmcsException("WHMCS complained: " . $response->message);
        }
        return $response;
    }


    protected function api($action, $params)
    {
        $postfields = array();
        $postfields['username'] = $this->username;
        $postfields['password'] = md5($this->password);
        $postfields['responsetype'] = 'json';
        $postfields['action'] = $action;
        if ($this->accesskey != '') {
            $postfields['accesskey'] = $this->accesskey;
        }
        if (isset($params))
        {
            foreach ($params as $k => $v) {
                $postfields[$k] = $v;
            }
        }
        if (!$this->localApi == true) {
            $queryString = http_build_query($postfields);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $queryString);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
            $this->results  = curl_exec($ch);
            if (curl_error($ch))
            {
                $this->error = true;
                $this->errorMessage =
                    'Unable to connect: ' . curl_errno($ch) . ' - ' . curl_error($ch);
                curl_close($ch);
            }else {
                curl_close($ch);
                $this->checkResponse();
            }
        } else {
            $this->results = $this->localApi($action, $params, $this->username);
            $this->checkResponse();
        }
    }

    private function checkResponse()
    {
        $result = $this->results;
        if ($result['result'] !== '' || !$result['result'] == 'success') {
            $this->error = true;
            $this->errorMessage = $result['message'];
        } else {
            $this->message = $result['message'];
        }
    }
}

