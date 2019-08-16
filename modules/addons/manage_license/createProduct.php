<?php
/*
-- ُ Startup AllGateway License
-- Create by nicsepehr.com
-- Developer_Mail:  support@nicsepehr.com
*/
//include(dirname(dirname(dirname(dirname(__FILE__))))."/init.php");

/*
 --> Prevent how try to access directly
 */
if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}
use WHMCS\Database\Capsule as DB;





$res="
<div class='form-group col-md-3'>
<label class='info'>product name</label>
<select name='' id='productName' class='form-control select-wrapper'>
<option value='0' selected disabled>Please select product</option>
";
    $products = DB::table("mod_manage_license_products")->orderBy("name")->get();
    foreach ($products as $product) {
        $res.="<option value='$product->id'>$product->name</option>";
}
$res.="</optgroup>
</select>
</div>";

$serviceid=DB::table("mod_manage_license_ap")->get();
$res.="<div class='form-group col-md-3'>
<label class='info'>serviceid</label>
 
<input type='text' class='form-control' id='serviceid'>
</select>
</div>";

$res.="<div class='form-group  col-md-2'>
<label class='info'>&nbsp;</label>
<input type='button' class='btn btn-primary form-control' value='create' onclick='functions.createProduct()'>
</select>
</div>";

return $res;