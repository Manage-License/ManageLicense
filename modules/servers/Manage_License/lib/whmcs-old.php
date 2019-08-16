<?php
/**
 * Created by PhpStorm.
 * User: Msirous
 * Date: 7/10/18
 * Time: 11:37 AM
 */

class Whmcss
{
    private $url = 'http://whmcs.com/include/api.php';
    public $error = false;
    public $errorMessage = '';
    public $message = [];
    private $response = [];
    private $postField = [];
    public $accesskey;


    public function __construct(array $params)
    {
        $this->generateField($params);
    }

    public function authenticate(string $username, string $password)
    {
        $response = $this->api("validatelogin",
            array("email" => $username, "password2" => $password));
        if ($response['error'] = true) {
            $this->error = true;
            $this->errorMessage = $response['message'];
        }
        $this->response = $response;
//        $this->checkResponses();
    }


    private function generateField(array $params)
    {
        $this->postField = [
            "username" => $params['username'],
            "password" => md5($params['password']),
            'responsetype' => 'json',
//            'action' => $action
        ];
    }


    public function getDomains(array $optional = [])
    {
        $fielss = [
            'action' => 'GetClientsDomains',
        ];

        $optionalFields = [
            'limitstart' => $optional['limitstart'],
            'limitnum' => $optional['limitnum'],
            'clientid' => $optional['clientid'],
            'domainid' => $optional['domainid'],
            'domain	' => $optional['domain'],
        ];
        $this->postField = array_push($fielss, $optionalFields);
//         = $fiels;
        $this->api();
    }

    public function getDomainNameservers(int $params)
    {
        $required = [
            'action' => 'GetClientsDomains',
            'domainid' => $params
        ];

        $this->postField = $required;
        $this->api();
    }

    public function acceptOrder(int $params, array $optional = [])
    {
        $required = [
            'action' => 'AcceptOrder',
            'orderid' => $params,

        ];
        $optionalFields = [
            'serverid' => $optional['serverid'],
            'serviceusername' => $optional['serviceusername'],
            'servicepassword' => $optional['servicepassword'],
            'registrar' => $optional['registrar'],
            'sendregistrar' => $optional['sendregistrar'],
            'autosetup' => $optional['autosetup'],
            'sendemail' => $optional['sendemail'],
        ];
        $this->postField = array_push($required, $optionalFields);
//         = $fiels;
        $this->api();
    }


//    public function getStats()
//    {
//        $required = [
//            'action' => 'AcceptOrder'
//    ];
//    }


    public function addOrder(array $params, array $optional = [], $productdata, $otherparams = null)
    {
        $required = [
            'action' => 'AddOrder',
            'clientid' => $params['clientid'],
            'paymentmethod' => $params['paymentmethod'],
        ];
        $optionalFields = [
            'promocode' => $optional['promocode'],
            'affid' => $optional['affid'],
            'noemail' => $optional['noemail'],
            'noinvoice' => $optional['noinvoice'],
            'noinvoiceemail' => $optional['noinvoiceemail'],
            'clientip' => $optional['clientip'],
        ];
        $i = 0;
        $params = [];
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
        $fiels = array_push($required, $optionalFields);
        $this->postField = $fiels;
        $this->api();
    }

    public function getOrders(array $optional = [], string $status = '')
    {
        $required = [
            'action' => 'GetOrders',
        ];

        $optionalFields = [
            'limitstart' => $optional['limitstart'],
            'limitnum' => $optional['limitnum'],
            'id' => $optional['id'],
            'userid' => $optional['userid'],
            'status' => $status
        ];
        $this->postField = array_push($required, $optionalFields);
//         = $fiels;
        $this->api();
    }

    public function getProducts(array $params, array $optional = [])
    {
        $required = [
            'action' => 'GetProducts',
            'pid' => $params['pid']
        ];

        $optionalFields = [
            'gid' => $optional['gid'],
            'module' => $optional['module']
        ];
        $this->postField = array_push($required, $optionalFields);
//         = $fiels;
        $this->api();
    }

    public function getServices(array $params, array $optional = [])
    {
        $required = [
            'action' => 'GetProducts',
            'pid' => $params['pid']
        ];

        $optionalFields = [
            'limitnum' => $optional['limitnum'],
            'clientid' => $optional['clientid'],
            'serviceid' => $optional['serviceid'],
            'domain' => $optional['domain'],
            'username2' => $optional['username2'],
        ];
        $fiels = array_push($required, $optionalFields);
        $this->postField = $fiels;
        $this->api();
    }

    public function getTransactions(array $params, array $optional = [])
    {
        $required = [
            'action' => 'gettransactions',
            'pid' => $params['pid']
        ];

        $optionalFields = [
            'clientid' => $optional['clientid'],
            'invoiceid' => $optional['invoiceid'],
            'transid' => $optional['transid'],
        ];
        $fiels = array_push($required, $optionalFields);
        $this->postField = $fiels;
        $this->api();
    }

    public function getEmails(array $params, array $optional = [])
    {
        $required = [
            'action' => 'getemails',
            'pid' => $params['pid']
        ];

        $optionalFields = [
            'subject' => $optional['subject'],
            'date' => $optional['date'],
            'limitnum' => $optional['limitnum'],
            'limitstart' => $optional['limitstart'],
        ];
        $fiels = array_push($required, $optionalFields);
        $this->postField = $fiels;
        $this->api();
    }

    public function addCredit(array $params, $data)
    {
        $required = [
            'action' => $params['addcredit'],
            'clientid' => $params['getemails'],
            'description' => $params['getemails'],
            'amount' => $params['getemails'],
        ];
        foreach ($required as $k) {
            $credit[$k] = $data[$k];
        }

        if (!$credit['clientid'] || !$credit['description'] || !$credit['amount']) {
            $this->error = true;
            $this->errorMessage;
        }
        $this->postField = $required;
        $this->api();
    }

    public function updateClient(array $params, $uid = 0, $update)
    {
        $required = [
            'action' => $params['updateclient'],
            'firstname' => $params['getemails'],
            'lastname' => $params['getemails'],
            'companyname' => $params['getemails'],
            'email' => $params['getemails'],
            'address1' => $params['getemails'],
            'address2' => $params['getemails'],
            'city' => $params['getemails'],
            'state' => $params['getemails'],
            'postcode' => $params['getemails'],
            'country' => $params['getemails'],
            'phonenumber' => $params['getemails'],
            'password2' => $params['getemails'],
            'credit' => $params['getemails'],
            'taxexempt' => $params['getemails'],
            'notes' => $params['getemails'],
            'cardtype' => $params['getemails'],
            'cardnum' => $params['getemails'],
            'expdate' => $params['getemails'],
            'startdate' => $params['getemails'],
            'issuenumber' => $params['getemails'],
            'language' => $params['getemails'],
            'customfields' => $params['getemails'],
            'status' => $params['getemails'],
            'latefeeoveride' => $params['getemails'],
            'overideduenotices' => $params['getemails'],
            'disableautocc' => $params['getemails'],
        ];
        foreach ($required as $k) {
            if (isset($update[$k])) {
                $params[$k] = $update[$k];
            }
        }
        $params['clientid'] = $uid;
        if ($this->error = true) {
            $this->errorMessage;
        }
        $this->postField = $required;
        $this->api();
    }


    public function addClient($data, array $params)
    {
        $required = [
            'action' => $params['updateclient'],
            'firstname' => $params['getemails'],
            'lastname' => $params['getemails'],
            'companyname' => $params['getemails'],
            'email' => $params['getemails'],
            'address1' => $params['getemails'],
            'address2' => $params['getemails'],
            'city' => $params['getemails'],
            'state' => $params['getemails'],
            'postcode' => $params['getemails'],
            'country' => $params['getemails'],
            'phonenumber' => $params['getemails'],
            'password2' => $params['getemails'],
            'currency' => $params['getemails'],
            'clientip' => $params['getemails'],
            'language' => $params['getemails'],
            'groupid' => $params['getemails'],
            'securityqid' => $params['getemails'],
            'securityqans' => $params['getemails'],
            'notes' => $params['getemails'],
            'cctype' => $params['getemails'],
            'cardnum' => $params['getemails'],
            'expdate' => $params['getemails'],
            'startdate' => $params['getemails'],
            'issuenumber' => $params['getemails'],
            'customfields' => $params['getemails'],
            'noemail' => $params['getemails'],
            'skipvalidation' => $params['skipvalidation'],
        ];
        foreach ($required as $k) {
            $customer[$k] = $data[$k];
        }
        if ($customer['skipvalidation'] != true) {
            if (!$customer['firstname'] || !$customer['lastname'] || !$customer['email']
                || !$customer['address1'] || !$customer['city'] || !$customer['state']
                || !$customer['postcode'] || !$customer['country'] || !$customer['phonenumber']
                || !$customer['password2']) {
                $this->error = true;
                $this->errorMessage;
            }
        }
        $this->postField = $required;
        $this->api();
    }

    public function getClient(array $optional = [])
    {
        $required = [
            'action' => 'GetClientsDetails',
        ];

        $optionalFields = [
            'clientid' => $optional['clientid'],
            'email' => $optional['email'],
            'stats' => $optional['stats']
        ];
        $fiels = array_push($required, $optionalFields);
        $this->postField = $fiels;
        $this->api();
    }

    public function addContact($data, array $params)
    {
        $required = [
            'action' => $params['addcontact'],
            'clientid' => $params['getemails'],
            'firstname' => $params['getemails'],
            'lastname' => $params['getemails'],
            'companyname' => $params['getemails'],
            'email' => $params['getemails'],
            'address1' => $params['getemails'],
            'address2' => $params['getemails'],
            'city' => $params['getemails'],
            'state' => $params['getemails'],
            'postcode' => $params['getemails'],
            'country' => $params['getemails'],
            'phonenumber' => $params['getemails'],
            'password2' => $params['getemails'],
            'permissions' => $params['getemails'],
            'generalemails' => $params['getemails'],
            'productemails' => $params['getemails'],
            'domainemails' => $params['getemails'],
            'invoiceemails' => $params['getemails'],
            'supportemails' => $params['getemails'],
            'skipvalidation' => $params['skipvalidation'],
        ];
        foreach ($required as $k) {
            $contact[$k] = $data[$k];
        }
        if ($contact['skipvalidation'] != true) {
            if (!$contact['clientid'] || !$contact['firstname'] ||
                !$contact['lastname'] || !$contact['email'] || !$contact['address1'] ||
                !$contact['city'] || !$contact['state'] || !$contact['postcode'] ||
                !$contact['country'] || !$contact['phonenumber'] || !$contact['password2']) {
                $this->error = true;
                $this->errorMessage;
            }
        }
        $this->postField = $required;
        $this->api();
    }

    public function getInvoice(array $params)
    {
        $fields = [
            'action' => $params['action'],
            'invoiceid' => $params['invoiceid']
        ];
        $this->postField = $fields;
        $this->api();
    }

    public function CreateInvoice(array $params, array $optional = [])
    {
        $required = [
            'action' => 'CreateInvoice',
            'userid' => $params['userid']
        ];

        $optionalFields = [
            'status' => $optional['subject'],
            'draft' => $optional['date'],
            'sendinvoice' => $optional['limitnum'],
            'paymentmethod' => $optional['limitstart'],
            'taxrate' => $optional['limitstart'],
            'taxrate2' => $optional['limitstart'],
            'date' => $optional['limitstart'],
            'duedate' => $optional['limitstart'],
            'notes' => $optional['notes'],
            'itemdescriptionx' => $optional['itemdescriptionx'],
            'itemamountx' => $optional['itemamountx'],
            'autoapplycredit' => $optional['autoapplycredit'],
        ];
        $fiels = array_push($required, $optionalFields);
        $this->postField = $fiels;
        $this->api();
    }

    public function AddInvoicePayment(array $params, array $optional = [])
    {
        $required = [
            'action' => 'AddInvoicePayment',
            'invoiceid' => $params['invoiceid'],
            'transid' => $params['transid'],
            'gateway' => $params['gateway'],
        ];

        $optionalFields = [
            'date' => $optional['date'],
            'amount' => $optional['amount'],
            'fees' => $optional['fees'],
            'noemail' => $optional['noemail']
        ];
        $fiels = array_push($required, $optionalFields);
        $this->postField = $fiels;
        $this->api();
    }


    private function api(string $action, array $params)

    {
        $cl = curl_init();
        curl_setopt($cl, CURLOPT_URL, $this->url);
        curl_setopt($cl, CURLOPT_HEADER, 0);
        curl_setopt($cl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cl, CURLOPT_TIMEOUT, 30);
        curl_setopt($cl, CURLOPT_POST, 1);
        curl_setopt($cl, CURLOPT_POSTFIELDS, http_build_query($this->postField));
        curl_setopt($cl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($cl);
        curl_close($cl);
        if (curl_error($cl)) {
            $this->error = true;
            $this->errorMessage =
                'Unable to connect: ' . curl_errno($cl) . ' - ' . curl_error($cl);
        } else {
            $this->response = $output;
            $this->checkResponses();
        }
    }

    private function checkResponses()
    {
        $response = $this->response;
        if ($response['error'] = true) {
            $this->error = true;
            $this->errorMessage = $response['message'];
        } else {
            $this->message = $response['message'];
        }
    }
}

