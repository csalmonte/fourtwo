<?php

use GuzzleHttp\Client;

class Func {

    public static function createAPIRequest($module, $request, $param) {
        $ipaddress = Request::getClientIp();
        $clienid = Config::get('app.clientid');
        $clientkey = Config::get('app.clientkey');
        $token = md5($ipaddress . $clienid . $clientkey);

        $location_id = Session::get('userinfo')[0]['plocation_id'];
        $user_id = Session::get('userinfo')[0]['vuser_id'];
        $web = Config::get('app.isweb');

        $header = array("clientid" => $clienid, "token" => $token, "location_id" => $location_id, "user_id" => $user_id, "clientip" => $ipaddress, "isweb" => $web);
        $body = array("module" => $module, "request" => $request, "param" => $param);

        return array("apiusp" => array("header" => $header, "body" => $body));
    }

    public static function createAPIRequestComplete($module, $request, $param) {
        $ipaddress = Request::getClientIp();
        $clienid = Config::get('app.clientid');
        $clientkey = Config::get('app.clientkey');
        $token = md5($ipaddress . $clienid . $clientkey);

        $location_id = Session::get('userinfo')[0]['plocation_id'];
        $user_id = Session::get('userinfo')[0]['vuser_id'];
        $web = Config::get('app.isweb');

        $header = array("clientid" => $clienid, "token" => $token, "location_id" => $location_id, "user_id" => $user_id, "clientip" => $ipaddress, "isweb" => $web);
        $body = array("module" => $module, "request" => $request, "param" => $param);


        $json = json_encode(array("apiusp" => array("header" => $header, "body" => $body)));
        self::SaveLogs($json, "RQ-" . $request, $module);
        $urlsegment = base64_encode($json);
        $url = Config::get('app.urlAPI') . "/" . $module . "/" . $urlsegment;
        $return = file_get_contents($url);
        self::SaveLogs($return, "RS-" . $request, $module);
        return $return;
    }

    public static function createAPIRequestComplete2($module, $request, $param, $trxn, $filename) {
        $ipaddress = Request::getClientIp();
        $clienid = Config::get('app.clientid');
        $clientkey = Config::get('app.clientkey');
        $token = md5($ipaddress . $clienid . $clientkey);

        $location_id = Session::get('userinfo')[0]['plocation_id'];
        $user_id = Session::get('userinfo')[0]['vuser_id'];
        $web = Config::get('app.isweb');

        $header = array("clientid" => $clienid, "token" => $token, "location_id" => $location_id, "user_id" => $user_id, "clientip" => $ipaddress, "isweb" => $web);
        $body = array("module" => $module, "request" => $request, "param" => $param);


        $json = json_encode(array("apiusp" => array("header" => $header, "body" => $body)));
//        self::SaveLogs($json, $filename, $trxn);
        $urlsegment = base64_encode($json);
        $url = Config::get('app.urlAPI') . "/" . $module . "?hash=" . $urlsegment;
        $return = file_get_contents($url);
//        self::SaveLogs($return, str_replace("RQ", "RS", $filename), $trxn);
        return $return;
    }

    public static function createUSPAPIRequest($module, $request, $param, $trxn, $filename) {
        $ipaddress = Request::getClientIp();
        $clienid = Config::get('app.clientid');
        $clientkey = Config::get('app.clientkey');
        $token = md5($ipaddress . $clienid . $clientkey);

        $location_id = Session::get('userinfo')[0]['plocation_id'];
        $user_id = Session::get('userinfo')[0]['vuser_id'];
        $web = Config::get('app.isweb');

        $header = array("clientid" => $clienid, "token" => $token, "location_id" => $location_id, "user_id" => $user_id, "clientip" => $ipaddress, "isweb" => $web);
        $body = array("module" => $module, "request" => $request, "param" => $param);


        $json = json_encode(array("apiusp" => array("header" => $header, "body" => $body)));

        self::SaveLogs($json, $filename, $trxn);
//        $urlsegment = base64_encode($json);

        $client = new Client(['base_uri' => Config::get('app.urlAPI')]);
        //$client = new GuzzleHttp\Client();

        $return = $client->request('POST', Config::get('app.urlAPI') . '/' . $module, [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $json
        ]);

//        $return = $client->request('POST', Config::get('app.urlAPI') . '/' . $module . "?hash=" . $urlsegment);

        $testdata = $return->getBody();

        self::SaveLogs($testdata, str_replace("RQ", "RS", $filename), $trxn);

        return $testdata;
    }

    public static function createAPIRequestComplete1($module, $request, $param) {
        $ipaddress = Request::getClientIp();
        $clienid = Config::get('app.clientid');
        $clientkey = Config::get('app.clientkey');
        $token = md5($ipaddress . $clienid . $clientkey);

        $location_id = Session::get('userinfo')[0]['plocation_id'];
        $user_id = Session::get('userinfo')[0]['vuser_id'];
        $web = Config::get('app.isweb');

        $header = array("clientid" => $clienid, "token" => $token, "location_id" => $location_id, "user_id" => $user_id, "clientip" => $ipaddress, "isweb" => $web);
        $body = array("module" => $module, "request" => $request, "param" => $param);

        $json = json_encode(array("apiusp" => array("header" => $header, "body" => $body)));
        $urlsegment = base64_encode($json);
        $url = Config::get('app.urlAPI') . "/" . $module . "/" . $urlsegment;
        $return = file_get_contents($url);

        return $return;
    }

    public static function getguid() {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public static function TransactionForms($function, $param) {
        $hash = Func::createAPIRequestComplete("trxforms", $function, $param);
        $file = json_decode($hash, true);
        $return = $file['apiuspresponse'];
        return $return;
    }
    
    public static function TransactionFormsCAS($function, $param) {
        $hash = Func::createAPIRequestComplete("trxforms", $function, $param);
        $file = json_decode($hash, true);
        $return = $file['apiuspresponse'];
        return $return;
    }

    public static function eloadHash1($saveloc, $custNum, $rrn, $response, $tid, $balance, $epin, $err, $pcode, $amount, $com, $ptype, $provider, $form_type, $ORnum, $custID, $custName, $Fee, $promocode) {
        return Func::createAPIRequest("trxeload", $saveloc, array("trx_date" => Session::get("branch_trx_date"),
                    "customer_number" => $custNum,
                    "rrn" => $rrn,
                    "resp" => $response,
                    "tid" => $tid,
                    "bal" => $balance,
                    "epin" => $epin,
                    "err" => $err,
                    "product_code" => $pcode,
                    "amount" => $amount,
                    "comission" => $com,
                    "product_type" => $ptype,
                    "transcation_date" => Session::get("branch_trx_date"),
                    "provider" => $provider,
                    "form_type" => $form_type,
                    "form_number" => $ORnum,
                    "client_ip" => Request::getClientIp(),
                    "terminal_id" => "0", //Session::get('userinfo')[0]['pterminal_id'],                        
                    "customer_id" => $custID,
                    "customer_name" => $custName,
                    "date_encoded" => Session::get("branch_trx_date"),
                    "added_comission" => $Fee,
                    "promo_code" => $promocode));
    }

    public static function eloadHash2($id, $response, $tid, $epin, $err) {
        return Func::createAPIRequest("trxeload", "updateerr", array("trx_eload_temp_id" => $id,
                    "resp" => $response,
                    "epin" => $epin,
                    "tid" => $tid,
                    "err" => $err));
    }

    public static function eloadHash3($id, $frmNum, $custID, $custName) {
        return Func::createAPIRequest("trxeload", "update", array("trx_eload_temp_id" => $id,
                    "form_type" => "OAR",
                    "form_number" => $frmNum,
                    "customer_id" => $custID,
                    "customer_name" => $custName));
    }

    public static function airSave($reloc_number, $ticket_number, $route_type, $flight_type, $airline, $outbound_origin, $outbound_destination, $outbound_conn_routes, $outbound_terminals, $outbound_conn_dates, $outbound_conn_flightno, $inbound_origin, $inbound_destination, $inbound_conn_routes, $inbound_terminals, $inbound_conn_dates, $inbound_conn_flightno, $basefare, $taxes_and_fees, $feta_charge, $service_charge, $total_amount, $ticket_status, $pax_names, $contact_person, $mobile_number, $tel_no, $email_address, $remarks, $fare_calculation, $ticket_rule, $form_type, $form_number, $customer_id, $customer_name, $total_segment, $total_pax
    ) {
        $hash = Func::createAPIRequest("trxair", "save", array("trx_date" => Session::get("branch_trx_date"),
                    "reloc_number" => $reloc_number,
                    "ticket_number" => $ticket_number,
                    "route_type" => $route_type,
                    "flight_type" => $flight_type,
                    "airline" => $airline,
                    "outbound_origin" => $outbound_origin,
                    "outbound_destination" => $outbound_destination,
                    "outbound_conn_routes" => $outbound_conn_routes,
                    "outbound_terminals" => $outbound_terminals,
                    "outbound_conn_dates" => $outbound_conn_dates,
                    "outbound_conn_flightno" => $outbound_conn_flightno,
                    "inbound_origin" => $inbound_origin,
                    "inbound_destination" => $inbound_destination,
                    "inbound_conn_routes" => $inbound_conn_routes,
                    "inbound_terminals" => $inbound_terminals,
                    "inbound_conn_dates" => $inbound_conn_dates,
                    "inbound_conn_flightno" => $inbound_conn_flightno,
                    "basefare" => $basefare,
                    "taxes_and_fees" => $taxes_and_fees,
                    "feta_charge" => $feta_charge,
                    "service_charge" => $service_charge,
                    "total_amount" => $total_amount,
                    "ticket_status" => $ticket_status,
                    "pax_names" => $pax_names,
                    "contact_person" => $contact_person,
                    "mobile_number" => $mobile_number,
                    "tel_no" => $tel_no,
                    "email_address" => $email_address,
                    "remarks" => $remarks,
                    "fare_calculation" => $fare_calculation,
                    "ticket_rule" => $ticket_rule,
                    "form_type" => $form_type,
                    "form_number" => $form_number,
                    "client_ip" => Request::getClientIp(),
                    "terminal_id" => "0",
                    "customer_id" => $customer_id,
                    "customer_name" => $customer_name,
                    "total_segment" => $total_segment,
                    "total_pax" => $total_pax
        ));

        $json = json_encode($hash);
        $urlsegment = base64_encode($json);
        $url = Config::get("app.urlAPI") . "/trxair/" . $urlsegment;
        $file = json_decode(file_get_contents($url), true);
        $result = json_encode($file['apiuspresponse']["body"]);
        return $result;
    }

    public static function GetAvailableForms($function, $type, $formID) {
        $return = "";
        $param = array('type' => $type, 'location_form_id' => $formID);
        $apireturn = Func::TransactionForms($function, $param);
        if ($apireturn['header']['errorcode'] == '0') {
            if ($function == "get") {
                if ($type == 'COC') {
                    Session::put('trxformidCOC', $apireturn['body'][0]['location_form_id']);
                } else {
                    Session::put('trxformid', $apireturn['body'][0]['location_form_id']);
                }
            }

            $return = array('status' => '1', 'data' => $apireturn['body']);
        } else {
            $return = array('status' => '0', 'data' => $apireturn['header']['message']);
        }
        return $return;
    }

    public static function GetCASAvailableForms($function, $service_code, $trx_date) {
        $return = "";
        $param = array('trx_date' => $trx_date, 'service_code' => $service_code);
        $apireturn = Func::TransactionFormsCAS($function, $param);
        if ($apireturn['header']['errorcode'] == '0') {
            Session::put('trxformid', $apireturn['body'][0]['location_form_id']);

            $return = array('status' => '1', 'data' => $apireturn['body']);
        } else {
            $return = array('status' => '0', 'data' => $apireturn['header']['message']);
        }
        return $return;
    }

    public static function GoogleAuth() {
        $redirect_uri = 'http://localhost:8080/petnetUSP/home';
        $client = new Google_Client();
        $client->setAuthConfigFile(storage_path() . '/gdrive/client_id.json');
        $client->setRedirectUri($redirect_uri);
        $client->addScope("https://www.googleapis.com/auth/drive");
        $client->setAccessType('offline');

        if (isset($_REQUEST['logout'])) {
            Session::forget('upload_token');
        }

        if (isset($_GET['code'])) {
            $client->authenticate($_GET['code']);
            //  $_SESSION['upload_token'] = $client->getAccessToken();
            Session::put('upload', $client->getAccessToken());
            //$redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
            //header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
        }

        if (isset($_SESSION['upload_token']) && $_SESSION['upload_token']) {
            $client->setAccessToken($_SESSION['upload_token']);
            if ($client->isAccessTokenExpired()) {
                unset($_SESSION['upload_token']);
            }
        } else {
            return $authUrl = $client->createAuthUrl();
        }
    }

    public static function array2XML($obj, $array) {
        foreach ($array as $key => $value) {
            if (is_numeric($key)) {
                $key = 'item' . $key;
            }
            if (is_array($value)) {
                $node = $obj->addChild($key);
                Func::array2XML($node, $value);
            } else {
                $obj->addChild($key, htmlspecialchars($value));
            }
        }
    }

    public static function _get_julian($str) {
        $d = date_create($str);

        $is_leap_year = $d->format("L");

        if ($d == false)
            return 0;

        $day_in_year = (int) date_format($d, "z");
//        $year        = (int) date_format($d, "Y") - 1;
//        $julian_days = $year * 365;
//        $julian_days += ($year >>= 2);
//        $julian_days -= ($year /= 25);
//        $julian_days += $year >> 2;
//        $julian_days += $day_in_year + 1;
//
        //if($is_leap_year == 1){$day_in_year += 1;}
        $day_in_year += 1;
        //return ceil($day_in_year);
        return ceil($day_in_year);
        //return $ddd;
    }

    public static function refreshSession() {
        $timein = date("Y-m-d H:i:s");

        $endTime = strtotime("+" . Config::get("app.timeout") . " minutes", strtotime($timein));
        $timeout = date('Y-m-d H:i:s', $endTime);

        Session::put('timelogin', $timein);
        Session::put('timelogout', $timeout);
    }

    public static function FatalErrHandler() {
        $errfile = "unknown file";
        $errstr = "shutdown";
        $errno = E_CORE_ERROR;
        $errline = 0;

        $error = error_get_last();

        if ($error !== NULL) {
            $errno = $error["type"];
            $errfile = $error["file"];
            $errline = $error["line"];
            $errstr = $error["message"];


            Session::put('fatalerr', $errstr);
        }

        exit();
    }

    public static function MailError($code, $errormessage, $exception) {
        $layout = View::make('layout.default');
        $resultArray = access::CheckAccess(Session::get('accessinfo'), '');

        $stackTrace = Config::get('app.debug') ? access::getExceptionTraceAsString($exception) : '';
        $data = array('code' => $code,
            'errormessage' => $errormessage,
            'IPAddress' => filter_input(INPUT_SERVER, 'REMOTE_ADDR'),
            'BrowserName' => access::getBrowser(),
            'url' => Request::getPathInfo(),
            'stacktrace' => str_replace('#', '<br/>#', $stackTrace)
        );
        $layout->title = 'Petnet USP : Ooops!';
        $layout->admin = $resultArray['admin'];
        $layout->funding = $resultArray['funding'];
        $layout->bos = $resultArray['bos'];
        $layout->teller = $resultArray['teller'];
        $layout->reports = $resultArray['reports'];
        $layout->content = View::make('layout.customerror', $data);
        if ($stackTrace == '') {
            $stackTrace = str_replace('#', '<br/>#', access::getExceptionTraceAsString($exception));
            $data['stacktrace'] = $stackTrace;
        }

        Mail::queue('layout.customerror', $data, function($message) {
            $message->to('usp.error@petnet.com.ph', 'System Admin')->subject('Petnet USP Custom Error : PRODUCTION');
        });
    }

    public static function otp_validate($username, $pin, $otp) {
//      
        $client = new Client([
            'base_uri' => "https://172.0.0.6/validate",
            'verify' => false
        ]);

        $return = $client->request('GET', "https://172.0.0.6/validate/check", [
            'query' => [
                'user' => 'a' . $username,
                'pass' => $pin . $otp
            ]
        ]);

        $testdata = $return->getBody();
        return $testdata;
    }

    /* $data=$parameters, $filename=CANCEL-RQ-ValidationRequest, $trxn=ADJ/SO/PO */

    public static function SaveLogs($data, $filename, $trxn) {
        if (!File::exists(Config::get('app.logsPath') . "/usptranslog/" . date('Ymd'))) {
            File::makeDirectory(Config::get('app.logsPath') . "/usptranslog/" . date('Ymd'));
        }
        if (!File::exists(Config::get('app.logsPath') . "/usptranslog/" . date('Ymd') . "/" . $trxn)) {
            File::makeDirectory(Config::get('app.logsPath') . "/usptranslog/" . date('Ymd') . "/" . $trxn);
        }
        if (!File::exists(Config::get('app.logsPath') . "/usptranslog/" . date('Ymd') . "/" . $trxn . "/" . Session::get('userinfo')[0]['plocation_id'])) {
            File::makeDirectory(Config::get('app.logsPath') . "/usptranslog/" . date('Ymd') . "/" . $trxn . "/" . Session::get('userinfo')[0]['plocation_id']);
        }
        File::put(Config::get('app.logsPath') . "/usptranslog/" . date('Ymd') . "/" . $trxn . "/" . Session::get('userinfo')[0]['plocation_id'] . "/" . date('His') . "-" . Session::get('userinfo')[0]['vfirst_name'] . Session::get('userinfo')[0]['vlast_name'] . "-" . $filename . ".txt", $data);
    }

    public static function SaveXml($data, $filename, $trxn, $type) {
        if (!File::exists(Config::get('app.logsPath') . "/usptranslog/" . date('Ymd'))) {
            File::makeDirectory(Config::get('app.logsPath') . "/usptranslog/" . date('Ymd'));
        }
        if (!File::exists(Config::get('app.logsPath') . "/usptranslog/" . date('Ymd') . "/" . $trxn)) {
            File::makeDirectory(Config::get('app.logsPath') . "/usptranslog/" . date('Ymd') . "/" . $trxn);
        }
        if (!File::exists(Config::get('app.logsPath') . "/usptranslog/" . date('Ymd') . "/" . $trxn . "/" . Session::get('userinfo')[0]['plocation_id'])) {
            File::makeDirectory(Config::get('app.logsPath') . "/usptranslog/" . date('Ymd') . "/" . $trxn . "/" . Session::get('userinfo')[0]['plocation_id']);
        }
        File::put(Config::get('app.logsPath') . "/usptranslog/" . date('Ymd') . "/" . $trxn . "/" . Session::get('userinfo')[0]['plocation_id'] . "/" . date('His') . "-" . Session::get('userinfo')[0]['vfirst_name'] . Session::get('userinfo')[0]['vlast_name'] . "-" . $filename . $type, $data);
    }

    public static function airlineSaving($_request, $_param) {
        $hash = Func::createAPIRequest("trxair", $_request, $_param);
        self::AirlineSaveLogs(json_encode($hash), "RQ-" . $_request);
        $json = json_encode($hash);
        $urlsegment = base64_encode($json);
        $url = Config::get("app.urlAPI") . "/trxair/" . $urlsegment;
        $file = json_decode(file_get_contents($url), true);
        self::AirlineSaveLogs(json_encode($file), "RS-" . $_request);
        $result = json_encode($file['apiuspresponse']["body"]);
        return $result;
    }

    private static function AirlineSaveLogs($data, $filename) {
        if (!File::exists(Config::get('app.logsPath') . "/tmbapi/" . date('Ymd'))) {
            File::makeDirectory(Config::get('app.logsPath') . "/tmbapi/" . date('Ymd'));
        }
        if (!File::exists(Config::get('app.logsPath') . "/tmbapi/" . date('Ymd') . "/USPDatabase")) {
            File::makeDirectory(Config::get('app.logsPath') . "/tmbapi/" . date('Ymd') . "/USPDatabase");
        }
        if (!File::exists(Config::get('app.logsPath') . "/tmbapi/" . date('Ymd') . "/USPDatabase/" . Session::get('userinfo')[0]['plocation_id'])) {
            File::makeDirectory(Config::get('app.logsPath') . "/tmbapi/" . date('Ymd') . "/USPDatabase/" . Session::get('userinfo')[0]['plocation_id']);
        }
        File::put(Config::get('app.logsPath') . "/tmbapi/" . date('Ymd') . "/USPDatabase/" . Session::get('userinfo')[0]['plocation_id'] . "/" . date('His') . "-" . Session::get('userinfo')[0]['vfirst_name'] . Session::get('userinfo')[0]['vlast_name'] . "-" . $filename . ".json", $data);
    }

    public static function complianceDataBuffer($data_buffer) {
        $compliance = File::get(storage_path() . "/uspdata/kyc-complianceField.json");

        $dataVal = [];
        $field_id = [];
        $field_key = [];
        $field_length = [];
        $template_id = [];
        $buffer = [];
        $buffer[0] = $data_buffer;
        $field_id[0] = substr($buffer[0], 0, 4);
        $field_key[0] = substr($buffer[0], 0, 2);
        $field_length[0] = substr($field_id[0], 2, 2);
        $template_id[0] = substr($buffer[0], 4, $field_length[0]);
        $separator[0] = $field_id[0] . $template_id[0];
        $data[0] = explode($separator[0], $buffer[0]);
        $field_key_2 = "undefined";
        foreach (json_decode($compliance, true) as $getField) {
            if ($getField["field_id"] == $field_key[0]) {
                $field_key_2 = $getField["field_value"];
            }
        }
        if (gettype($template_id[0]) === "boolean") {
            $template_id[0] = "";
        }
        $dataVal = array_merge($dataVal, array($field_key_2 => $template_id[0]));
        for ($i = 1; $i < 100; $i++) {
            $field_id[$i] = substr($data[$i - 1][1], 0, 4);
            $field_key[$i] = substr($data[$i - 1][1], 0, 2);
            $field_length[$i] = substr($field_id[$i], 2, 2);
            $template_id[$i] = substr($data[$i - 1][1], 4, $field_length[$i]);
            $separator[$i] = $field_id[$i] . $template_id[$i];
            $field_key_2 = "undefined";
            if ($data[$i - 1][1] !== "") {
                $data[$i] = explode($separator[$i], $data[$i - 1][1]);
                foreach (json_decode($compliance, true) as $getField) {
                    if ($getField["field_id"] == $field_key[$i]) {
                        $field_key_2 = $getField["field_value"];
                    }
                }
                $dataVal = array_merge($dataVal, array($field_key_2 => $template_id[$i]));
            } else {
                break;
            }
        }
        return json_encode($dataVal);
    }

    public static function BananaPayRequest($method, $param, $trxn, $filename) {
        $reqHeader = array("partner" => "PHUB", "partner_id" => "8824111040", "partner_cn" => "rsa1001", "timestamp" => time(),
            "version" => "1.0", "method" => $method, "location_code" => Session::get('userinfo')[0]['plocation_id']);

        $reqData = array('bnnpapi' => array('header' => $reqHeader, 'body' => $param));

        $reqJson = json_encode($reqData);

        $certFile = storage_path() . "/cert/" . $reqHeader['partner_cn'] . '.crt';

        $publicKey = openssl_pkey_get_public(file_get_contents($certFile));

        openssl_public_encrypt(md5($reqJson), $encrypted, $publicKey);

        $reqData['bnnpapi']['sign'] = base64_encode($encrypted);

        self::SaveLogs(json_encode($reqData), $filename, $trxn);

        $url = Config::get('app.bananaPayAPI');
        $postFields = base64_encode(json_encode($reqData));

        $client = new Client(['base_uri' => $url]);
        //$client = new GuzzleHttp\Client();
//        $return = $client->request('POST', $url, [
//            'headers' => ['Content-Type' => 'application/json'],
//            'body' => $postFields
//        ]);
//
//        $resp = $return->getBody();
//
//        self::SaveLogs(base64_decode($resp), str_replace("RQ", "RS", $filename), $trxn);

        try {
            $return = $client->request('POST', $url, [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $postFields
            ]);
            $resp = $return->getBody();

            self::SaveLogs(base64_decode($resp), str_replace("RQ", "RS", $filename), $trxn);
        } catch (Exception $e) {
            self::SaveLogs($e->getMessage(), str_replace("RQ", "RS", $filename), $trxn);
        }

        return base64_decode($resp);
    }

    public static function BananaPaySaving($_request, $_param) {
        $hash = Func::createAPIRequest("bnnp", $_request, $_param);
        self::BananaPaySaveLogs(json_encode($hash), "RQ-" . $_request);
        $json = json_encode($hash);
        $urlsegment = base64_encode($json);
        $url = Config::get("app.urlAPI") . "/bnnp/" . $urlsegment;
        $file = json_decode(file_get_contents($url), true);
        self::BananaPaySaveLogs(json_encode($file), "RS-" . $_request);
        return $file;
    }

    private static function BananaPaySaveLogs($data, $filename) {
        if (!File::exists(Config::get('app.logsPath') . "/usptranslog/" . date('Ymd'))) {
            File::makeDirectory(Config::get('app.logsPath') . "/usptranslog/" . date('Ymd'));
        }
        if (!File::exists(Config::get('app.logsPath') . "/usptranslog/" . date('Ymd') . "/BNNP")) {
            File::makeDirectory(Config::get('app.logsPath') . "/usptranslog/" . date('Ymd') . "/BNNP");
        }
        if (!File::exists(Config::get('app.logsPath') . "/usptranslog/" . date('Ymd') . "/BNNP/" . Session::get('userinfo')[0]['plocation_id'])) {
            File::makeDirectory(Config::get('app.logsPath') . "/usptranslog/" . date('Ymd') . "/BNNP/" . Session::get('userinfo')[0]['plocation_id']);
        }
        if (!File::exists(Config::get('app.logsPath') . "/usptranslog/" . date('Ymd') . "/BNNP/" . Session::get('userinfo')[0]['plocation_id'] . "/Database")) {
            File::makeDirectory(Config::get('app.logsPath') . "/usptranslog/" . date('Ymd') . "/BNNP/" . Session::get('userinfo')[0]['plocation_id'] . "/Database");
        }
        File::put(Config::get('app.logsPath') . "/usptranslog/" . date('Ymd') . "/BNNP/" . Session::get('userinfo')[0]['plocation_id'] . "/Database" . "/" . date('His') . "-" . Session::get('userinfo')[0]['vfirst_name'] . Session::get('userinfo')[0]['vlast_name'] . "-" . $filename . ".txt", $data);
    }

    public static function getStartAndEndDate($week, $year) {
        //setting the default time zone
        //date_default_timezone_set('America/New_York');
        //getting the
        //$firstWeek = date('W',strtotime("January 1 $year", date(time())));
        //echo "Year : ".$year."<br/>"."Week : ".$week."<br/>";
        $firstWeekThursDay = date('W', strtotime("January $year first thursday", date(time())));

        if ($firstWeekThursDay == "01") {
            $time = strtotime("January $year first thursday", date(time()));
            //echo $time."<br/>";
            //echo date('Y-m-d H:i:s',$time)."<br/>";
            $time = ($time - (4 * 24 * 3600)) + (((7 * $week) - 6) * 24 * 3600);
            //echo $time."<br/>";
            //echo date('Y-m-d H:i:s',$time)."<br/>";
            $return[0] = date('Y-m-d', $time);
            $time += 6 * 24 * 3600;
            $return[1] = date('Y-m-d', $time);
            //print_r($return);
        } else {
            $time = strtotime("January 1 $year", time());
            //echo "<br/>".$time."<br/>";
            //echo date('Y-m-d H:i:s',$time)."<br/>";
            $time = ($time - (4 * 24 * 3600)) + (((7 * $week) - 6) * 24 * 3600);
            //echo $time."<br/>";
            //echo date('Y-m-d H:i:s',$time)."<br/>";
            $return[0] = date('Y-m-d', $time);
            $time += 6 * 24 * 3600;
            $return[1] = date('Y-m-d', $time);
            //print_r($return);
            //echo "<br/>End of Hi<br/>";
        }
        return $return;
    }

    public static function ListWeeks($numberOfYrs) {
        $yearweek = date('oW');
        $weekofyear = substr($yearweek, 4);
        $year = substr($yearweek, 0, 4);
        $arrWeeks = Array();
        //$arrOWEEK = Array();
        for ($x = 0; $x <= $numberOfYrs; $x++) {
            $new_yearweek = $yearweek;
            $new_year = $year - $x;
            $new_weekofyear = $weekofyear;
            if ($year != $new_year) {
                $new_yearweek = date('oW', strtotime($new_year . '-12-28'));
                $oweek = substr($new_yearweek, 4);
                $new_weekofyear = $oweek;
                //array_push($arrOWEEK,$new_weekofyear,$new_yearweek);
            }
            for ($a = 1; $a <= $new_weekofyear; $a++) {
                $b = ($new_weekofyear - $a) + 1;
                $dates = self::getStartAndEndDate($b, $new_year);

                array_push($dates, ($b < 10 ? $new_year . '0' . $b : $new_year . $b));
                array_push($arrWeeks, $dates);
            }
        }

        return $arrWeeks;
    }

    public static function WriteXMLToFile($filename, $data, $location, $module) {
        if (!File::exists(Config::get("app.logsPath") . "/" . $module)) {
            File::makeDirectory(Config::get("app.logsPath") . "/" . $module);
        }
        if (!File::exists(Config::get("app.logsPath") . "/" . $module . "/" . date('Ymd') . "/xml")) {
            File::makeDirectory(Config::get("app.logsPath") . "/" . $module . "/" . date('Ymd') . "/xml");
        }
        if (!File::exists(Config::get("app.logsPath") . "/" . $module . "/" . date('Ymd') . "/xml/" . $location)) {
            File::makeDirectory(Config::get("app.logsPath") . "/" . $module . "/" . date('Ymd') . "/xml/" . $location);
        }
        File::put(Config::get("app.logsPath") . "/" . $module . "/" . date('Ymd') . "/xml/" . $location . "/" . $filename . ".xml", $data);
    }

    public static function WriteJSONToFile($filename, $data, $location, $module) {
        if (!File::exists(Config::get("app.logsPath") . "/" . $module)) {
            File::makeDirectory(Config::get("app.logsPath") . "/" . $module);
        }
        if (!File::exists(Config::get("app.logsPath") . "/" . $module . "/" . date('Ymd'))) {
            File::makeDirectory(Config::get("app.logsPath") . "/" . $module . "/" . date('Ymd'));
        }
        if (!File::exists(Config::get("app.logsPath") . "/" . $module . "/" . date('Ymd') . "/json")) {
            File::makeDirectory(Config::get("app.logsPath") . "/" . $module . "/" . date('Ymd') . "/json");
        }
        if (!File::exists(Config::get("app.logsPath") . "/" . $module . "/" . date('Ymd') . "/json/" . $location)) {
            File::makeDirectory(Config::get("app.logsPath") . "/" . $module . "/" . date('Ymd') . "/json/" . $location);
        }
        File::put(Config::get("app.logsPath") . "/" . $module . "/" . date('Ymd') . "/json/" . $location . "/" . $filename . ".json", $data);
    }
	
	public static function emailOAR($email_address, $trx ){
        $path = storage_path() . "/tmp/".date('Ymdhis')."-oar.pdf";
        $pdf = PDF::loadView('casReceipt')
                ->setOption('margin-bottom', 0)
                ->setOption('margin-left', 0)
                ->setOption('margin-right', 0)
                ->setOption('margin-top', 10);
        $pdf->save($path);

        Mail::send([], [], function ($message) use($email_address, $trx, $path){
            $message->to($email_address)
            ->subject('Perahub '.$trx.' OAR')
            ->setBody('<p> Here is a e-copy of your oar </p>', 'text/html');
            $message->attach(str_replace('\\', '/', $path));
        });

        File::delete($path);
    }
    
    public static function LazadaPromo($customer_id, $customer_name, $mobile, $reference_no){
        $promotions = new TrxPromotions('ALLPRODUCTS', $customer_id, $customer_name, $reference_no, "lazada");
        if($promotions->return['body'] != "")
        {
            $promo_message1 = "Use code " . $promotions->return['body'] . "  from PERA HUB & get 12% off on app purchase at Lazada's 11.11 SALE (Nov 11-Dec 12 ‘18). Per DTI FTEB Permit No. 17808 Series of 2018.\n\n";
            SendSMS::Send($promo_message1, $mobile);    
        }
    }

    public static function addKYC($data){
        $custid = null;
     
        $param = $data['last_name'].', '.$data['first_name'];
        $search = json_decode(Func::createAPIRequestComplete("cust", "search", array("param" => $param)),true);
        $dob = $data['date_of_birth'];
        $formatedDOB = substr($dob, 0,4).'-'.substr($dob, 4,2).'-'.substr($dob,6,2);
        if ($search['apiuspresponse']['header']['errorcode'] == '1') {
            return json_encode(["status" => "2", "body" => $search['uspwuapi']['header']['message']]);
        }
        
        //return $search['apiuspresponse']['body'];
        if(count($search['apiuspresponse']['body']) != 0) {
            $personName = explode(', ', $param);

            foreach($search['apiuspresponse']['body'] as $person){
                if($person['last_name'] == $personName[0] && $person['first_name'] == $personName[1]  && $person['birth_date'] == $formatedDOB){
                   $custid = $person['customer_id'];
                   break;
                }
            }
        }

        if($custid == null){
            $client_ip = Request::getClientIp();
            $param = [
                        'first_name'=>$data['first_name'],
                        'last_name'=>$data['last_name'], 
                        'birth_date'=> $formatedDOB,
                        'middle_name'=>"", 
                        'address'=>$data['addr_line1'], 
                        'municipality'=>$data['city'], 
                        'province'=>$data['state'], 
                        'zip_code'=>$data['postal_code'], 
                        'tel_no'=>"", 
                        'mobile_no'=>$data['mobile_country_code'].$data['phone_number'], 
                        'email_add'=>"", 
                        'gender'=>"", 
                        'civil_status'=>"", 
                        'nationality'=>"", 
                        'country_birth'=>$data['country_of_birth'], 
                        'mobile_country_code'=>$data['mobile_country_code'], 
                        'barangay'=>"",
                        'country'=>"",
                        'birth_place'=>""
                    ];
            $param = array_add($param, 'ip_address', $client_ip);

            $addcust = json_decode(Func::createAPIRequestComplete("cust", "savefromtrx", $param),true);

            if ($addcust['apiuspresponse']['header']['errorcode'] != '0') {
                return json_encode(['status' => '2','body'=> $addcust['apiuspresponse']['header']['message']]);
            }

            $custid = $addcust['apiuspresponse']['body'][0]['customer_id'];
        }

        return $custid;
    }
}
