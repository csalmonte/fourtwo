function GetDTRS() {
    switch ($('#ReportType').val())
    {
        case "dtrs":
            $('#dtrs').attr('class', 'table table-bordered table-striped table-condensed nowrap');
            $('#cpr').attr('class', 'hideObj');
            $('#crs').attr('class', 'hideObj');
            $('#dtrs').DataTable({
                destroy: true,
                searching: false,
                paging: false,
                info: false,
                ajax: {
                    url: 'reports/' + $('#ReportType').val(),
                    dataSrc: 'data'
                },
                columns: [
                    {data: 'trx_date'},
                    {data: 'reference_no'},
                    {data: 'customer_name'},
                    {data: 'trx_type'},
                    {data: 'principal_amount'},
                    {data: 'wu_charges'},
                    {data: 'ds_tax'},
                    {data: 'net_amount'},
                    {data: 'usd_adj'},
                    {data: 'usd_released'},
                    {data: 'buy_back'},
                    {data: 'wu_sell_rate'},
                    {data: 'mc_rate'},
                    {data: 'php_adj'},
                    {data: 'php_released'}
                ],
                columnDefs: [
                    {
                        targets: [0, 1, 2],
                        className: "TenfontObj",
                        searchable: false
                    }, {
                        targets: [4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14],
                        className: "rightObj",
                        cellFilter: 'currency',
                        searchable: false,
                        'render': function (data) {
                            return commaSeparated(parseFloat(data).toFixed(2));
                        }
                    }
                ]
            });
            break;
        case "cpr":
            $('#dtrs').attr('class', 'hideObj');
            $('#cpr').attr('class', 'table table-bordered table-striped table-condensed nowrap');
            $('#crs').attr('class', 'hideObj');
            $('#cpr').DataTable({
                destroy: true,
                searching: false,
                paging: false,
                info: false,
                ajax: {
                    url: 'reports/' + $('#ReportType').val(),
                    dataSrc: 'data'
                },
                columns: [
                    {data: 'location_name'},
//                    {data: 'user_id'},
                    {data: 'trx_date'},
                    {data: 'beg_balance'},
                    {data: 'replenishment'},
                    {data: 'wu_sendout'},
                    {data: 'wu_payout'},
                    {data: 'deposits'},
                    {data: 'mc'},
                    {data: 'avp'},
                    {data: 'ibt_debit'},
                    {data: 'ibt_credit'},
                    {data: 'adjustment'},
                    {data: 'deped_partial'},
                    {data: 'ending_balance'},
                    {data: 'actual_cash'},
                    {data: 'variance'}
                ],
                columnDefs: [
                    {
                        targets: [0],
                        className: "TenfontObj",
                        searchable: false
                    },
                    {
                        targets: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15],
                        className: "rightObj",
                        cellFilter: 'currency',
                        searchable: false,
                        'render': function (data) {
                            return commaSeparated(parseFloat(data).toFixed(2));
                        }
                    }
                ]
            });
            break;
        case "crs":
            $('#dtrs').attr('class', 'hideObj');
            $('#cpr').attr('class', 'hideObj');
            $('#crs').attr('class', 'table table-bordered table-striped table-condensed nowrap');
            $('#crs').DataTable({
                destroy: true,
                searching: false,
                paging: false,
                info: false,
                ajax: {
                    url: 'reports/' + $('#ReportType').val(),
                    dataSrc: 'data'
                },
                columns: [
                    {data: 'trx_date'},
                    {data: 'payee'},
                    {data: 'particulars'},
                    {data: 'oar_number'},
                    {data: 'or_number'},
                    {data: 'wu_sendout_php'},
                    {data: 'wu_sendout_usd'},
                    {data: 'eload'},
                    {data: 'cebu_pac'},
                    {data: 'gtu'},
                    {data: 'bills_payment'},
                    {data: 'mc_sell'},
                    {data: 'hotel_reservation'},
                    {data: 'tour_package'},
                    {data: 'malayan_insurance'},
                    {data: 'deped_partial'},
                    {data: 'tv_plus'}

                ],
                columnDefs: [
                    {
                        targets: [0, 1, 2, 3, 4],
                        className: "TenfontObj",
                        searchable: false
                    }, {
                        targets: [5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
                        className: "rightObj",
                        searchable: false,
                        'render': function (data) {
                            return commaSeparated(parseFloat(data).toFixed(2));
                        }
                    }
                ]
            });
            break;
        case "ctos":
            window.open("./peraCashturnover");
            break;
        case "coh":
            window.open("./peraCashonhand");
            break;
    }

}

function PrintRpt()
{
    var success = true;
    var res = "";    
    var DateFrom = new Date($("#txtDateFrom").val());
    var DateTo = new Date($("#txtDateTo").val());
    
   // alert($("#ReportType").val());
   // return;

    if ($("#ReportType").val() !== "locadj"){
        if ($("#txtDateFrom").val() == "" ||
            $("#txtDateTo").val() == "")
                {
            success = false;
            res += "Please Fill up Fields.<br />";
        }  
        if(
            ($("#ReportType").val() != "mbbtbp") && 
            ($("#ReportType").val() != "ctos") && 
            ($("#ReportType").val() != "coh") && 
            ($("#ReportType").val() != "wulogs") &&
            ($("#ReportType").val() != "compctr") &&
            ($("#ReportType").val() != "compstrd") && 
            ($("#ReportType").val() != "compstrw") &&
            ($("#ReportType").val() != "compstrm") ){
       // The number of milliseconds in one day
        var ONE_DAY = 1000 * 60 * 60 * 24;
        // Convert both dates to milliseconds
        var DateFrom_ms = DateFrom.getTime();
        var DateTo_ms = DateTo.getTime();
        // Calculate the difference in milliseconds
        var difference_ms = DateTo_ms - DateFrom_ms;
        // Convert back to days and return
        var result = Math.round(difference_ms / ONE_DAY);
        console.log(result);
        if (result > 30) {
            success = false;
            res += "Kindly select a date from and to with a duration of 30 days.<br />";
        } else if (result < 0) {
            success = false;
            res += "Invalid format of selected dates. <br />";
        } 
    }
    else{
        delete result;
    }
    }
    if ($("#ReportType").val() == "dtrs" ||
            $("#ReportType").val() == "crs" ||
            $("#ReportType").val() == "cpr") {
        if ($("#txtDateTo").val() == "") {
            success = false;
            res += "Please Input Date To<br />";
        }
    }
    if ($("#ReportType").val() === "locadj"){
        if($("#lstMonth").val() === "0" || $("#lstYear").val() === "0")
        {
                success = false;
                res += "Please Fill up Fields.<br />";
        }
    }
    
    if($("#ReportType").val() === "mbbtbp"){
        if($("#lstMonth").val() === "0"){
              success = false;
              res += "Please select a month <br />";
        }
        if($("#lstYear").val() === "0"){
              success = false;
              res += "Please select a year <br />";
        }
        if($("#rateTxt").val() === ""){
              success = false;
              res += "Please fill up the rate <br />";
        }
        
    }
    
    if ($("#ReportType").val() === "wulogs"){
        if($("#lstAgent").val() === "")
        {
                success = false;
                res += "Please select Agent <br />";
        }
    }
    if ($("#ReportType").val() === "csreports"){
        if($("#lstTerminal").val() === "")
        {
                success = false;
                res += "Please select Terminal ID <br />";
        }
    }

        /*
       if ($("Response").val() !== "0"){
        success = false;
         res += "No Transaction(s) for the selected Dates <br/>"   
        }     
        */
//    if ($("#lstCurr").val() == "0") {
//        success = false;
//        res += "Please Select Currency<br />";
//    }
//    
//    if ($("#lstBank").val() == "0") {
//        success = false;
//        res += "Please Select Bank<br />";
//    }
//    
//    if ($("#lstLoc").val() == "0") {
//        success = false;
//        res += "Please Select Branch<br />";
//    }

    if (success) {
        var user = '';
        cleartAlert();
        switch ($('#ReportType').val())
        {
//        case "dtrs":                       
//        case "cpr":         
//        case "crs":        
            case "ctos":
                window.open("./peraCashturnover?"+ Base64.encode("date=" + $('#txtDateFrom').val()
                        + "&loc=" + $('#lstLoc').val()
                        + "&user=" + $('#lstUser').val()));
                break;
            case "coh":
                if ($('#lstUser').val() == "0") {
                    user = $('#txtBranch').val();
                }
                else
                {
                    user =  $('#lstUser').val() + "|";
                }
                
                
                window.open("./peraCashonhand?"+ Base64.encode("date=" + $('#txtDateFrom').val()
                        + "&loc=" + $('#lstLoc').val()
                        + "&user=" + user));
                break;
                
            case "mbbtbp":
                var datefrom = $('#lstMonth').val()  + "/01/" + $("#lstYear").val();
                var lastDayOfMonth = new Date($("#lstYear").val(), $('#lstMonth').val(), 0); 
                var dateto = $('#lstMonth').val()  + "/" + lastDayOfMonth.getDate() + "/" + $("#lstYear").val();
                var monthrate =  $('#rateTxt').val();
                console.log(monthrate);
                window.open("showrpt?"+ Base64.encode("dtfrom=" + datefrom 
                        + "&dtto=" + dateto
                        + "&loc=" + loc
                        + "&monthrate=" + monthrate
                        + "&type=" + $('#ReportType').val()));
                break; 
            
            case "locadj":
                var datefrom = $('#lstMonth').val()  + "/01/" + $("#lstYear").val();
                var lastDayOfMonth = new Date($("#lstYear").val(), $('#lstMonth').val(), 0); 
                var dateto = $('#lstMonth').val()  + "/" + lastDayOfMonth.getDate() + "/" + $("#lstYear").val();
                
                window.open("showrpt?"+ Base64.encode("dtfrom=" + datefrom 
                        + "&dtto=" + dateto
                        + "&loc=" + loc
                        + "&type=" + $('#ReportType').val()));
                break; 
            case "trxlogs":
                window.open('showrpt?'+ Base64.encode('dtfrom=' + $('#txtDateFrom').val()
                        + "&dtto=" + $('#txtDateTo').val()
                        + "&type=" + $('#ReportType').val()
                        + "&loc=" + $('#lstLoc').val()));
                break;
            case "wulogs":
                window.open('showrpt?'+ Base64.encode('dtfrom=' + $('#txtDateFrom').val()
                        + "&type=" + $('#ReportType').val()
                        + "&agent="+ $("#lstAgent").val()));
                break;
            case "wucomp":
                var _yearmonth = $("#lstYear").val() + ($('#lstMonth').val() < 10 ? '0' + $('#lstMonth').val() : $('#lstMonth').val());
                window.open('showrpt?'+ Base64.encode('yearmonth=' + _yearmonth
                        + "&risk_type=" + $('#lstRiskType').val()
                        + "&type=" + $('#ReportType').val()));
                break;
            case "compctr":
                var datefrom = $('#lstMonth').val()  + "/01/" + $("#lstYear").val();
                var _yearmonth = $("#lstYear").val() + $('#lstMonth').val();
                window.open('showrpt?'+ Base64.encode('yearmonth=' + _yearmonth
                        + "&type=" + $('#ReportType').val()
                        + "&dtfrom=" + datefrom));
                break;
                
            case "compstrd":
                var _trxdate = $('#txtDateFrom').val();
                window.open('showrpt?'+ Base64.encode('trxdate=' + _trxdate
                        + "&type=" + $('#ReportType').val()));
                break;
            case "compstrm":
                var datefrom = $('#lstMonth').val()  + "/01/" + $("#lstYear").val();
                var _yearmonth = $("#lstYear").val() + $('#lstMonth').val();
                window.open('showrpt?'+ Base64.encode('yearmonth=' + _yearmonth
                        + "&type=" + $('#ReportType').val()
                        + "&dtfrom=" + datefrom));
                break;
            case "compstrw":
                var _week = $('#lstWeek').val();
                var _weekname = $('#lstWeek option:selected').text();
                window.open('showrpt?'+ Base64.encode('yearweek=' + _week
                        + "&type=" + $('#ReportType').val()
                        + "&wkname=" + _weekname));
                break;
            case "csreports":
                window.open('showrpt?'+ Base64.encode('dtfrom=' + $('#txtDateFrom').val()
                        + "&dtto=" + $('#txtDateTo').val()
                        + "&type=" + $('#ReportType').val()
                        + "&loc=" + $('#lstType').find(":selected").attr("remote_location_id")
                        + "&terminal=" + $('#lstType').find(":selected").attr("terminal_id")));
               
                break;
            case "expd":
                window.open('showrpt?'+ Base64.encode('dtfrom=' + $('#txtDateFrom').val()
                        + "&dtto=" + $('#txtDateTo').val()
                        + "&loc=" + $('#lstLoc').val()
                        + "&locname=" + $('#lstLoc :selected').text()
                        + "&type=" + $('#ReportType').val()
                        + "&category=" + $('#lstExp').val()));
                window.open(link)
                break;
            default:
                window.open('showrpt?'+ Base64.encode('dtfrom=' + $('#txtDateFrom').val()
                        + "&dtto=" + $('#txtDateTo').val()
                        + "&loc=" + $('#lstLoc').val()
                        + "&locname=" + $('#lstLoc :selected').text()
                        + "&type=" + $('#ReportType').val()
                        + "&curr=" + $("#lstCurr").val()
                        + "&subrpt=" + $('#lstSubcategory option:selected').val()));
                break;
        }
    }
    else {
        customAlert("Reports", res, "warning");
    }

}