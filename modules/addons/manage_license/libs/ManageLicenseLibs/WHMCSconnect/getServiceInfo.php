<?php


namespace ML_Addon\WHMCSconnect;

use http\Params;
use WHMCS\Database\Capsule as DB;

class getServiceInfo {
	/*
	 * @var params
	 */
	protected $params;
	/*
	 * @var billing
	 */
	protected $billing;
	/*
	 * @var serviceId
	 */
	protected $serviceId;
	/*
	 * @var type
	 */
	protected $type;
	/*
	 * @var action
	 */
	protected $action;

	/**
	 *
	 * @param $params
	 */
	public function __construct( array $params ) {
		$this->params    = json_decode( json_encode( $params ) );
		$this->serviceId = $this->params->accountid;
		$this->billing   = $this->params->model->billingcycle;
		$this->type = $this->params->configoption1;
		$this->action = $this->params->action;
	}

	/**
	 * @return string
	 */
	public function getServiceId() {
		return $this->serviceId;
	}

	/**
	 * @return string
	 */
	public function getBilling() {
		return $this->billing;
	}
	/**
	 * @return string
	 */
	public function getGroup() {
		return   explode("|", $this->type)[0];
	}
	/**
	 * @return string
	 */
	public function getType() {
		return   explode("|", $this->type)[1];
	}
	/**
	 * @return string
	 */
	public function getAction() {
		return    $this->action;
	}

}
//
//object(stdClass)#484 (53) {
//["whmcsVersion"]=>
//  string(15) "7.7.1-release.1"
//["accountid"]=>
//  int(10737)
//  ["serviceid"]=>
//  int(10737)
//  ["addonId"]=>
//  int(0)
//  ["userid"]=>
//  int(2557)
//  ["domain"]=>
//  string(11) "congoro.com"
//["username"]=>
//  string(8) "congoroc"
//["password"]=>
//  string(14) "Itp50o)6UOc.C3"
//["packageid"]=>
//  int(148)
//  ["pid"]=>
//  int(148)
//  ["serverid"]=>
//  int(17)
//  ["status"]=>
//  string(6) "Active"
//["type"]=>
//  string(5) "other"
//["producttype"]=>
//  string(5) "other"
//["moduletype"]=>
//  string(14) "Manage_License"
//["configoption1"]=>
//  string(18) "SSL|Commercial SSL"
//["configoption2"]=>
//  string(11) "**Zahra1368"
//["configoption3"]=>
//  string(27) "601|Commercial SSL (1 year)"
//["configoption4"]=>
//  string(5) "EMAIL"
//["configoption5"]=>
//  string(0) ""
//["configoption6"]=>
//  string(0) ""
//["configoption7"]=>
//  string(0) ""
//["configoption8"]=>
//  string(5) "Basic"
//["configoption9"]=>
//  string(0) ""
//["configoption10"]=>
//  string(0) ""
//["configoption11"]=>
//  string(2) "en"
//["configoption12"]=>
//  string(0) ""
//["configoption13"]=>
//  string(0) ""
//["configoption14"]=>
//  string(0) ""
//["configoption15"]=>
//  string(0) ""
//["configoption16"]=>
//  string(0) ""
//["configoption17"]=>
//  string(0) ""
//["configoption18"]=>
//  string(0) ""
//["configoption19"]=>
//  string(0) ""
//["configoption20"]=>
//  string(0) ""
//["configoption21"]=>
//  string(0) ""
//["configoption22"]=>
//  string(0) ""
//["configoption23"]=>
//  string(0) ""
//["configoption24"]=>
//  string(0) ""
//["customfields"]=>
//  object(stdClass)#449 (1) {
//  ["Domain"]=>
//    string(11) "congoro.com"
//  }
//  ["configoptions"]=>
//  object(stdClass)#450 (1) {
//  ["Domain Count"]=>
//    int(0)
//  }
//  ["model"]=>
//  object(stdClass)#461 (37) {
//  ["id"]=>
//    int(10737)
//    ["userid"]=>
//    int(2557)
//    ["orderid"]=>
//    int(10769)
//    ["packageid"]=>
//    int(148)
//    ["server"]=>
//    int(17)
//    ["regdate"]=>
//    string(10) "2019-08-10"
//["domain"]=>
//    string(11) "congoro.com"
//["paymentmethod"]=>
//    string(11) "allGateways"
//["firstpaymentamount"]=>
//    string(9) "140000.00"
//["amount"]=>
//    string(9) "140000.00"
//["billingcycle"]=>
//    string(8) "Annually"
//["nextduedate"]=>
//    string(10) "2020-08-10"
//["nextinvoicedate"]=>
//    string(10) "2020-08-10"
//["termination_date"]=>
//    string(10) "0000-00-00"
//["completed_date"]=>
//    string(10) "0000-00-00"
//["domainstatus"]=>
//    string(6) "Active"
//["username"]=>
//    string(8) "congoroc"
//["notes"]=>
//    string(0) ""
//["subscriptionid"]=>
//    string(0) ""
//["promoid"]=>
//    int(0)
//    ["suspendreason"]=>
//    string(0) ""
//["overideautosuspend"]=>
//    int(0)
//    ["overidesuspenduntil"]=>
//    string(10) "0000-00-00"
//["dedicatedip"]=>
//    string(0) ""
//["assignedips"]=>
//    string(0) ""
//["ns1"]=>
//    string(0) ""
//["ns2"]=>
//    string(0) ""
//["diskusage"]=>
//    int(0)
//    ["disklimit"]=>
//    int(0)
//    ["bwusage"]=>
//    int(0)
//    ["bwlimit"]=>
//    int(0)
//    ["lastupdate"]=>
//    string(19) "0000-00-00 00:00:00"
//["created_at"]=>
//    string(19) "0000-00-00 00:00:00"
//["updated_at"]=>
//    string(19) "0000-00-00 00:00:00"
//["serviceProperties"]=>
//    object(stdClass)#474 (0) {
//    }
//    ["product"]=>
//    object(stdClass)#476 (67) {
//    ["id"]=>
//      int(148)
//      ["type"]=>
//      string(5) "other"
//["gid"]=>
//      int(25)
//      ["name"]=>
//      string(19) "Commercial SSL (DV)"
//["description"]=>
//      string(628) "کد گذاری 2024 یا 4048 بایت

//["hidden"]=>
//      int(0)
//      ["showdomainoptions"]=>
//      int(1)
//      ["welcomeemail"]=>
//      int(270)
//      ["stockcontrol"]=>
//      int(0)
//      ["qty"]=>
//      int(0)
//      ["proratabilling"]=>
//      int(0)
//      ["proratadate"]=>
//      int(0)
//      ["proratachargenextmonth"]=>
//      int(0)
//      ["paytype"]=>
//      string(9) "recurring"
//["allowqty"]=>
//      int(0)
//      ["subdomain"]=>
//      string(0) ""
//["autosetup"]=>
//      string(7) "payment"
//["servertype"]=>
//      string(14) "Manage_License"
//["servergroup"]=>
//      int(13)
//      ["configoption1"]=>
//      string(18) "SSL|Commercial SSL"
//["configoption2"]=>
//      string(11) "**Zahra1368"
//["configoption3"]=>
//      string(27) "601|Commercial SSL (1 year)"
//["configoption4"]=>
//      string(5) "EMAIL"
//["configoption5"]=>
//      string(0) ""
//["configoption6"]=>
//      string(0) ""
//["configoption7"]=>
//      string(0) ""
//["configoption8"]=>
//      string(5) "Basic"
//["configoption9"]=>
//      string(0) ""
//["configoption10"]=>
//      string(0) ""
//["configoption11"]=>
//      string(2) "en"
//["configoption12"]=>
//      string(0) ""
//["configoption13"]=>
//      string(0) ""
//["configoption14"]=>
//      string(0) ""
//["configoption15"]=>
//      string(0) ""
//["configoption16"]=>
//      string(0) ""
//["configoption17"]=>
//      string(0) ""
//["configoption18"]=>
//      string(0) ""
//["configoption19"]=>
//      string(0) ""
//["configoption20"]=>
//      string(0) ""
//["configoption21"]=>
//      string(0) ""
//["configoption22"]=>
//      string(0) ""
//["configoption23"]=>
//      string(0) ""
//["configoption24"]=>
//      string(0) ""
//["freedomain"]=>
//      string(0) ""
//["freedomainpaymentterms"]=>
//      string(0) ""
//["freedomaintlds"]=>
//      string(0) ""
//["recurringcycles"]=>
//      int(0)
//      ["autoterminatedays"]=>
//      int(0)
//      ["autoterminateemail"]=>
//      int(208)
//      ["configoptionsupgrade"]=>
//      int(0)
//      ["billingcycleupgrade"]=>
//      string(0) ""
//["upgradeemail"]=>
//      int(0)
//      ["overagesenabled"]=>
//      string(0) ""
//["overagesdisklimit"]=>
//      int(0)
//      ["overagesbwlimit"]=>
//      int(0)
//      ["overagesdiskprice"]=>
//      string(6) "0.0000"
//["overagesbwprice"]=>
//      string(6) "0.0000"
//["tax"]=>
//      int(0)
//      ["affiliateonetime"]=>
//      int(0)
//      ["affiliatepaytype"]=>
//      string(0) ""
//["affiliatepayamount"]=>
//      string(4) "0.00"
//["order"]=>
//      int(0)
//      ["retired"]=>
//      int(0)
//      ["is_featured"]=>
//      int(0)
//      ["created_at"]=>
//      string(19) "2017-01-12 19:10:08"
//["updated_at"]=>
//      string(19) "2019-02-27 13:24:08"
//["formattedProductFeatures"]=>
//      object(stdClass)#451 (3) {
//      ["original"]=>
//        string(682) "کد گذاری 2024 یا 4048 بایت
//

//["features"]=>
//        array(0) {
//}
//        ["featuresDescription"]=>
//        string(689) "کد گذاری 2024 یا 4048 بایت
//

//
//"
//      }
//    }
//    ["client"]=>
//    object(stdClass)#463 (45) {
//    ["id"]=>
//      int(2557)
//      ["uuid"]=>
//      string(36) "184f27a2-b966-4a0d-bdcb-11493d1d3186"
//["firstname"]=>
//      string(9) "hostbaran"
//["lastname"]=>
//      string(3) "com"
//["companyname"]=>
//      string(0) ""
//["email"]=>
//      string(18) "info@hostbaran.com"
//["address1"]=>
//      string(0) ""
//["address2"]=>
//      string(0) ""
//["city"]=>
//      string(0) ""
//["state"]=>
//      string(0) ""
//["postcode"]=>
//      string(0) ""
//["country"]=>
//      string(2) "IR"
//["phonenumber"]=>
//      string(0) ""
//["tax_id"]=>
//      string(0) ""
//["authmodule"]=>
//      string(0) ""
//["currency"]=>
//      int(1)
//      ["defaultgateway"]=>
//      string(0) ""
//["credit"]=>
//      string(11) "50708894.26"
//["taxexempt"]=>
//      int(0)
//      ["latefeeoveride"]=>
//      int(0)
//      ["overideduenotices"]=>
//      int(0)
//      ["separateinvoices"]=>
//      int(0)
//      ["disableautocc"]=>
//      int(0)
//      ["datecreated"]=>
//      string(10) "2019-04-26"
//["notes"]=>
//      string(0) ""
//["billingcid"]=>
//      int(0)
//      ["securityqid"]=>
//      int(0)
//      ["groupid"]=>
//      int(0)
//      ["cardtype"]=>
//      string(0) ""
//["cardlastfour"]=>
//      string(0) ""
//["gatewayid"]=>
//      string(0) ""
//["lastlogin"]=>
//      string(19) "0000-00-00 00:00:00"
//["ip"]=>
//      string(14) "188.208.201.20"
//["host"]=>
//      string(14) "188.208.201.20"
//["status"]=>
//      string(6) "Active"
//["language"]=>
//      string(7) "english"
//["emailoptout"]=>
//      int(1)
//      ["marketing_emails_opt_in"]=>
//      int(0)
//      ["overrideautoclose"]=>
//      int(0)
//      ["allow_sso"]=>
//      int(0)
//      ["email_verified"]=>
//      int(0)
//      ["created_at"]=>
//      string(19) "0000-00-00 00:00:00"
//["updated_at"]=>
//      string(19) "2019-05-18 13:42:50"
//["fullName"]=>
//      string(13) "hostbaran com"
//["countryName"]=>
//      string(36) "جمهوری اسلامی ایران"
//    }
//  }
//  ["server"]=>
//  bool(true)
//  ["serverip"]=>
//  string(0) ""
//["serverhostname"]=>
//  string(46) "https://nicsepehrapi.com/api/product/licenseha"
//["serverusername"]=>
//  string(20) "sa.g0me@gmail.com"
//["serverpassword"]=>
//  string(10) "2 n"
//["serveraccesshash"]=>
//  string(0) ""
//["serversecure"]=>
//  bool(false)
//  ["serverhttpprefix"]=>
//  string(4) "http"
//["serverport"]=>
//  string(0) ""
//["clientsdetails"]=>
//  object(stdClass)#455 (52) {
//  ["userid"]=>
//    string(4) "2557"
//["id"]=>
//    string(4) "2557"
//["uuid"]=>
//    string(36) "184f27a2-b966-4a0d-bdcb-11493d1d3186"
//["firstname"]=>
//    string(9) "hostbaran"
//["lastname"]=>
//    string(3) "com"
//["fullname"]=>
//    string(13) "hostbaran com"
//["companyname"]=>
//    string(0) ""
//["email"]=>
//    string(18) "info@hostbaran.com"
//["address1"]=>
//    string(0) ""
//["address2"]=>
//    string(0) ""
//["city"]=>
//    string(0) ""
//["fullstate"]=>
//    string(0) ""
//["state"]=>
//    string(0) ""
//["postcode"]=>
//    string(0) ""
//["countrycode"]=>
//    string(2) "IR"
//["country"]=>
//    string(2) "IR"
//["phonenumber"]=>
//    string(0) ""
//["tax_id"]=>
//    string(0) ""
//["password"]=>
//    string(60) "$2y$10$xkKdUKhgAJlxCOVZ.ZtPReJvDdFZD9BUJ4mZ/lbmQ8gQqZhPo906y"
//["statecode"]=>
//    string(0) ""
//["countryname"]=>
//    string(36) "جمهوری اسلامی ایران"
//["phonecc"]=>
//    string(2) "98"
//["phonenumberformatted"]=>
//    string(0) ""
//["telephoneNumber"]=>
//    string(0) ""
//["billingcid"]=>
//    string(1) "0"
//["notes"]=>
//    string(0) ""
//["twofaenabled"]=>
//    bool(false)
//    ["currency"]=>
//    string(1) "1"
//["defaultgateway"]=>
//    string(0) ""
//["cctype"]=>
//    string(0) ""
//["cclastfour"]=>
//    string(0) ""
//["gatewayid"]=>
//    string(0) ""
//["securityqid"]=>
//    string(1) "0"
//["securityqans"]=>
//    string(0) ""
//["groupid"]=>
//    string(1) "0"
//["status"]=>
//    string(6) "Active"
//["credit"]=>
//    string(11) "50708894.26"
//["taxexempt"]=>
//    bool(false)
//    ["latefeeoveride"]=>
//    bool(false)
//    ["overideduenotices"]=>
//    bool(false)
//    ["separateinvoices"]=>
//    bool(false)
//    ["disableautocc"]=>
//    bool(false)
//    ["emailoptout"]=>
//    bool(true)
//    ["marketing_emails_opt_in"]=>
//    bool(false)
//    ["overrideautoclose"]=>
//    bool(false)
//    ["allowSingleSignOn"]=>
//    string(1) "0"
//["language"]=>
//    string(7) "english"
//["isOptedInToMarketingEmails"]=>
//    bool(false)
//    ["lastlogin"]=>
//    string(15) "No Login Logged"
//["customfields1"]=>
//    string(0) ""
//["customfields"]=>
//    array(2) {
//	[0]=>
//      object(stdClass)#453 (2) {
//      ["id"]=>
//        string(2) "15"
//	["value"]=>
//        string(0) ""
//      }
//      [1]=>
//      object(stdClass)#448 (2) {
//      ["id"]=>
//        string(2) "29"
//["value"]=>
//        string(6) "خیر"
//      }
//    }
//    ["customfields2"]=>
//    string(6) "خیر"
//  }
//  ["action"]=>
//  string(6) "create"
//}