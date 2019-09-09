<?php

class ShowReportController extends \BaseController {

    public $restful = true;
    protected $layout = 'layout.showRpt';

    public function index() {

        if (!Session::has('userinfo')) {
            return Redirect::route('login')->with('message', 'Session has Expired, Please Login Again!');
        }
        $url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        $urlparam = parse_url($url, PHP_URL_QUERY);
        $stringparam = base64_decode($urlparam);
        parse_str($stringparam, $output);
        //dd($stringparam);
        
        $title = '';
        $path = '';
        $trx_type = '';
        $tabledata = '';
        $WUcount = '';        
        $location_name = ''; 
        $location_name2 = ''; 
        $datefrom = ''; 
        $dateto = ''; 
        $yearmonth = ''; 
        $locid = ''; 
        $category = ''; 
        $currid = ''; 
        $monthrate = '';
        $subrpt = ''; 
        $yearweek = '';
        $trxdate = '';
        $agent = '';

        
        if(isset($output['type'])){
        $type = $output['type'];
        }
        // dd($type);
        if(isset($output['locname'])){
        $location_name = $output['locname']; 
        }
        
        if(isset($output['locname'])){
        $location_name2 = $output['locname']; 
        }
        
        if(isset($output['dtfrom'])){
        $datefrom = $output['dtfrom']; 
        }

        if(isset($output['dtto'])){
        $dateto = $output['dtto']; 
        } 
        
        if(isset($output['yearmonth'])){
        $yearmonth = $output['yearmonth']; 
        }  
        
        if(isset($output['loc'])){
        $locid = $output['loc']; 
        } 
        
        if(isset($output['curr'])){
        $currid = $output['curr']; 
        }

        if(isset($output['category'])){
        $category = $output['category'];
        }
        
        if(isset($output['monthrate'])){
        $monthrate = $output['monthrate']; 
        }
        
        if(isset($output['subrpt'])){
        $subrpt = $output['subrpt']; 
        }       
        
        if(isset($output['yearweek'])){
        $yearweek = $output['yearweek']; 
        }      
        
        if(isset($output['trxdate'])){
        $trxdate = $output['trxdate']; 
        }           
        if(isset($output['agent'])){
        $agent = $output['agent']; 
        }  
        
        $sesslocid = Session::get('userinfo')[0]['plocation_id'];
        $sessgrpid = Session::get('userinfo')[0]['vuser_group_id'];
        $sesslocgrpid = Session::get('userinfo')[0]['vlocation_group_id'];

        if(isset($output['dtfrom'])){
        $datefromNew = DateTime::createFromFormat("m/d/Y", $datefrom);
        $datefromNewFin = $datefromNew->format('Y-m-d');
        }
        if(isset($output['dtto'])){
        $datetoNew = DateTime::createFromFormat("m/d/Y", $dateto);
        $datetoNewFin = $datetoNew->format('Y-m-d');
        $dateto_checker = date_create($datetoNewFin);
        }
        
        if(isset($output['dtfrom']) && isset($output['dtto'])){       
        $datefrom_checker = date_create($datefromNewFin);
        $interval_checker = date_diff($datefrom_checker,$dateto_checker);
        $result_checker = $interval_checker->format('%R%a');
            if ($result_checker > 30 || $result_checker < 0) {
                return Redirect::route('reports');
            }
        }

        if (Session::get('userinfo')[0]['vuser_group_id'] == "5" || Session::get('userinfo')[0]['vuser_group_id'] == "22") {
            $locid = Session::get('userinfo')[0]['plocation_id'];
            $location_name = Session::get('userinfo')[0]['vlocation_name'];
        }

        $hash2 = Func::createAPIRequest("locations", "grid", array("type" => "ALL","param" => ""));
        $json2 = json_encode($hash2);
        $urlsegment2 = base64_encode($json2);
        $url2 = Config::get("app.urlAPI") . "/locations/" . $urlsegment2;
        $file2 = json_decode(file_get_contents($url2), true);
        $arr2 = $file2['apiuspresponse']["body"];
//        foreach ($arr2 as $value) {
//            if ($locid == $value['location_id']) {
//                $location_name = $value['location_name'];
//                break;
//            }
//        }
       
//              
        switch ($type) {
            case 'dtrs': {
                    $title = 'DAILY TRANSACTIONS AND REPLENISHMENT SUMMARY';
                    break;
                }
            case 'cpr': {
                    $title = 'CASH POSITION REPORT';
                    break;
                }
            case 'crs': {
                    $title = 'CASH RECEIPTS SUMMARY';
                    break;
                }
            case 'pcrs': {
                    $title = "PETTY CASH REPLENISHMENT";
                    break;
                }
            case 'trxlogs': {
                    $title = "WU TRANSACTION LOG";
                    break;
                }
            case 'wulogs': {
                    $title = $agent . " TRANSACTION LOG";
                    break;
                }
            case 'wucomp': {
                    $title = strtoupper(Input::get("risk_type")) . " RISK CUSTOMERS";
                    break;
                }
            case 'compctr': {
                    $title = "COVERED TRANSACTION REPORT";
                    break;
                }
            case 'compstrd': {
                    $title = "DAILY SUSPICIOUS TRANSACTION REPORT";
                    break;
                }
            case 'compstrm': {
                    $title = "MONTHLY SUSPICIOUS TRANSACTION REPORT";
                    break;
                }
            case 'compstrw': {
                    $title = "WEEKLY SUSPICIOUS TRANSACTION REPORT";
                    break;
                }
            case 'bpwubb': {
                    $title = "BUSINESS PARTNER WU BUY BACK TRANSACTION REPORT";
                    break;
                }
            case 'csreports': {
                    $title = "REMOTE TRANSACTION LOG";
                    break;
                }
            case 'bpins': {
                    $title = "BUSINESS PARTNER INSURANCE TRANSACTION REPORT";
                    break;
                }
            case 'bpload': {
                    $title = "BP E-LOAD TRANSACTION";
                    break;
                }
            case 'sumloadl': {
                    $title = "E-LOAD TRANSACTION SUMMARY PER BRANCH";
                    break;
            }
            case 'bpsumloadl': {
                    $title = "BP E-LOAD TRANSACTION SUMMARY PER BRANCH";
                    break;
                }
            case 'sumloadd': {
                    $title = "E-LOAD TRANSACTION SUMMARY PER DAY";
                    break;
            }
            case 'bpsumloadd': {
                    $title = "BP E-LOAD TRANSACTION SUMMARY PER DAY";
                    break;
                }
            case 'suminsl':{
                    $title = "INSURANCE TRANSACTION SUMMARY PER BRANCH";    
                    break;
            }
            case 'bpsuminsl': {
                    $title = "BP INSURANCE TRANSACTION SUMMARY PER BRANCH";
                    break;
                }
            case 'suminsd': {
                    $title = "INSURANCE TRANSACTION SUMMARY PER DAY";
                    break;
            }
            case 'bpsuminsd': {
                    $title = "BP INSURANCE TRANSACTION SUMMARY PER DAY";
                    break;
                }
            case 'sumwubbd':{
                    $title = "WU BUY BACK SUMMARY PER DAY";
                    break;
            }
            case 'bpsumwubbd': {
                    $title = "BP WU BUY BACK SUMMARY PER DAY";
                    break;
                }
            case 'sumwubbl':{
                    $title = "WU BUY BACK SUMMARY PER BRANCH";
                    break;
                }
            case 'bpsumwubbl': {
                    $title = "BP WU BUY BACK SUMMARY PER BRANCH";
                    break;
                }

            case 'mbbtbp': {
                    $title = "MONTHLY BP  BUY BACK TRANSACTIONS";
                    break;
                }
                
            case 'for_expenses': {
                    $title = "EXPENSES TRANSACTIONS";
                    break;
                }                

            case 'sales': {
                    $title = "SALES REPORT";
                    break;
                }
                
             case 'expd': {
                    $title = "BRANCH EXPENSES DETAILED REPORT";
                    break;
                }    

             case 'rptmcrate': {
                    $title = "MC RATE DETAILED REPORT";
                    break;
                }     
            case 'sumwubbfc': {
                $title = "WU BUY BACK FIRST CUSTOMER - SUMMARY";
                break;
            }  
            case 'detwubbfc': {
                $title = "WU BUY BACK FIRST CUSTOMER - DETAILED";
                break;
            }  
        }//switch
        if ($type == 'cpr') {
            $paramArray = array("trx_date" => date('Y-m-d', strtotime($datefrom)),
                "dateto" => date('Y-m-d', strtotime($dateto)),
                "location_id" => $locid,
                "user_id" => "0",
                "currency_id" =>  $currid,
                "bank_id" => 1); 
        }

        if ($type == 'sales') {
            $paramArray = array("trx_date" => date('Y-m-d', strtotime($datefrom)),
                "dateto" => date('Y-m-d', strtotime($dateto)),
                "location_id" => $locid,
                "user_id" => "0",
                "service_code" => $subrpt);
        }
        if ($type == 'locadj') {
            $paramArray = array("from" => date('Y-m-d', strtotime($datefrom)),
                "to" => date('Y-m-d', strtotime($dateto)),
                "location_id" => $locid,
                "expense_id" => "2");
        }
        if ($type == 'trxlogs') {
            $paramArray = array("location_id" => $locid,
                "user_id" => Session::get('userinfo')[0]['vuser_id'],
                "from" => date('Y-m-d', strtotime($datefrom)), 
                "to" => date('Y-m-d', strtotime($dateto)));
        }
        if ($type == 'wulogs') {
            $paramArray = array("client_code" => $agent, "trx_date" => date('Y-m-d', strtotime($datefrom)));
        }
        if ($type == 'wucomp') {
            $paramArray = array("year_month" => $yearmonth, "risk_type" => Input::get("risk_type"));
        }
        if ($type == 'compctr') {
            $paramArray = array("month_year" => $yearmonth);
        }
        if ($type == 'compstrd') {
            $paramArray = array("trx_date" => date('Y-m-d', strtotime($trxdate)));
        }
        if ($type == 'compstrm') {
            $paramArray = array("month_code" => $yearmonth);
        }
        if ($type == 'compstrw') {
            $paramArray = array("week_code" => $yearweek);
            //dd($paramArray);
        }
        if ($type == 'bpwubb') {
            $paramArray = array(
                "date_from" => $datefromNewFin,
                "date_to" => $datetoNewFin,
                "location_id" => $locid,
                "user_id" => $sesslocgrpid,
                "service_code" => "perapay");
        }
        if ($type == 'bpins') {
            $paramArray = array(
                "date_from" => $datefromNewFin,
                "date_to" => $datetoNewFin,
                "location_id" => $locid,
                "user_id" => $sesslocgrpid,
                "service_code" => "perapay");
        }
        if ($type == 'bpload') {
            $paramArray = array(
                "date_from" => $datefromNewFin,
                "date_to" => $datetoNewFin,
                "location_id" => $locid);
        }
        //--Created--by:ram--9/13/2018--
        if ($type == 'bpsumloadl' || $type == 'sumloadl') {
            if ($location_name != 'ALL') {
                $paramArray = array(
                    "date_from" => $datefromNewFin,
                    "date_to" => $datetoNewFin,
                    "type" => '1',
                    "param" => $locid);
            } else {
                if ($sessgrpid == 29 || $sessgrpid == 12 || $sessgrpid == 1) {
                    $paramArray = array(
                        "date_from" => $datefromNewFin,
                        "date_to" => $datetoNewFin,
                        "type" => '3',
                        "param" => "3");
                }// if user_grp_id == 29
                else if ($sessgrpid == 30 || $sessgrpid == 11) {
                    $paramArray = array(
                        "date_from" => $datefromNewFin,
                        "date_to" => $datetoNewFin,
                        "type" => '2',
                        "param" => $sesslocgrpid);
                }// if user_grp_id == 30
            }//else
        }// IF TYPE
        if ($type == 'bpsumloadd' || $type == 'sumloadd') {
            if ($location_name != 'ALL') {
                $paramArray = array(
                    "date_from" => $datefromNewFin,
                    "date_to" => $datetoNewFin,
                    "type" => '1',
                    "param" => $locid);
            }//if
            else {
                if ($sessgrpid == 29 || $sessgrpid == 12 || $sessgrpid == 1) {
                    $paramArray = array(
                        "date_from" => $datefromNewFin,
                        "date_to" => $datetoNewFin,
                        "location_id" => $locid,
                        "type" => '3',
                        "param" => "3");
                }// else if
                else if ($sessgrpid == 30 || $sessgrpid == 11) {
                    $paramArray = array(
                        "date_from" => $datefromNewFin,
                        "date_to" => $datetoNewFin,
                        "location_id" => $locid,
                        "type" => '2',
                        "param" => $sesslocgrpid);
                }//else if
            }//else
        }// IF TYPE     
        if ($type == 'bpsuminsl' || $type == 'suminsl') {
            if ($location_name != 'ALL') {
                $paramArray = array(
                    "date_from" => $datefromNewFin,
                    "date_to" => $datetoNewFin,
                    "type" => '1',
                    "param" => $locid);
            }//if
            else {
                if ($sessgrpid == 29 || $sessgrpid == 12 || $sessgrpid == 1) {
                    $paramArray = array(
                        "date_from" => $datefromNewFin,
                        "date_to" => $datetoNewFin,
                        "location_id" => $locid,
                        "type" => '3',
                        "param" => "3");
                }//else if
                else if ($sessgrpid == 30 || $sessgrpid == 11) {
                    $paramArray = array(
                        "date_from" => $datefromNewFin,
                        "date_to" => $datetoNewFin,
                        "location_id" => $locid,
                        "type" => '2',
                        "param" => $sesslocgrpid);
                }
            }//else
        }//IF TYPE
        if ($type == 'bpsuminsd' || $type == 'suminsd') {
            if ($location_name != 'ALL') {
                $paramArray = array(
                    "date_from" => $datefromNewFin,
                    "date_to" => $datetoNewFin,
                    "type" => '1',
                    "param" => $sessgrpid);
            } //if
            else {
                if ($sessgrpid == 29 || $sessgrpid == 12 || $sessgrpid == 1) {
                    $paramArray = array(
                        "date_from" => $datefromNewFin,
                        "date_to" => $datetoNewFin,
                        "type" => '3',
                        "param" => "3");
                }//else if
                else if ($sessgrpid == 30 || $sessgrpid == 11) {
                    $paramArray = array(
                        "date_from" => $datefromNewFin,
                        "date_to" => $datetoNewFin,
                        "type" => '2',
                        "param" => $sesslocgrpid);
                }// else if
            }//else
        }// IF TYPE
        if ($type == 'bpsumwubbd' || $type == 'sumwubbd') {
            if ($location_name != 'ALL') {
                $paramArray = array(
                    "date_from" => $datefromNewFin,
                    "date_to" => $datetoNewFin,
                    "type" => '1',
                    "param" => $locid);
            }//if
            else {
                if ($sessgrpid == 29 || $sessgrpid == 12 || $sessgrpid == 1) {
                    $paramArray = array(
                        "date_from" => $datefromNewFin,
                        "date_to" => $datetoNewFin,
                        "type" => '3',
                        "param" => "3");
                }//else if
                else if ($sessgrpid == 30 || $sessgrpid == 11) {
                    $paramArray = array(
                        "date_from" => $datefromNewFin,
                        "date_to" => $datetoNewFin,
                        "type" => '2',
                        "param" => $sesslocgrpid);
                }// else if
            }// else
        }// IF TYPE

        if ($type == 'bpsumwubbl' || $type == 'sumwubbl') {
            if ($location_name != 'ALL') {
                $paramArray = array(
                    "date_from" => $datefromNewFin,
                    "date_to" => $datetoNewFin,
                    "type" => '1',
                    "param" => $locid);
            }//if
            else {
                if ($sessgrpid == 29 || $sessgrpid == 12 || $sessgrpid == 1) {
                    $paramArray = array(
                        "date_from" => $datefromNewFin,
                        "date_to" => $datetoNewFin,
                        "type" => '3',
                        "param" => "3");
                } else if ($sessgrpid == 30 || $sessgrpid == 11) {
                    $paramArray = array(
                        "date_from" => $datefromNewFin,
                        "date_to" => $datetoNewFin,
                        "type" => '2',
                        "param" => $sesslocgrpid);
                }
            }//else
        }//IF TYPE 

        if ($type == 'mbbtbp') {
            $paramArray = array(
                "date_from" => $datefromNewFin,
                "date_to" => $datetoNewFin,
                "type" => '1',
                "month_rate" => $monthrate);
        }//if

        if ($type == 'expd') {
            if ($locid != 0) {
                $paramArray = array(
                    "date_from" => $datefromNewFin,
                    "date_to" => $datetoNewFin,
                    "type" => '1',
                    "param" => $locid,
                    "filter" => $category);
            } else {
                $paramArray = array(
                    "date_from" => $datefromNewFin,
                    "date_to" => $datetoNewFin,
                    "type" => '2',
                    "param" => 0,
                    "filter" => $category);
            }//else
        }//if      
        
        if ($type == 'rptmcrate') {
            if ($location_name != 'ALL') {
                $paramArray = array(
                    "date_from" => $datefromNewFin,
                    "date_to" => $datetoNewFin,
                    "type" => '1',
                    "param" => $locid);
            }//if
            else {
                if ($sessgrpid == 29 || $sessgrpid == 12 || $sessgrpid == 7 || $sessgrpid == 1) {
                    $paramArray = array(
                        "date_from" => $datefromNewFin,
                        "date_to" => $datetoNewFin,
                        "type" => '3',
                        "param" => "3");
                } else if ($sessgrpid == 30 || $sessgrpid == 11) {
                    $paramArray = array(
                        "date_from" => $datefromNewFin,
                        "date_to" => $datetoNewFin,
                        "type" => '2',
                        "param" => $sesslocgrpid);
                }
            }//else
        }
        
        if ($type == 'detwubbfc' || $type == 'sumwubbfc') {
            if ($location_name != 'ALL') {
                $paramArray = array(
                    "date_from" => $datefromNewFin,
                    "date_to" => $datetoNewFin,
                    "type" => '1',
                    "param" => $locid);
            }//if
            else {
                $paramArray = array(
                                    "date_from" => $datefromNewFin,
                                    "date_to" => $datetoNewFin,
                                    "type" => '2',
                                    "param" => '');
                
            }
        }
        
        if ($type === 'csreports') {
            $paramArray = array("remote_location_id" => Input::get("loc"), "fs_id" => Input::get("terminal"), "date_from" => date('Y-m-d', strtotime($datefrom)), "date_to" => date('Y-m-d', strtotime($dateto)));
        }
    else if($type != 'locadj' &&
            $type != 'trxlogs' &&
            $type != 'wulogs' &&
            $type != 'compctr' &&
            $type != 'compstrm' &&
            $type != 'compstrw' &&
            $type != 'compstrd' &&
            $type != 'cpr' &&
            $type != 'sales' &&
            $type != 'bpwubb' &&
            $type != 'bpins' &&
            $type != 'bpload' &&
            $type != 'bpsumloadl' &&
            $type != 'bpsumloadd' && 
            $type != 'bpsuminsl' && 
            $type != 'bpsuminsd' &&
            $type != 'bpsumwubbd'&&
            $type != 'bpsumwubbl' &&
            $type != 'sumloadl' &&
            $type != 'sumloadd' &&
            $type != 'suminsl' &&
            $type != 'suminsd' &&
            $type != 'sumwubbd' &&
            $type != 'sumwubbl' &&
            $type != 'expd' &&
            $type != 'rptmcrate' &&
            $type != 'detwubbfc' &&
            $type != 'sumwubbfc') {
            
        
            $paramArray = array("trx_date" => date('Y-m-d', strtotime($datefrom)),
                "dateto" => date('Y-m-d', strtotime($dateto)),
                "location_id" => $locid,
                "user_id" => "0");
        }
        $res = '';
        $res2 = '';
        switch ($type) {
            case 'wulogs': {
                    $result = WUGateway::createWUAPIRequest("wurpt", "wurpt", $paramArray, "WURPT", "WURPT-RQ-WUShowReports");
                    $file = json_decode($result, true);
                    break;
                }
            case 'wucomp': {
                    $result = WUGateway::createWUAPIRequest("wurpt", "compl", $paramArray, "WUCOMP", "WUCOMP-RQ-WUShowReports");
                    $file = json_decode($result, true);
                    break;
                }
            default : {
                    $hash = Func::createAPIRequestComplete("reports", $type, $paramArray);
                    $file = json_decode($hash, true);
                    $response = $file["apiuspresponse"]["header"]["errorcode"];
                    
                    break;
                }
        }
       // dd($file);
        switch ($type) {
            case 'dtrs':
            case 'cpr': {
                    try {
                        $res = $file['apiuspresponse']["body"][1];
                    } catch (Exception $e) {
                        $res = array();
                    }

                    try {
                        $res2 = $file['apiuspresponse']["body"][2];
                    } catch (Exception $e) {
                        $res2 = array();
                    }
                    break;
                }
            case 'wulogs': {
                    try {
                        $res = $file["uspwuapi"];
                    } catch (Exception $ex) {
                        $res = array();
                    }
                    break;
                }
            case 'wucomp': {
                    try {
                        $res = $file["uspwuapi"];
                    } catch (Exception $ex) {
                        $res = array();
                    }
                    break;
                }
            default: {
                    try {
                        $res = $file['apiuspresponse'];
                        $WUcount = count($file["apiuspresponse"]["body"]);
                    } catch (Exception $e) {
                        $res = array();
                    }
                    break;
                }
        }
       
        if ($type === 'trxlogs') {
            if (!File::exists(storage_path() . "/reports/")) {
                File::makeDirectory(storage_path() . "/reports/");
            }
            if (!File::exists(storage_path() . "/reports/USP/")) {
                File::makeDirectory(storage_path() . "/reports/USP/");
            }
            if (!File::exists(storage_path() . "/reports/USP/" . date('Ymd'))) {
                File::makeDirectory(storage_path() . "/reports/USP/" . date('Ymd'));
            }
            if (!File::exists(storage_path() . "/reports/USP/" . date('Ymd') . "/" . Session::get('userinfo')[0]['vuser_id'])) {
                File::makeDirectory(storage_path() . "/reports/USP/" . date('Ymd') . "/" . Session::get('userinfo')[0]['vuser_id']);
            }
            $datas = [];
            $net_POphp = 0;
            $net_POusd = 0;
            $net_SOphp = 0;
            $principal_POphp = 0;
            $principal_POusd = 0;
            $principal_SOphp = 0;
            array_push($datas, "MTCN,", "Trx Type,", "Location Name,", "Location Code,", "Transaction Date,", "Sender Name,", "Receiver Name,", "Principal Amount,", "Total Charges,", "Net Amount,", "Originating Country,", "Country Code Paid,", "Country Currency Paid,", "Operator ID,", "Terminal ID,", "Remote Terminal ID,", "Date Encoded\r\n");
            foreach ($file["apiuspresponse"]["body"] as $data) {
                $mtcn = substr($data["mtcn"], 1);
                $trxType = $data["wu_tran_type"];
                $locName = $data["location_name"];
                $locCode = $data["location_code"];
                $trxDate = $data["wu_trx_date"];
                $senderName = $data["wu_sender_name"];
                $payeeName = $data["wu_payee_name"];
                $principalAmt = $data["principal_amount"];
                $charges = $data["wu_total_charge"];
                $netAmt = $data["net_amount"];
                $origCountry = $data['wu_originating_country'];
                $countryPaid = $data['wu_country_code_paid'];
                $currPaid = $data["wu_country_currency_paid"];
                $operatorId = $data["wu_opid"];
                $wu_terminal_id = $data["wu_terminal_id"];
                $remot_terminal_id = $data["wu_remote_terminal_id"];
                $date_encoded = $data["date_encoded"];

                array_push($datas, $mtcn . ",", $trxType . ",", $locName . ",", $locCode . ",", $trxDate . ",", $senderName . ",", $payeeName . ",", $principalAmt . ",", $charges . ",", $netAmt . ",", $origCountry . ",", $countryPaid . ",", $currPaid . ",", $operatorId . ",", $wu_terminal_id . ",", $remot_terminal_id . ",", $date_encoded . ",\r\n");

                if ($data["wu_tran_type"] == "PO") {
                    if ($data["wu_country_currency_paid"] == "PHP") {
                        $net_POphp += $data["net_amount"];
                    } else {
                        $net_POusd += $data["net_amount"];
                    }
                } else {
                    $net_SOphp += $data["net_amount"];
                }
                if ($data["wu_tran_type"] == "PO") {
                    if ($data["wu_country_currency_paid"] == "PHP") {
                        $principal_POphp += $data["principal_amount"];
                    } else {
                        $principal_POusd += $data["principal_amount"];
                    }
                } else {
                    $principal_SOphp += $data["principal_amount"];
                }
            }
            array_push($datas, "Total Amount for SO (PHP),", ",", ",", ",", ",", ",", ",", $principal_SOphp . ",", ",", $net_SOphp . ",\r\n");
            array_push($datas, "Total Amount for PO (PHP),", ",", ",", ",", ",", ",", ",", $principal_POphp . ",", ",", $net_POphp . ",\r\n");
            array_push($datas, "Total Amount for PO (USD),", ",", ",", ",", ",", ",", ",", $principal_POusd . ",", ",", $net_POusd . ",\r\n");
            File::put(storage_path() . "/reports/USP/" . date('Ymd') . "/" . Session::get('userinfo')[0]['vuser_id'] . "/" . date('Ymd') . Session::get('userinfo')[0]['plocation_id'] . Session::get('userinfo')[0]['vuser_id'] . ".csv", $datas);
//            $path = storage_path() . "\\reports\\USP\\" . date('Ymd') . "\\" . Session::get('userinfo')[0]['vuser_id'] ."\\".date('Ymd').Session::get('userinfo')[0]['plocation_id'].Session::get('userinfo')[0]['vuser_id'].".csv";
            $path = storage_path() . "/reports/USP/" . date('Ymd') . "/" . Session::get('userinfo')[0]['vuser_id'] . "/" . date('Ymd') . Session::get('userinfo')[0]['plocation_id'] . Session::get('userinfo')[0]['vuser_id'] . ".csv";
            $WUcount = count($file["apiuspresponse"]["body"]);
        }

        if ($type === 'wulogs') {
            if (!File::exists(storage_path() . "/reports/")) {
                File::makeDirectory(storage_path() . "/reports/");
            }
            if (!File::exists(storage_path() . "/reports/" . $agent)) {
                File::makeDirectory(storage_path() . "/reports/" . $agent);
            }
            if (!File::exists(storage_path() . "/reports/" . $agent . "/" . date('Ymd'))) {
                File::makeDirectory(storage_path() . "/reports/" . $agent . "/" . date('Ymd'));
            }
            if (!File::exists(storage_path() . "/reports/" . $agent . "/" . date('Ymd') . "/" . Session::get('userinfo')[0]['vuser_id'])) {
                File::makeDirectory(storage_path() . "/reports/" . $agent . "/" . date('Ymd') . "/" . Session::get('userinfo')[0]['vuser_id']);
            }
            $reports = [];
            array_push($reports, "MTCN,", "Trx Type,", "Sender Name,", "Receiver Name,", "Principal Amount,", "FX Rate,", "Total Charges,", "Originating Country,", "Country Code Paid,", "Country Currency Paid,", "Net Amount,", "Operator ID,", "Terminal ID,", "Date Encoded\r\n");
            foreach ($file["uspwuapi"]["body"] as $data) {
                $mtcn = substr($data["mtcn"], 1);
                $trxType = $data["trx_type"];
                $senderName = $data["sender_first_name"] . " " . $data["sender_last_name"];
                $payeeName = $data["receiver_first_name"] . " " . $data["receiver_last_name"];
                $principalAmt = $data["real_principal_amount"];
                $rate = $data["exchange_rate"];
                $charges = $data["charges"] / 100;
                $origCountry = $data['originating_country_code'];
                $countryPaid = $data['destination_country_code'];
                $currPaid = $data["destination_currency_code"];
                $netAmt = $data["real_net_amount"];
                $operatorId = $data["operator_id"];
                $wu_terminal_id = $data["terminal_id"];
//                $date_encoded = $data["date_save"];
                $date_encoded = date('Y-m-d H:i', strtotime($data["date_save"]));
                $tabledata .= "<tr>" . "<td nowrap style='text-align: center;'>" . $mtcn . "</td>" .
                        "<td >" . $trxType . "</td>" .
                        "<td nowrap>" . $senderName . "</td>" .
                        "<td nowrap>" . $payeeName . "</td>" .
                        "<td>" . $principalAmt . "</td>" .
                        "<td>" . $rate . "</td>" .
                        "<td>" . $charges . "</td>" .
                        "<td style='text-align: center;'>" . $origCountry . "</td>" .
                        "<td style='text-align: center;'>" . $countryPaid . "</td>" .
                        "<td style='text-align: center;'>" . $currPaid . "</td>" .
                        "<td>" . $netAmt . "</td>" .
                        "<td style='text-align: center;'>" . $operatorId . "</td>" .
                        "<td>" . $wu_terminal_id . "</td>" .
                        "<td>" . $date_encoded . "</td>" .
                        "</tr>";
                array_push($reports, $mtcn . ",", $trxType . ",", $senderName . ",", $payeeName . ",", $principalAmt . ",", $rate . ",", $charges . ",", $origCountry . ",", $countryPaid . ",", $currPaid . ",", $netAmt . ",", $operatorId . ",", $wu_terminal_id . ",", $date_encoded . ",\r\n");
            }

            File::put(storage_path() . "/reports/" . $agent . "/" . date('Ymd') . "/" . Session::get('userinfo')[0]['vuser_id'] . "/" . date('Ymd') . Session::get('userinfo')[0]['plocation_id'] . Session::get('userinfo')[0]['vuser_id'] . ".csv", $reports);
//            $path = storage_path() . "\\reports\\" .Input::get("agent") ."\\". date('Ymd') . "\\" . Session::get('userinfo')[0]['vuser_id'] ."\\".date('Ymd').Session::get('userinfo')[0]['plocation_id'].Session::get('userinfo')[0]['vuser_id'].".csv";
            $path = storage_path() . "/reports/" . $agent . "/" . date('Ymd') . "/" . Session::get('userinfo')[0]['vuser_id'] . "/" . date('Ymd') . Session::get('userinfo')[0]['plocation_id'] . Session::get('userinfo')[0]['vuser_id'] . ".csv";
            $WUcount = count($file["uspwuapi"]["body"]);
        }


        if ($type === 'wucomp') {
            if (!File::exists(storage_path() . "/reports/")) {
                File::makeDirectory(storage_path() . "/reports/");
            }
            /*
              if (!File::exists(storage_path() . "/reports/". Input::get("agent"))) {
              File::makeDirectory(storage_path() . "/reports/".Input::get("agent"));
              }
              if (!File::exists(storage_path() . "/reports/".Input::get("agent") ."/".date('Ymd'))) {
              File::makeDirectory(storage_path() . "/reports/".Input::get("agent") ."/". date('Ymd'));
              }
              if (!File::exists(storage_path() . "/reports/".Input::get("agent") ."/".date('Ymd') . "/" . Session::get('userinfo')[0]['vuser_id'])) {
              File::makeDirectory(storage_path() . "/reports/".Input::get("agent") ."/". date('Ymd') . "/" . Session::get('userinfo')[0]['vuser_id']);
              }
             */
            $reports = [];
            array_push($reports, "customer_number,", "customer_name,total_peso,total_usd,dom_peso,int_peso,dom_count,int_count \r\n");

            foreach ($file["uspwuapi"]["body"] as $data) {
                $customer_number = $data["customer_number"];
                $customer_name = $data["customer_name"];
                $total_peso = $data["total_peso"];
                $total_usd = $data["total_usd"];
                $dom_count = $data["dom_count"];
                $int_count = $data['int_count'];
                $tabledata .= "<tr>" . "<td nowrap style='text-align: center;'>" . $customer_number . "</td>" .
                        "<td nowrap>" . $customer_name . "</td>" .
                        "<td>" . $total_peso . "</td>" .
                        "<td>" . $total_usd . "</td>" .
                        "<td>" . $dom_count . "</td>" .
                        "<td>" . $int_count . "</td>" .
                        "</tr>";
                array_push($reports, $customer_number . ",", $customer_name . ",", $total_peso . ",", $total_usd . ",", $dom_count . ",", $int_count . ",\r\n");
            }

            //File::put(storage_path() . "/reports/" .Input::get("agent") ."/". date('Ymd') . "/" . Session::get('userinfo')[0]['vuser_id'] ."/".date('Ymd').Session::get('userinfo')[0]['plocation_id'].Session::get('userinfo')[0]['vuser_id'].".csv",$reports);
//            $path = storage_path() . "\\reports\\" .Input::get("agent") ."\\". date('Ymd') . "\\" . Session::get('userinfo')[0]['vuser_id'] ."\\".date('Ymd').Session::get('userinfo')[0]['plocation_id'].Session::get('userinfo')[0]['vuser_id'].".csv";
            // $path = storage_path() . "/reports/" .Input::get("agent") ."/". date('Ymd') . "/" . Session::get('userinfo')[0]['vuser_id'] ."/".date('Ymd').Session::get('userinfo')[0]['plocation_id'].Session::get('userinfo')[0]['vuser_id'].".csv";
            $WUcount = count($file["uspwuapi"]["body"]);
        }

        if ($type === 'compctr') {
            $path_to_file = storage_path() . "/reports/compliance/" . date('Ymd') . "/" . Session::get('userinfo')[0]['plocation_id'];
            if (!File::exists(storage_path() . "/reports/")) {
                File::makeDirectory(storage_path() . "/reports/");
            }
            if (!File::exists(storage_path() . "/reports/compliance")) {
                File::makeDirectory(storage_path() . "/reports/compliance");
            }
            if (!File::exists(storage_path() . "/reports/compliance/" . date('Ymd'))) {
                File::makeDirectory(storage_path() . "/reports/compliance/" . date('Ymd'));
            }
            if (!File::exists($path_to_file)) {
                File::makeDirectory($path_to_file);
            }

            $reports = [];
            array_push($reports, "details,date_actual,amlc_code,row_number,mtcn,permanent_value1,php_amount,usd_amount,currency,purpose_transaction,date_processed,date_released,amount_released,permanent_value2,permanent_value3,location_name,location_brgy,location_city,location_province,coutnry_code,is_individual,sender_last_name,sender_first_name,sender_middle_name,sender_address,sender_birth_date,sender_birth_place,sender_birth_country,id_code,id_number,sender_contact_no,bene_detail,receiver_last_name,receiver_first_name,receiver_middle_name,receiver_address,receiver_birth_date,receiver_birth_place,receiver_birth_country,receiver_contact_no\r\n");

            foreach ($file["apiuspresponse"]["body"] as $data) {
                array_push($reports, $data["details"] . "," . date('Ymd', strtotime($data["date_actual"])) . "," . $data["amlc_code"] . "," . $data["row_number"] . "," . $data["mtcn"] . "," . $data["permanent_value1"] . "," . $data["php_amount"] . "," . $data["usd_amount"] . "," . $data["currency"] . "," . $data["purpose_transaction"] . "," . date('Ymd', strtotime($data["date_processed"])) . "," . date('Ymd', strtotime($data["date_released"])) . "," . $data["amount_released"] . "," . $data["permanent_value2"] . "," . $data["permanent_value3"] . "," . strtoupper($data["location_name"]) . "," . strtoupper($data["location_brgy"]) . "," . strtoupper($data["location_city"]) . "," . strtoupper($data["location_province"]) . "," . $data["coutnry_code"] . "," . $data["is_individual"] . "," . strtoupper($data["sender_last_name"]) . "," . strtoupper($data["sender_first_name"]) . "," . strtoupper($data["sender_middle_name"]) . "," . strtoupper($data["sender_address"]) . "," . $data["sender_birth_date"] . "," . strtoupper($data["sender_birth_place"]) . "," . strtoupper($data["sender_birth_country"]) . "," . strtoupper($data["id_code"]) . "," . $data["id_number"] . "," . $data["sender_contact_no"] . "," . $data["bene_detail"] . "," . strtoupper($data["receiver_last_name"]) . "," . strtoupper($data["receiver_first_name"]) . "," . strtoupper($data["receiver_middle_name"]) . "," . strtoupper($data["receiver_address"]) . "," . $data["receiver_birth_date"] . "," . strtoupper($data["receiver_birth_place"]) . "," . strtoupper($data["receiver_birth_country"]) . "," . $data["receiver_contact_no"] . ",\r\n");
            }

            $csv_filename = 'CTR--' . date('YmdHis') . '--' . Session::get('userinfo')[0]['vuser_id'] . ".csv";
            $path = $path_to_file . '/' . $csv_filename;
            File::put($path, $reports);

            $hash2 = Func::createAPIRequestComplete("reports", 'compctrsum', $paramArray);
            $fileSum = json_decode($hash2, true);

            foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                $product = 'Money Remittance';
                if ($data["product"] == '2') {
                    $product = 'Money Changing';
                }
                $tabledata .= "<tr>" . "<td>" . strtoupper($data["customer_name"]) . "</td>" .
                        "<td>" . $product . "</td>" .
                        "<td>" . date('F Y', strtotime($datefrom)) . "</td>" .
                        "<td>" . $data["trx_count"] . "</td>" .
                        "<td>" . number_format($data["php_amount"], 2, '.', ',') . "</td>" .
                        "<td>" . number_format($data["usd_amount"], 2, '.', ',') . "</td>" .
                        "</tr>";
            }

            $WUcount = count($fileSum["apiuspresponse"]["body"]);
        }

        if ($type === 'compstrd') {
            $datefrom = $trxdate;
            $path_to_file = storage_path() . "/reports/compliance/" . date('Ymd') . "/" . Session::get('userinfo')[0]['plocation_id'];
            if (!File::exists(storage_path() . "/reports/")) {
                File::makeDirectory(storage_path() . "/reports/");
            }
            if (!File::exists(storage_path() . "/reports/compliance")) {
                File::makeDirectory(storage_path() . "/reports/compliance");
            }
            if (!File::exists(storage_path() . "/reports/compliance/" . date('Ymd'))) {
                File::makeDirectory(storage_path() . "/reports/compliance/" . date('Ymd'));
            }
            if (!File::exists($path_to_file)) {
                File::makeDirectory($path_to_file);
            }

            $reports = [];
            array_push($reports, "details,date_actual,amlc_code,row_number,mtcn,permanent_value1,php_amount,usd_amount,currency,purpose_transaction,date_processed,date_released,amount_released,permanent_value2,permanent_value3,location_name,location_brgy,location_city,location_province,coutnry_code,is_individual,sender_last_name,sender_first_name,sender_middle_name,sender_address,sender_birth_date,sender_birth_place,sender_birth_country,id_code,id_number,sender_contact_no,bene_detail,receiver_last_name,receiver_first_name,receiver_middle_name,receiver_address,receiver_birth_date,receiver_birth_place,receiver_birth_country,receiver_contact_no\r\n");

            foreach ($file["apiuspresponse"]["body"] as $data) {
                array_push($reports, $data["details"] . "," . date('Ymd', strtotime($data["date_actual"])) . "," . $data["amlc_code"] . "," . $data["row_number"] . "," . $data["mtcn"] . "," . $data["permanent_value1"] . "," . $data["php_amount"] . "," . $data["usd_amount"] . "," . $data["currency"] . "," . $data["purpose_transaction"] . "," . date('Ymd', strtotime($data["date_processed"])) . "," . date('Ymd', strtotime($data["date_released"])) . "," . $data["amount_released"] . "," . $data["permanent_value2"] . "," . $data["permanent_value3"] . "," . strtoupper($data["location_name"]) . "," . strtoupper($data["location_brgy"]) . "," . strtoupper($data["location_city"]) . "," . strtoupper($data["location_province"]) . "," . $data["coutnry_code"] . "," . $data["is_individual"] . "," . strtoupper($data["sender_last_name"]) . "," . strtoupper($data["sender_first_name"]) . "," . strtoupper($data["sender_middle_name"]) . "," . strtoupper($data["sender_address"]) . "," . $data["sender_birth_date"] . "," . strtoupper($data["sender_birth_place"]) . "," . strtoupper($data["sender_birth_country"]) . "," . strtoupper($data["id_code"]) . "," . $data["id_number"] . "," . $data["sender_contact_no"] . "," . $data["bene_detail"] . "," . strtoupper($data["receiver_last_name"]) . "," . strtoupper($data["receiver_first_name"]) . "," . strtoupper($data["receiver_middle_name"]) . "," . strtoupper($data["receiver_address"]) . "," . $data["receiver_birth_date"] . "," . strtoupper($data["receiver_birth_place"]) . "," . strtoupper($data["receiver_birth_country"]) . "," . $data["receiver_contact_no"] . ",\r\n");
            }

            $csv_filename = 'STR DAILY--' . date('YmdHis') . '--' . Session::get('userinfo')[0]['vuser_id'] . ".csv";
            $path = $path_to_file . '/' . $csv_filename;
            File::put($path, $reports);

            $hash2 = Func::createAPIRequestComplete("reports", 'compstrdsum', $paramArray);
            $fileSum = json_decode($hash2, true);

            foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                $tabledata .= "<tr>" . "<td>" . strtoupper($data["customer_name"]) . "</td>" .
                        "<td>" . date('Y-m-d', strtotime($data["trx_date"])) . "</td>" .
                        "<td>" . $data["trx_count"] . "</td>" .
                        "<td>" . number_format($data["php_amount"], 2, '.', ',') . "</td>" .
                        "<td>" . number_format($data["usd_amount"], 2, '.', ',') . "</td>" .
                        "<td>" . $data["country"] . "</td>" .
                        "</tr>";
            }

            $WUcount = count($fileSum["apiuspresponse"]["body"]);
        }

        if ($type === 'compstrm') {
            $path_to_file = storage_path() . "/reports/compliance/" . date('Ymd') . "/" . Session::get('userinfo')[0]['plocation_id'];
            if (!File::exists(storage_path() . "/reports/")) {
                File::makeDirectory(storage_path() . "/reports/");
            }
            if (!File::exists(storage_path() . "/reports/compliance")) {
                File::makeDirectory(storage_path() . "/reports/compliance");
            }
            if (!File::exists(storage_path() . "/reports/compliance/" . date('Ymd'))) {
                File::makeDirectory(storage_path() . "/reports/compliance/" . date('Ymd'));
            }
            if (!File::exists($path_to_file)) {
                File::makeDirectory($path_to_file);
            }

            $reports = [];
            array_push($reports, "details,date_actual,amlc_code,row_number,mtcn,permanent_value1,php_amount,usd_amount,currency,purpose_transaction,date_processed,date_released,amount_released,permanent_value2,permanent_value3,location_name,location_brgy,location_city,location_province,coutnry_code,is_individual,sender_last_name,sender_first_name,sender_middle_name,sender_address,sender_birth_date,sender_birth_place,sender_birth_country,id_code,id_number,sender_contact_no,bene_detail,receiver_last_name,receiver_first_name,receiver_middle_name,receiver_address,receiver_birth_date,receiver_birth_place,receiver_birth_country,receiver_contact_no\r\n");

            foreach ($file["apiuspresponse"]["body"] as $data) {
                array_push($reports, $data["details"] . "," . date('Ymd', strtotime($data["date_actual"])) . "," . $data["amlc_code"] . "," . $data["row_number"] . "," . $data["mtcn"] . "," . $data["permanent_value1"] . "," . $data["php_amount"] . "," . $data["usd_amount"] . "," . $data["currency"] . "," . $data["purpose_transaction"] . "," . date('Ymd', strtotime($data["date_processed"])) . "," . date('Ymd', strtotime($data["date_released"])) . "," . $data["amount_released"] . "," . $data["permanent_value2"] . "," . $data["permanent_value3"] . "," . strtoupper($data["location_name"]) . "," . strtoupper($data["location_brgy"]) . "," . strtoupper($data["location_city"]) . "," . strtoupper($data["location_province"]) . "," . $data["coutnry_code"] . "," . $data["is_individual"] . "," . strtoupper($data["sender_last_name"]) . "," . strtoupper($data["sender_first_name"]) . "," . strtoupper($data["sender_middle_name"]) . "," . strtoupper($data["sender_address"]) . "," . $data["sender_birth_date"] . "," . strtoupper($data["sender_birth_place"]) . "," . strtoupper($data["sender_birth_country"]) . "," . strtoupper($data["id_code"]) . "," . $data["id_number"] . "," . $data["sender_contact_no"] . "," . $data["bene_detail"] . "," . strtoupper($data["receiver_last_name"]) . "," . strtoupper($data["receiver_first_name"]) . "," . strtoupper($data["receiver_middle_name"]) . "," . strtoupper($data["receiver_address"]) . "," . $data["receiver_birth_date"] . "," . strtoupper($data["receiver_birth_place"]) . "," . strtoupper($data["receiver_birth_country"]) . "," . $data["receiver_contact_no"] . ",\r\n");
            }

            $csv_filename = 'STR Monthly--' . date('YmdHis') . '--' . Session::get('userinfo')[0]['vuser_id'] . ".csv";
            $path = $path_to_file . '/' . $csv_filename;
            File::put($path, $reports);

            $hash2 = Func::createAPIRequestComplete("reports", 'compstrmsum', $paramArray);
            $fileSum = json_decode($hash2, true);

            foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                $tabledata .= "<tr>" . "<td>" . strtoupper($data["customer_name"]) . "</td>" .
                        "<td>" . date('F Y', strtotime($datefrom)) . "</td>" .
                        "<td>" . $data["trx_count"] . "</td>" .
                        "<td>" . number_format($data["php_amount"], 2, '.', ',') . "</td>" .
                        "<td>" . number_format($data["usd_amount"], 2, '.', ',') . "</td>" .
                        "</tr>";
            }

            $WUcount = count($fileSum["apiuspresponse"]["body"]);
        }

        if ($type === 'compstrw') {
            $path_to_file = storage_path() . "/reports/compliance/" . date('Ymd') . "/" . Session::get('userinfo')[0]['plocation_id'];
            if (!File::exists(storage_path() . "/reports/")) {
                File::makeDirectory(storage_path() . "/reports/");
            }
            if (!File::exists(storage_path() . "/reports/compliance")) {
                File::makeDirectory(storage_path() . "/reports/compliance");
            }
            if (!File::exists(storage_path() . "/reports/compliance/" . date('Ymd'))) {
                File::makeDirectory(storage_path() . "/reports/compliance/" . date('Ymd'));
            }
            if (!File::exists($path_to_file)) {
                File::makeDirectory($path_to_file);
            }

            $reports = [];
            array_push($reports, "details,date_actual,amlc_code,row_number,mtcn,permanent_value1,php_amount,usd_amount,currency,purpose_transaction,date_processed,date_released,amount_released,permanent_value2,permanent_value3,location_name,location_brgy,location_city,location_province,coutnry_code,is_individual,sender_last_name,sender_first_name,sender_middle_name,sender_address,sender_birth_date,sender_birth_place,sender_birth_country,id_code,id_number,sender_contact_no,bene_detail,receiver_last_name,receiver_first_name,receiver_middle_name,receiver_address,receiver_birth_date,receiver_birth_place,receiver_birth_country,receiver_contact_no\r\n");
            //dd($file);
            foreach ($file["apiuspresponse"]["body"] as $data) {
                array_push($reports, "," . date('Ymd', strtotime($data["date_actual"])) . "," . $data["amlc_code"] . "," . $data["row_number"] . "," . $data["mtcn"] . "," . $data["permanent_value1"] . "," . $data["php_amount"] . "," . $data["usd_amount"] . "," . $data["currency"] . "," . $data["purpose_transaction"] . "," . date('Ymd', strtotime($data["date_processed"])) . "," . date('Ymd', strtotime($data["date_released"])) . "," . $data["amount_released"] . "," . $data["permanent_value2"] . "," . $data["permanent_value3"] . "," . strtoupper($data["location_name"]) . "," . strtoupper($data["location_brgy"]) . "," . strtoupper($data["location_city"]) . "," . strtoupper($data["location_province"]) . "," . $data["coutnry_code"] . "," . $data["is_individual"] . "," . strtoupper($data["sender_last_name"]) . "," . strtoupper($data["sender_first_name"]) . "," . strtoupper($data["sender_middle_name"]) . "," . strtoupper($data["sender_address"]) . "," . $data["sender_birth_date"] . "," . strtoupper($data["sender_birth_place"]) . "," . strtoupper($data["sender_birth_country"]) . "," . strtoupper($data["id_code"]) . "," . $data["id_number"] . "," . $data["sender_contact_no"] . "," . $data["bene_detail"] . "," . strtoupper($data["receiver_last_name"]) . "," . strtoupper($data["receiver_first_name"]) . "," . strtoupper($data["receiver_middle_name"]) . "," . strtoupper($data["receiver_address"]) . "," . $data["receiver_birth_date"] . "," . strtoupper($data["receiver_birth_place"]) . "," . strtoupper($data["receiver_birth_country"]) . "," . $data["receiver_contact_no"] . ",\r\n");
            }

            $csv_filename = 'STR Weekly--' . date('YmdHis') . '--' . Session::get('userinfo')[0]['vuser_id'] . ".csv";
            $path = $path_to_file . '/' . $csv_filename;
            File::put($path, $reports);
            
            //dd($paramArray);
            $hash2 = Func::createAPIRequestComplete("reports", 'compstrwsum', $paramArray);
            //dd($hash2);
            $fileSum = json_decode($hash2, true);
            foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                $tabledata .= "<tr>" . "<td>" . strtoupper($data["customer_name"]) . "</td>" .
                        "<td>" . Input::get('wkname') . "</td>" .
                        "<td>" . $data["trx_count"] . "</td>" .
                        "<td>" . number_format($data["php_amount"], 2, '.', ',') . "</td>" .
                        "<td>" . number_format($data["usd_amount"], 2, '.', ',') . "</td>" .
                        "</tr>";
            }

            $WUcount = count($fileSum["apiuspresponse"]["body"]);
            $datefrom = Input::get('wkname');
        }
        //----------CREATED BY: RAM 9/6/18-------------
        if ($type === 'bpwubb') {
            $path_to_file = storage_path() . "/reports/compliance/" . date('Ymd') . "/" . Session::get('userinfo')[0]['plocation_id'];
            if (!File::exists(storage_path() . "/reports/")) {
                File::makeDirectory(storage_path() . "/reports/");
            }
            if (!File::exists(storage_path() . "/reports/compliance")) {
                File::makeDirectory(storage_path() . "/reports/compliance");
            }
            if (!File::exists(storage_path() . "/reports/compliance/" . date('Ymd'))) {
                File::makeDirectory(storage_path() . "/reports/compliance/" . date('Ymd'));
            }
            if (!File::exists($path_to_file)) {
                File::makeDirectory($path_to_file);
            }
            $reports = [];
            array_push($reports, "trx_date,wu_mtcn,wu_payee_name,wu_sender_name,principal_amount,mc_rate,buy_back,revenue\r\n");
            foreach ($file["apiuspresponse"]["body"] as $data) {

                array_push($reports, "," . date('Ymd', strtotime($data["trx_date"])) . "," . $data["wu_mtcn"] . "," . $data["wu_payee_name"] . "," . $data["wu_sender_name"] . "," . $data["principal_amount"] . "," . $data["mc_rate"] . "," . $data["buy_back"] . "," . $data["revenue"] . ",\r\n");
                //array_push($reports,$trx_date.",",$wu_mtcn.",",$wu_payee_name.",",$wu_sender_name.",", $principal_amount.",", $mc_rate.",",$buy_back.",", $revenue.",\r\n");
            }
            $csv_filename = 'BPWUBB--' . date('YmdHis') . '--' . Session::get('userinfo')[0]['vuser_id'] . ".csv";
            $path = $path_to_file . '/' . $csv_filename;
            File::put($path, $reports);

            $hash2 = Func::createAPIRequestComplete("reports", 'bpwubb', $paramArray);
           
            $fileSum = json_decode($hash2, true);
            $response = $fileSum["apiuspresponse"]["header"]["errorcode"];
            //dd($fileSum);
            foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                $tabledata .= "<tr>" . "<td>" . strtoupper($data["trx_date"]) . "</td>" .
                        "<td>" . $data["wu_mtcn"] . "</td>" .
                        "<td>" . $data["wu_payee_name"] . "</td>" .
                        "<td>" . $data["wu_sender_name"] . "</td>" .
                        "<td>" . number_format($data["principal_amount"], 2, '.', ',') . "</td>" .
                        "<td>" . number_format($data["mc_rate"]) . "</td>" .
                        "<td>" . number_format($data["buy_back"], 2, '.', ',') . "</td>" .
                        "<td>" . number_format($data["revenue"], 2, '.', ',') . "</td>" .
                        "</tr>";
            }
            $WUcount = count($fileSum["apiuspresponse"]["body"]);
        }

        if ($type === 'bpins') {
            $path_to_file = storage_path() . "/reports/compliance/" . date('Ymd') . "/" . Session::get('userinfo')[0]['plocation_id'];
            if (!File::exists(storage_path() . "/reports/")) {
                File::makeDirectory(storage_path() . "/reports/");
            }
            if (!File::exists(storage_path() . "/reports/compliance")) {
                File::makeDirectory(storage_path() . "/reports/compliance");
            }
            if (!File::exists(storage_path() . "/reports/compliance/" . date('Ymd'))) {
                File::makeDirectory(storage_path() . "/reports/compliance/" . date('Ymd'));
            }
            if (!File::exists($path_to_file)) {
                File::makeDirectory($path_to_file);
            }

            $reports = [];
            array_push($reports, "trx_date,coc_number,customer_name,beneficiary,coverage_count,amount,revenue\r\n");

            foreach ($file["apiuspresponse"]["body"] as $data) {
                $trx_date = date('Ymd', strtotime($data["trx_date"]));
                $coc_number = $data["coc_number"];
                $customer_name = $data["customer_name"];
                $beneficiary = $data["beneficiary"];
                $coverage_count = $data["coverage_count"];
                $amount = $data["amount"];
                $revenue = $data["revenue"];

                array_push($reports, $trx_date . ",", $coc_number . ",", $customer_name . ",", $beneficiary . ",", $coverage_count . ",", $amount . ",", $revenue . ",\r\n");
            }
            $csv_filename = 'STR Weekly--' . date('YmdHis') . '--' . Session::get('userinfo')[0]['vuser_id'] . ".csv";
            $path = $path_to_file . '/' . $csv_filename;
            File::put($path, $reports);

            $hash2 = Func::createAPIRequestComplete("reports", 'bpins', $paramArray);
            $fileSum = json_decode($hash2, true);
            $response = $fileSum["apiuspresponse"]["header"]["errorcode"];
            foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                $tabledata .= "<tr>" . "<td>" . strtoupper($data["trx_date"]) . "</td>" .
                        "<td>" . $data["coc_number"] . "</td>" .
                        "<td>" . $data["customer_name"] . "</td>" .
                        "<td>" . $data["beneficiary"] . "</td>" .
                        "<td>" . $data["coverage_count"] . "</td>" .
                        "<td>" . number_format($data["amount"]) . "</td>" .
                        "<td>" . number_format($data["revenue"], 2, '.', ',') . "</td>" .
                        "</tr>";
            }
            $WUcount = count($fileSum["apiuspresponse"]["body"]);
        }

        if ($type === 'bpload') {
            $path_to_file = storage_path() . "/reports/compliance/" . date('Ymd') . "/" . Session::get('userinfo')[0]['plocation_id'];
            if (!File::exists(storage_path() . "/reports/")) {
                File::makeDirectory(storage_path() . "/reports/");
            }
            if (!File::exists(storage_path() . "/reports/compliance")) {
                File::makeDirectory(storage_path() . "/reports/compliance");
            }
            if (!File::exists(storage_path() . "/reports/compliance/" . date('Ymd'))) {
                File::makeDirectory(storage_path() . "/reports/compliance/" . date('Ymd'));
            }
            if (!File::exists($path_to_file)) {
                File::makeDirectory($path_to_file);
            }

            $reports = [];
            array_push($reports, "trx_date,customer_number,provider,product_code,amount,comission,revenue,rebate\r\n");
            foreach ($file["apiuspresponse"]["body"] as $data) {
                $trx_date = date('Ymd', strtotime($data["trx_date"]));
                $customer_number = $data["customer_number"];
                $provider = $data["provider"];
                $product_code = $data["product_code"];
                $amount = $data["amount"];
                $comission = $data["comission"];
                $revenue = $data["revenue"];
                $rebate = $data["rebate"];

                array_push($reports, $trx_date . ",", $customer_number . ",", $provider . ",", $product_code . ",", $amount . ",", $comission . ",", $revenue . ",", $rebate . "\r\n");
            }
            $csv_filename = 'STR Weekly--' . date('YmdHis') . '--' . Session::get('userinfo')[0]['vuser_id'] . ".csv";
            $path = $path_to_file . '/' . $csv_filename;
            File::put($path, $reports);

            $hash2 = Func::createAPIRequestComplete("reports", 'bpload', $paramArray);
            $fileSum = json_decode($hash2, true);
            $response = $fileSum["apiuspresponse"]["header"]["errorcode"];
            foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                $tabledata .= "<tr>" . "<td>" . strtoupper($data["trx_date"]) . "</td>" .
                        "<td>" . $data["customer_number"] . "</td>" .
                        "<td>" . $data["provider"] . "</td>" .
                        "<td>" . $data["product_code"] . "</td>" .
                        "<td>" . number_format($data["amount"]) . "</td>" .
                        "<td>" . number_format($data["comission"]) . "</td>" .
                        "<td>" . number_format($data["revenue"], 2, '.', ',') . "</td>" .
                        "<td>" . number_format($data["rebate"], 2, '.', ',') . "</td>" .
                        "</tr>";
            }
            $WUcount = count($fileSum["apiuspresponse"]["body"]);
        }

        if ($type === 'bpsumloadl' || $type === 'sumloadl') {
            $path_to_file = storage_path() . "/reports/compliance/" . date('Ymd') . "/" . Session::get('userinfo')[0]['plocation_id'];
            if (!File::exists(storage_path() . "/reports/")) {
                File::makeDirectory(storage_path() . "/reports/");
            }
            if (!File::exists(storage_path() . "/reports/compliance")) {
                File::makeDirectory(storage_path() . "/reports/compliance");
            }
            if (!File::exists(storage_path() . "/reports/compliance/" . date('Ymd'))) {
                File::makeDirectory(storage_path() . "/reports/compliance/" . date('Ymd'));
            }
            if (!File::exists($path_to_file)) {
                File::makeDirectory($path_to_file);
            }

            if (
                    ($locid != 0 && $type == 'bpsumloadl' && $sessgrpid != 29) &&
                    ($locid != 0 && $type == 'bpsumloadl' && $sessgrpid != 12) &&
                    ($locid != 0 && $type == 'bpsumloadl' && $sessgrpid != 1)) {
                $reports = [];
                array_push($reports, "location_name,trx_count,load_amount,revenue\r\n");
                foreach ($file["apiuspresponse"]["body"] as $data) {
                    // $trx_date = date('Ymd',strtotime($data["trx_date"]));
                    $location_name = $data["location_name"];
                    $trx_count = $data["trx_count"];
                    $load_amount = $data["load_amount"];
                    $revenue = $data["revenue"];

                    array_push($reports, $location_name . ",", $trx_count . ",", $load_amount . ",", $revenue . "\r\n");
                }//foreach 
            }//if type == bpsumloadl
            else if (
                    ($locid == 0 && $type == 'bpsumloadl' && $sessgrpid != 29) &&
                    ($locid == 0 && $type == 'bpsumloadl' && $sessgrpid != 12) &&
                    ($locid == 0 && $type == 'bpsumloadl' && $sessgrpid != 1)) {
                $reports = [];
                array_push($reports, "location_name,trx_count,load_amount,revenue\r\n");
                foreach ($file["apiuspresponse"]["body"] as $data) {
                    // $trx_date = date('Ymd',strtotime($data["trx_date"]));
                    $location_name = $data["location_name"];
                    $trx_count = $data["trx_count"];
                    $load_amount = $data["load_amount"];
                    $revenue = $data["revenue"];

                    array_push($reports, $location_name . ",", $trx_count . ",", $load_amount . ",", $revenue . "\r\n");
                }//foreach 
            }//if type == bpsumloadl            
            else if (
                    ($sessgrpid == 29 && $type == 'bpsumloadl' && $locid == 0) ||
                    ($sessgrpid == 12 && $type == 'bpsumloadl' && $locid == 0) ||
                    ( $sessgrpid == 1 && $type == 'bpsumloadl' && $locid == 0)) {
                $reports = [];
                array_push($reports, "location_name,trx_count,load_amount,comission,revenue\r\n");
                foreach ($file["apiuspresponse"]["body"] as $data) {
                    // $trx_date = date('Ymd',strtotime($data["trx_date"]));
                    $location_name = $data["location_name"];
                    $trx_count = $data["trx_count"];
                    $load_amount = $data["load_amount"];
                    $comission = $data["comission"];
                    $revenue = $data["revenue"];

                    array_push($reports, $location_name . ",", $trx_count . ",", $load_amount . ",", $comission . ",", $revenue . "\r\n");
                }//foreach
            }//if
            else if (
                    ($sessgrpid == 29 && $type == 'bpsumloadl' && $locid != 0) ||
                    ($sessgrpid == 12 && $type == 'bpsumloadl' && $locid != 0) ||
                    ( $sessgrpid == 1 && $type == 'bpsumloadl' && $locid != 0)) {
                $reports = [];
                array_push($reports, "location_name,trx_count,load_amount,comission,revenue\r\n");
                foreach ($file["apiuspresponse"]["body"] as $data) {
                    // $trx_date = date('Ymd',strtotime($data["trx_date"]));
                    $location_name = $data["location_name"];
                    $trx_count = $data["trx_count"];
                    $load_amount = $data["load_amount"];
                    $comission = $data["rebate"];
                    $revenue = $data["revenue"];

                    array_push($reports, $location_name . ",", $trx_count . ",", $load_amount . ",", $comission . ",", $revenue . "\r\n");
                }//foreach
            }//if            
            else {
                $reports = [];
                array_push($reports, "location_name,trx_count,load_amount,comission,revenue\r\n");
                foreach ($file["apiuspresponse"]["body"] as $data) {
                    // $trx_date = date('Ymd',strtotime($data["trx_date"]));
                    $location_name = $data["location_name"];
                    $trx_count = $data["trx_count"];
                    $load_amount = $data["load_amount"];
                    $rebate = $data["comission"];
                    $revenue = $data["revenue"];

                    array_push($reports, $location_name . ",", $trx_count . ",", $load_amount . ",", $rebate . ",", $revenue . "\r\n");
                }//foreach
            }//else

            $csv_filename = 'STR Weekly--' . date('YmdHis') . '--' . Session::get('userinfo')[0]['vuser_id'] . ".csv";
            $path = $path_to_file . '/' . $csv_filename;
            File::put($path, $reports);

            if ($type == 'bpsumloadl') {
                $hash2 = Func::createAPIRequestComplete("reports", 'bpsumloadl', $paramArray);
            }//if 
            else {
                $hash2 = Func::createAPIRequestComplete("reports", 'sumloadl', $paramArray);
            }//else

            $fileSum = json_decode($hash2, true);
            $response = $fileSum["apiuspresponse"]["header"]["errorcode"];

            if (
                    ($locid == 0 && $type == 'bpsumloadl' && $sessgrpid != 29) &&
                    ($locid == 0 && $type == 'bpsumloadl' && $sessgrpid != 12) &&
                    ($locid == 0 && $type == 'bpsumloadl' && $sessgrpid != 1)) {
                foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                    $tabledata .= "<tr>" . "<td>" . strtoupper($data["location_name"]) . "</td>" .
                            "<td>" . number_format($data["trx_count"]) . "</td>" .
                            "<td>" . number_format($data["load_amount"]) . "</td>" .
                            "<td>" . number_format($data["revenue"], 2, '.', ',') . "</td>" .
                            "</tr>";
                }//foreach
            }//if
            else if (
                    ($locid != 0 && $type == 'bpsumloadl' && $sessgrpid != 29) &&
                    ($locid != 0 && $type == 'bpsumloadl' && $sessgrpid != 12) &&
                    ($locid != 0 && $type == 'bpsumloadl' && $sessgrpid != 1)) {
                foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                    $tabledata .= "<tr>" . "<td>" . strtoupper($data["location_name"]) . "</td>" .
                            "<td>" . number_format($data["trx_count"]) . "</td>" .
                            "<td>" . number_format($data["load_amount"]) . "</td>" .
                            "<td>" . number_format($data["revenue"], 2, '.', ',') . "</td>" .
                            "</tr>";
                }//foreach
            }//if            
            else if (
                    ($locid == 0 && $type == 'bpsumloadl' && $sessgrpid == 29) ||
                    ($locid == 0 && $type == 'bpsumloadl' && $sessgrpid == 12) ||
                    ($locid == 0 && $type == 'bpsumloadl' && $sessgrpid == 1)) {
                foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                    $tabledata .= "<tr>" . "<td>" . strtoupper($data["location_name"]) . "</td>" .
                            "<td>" . number_format($data["trx_count"]) . "</td>" .
                            "<td>" . number_format($data["load_amount"]) . "</td>" .
                            "<td>" . number_format($data["comission"], 2, '.', ',') . "</td>" .
                            "<td>" . number_format($data["revenue"], 2, '.', ',') . "</td>" .
                            "</tr>";
                }//foreach
            }//if    
            else if (
                    ($locid != 0 && $type == 'bpsumloadl' && $sessgrpid == 29) ||
                    ($locid != 0 && $type == 'bpsumloadl' && $sessgrpid == 12) ||
                    ($locid != 0 && $type == 'bpsumloadl' && $sessgrpid == 1)) {
                foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                    $tabledata .= "<tr>" . "<td>" . strtoupper($data["location_name"]) . "</td>" .
                            "<td>" . number_format($data["trx_count"]) . "</td>" .
                            "<td>" . number_format($data["load_amount"]) . "</td>" .
                            "<td>" . number_format($data["rebate"], 2, '.', ',') . "</td>" .
                            "<td>" . number_format($data["revenue"], 2, '.', ',') . "</td>" .
                            "</tr>";
                }//foreach
            }//if                
//                        
//            
            else {
                foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                    $tabledata .= "<tr>" . "<td>" . strtoupper($data["location_name"]) . "</td>" .
                            "<td>" . number_format($data["trx_count"]) . "</td>" .
                            "<td>" . number_format($data["load_amount"]) . "</td>" .
                            "<td>" . number_format($data["comission"], 2, '.', ',') . "</td>" .
                            "<td>" . number_format($data["revenue"], 2, '.', ',') . "</td>" .
                            "</tr>";
                }//foreach
            }//else   
            $WUcount = count($fileSum["apiuspresponse"]["body"]);
        }//if

        if ($type == 'bpsumloadd' || $type == 'sumloadd') {
            $path_to_file = storage_path() . "/reports/compliance/" . date('Ymd') . "/" . Session::get('userinfo')[0]['plocation_id'];
            if (!File::exists(storage_path() . "/reports/")) {
                File::makeDirectory(storage_path() . "/reports/");
            }
            if (!File::exists(storage_path() . "/reports/compliance")) {
                File::makeDirectory(storage_path() . "/reports/compliance");
            }
            if (!File::exists(storage_path() . "/reports/compliance/" . date('Ymd'))) {
                File::makeDirectory(storage_path() . "/reports/compliance/" . date('Ymd'));
            }
            if (!File::exists($path_to_file)) {
                File::makeDirectory($path_to_file);
            }

            if (
                    ($location_name == 'ALL' && $type == 'bpsumloadd' && $sessgrpid != 29) &&
                    ($location_name == 'ALL' && $type == 'bpsumloadd' && $sessgrpid != 12) &&
                    ($location_name == 'ALL' && $type == 'bpsumloadd' && $sessgrpid != 1)) {
                $reports = [];
                array_push($reports, "trx_date,trx_count,load_amount,rebate,revenue\r\n");
                foreach ($file["apiuspresponse"]["body"] as $data) {
                    $trx_date = date('Ymd', strtotime($data["trx_date"]));
                    $trx_count = $data["trx_count"];
                    $load_amount = $data["load_amount"];
                    $rebate = $data["rebate"];
                    $revenue = $data["revenue"];

                    array_push($reports, $location_name . ",", $trx_count . ",", $load_amount . ",", $rebate . ",", $revenue . "\r\n");
                }//foreach
            }//if
            else if (
                    ($location_name != 'ALL' && $type == 'bpsumloadd' && $sessgrpid != 29) &&
                    ($location_name != 'ALL' && $type == 'bpsumloadd' && $sessgrpid != 12) &&
                    ($location_name != 'ALL' && $type == 'bpsumloadd' && $sessgrpid != 1)) {
                $reports = [];
                array_push($reports, "trx_date,trx_count,load_amount,rebate,revenue\r\n");
                foreach ($file["apiuspresponse"]["body"] as $data) {
                    $trx_date = date('Ymd', strtotime($data["trx_date"]));
                    $trx_count = $data["trx_count"];
                    $load_amount = $data["load_amount"];
                    $rebate = $data["rebate"];
                    $revenue = $data["revenue"];

                    array_push($reports, $location_name . ",", $trx_count . ",", $load_amount . ",", $rebate . ",", $revenue . "\r\n");
                }//foreach
            }//if            
            else if (
                    ($location_name == 'ALL' && $type == 'bpsumloadd' && $sessgrpid == 29) ||
                    ($location_name == 'ALL' && $type == 'bpsumloadd' && $sessgrpid == 12) ||
                    ($location_name == 'ALL' && $type == 'bpsumloadd' && $sessgrpid == 1)) {
                $reports = [];
                array_push($reports, "trx_date,trx_count,load_amount,comission,revenue\r\n");
                foreach ($file["apiuspresponse"]["body"] as $data) {
                    $trx_date = date('Ymd', strtotime($data["trx_date"]));
                    $trx_count = $data["trx_count"];
                    $load_amount = $data["load_amount"];
                    $comission = $data["comission"];
                    $revenue = $data["revenue"];

                    array_push($reports, $location_name . ",", $trx_count . ",", $load_amount . ",", $comission . ",", $revenue . "\r\n");
                }//foreach
            }//if
            else if (($location_name != 'ALL' && $type == 'bpsumloadd' && $sessgrpid == 29) ||
                    ($location_name != 'ALL' && $type == 'bpsumloadd' && $sessgrpid == 12) ||
                    ($location_name != 'ALL' && $type == 'bpsumloadd' && $sessgrpid == 1)) {
                $reports = [];
                array_push($reports, "trx_date,trx_count,load_amount,comission,revenue\r\n");
                foreach ($file["apiuspresponse"]["body"] as $data) {
                    $trx_date = date('Ymd', strtotime($data["trx_date"]));
                    $trx_count = $data["trx_count"];
                    $load_amount = $data["load_amount"];
                    $comission = $data["rebate"];
                    $revenue = $data["revenue"];

                    array_push($reports, $location_name . ",", $trx_count . ",", $load_amount . ",", $comission . ",", $revenue . "\r\n");
                }//foreach
            }//if           
            else {
                $reports = [];
                array_push($reports, "trx_date,trx_count,load_amount,comission,revenue\r\n");
                foreach ($file["apiuspresponse"]["body"] as $data) {
                    $trx_date = date('Ymd', strtotime($data["trx_date"]));
                    $trx_count = $data["trx_count"];
                    $load_amount = $data["load_amount"];
                    $rebate = $data["comission"];
                    $revenue = $data["revenue"];

                    array_push($reports, $location_name . ",", $trx_count . ",", $load_amount . ",", $rebate . ",", $revenue . "\r\n");
                }//foreach
            }//else

            $csv_filename = 'STR Weekly--' . date('YmdHis') . '--' . Session::get('userinfo')[0]['vuser_id'] . ".csv";
            $path = $path_to_file . '/' . $csv_filename;
            File::put($path, $reports);

            if ($type == 'bpsumloadd') {
                $hash2 = Func::createAPIRequestComplete("reports", 'bpsumloadd', $paramArray);
            }//if
            else {
                $hash2 = Func::createAPIRequestComplete("reports", 'sumloadd', $paramArray);
            }//else

            $fileSum = json_decode($hash2, true);
            $response = $fileSum["apiuspresponse"]["header"]["errorcode"];

            if (
                    ($location_name == 'ALL' && $type == 'bpsumloadd' && $sessgrpid != 29) &&
                    ($location_name == 'ALL' && $type == 'bpsumloadd' && $sessgrpid != 12) &&
                    ($location_name == 'ALL' && $type == 'bpsumloadd' && $sessgrpid != 1)) {
                foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                    $tabledata .= "<tr>" . "<td>" . strtoupper($data["trx_date"]) . "</td>" .
                            "<td>" . number_format($data["trx_count"]) . "</td>" .
                            "<td>" . number_format($data["load_amount"]) . "</td>" .
                            "<td>" . number_format($data["rebate"], 2, '.', ',') . "</td>" .
                            "<td>" . number_format($data["revenue"], 2, '.', ',') . "</td>" .
                            "</tr>";
                }//foreach
            }//if
            else if (
                    ($location_name != 'ALL' && $type == 'bpsumloadd' && $sessgrpid != 29) &&
                    ($location_name != 'ALL' && $type == 'bpsumloadd' && $sessgrpid != 12) &&
                    ($location_name != 'ALL' && $type == 'bpsumloadd' && $sessgrpid != 1)) {
                foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                    $tabledata .= "<tr>" . "<td>" . strtoupper($data["trx_date"]) . "</td>" .
                            "<td>" . number_format($data["trx_count"]) . "</td>" .
                            "<td>" . number_format($data["load_amount"]) . "</td>" .
                            "<td>" . number_format($data["rebate"], 2, '.', ',') . "</td>" .
                            "<td>" . number_format($data["revenue"], 2, '.', ',') . "</td>" .
                            "</tr>";
                }//foreach
            }//if            
            else if (
                    ($location_name == 'ALL' && $type == 'bpsumloadd' && $sessgrpid == 29) ||
                    ($location_name == 'ALL' && $type == 'bpsumloadd' && $sessgrpid == 12) ||
                    ($location_name == 'ALL' && $type == 'bpsumloadd' && $sessgrpid == 1)) {
                foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                    $tabledata .= "<tr>" . "<td>" . strtoupper($data["trx_date"]) . "</td>" .
                            "<td>" . number_format($data["trx_count"]) . "</td>" .
                            "<td>" . number_format($data["load_amount"]) . "</td>" .
                            "<td>" . number_format($data["comission"], 2, '.', ',') . "</td>" .
                            "<td>" . number_format($data["revenue"], 2, '.', ',') . "</td>" .
                            "</tr>";
                }//foreach
            }//if      
            else if (
                    ($location_name != 'ALL' && $type == 'bpsumloadd' && $sessgrpid == 29) ||
                    ($location_name != 'ALL' && $type == 'bpsumloadd' && $sessgrpid == 12) ||
                    ($location_name != 'ALL' && $type == 'bpsumloadd' && $sessgrpid == 1)) {
                foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                    $tabledata .= "<tr>" . "<td>" . strtoupper($data["trx_date"]) . "</td>" .
                            "<td>" . number_format($data["trx_count"]) . "</td>" .
                            "<td>" . number_format($data["load_amount"]) . "</td>" .
                            "<td>" . number_format($data["rebate"], 2, '.', ',') . "</td>" .
                            "<td>" . number_format($data["revenue"], 2, '.', ',') . "</td>" .
                            "</tr>";
                }//foreach
            }//if                 
            else {
                foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                    $tabledata .= "<tr>" . "<td>" . strtoupper($data["trx_date"]) . "</td>" .
                            "<td>" . number_format($data["trx_count"]) . "</td>" .
                            "<td>" . number_format($data["load_amount"]) . "</td>" .
                            "<td>" . number_format($data["comission"], 2, '.', ',') . "</td>" .
                            "<td>" . number_format($data["revenue"], 2, '.', ',') . "</td>" .
                            "</tr>";
                }//foreach           
            }//else

            $WUcount = count($fileSum["apiuspresponse"]["body"]);
        }//if    

        if ($type === 'bpsuminsl' || $type === 'suminsl') {
            $path_to_file = storage_path() . "/reports/compliance/" . date('Ymd') . "/" . Session::get('userinfo')[0]['plocation_id'];
            if (!File::exists(storage_path() . "/reports/")) {
                File::makeDirectory(storage_path() . "/reports/");
            }
            if (!File::exists(storage_path() . "/reports/compliance")) {
                File::makeDirectory(storage_path() . "/reports/compliance");
            }
            if (!File::exists(storage_path() . "/reports/compliance/" . date('Ymd'))) {
                File::makeDirectory(storage_path() . "/reports/compliance/" . date('Ymd'));
            }
            if (!File::exists($path_to_file)) {
                File::makeDirectory($path_to_file);
            }

            if (
                    ($locid != 0 && $type == 'bpsuminsl' && $sessgrpid != 29) ||
                    ($locid != 0 && $type == 'bpsuminsl' && $sessgrpid != 12) ||
                    ($locid != 0 && $type == 'bpsuminsl' && $sessgrpid != 1)) {
                $reports = [];
                array_push($reports, "location_name,trx_count,coverage_count,amount,revenue\r\n");
                foreach ($file["apiuspresponse"]["body"] as $data) {
                    //$trx_date = date('Ymd',strtotime($data["trx_date"]));

                    $location_name = $data["location_name"];
                    $trx_count = $data["trx_count"];
                    $coverage_count = $data["coverage_count"];
                    $amount = $data["amount"];
                    $revenue = $data["revenue"];

                    array_push($reports, $location_name . ",", $trx_count . ",", $coverage_count . ",", $amount . ",", $revenue . "\r\n");
                }
            } else if (
                    ($locid == 0 && $type == 'bpsuminsl' && $sessgrpid != 29) ||
                    ($locid == 0 && $type == 'bpsuminsl' && $sessgrpid != 12) ||
                    ($locid == 0 && $type == 'bpsuminsl' && $sessgrpid != 1)) {
                $reports = [];
                array_push($reports, "location_name,trx_count,coverage_count,amount,revenue\r\n");
                foreach ($file["apiuspresponse"]["body"] as $data) {
                    //$trx_date = date('Ymd',strtotime($data["trx_date"]));

                    $location_name = $data["location_name"];
                    $trx_count = $data["trx_count"];
                    $coverage_count = $data["coverage_count"];
                    $amount = $data["amount"];
                    $revenue = $data["revenue"];

                    array_push($reports, $location_name . ",", $trx_count . ",", $coverage_count . ",", $amount . ",", $revenue . "\r\n");
                }
            } else if (
                    ($locid == 0 && $type == 'bpsuminsl' && $sessgrpid == 29) ||
                    ($locid == 0 && $type == 'bpsuminsl' && $sessgrpid == 12) ||
                    ($locid == 0 && $type == 'bpsuminsl' && $sessgrpid == 1)) {
                $reports = [];
                array_push($reports, "location_name,trx_count,coverage_count,revenue\r\n");
                foreach ($file["apiuspresponse"]["body"] as $data) {
                    //$trx_date = date('Ymd',strtotime($data["trx_date"]));

                    $location_name = $data["location_name"];
                    $trx_count = $data["trx_count"];
                    $coverage_count = $data["coverage_count"];
                    $amount = $data["amount"];
                    $revenue = $data["revenue"];

                    array_push($reports, $location_name . ",", $trx_count . ",", $coverage_count . ",", $a . ",", $revenue . "\r\n");
                }
            } else if (
                    ($locid != 0 && $type == 'bpsuminsl' && $sessgrpid == 29 ) ||
                    ($locid != 0 && $type == 'bpsuminsl' && $sessgrpid == 12) ||
                    ($locid != 0 && $type == 'bpsuminsl' && $sessgrpid == 1)) {
                $reports = [];
                array_push($reports, "location_name,trx_count,coverage_count,revenue\r\n");
                foreach ($file["apiuspresponse"]["body"] as $data) {
                    //$trx_date = date('Ymd',strtotime($data["trx_date"]));

                    $location_name = $data["location_name"];
                    $trx_count = $data["trx_count"];
                    $coverage_count = $data["coverage_count"];
                    $revenue = $data["revenue"];

                    array_push($reports, $location_name . ",", $trx_count . ",", $coverage_count . ",", $revenue . "\r\n");
                }
            } else {
                $reports = [];
                array_push($reports, "location_name,trx_count,coverage_count,amount\r\n");
                foreach ($file["apiuspresponse"]["body"] as $data) {
                    //$trx_date = date('Ymd',strtotime($data["trx_date"]));

                    $location_name = $data["location_name"];
                    $trx_count = $data["trx_count"];
                    $coverage_count = $data["coverage_count"];
                    $amount = $data["amount"];


                    array_push($reports, $location_name . ",", $trx_count . ",", $coverage_count . ",", $amount . "\r\n");
                }//foreach
            }//else

            $csv_filename = 'STR Weekly--' . date('YmdHis') . '--' . Session::get('userinfo')[0]['vuser_id'] . ".csv";
            $path = $path_to_file . '/' . $csv_filename;
            File::put($path, $reports);

            if ($type == 'bpsuminsl') {
                $hash2 = Func::createAPIRequestComplete("reports", 'bpsuminsl', $paramArray);
            } else {
                $hash2 = Func::createAPIRequestComplete("reports", 'suminsl', $paramArray);
            }

            $fileSum = json_decode($hash2, true);
            $response = $fileSum["apiuspresponse"]["header"]["errorcode"];

            if (
                    ($locid == 0 && $type == 'bpsuminsl' && $sessgrpid != 29) ||
                    ($locid == 0 && $type == 'bpsuminsl' && $sessgrpid != 12) ||
                    ($locid == 0 && $type == 'bpsuminsl' && $sessgrpid != 1)) {
                foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                    $tabledata .= "<tr>" . "<td>" . strtoupper($data["location_name"]) . "</td>" .
                            "<td>" . number_format($data["trx_count"]) . "</td>" .
                            "<td>" . number_format($data["coverage_count"]) . "</td>" .
                            "<td>" . number_format($data["amount"], 2, '.', ',') . "</td>" .
                            "<td>" . number_format($data["revenue"], 2, '.', ',') . "</td>" .
                            "</tr>";
                }
            } else if (
                    ($locid != 0 && $type == 'bpsuminsl' && $sessgrpid != 29) ||
                    ($locid != 0 && $type == 'bpsuminsl' && $sessgrpid != 12) ||
                    ($locid != 0 && $type == 'bpsuminsl' && $sessgrpid != 1)) {
                foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                    $tabledata .= "<tr>" . "<td>" . strtoupper($data["location_name"]) . "</td>" .
                            "<td>" . number_format($data["trx_count"]) . "</td>" .
                            "<td>" . number_format($data["coverage_count"]) . "</td>" .
                            "<td>" . number_format($data["amount"], 2, '.', ',') . "</td>" .
                            "<td>" . number_format($data["revenue"], 2, '.', ',') . "</td>" .
                            "</tr>";
                }
            } else if (
                    ($locid == 0 && $type == 'bpsuminsl' && $sessgrpid == 29) ||
                    ($locid == 0 && $type == 'bpsuminsl' && $sessgrpid == 12) ||
                    ($locid == 0 && $type == 'bpsuminsl' && $sessgrpid == 1)) {
                foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                    $tabledata .= "<tr>" . "<td>" . strtoupper($data["location_name"]) . "</td>" .
                            "<td>" . number_format($data["trx_count"]) . "</td>" .
                            "<td>" . number_format($data["coverage_count"]) . "</td>" .
                            "<td>" . number_format($data["revenue"], 2, '.', ',') . "</td>" .
                            "</tr>";
                }
            } else if (
                    ($locid != 0 && $type == 'bpsuminsl' && $sessgrpid == 29) ||
                    ($locid != 0 && $type == 'bpsuminsl' && $sessgrpid == 12) ||
                    ($locid != 0 && $type == 'bpsuminsl' && $sessgrpid == 1)) {
                foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                    $tabledata .= "<tr>" . "<td>" . strtoupper($data["location_name"]) . "</td>" .
                            "<td>" . number_format($data["trx_count"]) . "</td>" .
                            "<td>" . number_format($data["coverage_count"]) . "</td>" .
                            "<td>" . number_format($data["revenue"], 2, '.', ',') . "</td>" .
                            "</tr>";
                }
            } else {
                foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                    $tabledata .= "<tr>" . "<td>" . strtoupper($data["location_name"]) . "</td>" .
                            "<td>" . number_format($data["trx_count"]) . "</td>" .
                            "<td>" . number_format($data["coverage_count"]) . "</td>" .
                            "<td>" . number_format($data["amount"], 2, '.', ',') . "</td>" .
                            "</tr>";
                }
            }

            $WUcount = count($fileSum["apiuspresponse"]["body"]);
        }
        if ($type === 'bpsuminsd' || $type === 'suminsd') {
            $path_to_file = storage_path() . "/reports/compliance/" . date('Ymd') . "/" . Session::get('userinfo')[0]['plocation_id'];
            if (!File::exists(storage_path() . "/reports/")) {
                File::makeDirectory(storage_path() . "/reports/");
            }
            if (!File::exists(storage_path() . "/reports/compliance")) {
                File::makeDirectory(storage_path() . "/reports/compliance");
            }
            if (!File::exists(storage_path() . "/reports/compliance/" . date('Ymd'))) {
                File::makeDirectory(storage_path() . "/reports/compliance/" . date('Ymd'));
            }
            if (!File::exists($path_to_file)) {
                File::makeDirectory($path_to_file);
            }

            if (
                    ($locid != 0 && $type == 'bpsuminsd' && $sessgrpid == 29) &&
                    ($locid != 0 && $type == 'bpsuminsd' && $sessgrpid == 12) &&
                    ($locid != 0 && $type == 'bpsuminsd' && $sessgrpid == 1)) {
                $reports = [];
                array_push($reports, "location_name,trx_count,coverage_count,amount,revenue\r\n");
                foreach ($file["apiuspresponse"]["body"] as $data) {
                    //$trx_date = date('Ymd',strtotime($data["trx_date"]));

                    $trx_date = $data["trx_date"];
                    $trx_count = $data["trx_count"];
                    $coverage_count = $data["coverage_count"];
                    $amount = $data["amount"];
                    $revenue = $data["revenue"];

                    array_push($reports, $trx_date . ",", $trx_count . ",", $coverage_count . ",", $amount . ",", $revenue . "\r\n");
                }
            }

//
            else if (
                    ($locid == 0 && $type == 'bpsuminsd' && $sessgrpid == 29) &&
                    ($locid == 0 && $type == 'bpsuminsd' && $sessgrpid == 12) &&
                    ($locid == 0 && $type == 'bpsuminsd' && $sessgrpid == 1)) {
                $reports = [];
                array_push($reports, "location_name,trx_count,coverage_count,amount,revenue\r\n");
                foreach ($file["apiuspresponse"]["body"] as $data) {
                    //$trx_date = date('Ymd',strtotime($data["trx_date"]));

                    $trx_date = $data["trx_date"];
                    $trx_count = $data["trx_count"];
                    $coverage_count = $data["coverage_count"];
                    $amount = $data["amount"];
                    $revenue = $data["revenue"];

                    array_push($reports, $trx_date . ",", $trx_count . ",", $coverage_count . ",", $amount . ",", $revenue . "\r\n");
                }
            }
//            
            else if (
                    ($locid == 0 && $type == 'bpsuminsd' && $sessgrpid != 29) &&
                    ($locid == 0 && $type == 'bpsuminsd' && $sessgrpid != 12) &&
                    ($locid == 0 && $type == 'bpsuminsd' && $sessgrpid != 1)) {
                $reports = [];
                array_push($reports, "location_name,trx_count,coverage_count,revenue\r\n");
                foreach ($file["apiuspresponse"]["body"] as $data) {
                    //$trx_date = date('Ymd',strtotime($data["trx_date"]));

                    $trx_date = $data["trx_date"];
                    $trx_count = $data["trx_count"];
                    $coverage_count = $data["coverage_count"];
                    $revenue = $data["revenue"];

                    array_push($reports, $trx_date . ",", $trx_count . ",", $coverage_count . ",", $revenue . "\r\n");
                }
            }//if     
            else if (
                    ($locid != 0 && $type == 'bpsuminsd' && $sessgrpid != 29) &&
                    ($locid != 0 && $type == 'bpsuminsd' && $sessgrpid != 12) &&
                    ($locid != 0 && $type == 'bpsuminsd' && $sessgrpid != 1)) {
                $reports = [];
                array_push($reports, "location_name,trx_count,coverage_count,revenue\r\n");
                foreach ($file["apiuspresponse"]["body"] as $data) {
                    //$trx_date = date('Ymd',strtotime($data["trx_date"]));

                    $trx_date = $data["trx_date"];
                    $trx_count = $data["trx_count"];
                    $coverage_count = $data["coverage_count"];
                    $revenue = $data["revenue"];

                    array_push($reports, $trx_date . ",", $trx_count . ",", $coverage_count . ",", $revenue . "\r\n");
                }
            }//if               
            else {
                $reports = [];
                array_push($reports, "location_name,trx_count,coverage_count,amount,\r\n");
                foreach ($file["apiuspresponse"]["body"] as $data) {
                    //$trx_date = date('Ymd',strtotime($data["trx_date"]));

                    $trx_date = $data["trx_date"];
                    $trx_count = $data["trx_count"];
                    $coverage_count = $data["coverage_count"];
                    $amount = $data["amount"];

                    array_push($reports, $trx_date . ",", $trx_count . ",", $coverage_count . ",", $amount . "\r\n");
                }
            }

            $csv_filename = 'STR Weekly--' . date('YmdHis') . '--' . Session::get('userinfo')[0]['vuser_id'] . ".csv";
            $path = $path_to_file . '/' . $csv_filename;
            File::put($path, $reports);

            if ($type == 'bpsuminsd') {
                $hash2 = Func::createAPIRequestComplete("reports", 'bpsuminsd', $paramArray);
            } else {
                $hash2 = Func::createAPIRequestComplete("reports", 'suminsd', $paramArray);
            }
            $fileSum = json_decode($hash2, true);
            $response = $fileSum["apiuspresponse"]["header"]["errorcode"];

            if (
                    ( $locid != 0 && $type == 'bpsuminsd' && $sessgrpid != 29) &&
                    ($locid != 0 && $type == 'bpsuminsd' && $sessgrpid != 12) &&
                    ($locid != 0 && $type == 'bpsuminsd' && $sessgrpid != 1)) {
                foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                    $tabledata .= "<tr>" . "<td>" . strtoupper($data["trx_date"]) . "</td>" .
                            "<td>" . number_format($data["trx_count"]) . "</td>" .
                            "<td>" . number_format($data["coverage_count"]) . "</td>" .
                            "<td>" . number_format($data["amount"], 2, '.', ',') . "</td>" .
                            "<td>" . number_format($data["revenue"], 2, '.', ',') . "</td>" .
                            "</tr>";
                }
            } else if (
                    ( $locid == 0 && $type == 'bpsuminsd' && $sessgrpid != 29) &&
                    ($locid == 0 && $type == 'bpsuminsd' && $sessgrpid != 12) &&
                    ($locid == 0 && $type == 'bpsuminsd' && $sessgrpid != 1)) {
                foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                    $tabledata .= "<tr>" . "<td>" . strtoupper($data["trx_date"]) . "</td>" .
                            "<td>" . number_format($data["trx_count"]) . "</td>" .
                            "<td>" . number_format($data["coverage_count"]) . "</td>" .
                            "<td>" . number_format($data["amount"], 2, '.', ',') . "</td>" .
                            "<td>" . number_format($data["revenue"], 2, '.', ',') . "</td>" .
                            "</tr>";
                }
            } else if (
                    ($locid != 0 && $type == 'bpsuminsd' && $sessgrpid == 29) ||
                    ($locid != 0 && $type == 'bpsuminsd' && $sessgrpid == 12) ||
                    ($locid != 0 && $type == 'bpsuminsd' && $sessgrpid == 1)) {
                foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                    $tabledata .= "<tr>" . "<td>" . strtoupper($data["trx_date"]) . "</td>" .
                            "<td>" . number_format($data["trx_count"]) . "</td>" .
                            "<td>" . number_format($data["coverage_count"]) . "</td>" .
                            "<td>" . number_format($data["revenue"], 2, '.', ',') . "</td>" .
                            "</tr>";
                }
            } else if (
                    ($locid == 0 && $type == 'bpsuminsd' && $sessgrpid == 29) ||
                    ($locid == 0 && $type == 'bpsuminsd' && $sessgrpid == 12) ||
                    ($locid == 0 && $type == 'bpsuminsd' && $sessgrpid == 1)) {
                foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                    $tabledata .= "<tr>" . "<td>" . strtoupper($data["trx_date"]) . "</td>" .
                            "<td>" . number_format($data["trx_count"]) . "</td>" .
                            "<td>" . number_format($data["coverage_count"]) . "</td>" .
                            "<td>" . number_format($data["amount"], 2, '.', ',') . "</td>" .
                            "<td>" . number_format($data["revenue"], 2, '.', ',') . "</td>" .
                            "</tr>";
                }
            } else {
                foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                    $tabledata .= "<tr>" . "<td>" . strtoupper($data["trx_date"]) . "</td>" .
                            "<td>" . number_format($data["trx_count"]) . "</td>" .
                            "<td>" . number_format($data["coverage_count"]) . "</td>" .
                            "<td>" . number_format($data["amount"], 2, '.', ',') . "</td>" .
                            "</tr>";
                }
            }

            $WUcount = count($fileSum["apiuspresponse"]["body"]);
        }

        if ($type === 'bpsumwubbd' || $type === 'sumwubbd') {
            $path_to_file = storage_path() . "/reports/compliance/" . date('Ymd') . "/" . Session::get('userinfo')[0]['plocation_id'];
            if (!File::exists(storage_path() . "/reports/")) {
                File::makeDirectory(storage_path() . "/reports/");
            }
            if (!File::exists(storage_path() . "/reports/compliance")) {
                File::makeDirectory(storage_path() . "/reports/compliance");
            }
            if (!File::exists(storage_path() . "/reports/compliance/" . date('Ymd'))) {
                File::makeDirectory(storage_path() . "/reports/compliance/" . date('Ymd'));
            }
            if (!File::exists($path_to_file)) {
                File::makeDirectory($path_to_file);
            }

            if (
                    ($locid == 0 && $type == 'bpsumwubbd' && $sessgrpid != 29) &&
                    ($locid == 0 && $type == 'bpsumwubbd' && $sessgrpid != 12) &&
                    ($locid == 0 && $type == 'bpsumwubbd' && $sessgrpid != 1)) {
                $reports = [];
                array_push($reports, "trx_date,trx_count,,revenue\r\n");
                foreach ($file["apiuspresponse"]["body"] as $data) {
                    //$trx_date = date('Ymd',strtotime($data["trx_date"]));

                    $trx_date = $data["trx_date"];
                    $trx_count = $data["trx_count"];
                    $revenue = $data["revenue"];

                    array_push($reports, $trx_date . ",", $trx_count . ",", $revenue . "\r\n");
                }
            }//if
            else if (
                    ($locid != 0 && $type == 'bpsumwubbd' && $sessgrpid != 29) &&
                    ($locid != 0 && $type == 'bpsumwubbd' && $sessgrpid != 12) &&
                    ($locid != 0 && $type == 'bpsumwubbd' && $sessgrpid != 1)) {
                $reports = [];
                array_push($reports, "trx_date,trx_count,,revenue\r\n");
                foreach ($file["apiuspresponse"]["body"] as $data) {
                    //$trx_date = date('Ymd',strtotime($data["trx_date"]));

                    $trx_date = $data["trx_date"];
                    $trx_count = $data["trx_count"];
                    $revenue = $data["revenue"];

                    array_push($reports, $trx_date . ",", $trx_count . ",", $revenue . "\r\n");
                }
            }//if            
            else if (
                    ($locid == 0 && $type == 'bpsumwubbd' && $sessgrpid == 29) ||
                    ($locid == 0 && $type == 'bpsumwubbd' && $sessgrpid == 12) ||
                    ($locid == 0 && $type == 'bpsumwubbd' && $sessgrpid == 1)) {
                $reports = [];
                array_push($reports, "trx_date,trx_count,usd_buy_back,php_buy_back,revenue\r\n");
                foreach ($file["apiuspresponse"]["body"] as $data) {
                    //$trx_date = date('Ymd',strtotime($data["trx_date"]));

                    $trx_date = $data["trx_date"];
                    $trx_count = $data["trx_count"];
                    $usd_buy_back = $data["usd_buy_back"];
                    $php_buy_back = $data["php_buy_back"];
                    $revenue = $data["revenue"];

                    array_push($reports, $trx_date . ",", $trx_count . ",", $php_buy_back . ",", $usd_buy_back . ",", $revenue . "\r\n");
                }
            } else if (
                    ($locid != 0 && $type == 'bpsumwubbd' && $sessgrpid == 29) ||
                    ($locid != 0 && $type == 'bpsumwubbd' && $sessgrpid == 12) ||
                    ($locid != 0 && $type == 'bpsumwubbd' && $sessgrpid == 1)) {
                $reports = [];
                array_push($reports, "trx_date,trx_count,usd_buy_back,revenue\r\n");
                foreach ($file["apiuspresponse"]["body"] as $data) {
                    //$trx_date = date('Ymd',strtotime($data["trx_date"]));

                    $trx_date = $data["trx_date"];
                    $trx_count = $data["trx_count"];
                    $usd_buy_back = $data["usd_buy_back"];

                    $revenue = $data["revenue"];

                    array_push($reports, $trx_date . ",", $trx_count . ",", $usd_buy_back . ",", $revenue . "\r\n");
                }
            } else {
                $reports = [];
                array_push($reports, "trx_date,trx_count,revenue\r\n");
                foreach ($file["apiuspresponse"]["body"] as $data) {
                    //$trx_date = date('Ymd',strtotime($data["trx_date"]));

                    $trx_date = $data["trx_date"];
                    $trx_count = $data["trx_count"];
                    $usd_buy_back = $data["usd_buy_back"];
                    $php_buy_back = $data["php_buy_back"];

                    array_push($reports, $trx_date . ",", $trx_count . ",", $usd_buy_back . ",", $php_buy_back . "\r\n");
                }
            }

            $csv_filename = 'STR Weekly--' . date('YmdHis') . '--' . Session::get('userinfo')[0]['vuser_id'] . ".csv";
            $path = $path_to_file . '/' . $csv_filename;
            File::put($path, $reports);

            if ($type == 'bpsumwubbd') {
                $hash2 = Func::createAPIRequestComplete("reports", 'bpsumwubbd', $paramArray);
            } else {
                $hash2 = Func::createAPIRequestComplete("reports", 'sumwubbd', $paramArray);
            }

            $fileSum = json_decode($hash2, true);
            $response = $fileSum["apiuspresponse"]["header"]["errorcode"];

            if (
                    ($locid == 0 && $type == 'bpsumwubbd' && $sessgrpid != 29) &&
                    ($locid == 0 && $type == 'bpsumwubbd' && $sessgrpid != 12) &&
                    ($locid == 0 && $type == 'bpsumwubbd' && $sessgrpid != 1)) {
                foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                    $tabledata .= "<tr>" . "<td>" . strtoupper($data["trx_date"]) . "</td>" .
                            "<td>" . number_format($data["trx_count"]) . "</td>" .
                            "<td>" . number_format($data["usd_buy_back"]) . "</td>" .
                            "<td>" . number_format($data["php_buy_back"]) . "</td>" .
                            "<td>" . number_format($data["revenue"], 2, '.', ',') . "</td>" .
                            "</tr>";
                }
            } else if (
                    ($locid != 0 && $type == 'bpsumwubbd' && $sessgrpid != 29) &&
                    ($locid != 0 && $type == 'bpsumwubbd' && $sessgrpid != 12) &&
                    ($locid != 0 && $type == 'bpsumwubbd' && $sessgrpid != 1)) {
                foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                    $tabledata .= "<tr>" . "<td>" . strtoupper($data["trx_date"]) . "</td>" .
                            "<td>" . number_format($data["trx_count"]) . "</td>" .
                            "<td>" . number_format($data["usd_buy_back"]) . "</td>" .
                            "<td>" . number_format($data["php_buy_back"]) . "</td>" .
                            "<td>" . number_format($data["revenue"], 2, '.', ',') . "</td>" .
                            "</tr>";
                }
            } else if (
                    ($locid == 0 && $type == 'bpsumwubbd' && $sessgrpid == 29) ||
                    ($locid == 0 && $type == 'bpsumwubbd' && $sessgrpid == 12) ||
                    ($locid == 0 && $type == 'bpsumwubbd' && $sessgrpid == 1)) {
                foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                    $tabledata .= "<tr>" . "<td>" . strtoupper($data["trx_date"]) . "</td>" .
                            "<td>" . number_format($data["trx_count"]) . "</td>" .
                            "<td>" . number_format($data["usd_buy_back"]) . "</td>" .
                            "<td>" . number_format($data["php_buy_back"]) . "</td>" .
                            "<td>" . number_format($data["revenue"], 2, '.', ',') . "</td>" .
                            "</tr>";
                }
            } else if (
                    ($locid != 0 && $type == 'bpsumwubbd' && $sessgrpid == 29) ||
                    ($locid != 0 && $type == 'bpsumwubbd' && $sessgrpid == 12) ||
                    ($locid != 0 && $type == 'bpsumwubbd' && $sessgrpid == 1)) {
                foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                    $tabledata .= "<tr>" . "<td>" . strtoupper($data["trx_date"]) . "</td>" .
                            "<td>" . number_format($data["trx_count"]) . "</td>" .
                            "<td>" . number_format($data["usd_buy_back"]) . "</td>" .
                            "<td>" . number_format($data["revenue"], 2, '.', ',') . "</td>" .
                            "</tr>";
                }
            } else {
                foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                    $tabledata .= "<tr>" . "<td>" . strtoupper($data["trx_date"]) . "</td>" .
                            "<td>" . number_format($data["trx_count"]) . "</td>" .
                            "<td>" . number_format($data["usd_buy_back"]) . "</td>" .
                            "<td>" . number_format($data["php_buy_back"]) . "</td>" .
                            "</tr>";
                }
            }
            $WUcount = count($fileSum["apiuspresponse"]["body"]);
        }
        if ($type === 'bpsumwubbl' || $type === 'sumwubbl') {
            $path_to_file = storage_path() . "/reports/compliance/" . date('Ymd') . "/" . Session::get('userinfo')[0]['plocation_id'];
            if (!File::exists(storage_path() . "/reports/")) {
                File::makeDirectory(storage_path() . "/reports/");
            }
            if (!File::exists(storage_path() . "/reports/compliance")) {
                File::makeDirectory(storage_path() . "/reports/compliance");
            }
            if (!File::exists(storage_path() . "/reports/compliance/" . date('Ymd'))) {
                File::makeDirectory(storage_path() . "/reports/compliance/" . date('Ymd'));
            }
            if (!File::exists($path_to_file)) {
                File::makeDirectory($path_to_file);
            }
            if (
                    ($locid == 0 && $type == 'bpsumwubbl' && $sessgrpid != 29) &&
                    ($locid == 0 && $type == 'bpsumwubbl' && $sessgrpid != 12) &&
                    ($locid == 0 && $type == 'bpsumwubbl' && $sessgrpid != 1)) {
                $reports = [];
                array_push($reports, "trx_date,trx_count,revenue\r\n");
                foreach ($file["apiuspresponse"]["body"] as $data) {
                    //$trx_date = date('Ymd',strtotime($data["trx_date"]));

                    $location_name = $data["location_name"];
                    $trx_count = $data["trx_count"];
                    $revenue = $data["revenue"];

                    array_push($reports, $location_name . ",", $trx_count . ",", $revenue . "\r\n");
                }
            } else if (
                    ($locid != 0 && $type == 'bpsumwubbl' && $sessgrpid != 29) &&
                    ($locid != 0 && $type == 'bpsumwubbl' && $sessgrpid != 12) &&
                    ($locid != 0 && $type == 'bpsumwubbl' && $sessgrpid != 1)) {
                $reports = [];
                array_push($reports, "trx_date,trx_count,revenue\r\n");
                foreach ($file["apiuspresponse"]["body"] as $data) {
                    //$trx_date = date('Ymd',strtotime($data["trx_date"]));

                    $location_name = $data["location_name"];
                    $trx_count = $data["trx_count"];
                    $revenue = $data["revenue"];

                    array_push($reports, $location_name . ",", $trx_count . ",", $revenue . "\r\n");
                }
            } else if (
                    ($locid != 0 && $type == 'bpsumwubbl' && $sessgrpid == 29) ||
                    ($locid != 0 && $type == 'bpsumwubbl' && $sessgrpid == 12) ||
                    ($locid != 0 && $type == 'bpsumwubbl' && $sessgrpid == 1)) {
                $reports = [];
                array_push($reports, "trx_date,trx_count,buy_back,revenue\r\n");
                foreach ($file["apiuspresponse"]["body"] as $data) {
                    //$trx_date = date('Ymd',strtotime($data["trx_date"]));

                    $location_name = $data["location_name"];
                    $trx_count = $data["trx_count"];
                    $buy_back = $data["buy_back"];
                    $revenue = $data["revenue"];

                    array_push($reports, $location_name . ",", $trx_count . ",", $buy_back . ",", $revenue . "\r\n");
                }
            } else if (
                    ($locid == 0 && $type == 'bpsumwubbl' && $sessgrpid == 29) ||
                    ($locid == 0 && $type == 'bpsumwubbl' && $sessgrpid == 12) ||
                    ($locid == 0 && $type == 'bpsumwubbl' && $sessgrpid == 1)) {
                $reports = [];
                array_push($reports, "trx_date,trx_count,buy_back,revenue\r\n");
                foreach ($file["apiuspresponse"]["body"] as $data) {
                    //$trx_date = date('Ymd',strtotime($data["trx_date"]));

                    $location_name = $data["location_name"];
                    $trx_count = $data["trx_count"];
                    $buy_back = $data["buy_back"];
                    $revenue = $data["revenue"];

                    array_push($reports, $location_name . ",", $trx_count . ",", $buy_back . ",", $revenue . "\r\n");
                }
            } else {
                $reports = [];
                array_push($reports, "trx_date,trx_count,buy_back,revenue\r\n");
                foreach ($file["apiuspresponse"]["body"] as $data) {
                    //$trx_date = date('Ymd',strtotime($data["trx_date"]));

                    $location_name = $data["location_name"];
                    $trx_count = $data["trx_count"];
                    $buy_back = $data["usd_buy_back"];
                    $php_buy_back = $data["php_buy_back"];

                    array_push($reports, $location_name . ",", $trx_count . ",", $buy_back . ",", $php_buy_back . "\r\n");
                }
            }

            $csv_filename = 'STR Weekly--' . date('YmdHis') . '--' . Session::get('userinfo')[0]['vuser_id'] . ".csv";
            $path = $path_to_file . '/' . $csv_filename;
            File::put($path, $reports);

            if ($type == 'bpsumwubbl') {
                $hash2 = Func::createAPIRequestComplete("reports", 'bpsumwubbl', $paramArray);
            } else {
                $hash2 = Func::createAPIRequestComplete("reports", 'sumwubbl', $paramArray);
            }
            $fileSum = json_decode($hash2, true);
            $response = $fileSum["apiuspresponse"]["header"]["errorcode"];

            if (
                    ($locid == 0 && $type == 'bpsumwubbl' && $sessgrpid != 29) &&
                    ($locid == 0 && $type == 'bpsumwubbl' && $sessgrpid != 12) &&
                    ($locid == 0 && $type == 'bpsumwubbl' && $sessgrpid != 1)) {
                foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                    $tabledata .= "<tr>" . "<td>" . strtoupper($data["location_name"]) . "</td>" .
                            "<td>" . number_format($data["trx_count"]) . "</td>" .
                            "<td>" . number_format($data["revenue"], 2, '.', ',') . "</td>" .
                            "</tr>";
                }
            } else if (
                    ($locid == 0 && $type == 'bpsumwubbl' && $sessgrpid != 29) &&
                    ($locid == 0 && $type == 'bpsumwubbl' && $sessgrpid != 12) &&
                    ($locid == 0 && $type == 'bpsumwubbl' && $sessgrpid != 1)) {
                foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                    $tabledata .= "<tr>" . "<td>" . strtoupper($data["location_name"]) . "</td>" .
                            "<td>" . number_format($data["trx_count"]) . "</td>" .
                            "<td>" . number_format($data["buy_back"]) . "</td>" .
                            "<td>" . number_format($data["revenue"], 2, '.', ',') . "</td>" .
                            "</tr>";
                }
            } else if (
                    ($locid != 0 && $type == 'bpsumwubbl' && $sessgrpid == 29) ||
                    ($locid != 0 && $type == 'bpsumwubbl' && $sessgrpid == 12) ||
                    ($locid != 0 && $type == 'bpsumwubbl' && $sessgrpid == 1)) {
                foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                    $tabledata .= "<tr>" . "<td>" . strtoupper($data["location_name"]) . "</td>" .
                            "<td>" . number_format($data["trx_count"]) . "</td>" .
                            "<td>" . number_format($data["buy_back"]) . "</td>" .
                            "<td>" . number_format($data["revenue"], 2, '.', ',') . "</td>" .
                            "</tr>";
                }
            } else if (
                    ($locid == 0 && $type == 'bpsumwubbl' && $sessgrpid == 29) ||
                    ($locid == 0 && $type == 'bpsumwubbl' && $sessgrpid == 12) ||
                    ($locid == 0 && $type == 'bpsumwubbl' && $sessgrpid == 1)) {
                foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                    $tabledata .= "<tr>" . "<td>" . strtoupper($data["location_name"]) . "</td>" .
                            "<td>" . number_format($data["trx_count"]) . "</td>" .
                            "<td>" . number_format($data["buy_back"]) . "</td>" .
                            "<td>" . number_format($data["revenue"], 2, '.', ',') . "</td>" .
                            "</tr>";
                }
            } else {
                foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                    $tabledata .= "<tr>" . "<td>" . strtoupper($data["location_name"]) . "</td>" .
                            "<td>" . number_format($data["trx_count"]) . "</td>" .
                            "<td>" . number_format($data["usd_buy_back"], 2, '.', ',') . "</td>" .
                            "<td>" . number_format($data["php_buy_back"], 2, '.', ',') . "</td>" .
                            "</tr>";
                }
            }
            $WUcount = count($fileSum["apiuspresponse"]["body"]);
        }

        if ($type === 'mbbtbp') {
            $path_to_file = storage_path() . "/reports/compliance/" . date('Ymd') . "/" . Session::get('userinfo')[0]['plocation_id'];
            if (!File::exists(storage_path() . "/reports/")) {
                File::makeDirectory(storage_path() . "/reports/");
            }
            if (!File::exists(storage_path() . "/reports/compliance")) {
                File::makeDirectory(storage_path() . "/reports/compliance");
            }
            if (!File::exists(storage_path() . "/reports/compliance/" . date('Ymd'))) {
                File::makeDirectory(storage_path() . "/reports/compliance/" . date('Ymd'));
            }
            if (!File::exists($path_to_file)) {
                File::makeDirectory($path_to_file);
            }

            $reports = [];
            array_push($reports, "trx_date,trx_count,revenue\r\n");
            foreach ($file["apiuspresponse"]["body"] as $data) {
                //$trx_date = date('Ymd',strtotime($data["trx_date"]));

                $location_name = $data["location_name"];
                $trx_count = $data["trx_count"];
                $revenue = $data["revenue"];

                array_push($reports, $location_name . ",", $trx_count . ",", $revenue . "\r\n");
            }



            $csv_filename = 'STR Weekly--' . date('YmdHis') . '--' . Session::get('userinfo')[0]['vuser_id'] . ".csv";
            $path = $path_to_file . '/' . $csv_filename;
            File::put($path, $reports);

            $hash2 = Func::createAPIRequestComplete("reports", 'mbbtbp', $paramArray);
            $fileSum = json_decode($hash2, true);
            $response = $fileSum["apiuspresponse"]["header"]["errorcode"];

            foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                $tabledata .= "<tr>" . "<td>" . strtoupper($data["location_name"]) . "</td>" .
                        "<td>" . number_format($data["trx_count"]) . "</td>" .
                        "<td>" . number_format($data["revenue"], 2, '.', ',') . "</td>" .
                        "</tr>";
            }

            $WUcount = count($fileSum["apiuspresponse"]["body"]);
        }
        
        if ($type === 'rptmcrate') {
            $path_to_file = storage_path() . "/reports/compliance/" . date('Ymd') . "/" . Session::get('userinfo')[0]['plocation_id'];
            if (!File::exists(storage_path() . "/reports/")) {
                File::makeDirectory(storage_path() . "/reports/");
            }
            if (!File::exists(storage_path() . "/reports/compliance")) {
                File::makeDirectory(storage_path() . "/reports/compliance");
            }
            if (!File::exists(storage_path() . "/reports/compliance/" . date('Ymd'))) {
                File::makeDirectory(storage_path() . "/reports/compliance/" . date('Ymd'));
            }
            if (!File::exists($path_to_file)) {
                File::makeDirectory($path_to_file);
            }

            $reports = [];
            array_push($reports,"location_name,category,approved_buying_rate,requested_buying_rate,approved_selling_rate,requested_selling_rate,requested_by,requested_date,approved_by,date_approved,remarks,status\r\n");
            foreach ($file["apiuspresponse"]["body"] as $data) {
                //$trx_date = date('Ymd',strtotime($data["trx_date"]));

                $location_name = $data["location_name"];
                $category = $data["category"];
                $approved_buying_rate = $data["approved_buying_rate"];
                $requested_buying_rate = $data["requested_buying_rate"];
                $approved_selling_rate = $data["approved_selling_rate"];
                $requested_selling_rate = $data["requested_selling_rate"];
                $requested_by = $data["requested_by"];
                $requested_date = $data["requested_date"];
                $date_approved = $data["date_approved"];
                $remarks = $data["remarks"];
                $status = $data["status"];
                        

                array_push($reports, $location_name . ",", $category . ",", 
                        $approved_buying_rate . ",", $requested_buying_rate .  ",", 
                        $approved_selling_rate . ",", $requested_selling_rate . ",",
                        $requested_by . ",", $requested_date . ",", $date_approved . ",",
                        $remarks . ",", $status . "\r\n");
            }



            $csv_filename = 'STR Weekly--' . date('YmdHis') . '--' . Session::get('userinfo')[0]['vuser_id'] . ".csv";
            $path = $path_to_file . '/' . $csv_filename;
            File::put($path, $reports);

            $hash2 = Func::createAPIRequestComplete("reports", 'rptmcrate', $paramArray);
            $fileSum = json_decode($hash2, true);
            $response = $fileSum["apiuspresponse"]["header"]["errorcode"];

            foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                $tabledata .= "<tr>" . "<td>" . strtoupper($data["location_name"]) . "</td>" .
                        "<td>" . $data["category"] . "</td>" .
                        "<td>" . $data["approved_buying_rate"] . "</td>" .
                        "<td>" . $data["requested_buying_rate"] . "</td>" .
                        "<td>" . $data["approved_selling_rate"] . "</td>" .
                        "<td>" . $data["requested_selling_rate"] . "</td>" .
                        "<td>" . $data["requested_by"] . "</td>" .
                        "<td>" . $data["requested_date"] . "</td>" .
                        "<td>" . $data["date_approved"] . "</td>" .
                        "<td>" . $data["remarks"] . "</td>" .
                        "<td>" . $data["status"] . "</td>" .
                        "</tr>";
            }

            $WUcount = count($fileSum["apiuspresponse"]["body"]);
        }        
        
        if ($type === 'expd') {
            $path_to_file = storage_path() . "/reports/compliance/" . date('Ymd') . "/" . Session::get('userinfo')[0]['plocation_id'];
            if (!File::exists(storage_path() . "/reports/")) {
                File::makeDirectory(storage_path() . "/reports/");
            }
            if (!File::exists(storage_path() . "/reports/compliance")) {
                File::makeDirectory(storage_path() . "/reports/compliance");
            }
            if (!File::exists(storage_path() . "/reports/compliance/" . date('Ymd'))) {
                File::makeDirectory(storage_path() . "/reports/compliance/" . date('Ymd'));
            }
            if (!File::exists($path_to_file)) {
                File::makeDirectory($path_to_file);
            }

            $reports = [];
            array_push($reports, "location_name,expense_name,category_name,date_encoded,payee,particulars,reference_no,trx_date,date_incured,user\r\n");
            foreach ($file["apiuspresponse"]["body"] as $data) {
                //$trx_date = date('Ymd',strtotime($data["trx_date"]));

                $location_name = $data["location_name"];
                $expense_name = $data["expense_name"];
                $category_name = $data["category_name"];
                $date_encoded = $data["date_encoded"];
                $payee = $data["payee"];
                $particulars = $data["particulars"];
                $reference_no = $data["reference_no"];
                $trx_date = $data["trx_date"];
                $date_incured = $data["date_incured"];
                $user = $data["user"];
                        

                array_push($reports, $location_name . ",", $expense_name . ",", $category_name . ",", $expense_name .  ",", $date_encoded . ",", $payee . ",", $particulars . ",", $reference_no . ",", $trx_date . ",", $date_incured . ",", $user . "\r\n");
            }



            $csv_filename = 'STR Weekly--' . date('YmdHis') . '--' . Session::get('userinfo')[0]['vuser_id'] . ".csv";
            $path = $path_to_file . '/' . $csv_filename;
            File::put($path, $reports);

            $hash2 = Func::createAPIRequestComplete("reports", 'expd', $paramArray);
            $fileSum = json_decode($hash2, true);
            $response = $fileSum["apiuspresponse"]["header"]["errorcode"];

            foreach ($fileSum["apiuspresponse"]["body"] as $data) {
                $tabledata .= "<tr>" . "<td>" . strtoupper($data["location_name"]) . "</td>" .
                        "<td>" . $data["expense_name"] . "</td>" .
                        "<td>" . $data["category_name"] . "</td>" .
                        "<td>" . $data["date_encoded"] . "</td>" .
                        "<td>" . $data["payee"] . "</td>" .
                        "<td>" . $data["particulars"] . "</td>" .
                        "<td>" . $data["reference_no"] . "</td>" .
                        "<td>" . $data["trx_date"] . "</td>" .
                        "<td>" . $data["date_incured"] . "</td>" .
                        "<td>" . $data["user"] . "</td>" .
                        "</tr>";
            }

            $WUcount = count($fileSum["apiuspresponse"]["body"]);
        }
              
        //END       

        if ($type === 'csreports') {
            if (!File::exists(storage_path() . "/reports/")) {
                File::makeDirectory(storage_path() . "/reports/");
            }
            if (!File::exists(storage_path() . "/reports/USP/")) {
                File::makeDirectory(storage_path() . "/reports/USP/");
            }
            if (!File::exists(storage_path() . "/reports/USP/" . date('Ymd'))) {
                File::makeDirectory(storage_path() . "/reports/USP/" . date('Ymd'));
            }
            if (!File::exists(storage_path() . "/reports/USP/" . date('Ymd') . "/" . Session::get('userinfo')[0]['vuser_id'])) {
                File::makeDirectory(storage_path() . "/reports/USP/" . date('Ymd') . "/" . Session::get('userinfo')[0]['vuser_id']);
            }
            $datas = [];
            $net_POphp = 0;
            $net_POusd = 0;
            $net_SOphp = 0;
            $principal_POphp = 0;
            $principal_POusd = 0;
            $principal_SOphp = 0;
            array_push($datas, "MTCN,", "Trx Type,", "Location Name,", "Transaction Date,", "Sender Name,", "Receiver Name,", "Principal Amount,", "Total Charges,", "Net Amount,", "Currency,", "Operator ID,", "Terminal ID,", "User Fullname,", "Remote Operator ID,", "Remote Terminal ID,", "Remote User Fullname,", "Computer Name,", "IP Address\r\n");
            foreach ($file["apiuspresponse"]["body"] as $data) {
                $mtcn = substr($data["mtcn"], 1);
                $trxType = $data["tran_type"];
                $locName = $data["location_name1"];
                $trxDate = $data["trx_date"];
                $senderName = $data["sender"];
                $payeeName = $data["receiver"];
                $principalAmt = $data["principal"];
                $charges = $data["total_charge"];
                $netAmt = $data["net_amount"];
                $currency = $data['currency'];
                $operatorId = $data["user_id1"];
                $wu_terminal_id = $data["fs_id1"];
                $user_fullname = $data["user_fullname1"];
                $remote_operatorId = $data["user_id2"];
                $remote_terminal_id = $data["fs_id2"];
                $remote_user_fullname = $data["user_fullname2"];
                $computer_name = $data["computer_name"];
                $ipaddress = $data["ipaddress2"];

                array_push($datas, $mtcn . ",", $trxType . ",", $locName . ",", $trxDate . ",", $senderName . ",", $payeeName . ",", $principalAmt . ",", $charges . ",", $netAmt . ",", $currency . ",", $operatorId . ",", $wu_terminal_id . ",", $user_fullname . ",", $remote_operatorId . ",", $remote_terminal_id . ",", $remote_user_fullname . ",", $computer_name . ",", $ipaddress . ",\r\n");

                if ($data["tran_type"] == "PO") {
                    if ($data["currency"] == "PHP") {
                        $net_POphp += $data["net_amount"];
                    } else {
                        $net_POusd += $data["net_amount"];
                    }
                } else {
                    $net_SOphp += $data["net_amount"];
                }
                if ($data["tran_type"] == "PO") {
                    if ($data["currency"] == "PHP") {
                        $principal_POphp += $data["principal"];
                    } else {
                        $principal_POusd += $data["principal"];
                    }
                } else {
                    $principal_SOphp += $data["principal"];
                }
            }
            array_push($datas, "Total Amount for SO (PHP),", ",", ",", ",", ",", ",", $principal_SOphp . ",", ",", $net_SOphp . ",\r\n");
            array_push($datas, "Total Amount for PO (PHP),", ",", ",", ",", ",", ",", $principal_POphp . ",", ",", $net_POphp . ",\r\n");
            array_push($datas, "Total Amount for PO (USD),", ",", ",", ",", ",", ",", $principal_POusd . ",", ",", $net_POusd . ",\r\n");
            File::put(storage_path() . "/reports/USP/" . date('Ymd') . "/" . Session::get('userinfo')[0]['vuser_id'] . "/" . date('Ymd') . Session::get('userinfo')[0]['plocation_id'] . Session::get('userinfo')[0]['vuser_id'] . ".csv", $datas);
//            $path = storage_path() . "\\reports\\USP\\" . date('Ymd') . "\\" . Session::get('userinfo')[0]['vuser_id'] ."\\".date('Ymd').Session::get('userinfo')[0]['plocation_id'].Session::get('userinfo')[0]['vuser_id'].".csv";
            $path = storage_path() . "/reports/USP/" . date('Ymd') . "/" . Session::get('userinfo')[0]['vuser_id'] . "/" . date('Ymd') . Session::get('userinfo')[0]['plocation_id'] . Session::get('userinfo')[0]['vuser_id'] . ".csv";
            $WUcount = count($file["apiuspresponse"]["body"]);
        }
        
        /************** SONNY FIRST BUY BACK **************/
        if ($type === 'detwubbfc') {
            $total_buy_back = 0;
            $total_php = 0;
            $path_to_file = storage_path() . "/reports/avp/" . date('Ymd') . "/" . Session::get('userinfo')[0]['plocation_id'];
            if (!File::exists(storage_path() . "/reports/")) {
                File::makeDirectory(storage_path() . "/reports/");
            }
            if (!File::exists(storage_path() . "/reports/avp")) {
                File::makeDirectory(storage_path() . "/reports/avp");
            }
            if (!File::exists(storage_path() . "/reports/avp/" . date('Ymd'))) {
                File::makeDirectory(storage_path() . "/reports/avp/" . date('Ymd'));
            }
            if (!File::exists($path_to_file)) {
                File::makeDirectory($path_to_file);
            }

            foreach ($file["apiuspresponse"]["body"] as $data) {
                $total_buy_back += $data["buy_back"];
                $total_php += $data["php_amount"];
                $tabledata .= "<tr>" . "<td>" . strtoupper($data["location_name"]) . "</td>" .
                        "<td>" . strtoupper($data["customer_name"]) . "</td>" .
                        "<td>" . date('M d, Y', strtotime($data["trx_date"])) . "</td>" .
                        "<td>" . $data["country_origin"] . "</td>" .
                        "<td>" . $data["mtcn"] . "</td>" .
                        "<td style='text-align: right;'>" . number_format($data["buy_back"], 2, '.', ',') . "</td>" .
                        "<td style='text-align: right;'>" . number_format($data["mc_rate"], 2, '.', ',') . "</td>" .
                        "<td style='text-align: right;'>" . number_format($data["php_amount"], 2, '.', ',') . "</td>" .
                        "</tr>";
            }
            
            $tabledata .= "<tr>" . "<td>TOTAL</td>" .
                        "<td></td>" .
                        "<td></td>" .
                        "<td></td>" .
                        "<td></td>" .
                        "<td style='text-align: right;'>" . number_format($total_buy_back, 2, '.', ',') . "</td>" .
                        "<td style='text-align: right;'></td>" .
                        "<td style='text-align: right;'>" . number_format($total_php, 2, '.', ',') . "</td>" .
                        "</tr>";
            
            $reports = [];
            array_push($reports, "location_name,customer_name,trx_date,country_origin,mtcn,buy_back,mc_rate,php_amount\r\n");
            foreach ($file["apiuspresponse"]["body"] as $data) {
                array_push($reports, $data["location_name"] . "," . $data["customer_name"] . "," . $data["trx_date"] . "," . $data["country_origin"] . "," . $data["mtcn"] . "," . $data["buy_back"] . "," . $data["mc_rate"] . "," . $data["php_amount"] . "," . ",\r\n");
            }
            array_push($reports,"TOTAL," . "" . "," . "" . "," . "" . "," . "" . "," . $total_buy_back . "," . "" . "," . $total_php . "," . ",\r\n");

            $csv_filename = 'WU_BB_First_Customer_Detail--' . date('YmdHis') . '--' . Session::get('userinfo')[0]['vuser_id'] . ".csv";
            $path = $path_to_file . '/' . $csv_filename;
            File::put($path, $reports);

            
            $WUcount = count($file["apiuspresponse"]["body"]);
        }
        
        if ($type === 'sumwubbfc') {
            $total_usd = 0;
            $total_php = 0;
            $total_revenue = 0;
            $total_trx = 0;
            $path_to_file = storage_path() . "/reports/avp/" . date('Ymd') . "/" . Session::get('userinfo')[0]['plocation_id'];
            if (!File::exists(storage_path() . "/reports/")) {
                File::makeDirectory(storage_path() . "/reports/");
            }
            if (!File::exists(storage_path() . "/reports/avp")) {
                File::makeDirectory(storage_path() . "/reports/avp");
            }
            if (!File::exists(storage_path() . "/reports/avp/" . date('Ymd'))) {
                File::makeDirectory(storage_path() . "/reports/avp/" . date('Ymd'));
            }
            if (!File::exists($path_to_file)) {
                File::makeDirectory($path_to_file);
            }

            foreach ($file["apiuspresponse"]["body"] as $data) {
                $total_usd += $data["usd_amount"];
                $total_php += $data["php"];
                $total_trx += $data["trx_count"];
                $total_revenue += $data["revenue"];
                $tabledata .= "<tr>" . "<td>" . strtoupper($data["location_name"]) . "</td>" .
                        "<td style='text-align: right;'>" . $data["trx_count"] . "</td>" .
                        "<td style='text-align: right;'>" . number_format($data["php"], 2, '.', ',') . "</td>" .
                        "<td style='text-align: right;'>" . number_format($data["usd_amount"], 2, '.', ',') . "</td>" .
                        "<td style='text-align: right;'>" . number_format($data["revenue"], 2, '.', ',') . "</td>" .
                        "</tr>";
            }
            
            $tabledata .= "<tr>" . "<td>TOTAL</td>" .
                        "<td style='text-align: right;'>" . $total_trx . "</td>" .
                        "<td style='text-align: right;'>" . number_format($total_php, 2, '.', ',') . "</td>" .
                        "<td style='text-align: right;'>" . number_format($total_usd, 2, '.', ',') . "</td>" .
                        "<td style='text-align: right;'>" . number_format($total_revenue, 2, '.', ',') . "</td>" .
                        "</tr>";
            
            $reports = [];
            array_push($reports, "location_name,trx_count,php_amount,usd_amount,revenue\r\n");
            foreach ($file["apiuspresponse"]["body"] as $data) {
                array_push($reports, $data["location_name"] . "," . $data["trx_count"] . "," . $data["php"] . "," . $data["usd_amount"] . "," . $data["revenue"] . "," . ",\r\n");
            }
            array_push($reports,"TOTAL," . $total_trx . "," . $total_php . "," . $total_usd . "," . $total_revenue . "," . ",\r\n");

            $csv_filename = 'WU_BB_First_Customer_Summary--' . date('YmdHis') . '--' . Session::get('userinfo')[0]['vuser_id'] . ".csv";
            $path = $path_to_file . '/' . $csv_filename;
            File::put($path, $reports);

            
            $WUcount = count($file["apiuspresponse"]["body"]);
        }
        
        $View = View::make('peraprintrpt', array(
                    'response' => $response,
                    'sessgrpid' => $sessgrpid,
                    'title' => $title,
                    'res' => $res,
                    'res2' => $res2,
                    'type' => $type,
                    'loc' => $location_name,
                    'loc2' => $location_name2,            
                    'locid' => $locid,
                    'trx_type' => $trx_type,
                    'datefrom' => $datefrom,
                    'dateto' => $dateto,
                    'subrpt' => $subrpt,
                    'path' => $path,
                    'tabledata' => $tabledata,
                    'WUcount' => $WUcount
        ));
        $this->layout->content = $View;
        //dd($View);
    }

    public function exportTrxLogs() {
        $exportLink = Input::get("exportLink");
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header("Content-Type: application/force-download");
        header('Content-Disposition: attachment; filename=' . urlencode(basename($exportLink)));
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($exportLink));
        readfile($exportLink);
        exit;
    }

}
