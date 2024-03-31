<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Zarinpal\Zarinpal;

class Zarinpal_Controller extends Controller
{
    public function payment()
    {
//        require_once("zarinpal_function.php");

        $MerchantID 	= "xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx";
        $Amount 		= 100;
        $Description 	= "تراکنش زرین پال";
        $Email 			= "";
        $Mobile 		= "";
        $CallbackURL 	= "http://example.com/verify.php";
        $ZarinGate 		= false;
        $SandBox 		= false;

        $zp 	= new zarinpal();
        $result = $zp->request($MerchantID, $Amount, $Description, $Email, $Mobile, $CallbackURL, $SandBox, $ZarinGate);

        if (isset($result["Status"]) && $result["Status"] == 100)
        {
            // Success and redirect to pay
            $zp->redirect($result["StartPay"]);
        } else {
            // error
            echo "خطا در ایجاد تراکنش";
            echo "<br />کد خطا : ". $result["Status"];
            echo "<br />تفسیر و علت خطا : ". $result["Message"];
        }
    }
}
