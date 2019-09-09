<?php

class trxReportsController extends \BaseController {

    public $restful = true;
    protected $layout = 'layout.default';

    public function index() {
        if (!Session::has('userinfo')) {
            return Redirect::route('login')->with('message', 'Session has Expired, Please Login Again!');
        }
        
        $title = Session::get('ModuleName');  
        $Message = Session::get('message') ? Session::get('message') : '';
        
        $_accessInfo = Session::get('accessinfo');
        $_reportAccess = "<option value='' access=''>-- Select Report Name --</option>";
        //dd($_accessInfo);
        

        /* for Report Name */
        for ($i = 0; $i < sizeof($_accessInfo); $i++) {
            if ($_accessInfo[$i]["access_group"] === "reports") {
                $_reportAccess .= "<option value='" . $_accessInfo[$i]["access_link"] . "' access='" . $_accessInfo[$i]["access_image"] . "'>" . $_accessInfo[$i]["access_description"] . "</option>";
            }
        }
        
       
        // dd($optionsCat);
        $View = View::make('perareports', array('title' => $title, 'message' => $Message,'report_list' => $_reportAccess));
        $this->layout->content = $View;
       
    }

    public function Reports($type = null) {
        if (Session::has('userinfo')) {
            $paramArray = array("trx_date" => Session::get("branch_trx_date"));
            if ($type === 'cpr') {
                $paramArray += array("currency_id" => "1");
                $paramArray += array("bank_id" => "1");
            }

            $hash = Func::createAPIRequestComplete("reports", $type, $paramArray);
            $file = json_decode($hash, true);
//            if ($file['apiuspresponse']["header"]["errorcode"] !== "0") {
//                return json_decode("{\"_messageCode\":\"70000\",\"_message\":\"With COC Number :" . $return . ". But with USP error " . $file['apiuspresponse']['body'] . "\"}", true);
//            }
            //Session::forget('trxformid');
            Session::put('rptRes', $file['apiuspresponse']);
            Session::put('rptType',$type);
            return "{\"data\":" . json_encode($file['apiuspresponse']['body']) . "}";
        } else {
            return json_decode("{\"_messageCode\":\"60000\",\"_message\":\"Session has Expired, Please Login Again!\"}", true);
        }
    }   
}
