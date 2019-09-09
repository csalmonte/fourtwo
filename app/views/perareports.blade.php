{{ HTML::script('app/js/reports.js?v='.Func::getguid()) }}
<style>
    /*a[href = "#dropdown-lvl1"]*/
    #dropdown5 a
    {
        background-color: #ffd100 !important;
    }
</style>
<script type="text/javascript">


    $('#rateTxt').keyup(function(){
    if (/\D/g.test(this.value)) {
    this.value = this.value.replace(/(([A-Za-z])|([/\\{}[/`~$&+,:;=?@#|"'<>^*()%! -])|(^\d+(\.\d{2,99})\.+?$)|(^\d+(\.\d{1,1})\.+?$)|(^\.+(\.\d{0,0})+?$)|(^\.+(\d{1,2})+?$)|(^\d+(\.{2,99})+?$)|(^\d+(\.{2,99})\d+?$)|(^\d+\.+(\d{2,2})\d+?$))/g, '');
    console.log('rateTxt-Checker');
    }//if
    }); //AmountDue  

    $(document).ready(function () {
    var monthList = { "1": " January ", "2": " February ", "3": " March ", "4": " April ", "5": " May ", "6": " June ", "7": "July", "8": "August", "9": "September", "10": "October", "11":"November", "12": "December"};
    var monthselect = $('#lstMonth');
    $.each(monthList, function(key, value) {
    monthselect.append($("<option />").val(key).text(value));
    });
    var start_year = new Date().getFullYear();
    $("#lstLoc").on('change', function(){

    });
    $("#txtDateFrom").val("{{ date('m/d/Y') }}");
    $("#txtDateTo").val("{{ date('m/d/Y') }}");
    for (var i = start_year; i > start_year - 5; i--) {
    $("#lstYear").append('<option value="' + i + '">' + i + '</option>');
    }
    $select = $('#lstLoc');
    var _user_group_id = "{{Session::get('userinfo')[0]['vuser_group_id']}}";
    switch ({{Session::get('userinfo')[0]['vbranch_type']}}){
    case 1:
            //alert(_user_group_id);
            $select.html('');
    if (_user_group_id == 21 || _user_group_id == 22){
    $locId = "{{ Session::get('userinfo')[0]['plocation_id'] }}";
    $locName = "{{ Session::get('userinfo')[0]['vlocation_name'] }}";
    $select.append('<option value="' + $locId + '">' + $locName + '</option>');
    }
    else{
    $.ajax({
    url: 'branches/getData',
            dataType: 'JSON',
            success: function (data) {
            //clear the current content of the select
            $select.html('');
            //iterate over the data and append a select option
            var _locgroupid = "{{ Session::get('userinfo')[0]['vlocation_group_id'] }}";
            var _locgrpname = "{{ Session::get('userinfo')[0]['vlocation_name'] }}"
                    //var _usergroupid = "{{ Session::get('userinfo')[0]['vuser_group_id'] }}";
                    if (_user_group_id == 11){

            $select.append('<option value="' + _locgroupid + '">' + _locgrpname + '</option>');
            $.each(data.data, function (key, val) {
            if (_locgroupid == val.location_group_id){
            $select.append('<option value="' + val.location_id + '">' + val.location_name + '</option>');
            }
            });
            }
            else{
            $select.append("<option  value='0'>ALL</option>");
            $.each(data.data, function (key, val) {
            $select.append('<option value="' + val.location_id + '">' + val.location_name + '</option>');
            });
            }
            },
            error: function () {
            //if there is an error append a 'none available' option
            $select.html('<option id="-1">none available</option>');
            }
    });
    }
    break;
    case 3:
            $select.html('');
    if ({{Session::get('userinfo')[0]['vuser_group_id']}} == 31){
    $locId = "{{ Session::get('userinfo')[0]['plocation_id'] }}";
    $locName = "{{ Session::get('userinfo')[0]['vlocation_name'] }}";
    $select.append('<option value="' + $locId + '">' + $locName + '</option>');
    }
    else{
    $.ajax({
    url: 'branches/getData',
            dataType: 'JSON',
            success: function (data) {
            //clear the current content of the select
            $select.html('');
            //iterate over the data and append a select option
            var _locgroupid = "{{ Session::get('userinfo')[0]['vlocation_group_id'] }}";
            $select.append("<option  value='0'>ALL</option>");
            if ({{Session::get('userinfo')[0]['vuser_group_id']}} == 29){
            $.each(data.data, function (key, val) {
            if (_locgroupid == val.location_group_id){
            $select.append('<option value="' + val.location_id + '">' + val.location_name + '</option>');
            }
            });
            }
            else{
            $.each(data.data, function (key, val) {
            $select.append('<option value="' + val.location_id + '">' + val.location_name + '</option>');
            });
            }
            },
            error: function () {
            //if there is an error append a 'none available' option
            $select.html('<option id="-1">none available</option>');
            }
    });
    }
    break;
    default :
            $.ajax({
            url: 'branches/getData',
                    dataType: 'JSON',
                    success: function (data) {
                    //clear the current content of the select
                    $select.html('');
                    //iterate over the data and append a select option
                    $select.append("<option value='0'>ALL</option>");
                    $.each(data.data, function (key, val) {

                    $select.append('<option value="' + val.location_id + '">' + val.location_name + '</option>');
                    });
                    },
                    error: function () {
                    //if there is an error append a 'none available' option
                    $select.html('<option id="-1">none available</option>');
                    }
            });
    break;
    }

    $select2 = $('#lstCurr');
    $.ajax({
    url: 'currency/getData',
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {
            //clear the current content of the select
            $select2.html('');
            //iterate over the data and append a select option
            $select2.append("<option value='0'>-- SELECT --</option>");
            $.each(data.data, function (key, val) {
            $select2.append('<option value="' + val.currency_id + '">' + val.currency_name + '</option>');
            });
            },
            error: function () {
            //if there is an error append a 'none available' option
            $select2.html('<option id="-1">none available</option>');
            }
    });
    $select3 = $('#lstBank');
    $.ajax({
    url: 'banks/getData',
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {
            //clear the current content of the select
            $select3.html('');
            //iterate over the data and append a select option
            $select3.append("<option value='0'>-- SELECT --</option>");
            $.each(data.data, function (key, val) {
            $select3.append('<option value="' + val.banks_id + '">' + val.bank_name + '</option>');
            });
            },
            error: function () {
            //if there is an error append a 'none available' option
            $select3.html('<option id="-1">none available</option>');
            }
    });
    $select5 = $('#lstExp');
    $.ajax({
    url: 'pccategory/getData',
            dataType: 'JSON',
            success: function (data) {
            $select5.html('');
            $select5.append("<option value='0'>ALL</option>");
            var prov = '';
            $.each(data.data, function (key, val) {
            if (val.expense_type_id == '1'){
            $select5.append('<option value="' + val.category_id + '">' + val.category_name + '</option>');
            }
            });
            },
            error: function () {
            $select5.html('<option value="-1">none availables</option>');
            }
    });
    $('#lstExp').select2();
    $('#lstCurr').select2();
    $('#lstLoc').select2();
    $('#lstBank').select2();
    showParam();
    LoadTeller();
    $("#txtDateFrom").click(function () {
    $("div.datepicker").show();
    });
    $("#txtDateTo").click(function () {
    $("div.datepicker").show();
    });
    $(".datefrom").on('changeDate', function () {
    $("div.datepicker").hide();
    });
    $(".dateto").on('changeDate', function () {
    $("div.datepicker").hide();
    });
    });
    $('.js-example-basic-single').select2();
    function LoadTeller() {
    //$("#txtDateFrom").val("{{ date('m/d/Y') }}");
    $("#txtBranch").val("");
    $select4 = $('#lstUser');
    $.ajax({
    url: 'turnover/getUsers',
            dataType: 'JSON',
            data: {
            loc: $("#lstLoc").val(),
                    date: $("#txtDateFrom").val()
            },
            success: function (data) {
            $select4.html('');
            $select4.append("<option value='0'>-- SELECT --</option>");
            $.each(data.data, function (key, val) {
            $select4.append("<option value='" + val.user_id + "'>" + val.last_name + ', ' + val.first_name + '</option>');
            $("#txtBranch").val(val.user_id + "|" + $("#txtBranch").val());
            });
            },
            error: function () {
            $select4.html('<option id="-1">none available</option>');
            }
    });
    $('#lstUser').select2();
    }

    function showParam() {

    switch ($("#ReportType").val())
    {
    case 'dtrs':
            case 'crs':
            $("#divDate").attr('class', '');
    $("#divLoc").attr('class', '');
    $("#divUser").attr('class', 'hideObj');
    $("#DivExpType").attr('class', 'hideObj');
    $("#divCurrency").attr('class', 'hideObj');
    $("#divOptions").attr('class', 'hideObj');
    $("#lblDateTo").attr('class', '');
    $("#inputDateTo").attr('class', '');
    $("#lblDateFrom").html("From:");
    $("#divMonthYear").attr('class', 'hideObj');
    $("#divRate").attr('class', 'hideObj');
    $("#divAgent").attr('class', 'hideObj');
    $("#divRiskType").attr('class', 'hideObj');
    $("#divWeekly").attr('class', 'hideObj');
    $("#divTerminal").attr('class', 'hideObj');
    break;
    case 'sales':
            $("#divDate").attr('class', '');
    $("#divLoc").attr('class', '');
    $("#divUser").attr('class', 'hideObj');
    $("#DivExpType").attr('class', 'hideObj');
    $("#divCurrency").attr('class', 'hideObj');
    $("#divOptions").attr('class', '');
    $("#lblDateTo").attr('class', '');
    $("#inputDateTo").attr('class', '');
    $("#lblDateFrom").html("From:");
    $("#divMonthYear").attr('class', 'hideObj');
    $("#divRate").attr('class', 'hideObj');
    $("#divAgent").attr('class', 'hideObj');
    $("#divRiskType").attr('class', 'hideObj');
    $("#divWeekly").attr('class', 'hideObj');
    $("#divTerminal").attr('class', 'hideObj');
    break;
    case 'cpr':
            $("#divDate").attr('class', '');
    $("#divLoc").attr('class', '');
    $("#divUser").attr('class', 'hideObj');
    $("#DivExpType").attr('class', 'hideObj');
    $("#divCurrency").attr('class', '');
    $("#divOptions").attr('class', 'hideObj');
    $("#lblDateTo").attr('class', '');
    $("#inputDateTo").attr('class', '');
    $("#lblDateFrom").html("From:");
    $("#divMonthYear").attr('class', 'hideObj');
    $("#divAgent").attr('class', 'hideObj');
    $("#divRiskType").attr('class', 'hideObj');
    $("#divWeekly").attr('class', 'hideObj');
    $("#divTerminal").attr('class', 'hideObj');
    break;
    case 'ctos':
            $("#divDate").attr('class', '');
    $("#divLoc").attr('class', '');
    $("#divUser").attr('class', '');
    $("#DivExpType").attr('class', 'hideObj');
    $("#divCurrency").attr('class', 'hideObj');
    $("#divOptions").attr('class', 'hideObj');
    $("#lblDateTo").attr('class', 'hideObj');
    $("#inputDateTo").attr('class', 'hideObj');
    $("#lblDateFrom").html("Date:");
    $("#divMonthYear").attr('class', 'hideObj');
    $("#divRate").attr('class', 'hideObj');
    $("#divAgent").attr('class', 'hideObj');
    $("#divRiskType").attr('class', 'hideObj');
    $("#divWeekly").attr('class', 'hideObj');
    $("#divTerminal").attr('class', 'hideObj');
    break;
    case 'coh':
            $("#divDate").attr('class', '');
    $("#divLoc").attr('class', '');
    $("#divUser").attr('class', 'hideObj');
    $("#lstUser").val('0').trigger("change");
    $("#DivExpType").attr('class', 'hideObj');
    $("#divCurrency").attr('class', 'hideObj');
    $("#divOptions").attr('class', 'hideObj');
    $("#lblDateTo").attr('class', 'hideObj');
    $("#inputDateTo").attr('class', 'hideObj');
    $("#lblDateFrom").html("");
    $("#divMonthYear").attr('class', 'hideObj');
    $("#divRate").attr('class', 'hideObj');
    $("#divAgent").attr('class', 'hideObj');
    $("#divRiskType").attr('class', 'hideObj');
    $("#divWeekly").attr('class', 'hideObj');
    $("#divTerminal").attr('class', 'hideObj');
    break;
    case "locadj":
            $("#divMonthYear").attr('class', 'showObj');
    $("#divRate").attr('class', 'hideObj');
    $("#divDate").attr('class', 'hideObj');
    $("#divLoc").attr('class', 'hideObj');
    $("#divUser").attr('class', 'hideObj');
    $("#DivExpType").attr('class', 'hideObj');
    $("#divCurrency").attr('class', 'hideObj');
    $("#divOptions").attr('class', 'hideObj');
    $("#lblDateTo").attr('class', 'hideObj');
    $("#inputDateTo").attr('class', 'hideObj');
    $("#lblDateFrom").html("From:");
    $("#divAgent").attr('class', 'hideObj');
    $("#divRiskType").attr('class', 'hideObj');
    $("#divWeekly").attr('class', 'hideObj');
    $("#divTerminal").attr('class', 'hideObj');
    break;
    case "bpwubb":
            $("#divDate").attr('class', '');
    $("#divLoc").attr('class', '');
    $("#divUser").attr('class', 'hideObj');
    $("#DivExpType").attr('class', 'hideObj');
    $("#divCurrency").attr('class', 'hideObj');
    $("#divOptions").attr('class', 'hideObj');
    $("#lblDateTo").attr('class', '');
    $("#inputDateTo").attr('class', '');
    $("#lblDateFrom").html("From:");
    $("#divMonthYear").attr('class', 'hideObj');
    $("#divRate").attr('class', 'hideObj');
    $("#divAgent").attr('class', 'hideObj');
    $("#divRiskType").attr('class', 'hideObj');
    $("#divWeekly").attr('class', 'hideObj');
    $("#divTerminal").attr('class', 'hideObj');
    break;
    case "bpins":
            $("#divDate").attr('class', '');
    $("#divLoc").attr('class', '');
    $("#divUser").attr('class', 'hideObj');
    $("#DivExpType").attr('class', 'hideObj');
    $("#divCurrency").attr('class', 'hideObj');
    $("#divOptions").attr('class', 'hideObj');
    $("#lblDateTo").attr('class', '');
    $("#inputDateTo").attr('class', '');
    $("#lblDateFrom").html("From:");
    $("#divMonthYear").attr('class', 'hideObj');
    $("#divRate").attr('class', 'hideObj');
    $("#divAgent").attr('class', 'hideObj');
    $("#divRiskType").attr('class', 'hideObj');
    $("#divWeekly").attr('class', 'hideObj');
    $("#divTerminal").attr('class', 'hideObj');
    break;
    case "bpload":
            $("#divDate").attr('class', '');
    $("#divLoc").attr('class', '');
    $("#divUser").attr('class', 'hideObj');
    $("#DivExpType").attr('class', 'hideObj');
    $("#divCurrency").attr('class', 'hideObj');
    $("#divOptions").attr('class', 'hideObj');
    $("#lblDateTo").attr('class', '');
    $("#inputDateTo").attr('class', '');
    $("#lblDateFrom").html("From:");
    $("#divMonthYear").attr('class', 'hideObj');
    $("#divRate").attr('class', 'hideObj');
    $("#divAgent").attr('class', 'hideObj');
    $("#divRiskType").attr('class', 'hideObj');
    $("#divWeekly").attr('class', 'hideObj');
    $("#divTerminal").attr('class', 'hideObj');
    break;
    case "sumloadl":
            case "bpsumloadl":
            $("#divDate").attr('class', '');
    $("#divLoc").attr('class', '');
    $("#divUser").attr('class', 'hideObj');
    $("#DivExpType").attr('class', 'hideObj');
    $("#divCurrency").attr('class', 'hideObj');
    $("#divOptions").attr('class', 'hideObj');
    $("#lblDateTo").attr('class', '');
    $("#inputDateTo").attr('class', '');
    $("#lblDateFrom").html("From:");
    $("#divMonthYear").attr('class', 'hideObj');
    $("#divRate").attr('class', 'hideObj');
    $("#divAgent").attr('class', 'hideObj');
    $("#divRiskType").attr('class', 'hideObj');
    $("#divWeekly").attr('class', 'hideObj');
    $("#divTerminal").attr('class', 'hideObj');
    break;
    case "sumloadd":
            case "bpsumloadd":
            $("#divDate").attr('class', '');
    $("#divLoc").attr('class', '');
    $("#divUser").attr('class', 'hideObj');
    $("#DivExpType").attr('class', 'hideObj');
    $("#divCurrency").attr('class', 'hideObj');
    $("#divOptions").attr('class', 'hideObj');
    $("#lblDateTo").attr('class', '');
    $("#inputDateTo").attr('class', '');
    $("#lblDateFrom").html("From:");
    $("#divMonthYear").attr('class', 'hideObj');
    $("#divRate").attr('class', 'hideObj');
    $("#divAgent").attr('class', 'hideObj');
    $("#divRiskType").attr('class', 'hideObj');
    $("#divWeekly").attr('class', 'hideObj');
    $("#divTerminal").attr('class', 'hideObj');
    break;
    case "suminsl":
            case "bpsuminsl":
            $("#divDate").attr('class', '');
    $("#divLoc").attr('class', '');
    $("#divUser").attr('class', 'hideObj');
    $("#DivExpType").attr('class', 'hideObj');
    $("#divCurrency").attr('class', 'hideObj');
    $("#divOptions").attr('class', 'hideObj');
    $("#lblDateTo").attr('class', '');
    $("#inputDateTo").attr('class', '');
    $("#lblDateFrom").html("From:");
    $("#divMonthYear").attr('class', 'hideObj');
    $("#divRate").attr('class', 'hideObj');
    $("#divAgent").attr('class', 'hideObj');
    $("#divRiskType").attr('class', 'hideObj');
    $("#divWeekly").attr('class', 'hideObj');
    $("#divTerminal").attr('class', 'hideObj');
    break;
    case "suminsd":
            case "bpsuminsd":
            $("#divDate").attr('class', '');
    $("#divLoc").attr('class', '');
    $("#divUser").attr('class', 'hideObj');
    $("#DivExpType").attr('class', 'hideObj');
    $("#divCurrency").attr('class', 'hideObj');
    $("#divOptions").attr('class', 'hideObj');
    $("#lblDateTo").attr('class', '');
    $("#inputDateTo").attr('class', '');
    $("#lblDateFrom").html("From:");
    $("#divMonthYear").attr('class', 'hideObj');
    $("#divRate").attr('class', 'hideObj');
    $("#divAgent").attr('class', 'hideObj');
    $("#divRiskType").attr('class', 'hideObj');
    $("#divWeekly").attr('class', 'hideObj');
    $("#divTerminal").attr('class', 'hideObj');
    break;
    case "sumwubbd":
            case "bpsumwubbd":
            case "detwubbfc":
            case "sumwubbfc":
            $("#divDate").attr('class', '');
    $("#divLoc").attr('class', '');
    $("#divUser").attr('class', 'hideObj');
    $("#DivExpType").attr('class', 'hideObj');
    $("#divCurrency").attr('class', 'hideObj');
    $("#divOptions").attr('class', 'hideObj');
    $("#lblDateTo").attr('class', '');
    $("#inputDateTo").attr('class', '');
    $("#lblDateFrom").html("From:");
    $("#divMonthYear").attr('class', 'hideObj');
    $("#divRate").attr('class', 'hideObj');
    $("#divAgent").attr('class', 'hideObj');
    $("#divRiskType").attr('class', 'hideObj');
    $("#divWeekly").attr('class', 'hideObj');
    $("#divTerminal").attr('class', 'hideObj');
    break;
    case "sumwubbl":
            case "bpsumwubbl":
            $("#divDate").attr('class', '');
    $("#divLoc").attr('class', '');
    $("#divUser").attr('class', 'hideObj');
    $("#DivExpType").attr('class', 'hideObj');
    $("#divCurrency").attr('class', 'hideObj');
    $("#divOptions").attr('class', 'hideObj');
    $("#lblDateTo").attr('class', '');
    $("#inputDateTo").attr('class', '');
    $("#lblDateFrom").html("From:");
    $("#divMonthYear").attr('class', 'hideObj');
    $("#divRate").attr('class', 'hideObj');
    $("#divAgent").attr('class', 'hideObj');
    $("#divRiskType").attr('class', 'hideObj');
    $("#divWeekly").attr('class', 'hideObj');
    $("#divTerminal").attr('class', 'hideObj');
    break;
    case "mbbtbp":
            $("#divDate").attr('class', 'hideObj');
    $("#divLoc").attr('class', 'hideObj');
    $("#divUser").attr('class', 'hideObj');
    $("#DivExpType").attr('class', 'hideObj');
    $("#divCurrency").attr('class', 'hideObj');
    $("#divOptions").attr('class', 'hideObj');
    $("#lblDateTo").attr('class', '');
    $("#inputDateTo").attr('class', '');
    $("#lblDateFrom").html("From:");
    $("#divMonthYear").attr('class', '');
    $("#divRate").attr('class', '');
    $("#divAgent").attr('class', 'hideObj');
    $("#divRiskType").attr('class', 'hideObj');
    $("#divWeekly").attr('class', 'hideObj');
    $("#divTerminal").attr('class', 'hideObj');
    break;
    case "expd":
            $("#divDate").attr('class', '');
    $("#divLoc").attr('class', '');
    $("#DivExpType").attr('class', '');
    $("#divUser").attr('class', 'hideObj');
    $("#divCurrency").attr('class', 'hideObj');
    $("#divOptions").attr('class', 'hideObj');
    $("#lblDateTo").attr('class', '');
    $("#inputDateTo").attr('class', '');
    $("#lblDateFrom").html("From:");
    $("#divMonthYear").attr('class', 'hideObj');
    $("#divRate").attr('class', 'hideObj');
    $("#divAgent").attr('class', 'hideObj');
    $("#divRiskType").attr('class', 'hideObj');
    $("#divWeekly").attr('class', 'hideObj');
    $("#divTerminal").attr('class', 'hideObj');
    break;
    case "rptmcrate":
            $("#divDate").attr('class', '');
    $("#divLoc").attr('class', '');
    $("#divUser").attr('class', 'hideObj');
    $("#DivExpType").attr('class', 'hideObj');
    $("#divCurrency").attr('class', 'hideObj');
    $("#divOptions").attr('class', 'hideObj');
    $("#lblDateTo").attr('class', '');
    $("#inputDateTo").attr('class', '');
    $("#lblDateFrom").html("From:");
    $("#divMonthYear").attr('class', 'hideObj');
    $("#divRate").attr('class', 'hideObj');
    $("#divAgent").attr('class', 'hideObj');
    $("#divRiskType").attr('class', 'hideObj');
    $("#divWeekly").attr('class', 'hideObj');
    $("#divTerminal").attr('class', 'hideObj');
    break;
    case "trxlogs":
            $("#divDate").attr('class', '');
    $("#divLoc").attr('class', '');
    $("#divUser").attr('class', 'hideObj');
    $("#DivExpType").attr('class', 'hideObj');
    $("#divCurrency").attr('class', 'hideObj');
    $("#divOptions").attr('class', 'hideObj');
    $("#lblDateTo").attr('class', '');
    $("#inputDateTo").attr('class', '');
    $("#lblDateFrom").html("From:");
    $("#divMonthYear").attr('class', 'hideObj');
    $("#divRate").attr('class', 'hideObj');
    $("#divAgent").attr('class', 'hideObj');
    $("#divRiskType").attr('class', 'hideObj');
    $("#divWeekly").attr('class', 'hideObj');
    $("#divTerminal").attr('class', 'hideObj');
    break;
    case "wulogs":
            $("#divDate").attr('class', '');
    $("#divLoc").attr('class', 'hideObj');
    $("#divUser").attr('class', 'hideObj');
    $("#DivExpType").attr('class', 'hideObj');
    $("#divCurrency").attr('class', 'hideObj');
    $("#divOptions").attr('class', 'hideObj');
    $("#lblDateTo").attr('class', 'hideObj');
    $("#inputDateTo").attr('class', 'hideObj');
    $("#lblDateFrom").html("Date:");
    $("#divMonthYear").attr('class', 'hideObj');
    $("#divRate").attr('class', 'hideObj');
    $("#divAgent").attr('class', 'showObj');
    $("#divRiskType").attr('class', 'hideObj');
    $("#divWeekly").attr('class', 'hideObj');
    $("#divTerminal").attr('class', 'hideObj');
    break;
    case "wucomp":
            $("#divDate").attr('class', 'hideObj');
    $("#divLoc").attr('class', 'hideObj');
    $("#divUser").attr('class', 'hideObj');
    $("#DivExpType").attr('class', 'hideObj');
    $("#divCurrency").attr('class', 'hideObj');
    $("#divOptions").attr('class', 'hideObj');
    $("#lblDateTo").attr('class', 'hideObj');
    $("#inputDateTo").attr('class', 'hideObj');
    $("#lblDateFrom").html("Date:");
    $("#divMonthYear").attr('class', '');
    $("#divRate").attr('class', 'hideObj');
    $("#divAgent").attr('class', 'hideObj');
    $("#divRiskType").attr('class', 'showObj');
    $("#divWeekly").attr('class', 'hideObj');
    $("#divTerminal").attr('class', 'hideObj');
    break;
    case "compctr":
            $("#divDate").attr('class', 'hideObj');
    $("#divLoc").attr('class', 'hideObj');
    $("#divUser").attr('class', 'hideObj');
    $("#DivExpType").attr('class', 'hideObj');
    $("#divCurrency").attr('class', 'hideObj');
    $("#divOptions").attr('class', 'hideObj');
    $("#lblDateTo").attr('class', '');
    $("#inputDateTo").attr('class', '');
    $("#lblDateFrom").html("From:");
    $("#divMonthYear").attr('class', '');
    $("#divRate").attr('class', 'hideObj');
    $("#divAgent").attr('class', 'hideObj');
    $("#divRiskType").attr('class', 'hideObj');
    $("#divWeekly").attr('class', 'hideObj');
    $("#divTerminal").attr('class', 'hideObj');
    break;
    case "compstrd":
            $("#divDate").attr('class', '');
    $("#divLoc").attr('class', 'hideObj');
    $("#divUser").attr('class', 'hideObj');
    $("#DivExpType").attr('class', 'hideObj');
    $("#divCurrency").attr('class', 'hideObj');
    $("#divOptions").attr('class', 'hideObj');
    $("#lblDateTo").attr('class', 'hideObj');
    $("#inputDateTo").attr('class', 'hideObj');
    $("#lblDateFrom").html("Date:");
    $("#divMonthYear").attr('class', 'hideObj');
    $("#divRate").attr('class', 'hideObj');
    $("#divAgent").attr('class', 'hideObj');
    $("#divRiskType").attr('class', 'hideObj');
    $("#divWeekly").attr('class', 'hideObj');
    $("#divTerminal").attr('class', 'hideObj');
    break;
    case "compstrm":
            $("#divDate").attr('class', 'hideObj');
    $("#divLoc").attr('class', 'hideObj');
    l('class', 'hideObj');
    $("#DivExpType").attr('class', 'hideObj');
    $("#divCurrency").attr('class', 'hideObj');
    $("#divOptions").attr('class', 'hideObj');
    $("#lblDateTo").attr('class', 'hideObj');
    $("#inputDateTo").attr('class', 'hideObj');
    $("#lblDateFrom").html("Date:");
    $("#divMonthYear").attr('class', '');
    $("#divRate").attr('class', 'hideObj');
    $("#divAgent").attr('class', 'hideObj');
    $("#divRiskType").attr('class', 'hideObj');
    $("#divWeekly").attr('class', 'hideObj');
    $("#divTerminal").attr('class', 'hideObj');
    break;
    case "compstrw":
            $("#divDate").attr('class', 'hideObj');
    $("#divLoc").attr('class', 'hideObj');
    $("#divUser").attr('class', 'hideObj');
    $("#DivExpType").attr('class', 'hideObj');
    $("#divCurrency").attr('class', 'hideObj');
    $("#divOptions").attr('class', 'hideObj');
    $("#lblDateTo").attr('class', 'hideObj');
    $("#inputDateTo").attr('class', 'hideObj');
    $("#lblDateFrom").html("Date:");
    $("#divMonthYear").attr('class', 'hideObj');
    $("#divRate").attr('class', 'hideObj');
    $("#divAgent").attr('class', 'hideObj');
    $("#divRiskType").attr('class', 'hideObj');
    $("#divWeekly").attr('class', '');
    $("#divTerminal").attr('class', 'hideObj');
    break;
    case "csreports":
            $("#divDate").attr('class', '');
    $("#divLoc").attr('class', 'hideObj');
    $("#divUser").attr('class', 'hideObj');
    $("#DivExpType").attr('class', 'hideObj');
    $("#divCurrency").attr('class', 'hideObj');
    $("#divOptions").attr('class', 'hideObj');
    $("#lblDateTo").attr('class', '');
    $("#inputDateTo").attr('class', '');
    $("#lblDateFrom").html("From:");
    $("#divMonthYear").attr('class', 'hideObj');
    $("#divRate").attr('class', 'hideObj');
    $("#divAgent").attr('class', 'hideObj');
    $("#divRiskType").attr('class', 'hideObj');
    $("#divWeekly").attr('class', 'hideObj');
    $("#divTerminal").attr('class', '');
    break;
    default:
            $("#divDate").attr('class', 'hideObj');
    $("#divLoc").attr('class', 'hideObj');
    $("#divUser").attr('class', 'hideObj');
    $("#DivExpType").attr('class', 'hideObj');
    $("#divCurrency").attr('class', 'hideObj');
    $("#divOptions").attr('class', 'hideObj');
    $("#lblDateTo").attr('class', '');
    $("#inputDateTo").attr('class', '');
    $("#lblDateFrom").html("From:");
    $("#divMonthYear").attr('class', 'hideObj');
    $("#divRate").attr('class', 'hideObj');
    $("#divAgent").attr('class', 'hideObj');
    $("#divRiskType").attr('class', 'hideObj');
    $("#divWeekly").attr('class', 'hideObj');
    $("#divTerminal").attr('class', 'hideObj');
    break;
    }

    switch ({{Session::get('userinfo')[0]['vuser_group_id']}}){
    case "5": case "6":
            case "17": case "18":
            case "20": case "21": case "22": case "30": case "31":
            $("#divLoc").attr('class', 'hideObj');
    $("#divUser").attr('class', 'hideObj');
    $("#lstLoc").val("{{ Session::get('userinfo')[0]['plocation_id'] }}").trigger("change");
    //$("#txtDateFrom").val("{{ date('m/d/Y') }}");
    break;
    }
    }
    var loc = {{ Session::get('userinfo')[0]['plocation_id'] }};</script>
<ul class="breadcrumb">
    <li>
        <i class="icon-folder-open"></i>
        <a href="#">Pera Reports</a>
        <i class="icon-angle-right"></i>
    </li>
</ul>
<div class="top_icon_reports"></div>
<div id="divGenTrx" class="row-fluid">
    <div id="divDefault" class="showObj">
        <h2 id="SessionMsg2">{{ $message}}</h2>
        <div id="divInput">
            <div class="row col-md-12">
                <div class="space row col-lg-4">
                    <div class="col-md-12"><span>Report Name:</span></div>
                    <div class="col-md-12">
                        <select class="form-control" id="ReportType" onchange="showParam()">
                            {{ $report_list }}
                        </select>
                    </div>
                </div>
                <div id="divDate" class="hideObj">
                    <div class="space row col-lg-4" style="clear: both;">

                        <div id="lblDateFrom" class="col-md-12">From:</div>
                        <div class="col-md-12">
                            <input class="form-control datefrom" type="text" name="txtDateFrom" id="txtDateFrom" value="" maxlength="45" placeholder="Date" readonly=""/>
                        </div>
                    </div>
                    <div class="space row col-lg-4" style="clear: both;">
                        <div id="lblDateTo">To:</div>
                        <div id="inputDateTo">
                            <input class="form-control dateto" type="text" name="txtDateTo" id="txtDateTo" value="" maxlength="45" placeholder="Date To" readonly=""/>
                        </div>
                    </div>
                </div>
                <div id="divLoc" class="hideObj" style="clear: both;">
                    <div class="space row col-lg-4">
                        <div class="col-md-12">Branch:</div>
                        <div class="col-md-12">
                            <select class="form-control list-group js-example-basic-single" id="lstLoc" onkeyup='this.blur(); this.focus();' onchange="LoadTeller()">
                            </select>
                        </div>
                    </div>
                </div>
                <div id="divUser" class="hideObj" style="clear: both;">
                    <div class="space row col-lg-4">
                        <div class="col-md-12">User:</div>
                        <div class="col-md-12">
                            <select class="form-control list-group js-example-basic-single" id="lstUser" onkeyup='this.blur(); this.focus();' style="width: 100%">
                                <option value='0'>-- SELECT --</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div id="divCurrency" class="hideObj" style="clear: both;">
                    <div class="space row col-lg-4">
                        <div class="col-md-12">Currency:</div>
                        <div class="col-md-12">
                            <select id="lstCurr" class='form-control list-group js-example-basic-single' style="width:100%"  onkeyup='this.blur(); this.focus();'>
                            </select>
                        </div>
                    </div>
                </div>

                <div id="divOptions" class="hideObj" style="clear: both;">
                    <div class="space row col-lg-4">
                        <div class="col-md-12">Sub Category:</div>
                        <div class="col-md-12">
                            <select id="lstSubcategory" class='form-control list-group js-example-basic-single' style="width:100%"  onkeyup='this.blur(); this.focus();'>
                                <option value="perapalit">Pera Palit</option>
                                <option value="peraload">Pera Load</option>
                                <option value="perapay">Pera Pay</option>
                                <option value="peraprotek">Pera Protect</option>
                                <option value="peratravel">Pera Travel</option>
                                <option value="peradali">Pera Dali</option>
                                <option value="peracard">Pera Hub Card</option>
                                <option value="cico">Pera CashInCashOut</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!--Month and year-->
                <div id="divMonthYear" class="hideObj">
                    <div class="space row col-lg-4" style="clear: both;padding-bottom: 0;padding-top: 0;">
                        <div id="lblMonth" class="col-md-12">Month:</div>
                        <div class="col-md-12">
                            <select id="lstMonth" class='form-control list-group js-example-basic-single' style="width:100%;padding-bottom: 0;padding-top: 0;margin-bottom: 3px;;margin-top: 0;"  onkeyup='this.blur();
                                this.focus();'>
                                <option value="0">--- Select --- </option>
                            </select>
                        </div>
                    </div>
                    <div class="space row col-lg-4" style="clear: both;padding-bottom: 0;padding-top: 0;">
                        <div id="lblYear" class="col-md-12">Year:</div>
                        <div id="inputDateTo">
                            <select id="lstYear" class='form-control list-group js-example-basic-single' style="width:100%"  onkeyup='this.blur();
                               this.focus();'>
                                <option value="0">--- Select --- </option>
                            </select>
                        </div>
                    </div>
                </div>

                <div id="divWeekly" class="">
                    <div class="space row col-lg-4" style="clear: both;padding-bottom: 0;padding-top: 0;">
                        <div id="lblMonth" class="col-md-12">Fiscal Week:</div>
                        <div class="col-md-12">
                            <select id="lstWeek" class='form-control list-group js-example-basic-single' style="width:100%;padding-bottom: 0;padding-top: 0;margin-bottom: 3px;;margin-top: 0;"  onkeyup='this.blur();
                                this.focus();'>
                                <option value="0">--- Select --- </option>
                                @foreach(Func::ListWeeks(2) as $week)
                                <option value='{{ $week[2] }}'>{{ date('F d, Y',strtotime($week[0])) }} to {{ date('F d, Y',strtotime($week[1]))  }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div id="divAgent" class="hideObj" style="clear: both;">
                    <div class="space row col-lg-4">
                        <div class="col-md-12">Agent:</div>
                        <div class="col-md-12">
                            <select id="lstAgent" class='form-control list-group js-example-basic-single' style="width:100%"  onkeyup='this.blur(); this.focus();'>
                                <option value="">--- Select ---</option>
                                <option value="usp">USP</option>
                                <option value="lbc">LBC</option>
                                <option value="yondu">YONDU</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div id="divRate" class="hideObj" style="clear: both;">
                    <div class="space row col-lg-4">
                        <div class="col-md-12">Rate:</div>
                        <div class="col-md-12">
                            <input type='text' id="rateTxt" class='form-control list-group js-example-basic-single' style="width:100%"  placeholder="  00.00">
                        </div>
                    </div>
                    <div></div>
                </div>                

                <div id="divRiskType" class="hideObj" style="clear: both;">
                    <div class="space row col-lg-4">
                        <div class="col-md-12">Risk Type:</div>
                        <div class="col-md-12">
                            <select id="lstRiskType" class='form-control list-group js-example-basic-single' style="width:100%"  onkeyup='this.blur(); this.focus();'>
                                <option value="">--- Select ---</option>
                                <option value="low">Low Risk</option>
                                <option value="med">Medium Risk</option>
                                <option value="high">High Risk</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div id="DivExpType" class="hideObj" style="clear: both;">
                    <div class="space row col-lg-4">
                        <div class="col-md-12">Category:</div>
                        <div class="col-md-12">
                            <select id="lstExp"  class="form-control list-group js-example-basic-single" onkeyup='this.blur(); this.focus();' style="width:100%">
                            </select>
                        </div>
                    </div>
                </div>                

                <div id="divTerminal" class="hideObj" style="clear: both;">
                    <div class="space row col-lg-4">
                        <div class="col-md-12">Type:</div>
                        <div class="col-md-12">
                            <select class="form-control list-group js-example-basic-single" id="lstType" onkeyup='this.blur(); this.focus();' >
                                <option value="">--- Select ---</option>
                                <option remote_location_id="0" terminal_id="0">All Assisted Transactions</option>
                                <option remote_location_id="{{ Session::get('userinfo')[0]['plocation_id'] }}" terminal_id="0">All CS Assisted Trasactions</option>
                                <option remote_location_id="{{ Session::get('userinfo')[0]['plocation_id'] }}" terminal_id="{{ Session::get('terminal_id') }}">This Terminal only</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="space row col-lg-4" style="clear: both;">
                    <div class="col-md-12">
                        <input type="button" class="btn btn-primary btn-sm" value="View Report" onclick="PrintRpt();"/>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="txtBranch" id="txtBranch">

