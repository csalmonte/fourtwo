<!doctype html>
<html lang="en">
<head>

	 <?php
        //set headers to NOT cache a page
        header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
        header("Pragma: no-cache"); //HTTP 1.0
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
     ?>
     <meta charset="utf-8">

     <meta name="viewport" content="width=device-width", initial-scale="1.0", maximum-scale="1.0", user-scalable="no">

     <meta http-equiv="X-UA-Compatible" content="IE=Edge">

     <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate, max-age=0" />
     <meta http-equiv="Pragma" content="no-cache" />
     <meta http-equiv="Expires" content="0" />
     <meta http-equiv="Expires" content="timestamp" />


	<title>Laravel PHP Framework</title>

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

	{{ HTML::style("css/bootstrap.min.css")}}

	{{ HTML::style("css/mystyle.css")}}

	{{ HTML::script("js/jquery-3.3.1.min.js")}}

	{{ HTML::script("js/bootstrap.min.js")}}

	{{ HTML::script("js/myscript.js")}}

  
	
</head>
<body>
	
	<!-- 
	<div class="container-fluid">

		<div class="row">

			<div class="col-md-6">
			 	<img src="../images/icon-head.jpg" class="icon-head"> 
			</div>

			<div class="col-md-6">
				    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			</div>
			
		</div>
		
	</div>
	 -->

 

	<div class="container-fluid">
		
		<div class="row">

			<div class="col-md-6">
				
		          <!-- Start of the UPS Form Function -->

                    <div class="top_icon_reports"></div>
                        <div id="divGenTrx" class="row-fluid">
                            <div id="divDefault" class="showObj">
                                <h2 id="SessionMsg2">$message in blade</h2>
                                <div id="divInput">
                                    <div class="row col-md-12">
                                        <div class="space row col-lg-4">
                                            <div class="col-md-12"><span>Report Name:</span></div>
                                            <div class="col-md-12">
                                                <select class="form-control" id="ReportType" onchange="showParam()">
                                                $report_list 
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
                                                        <!-- @foreach(Func::ListWeeks(2) as $week) -->
                                                        Func,ListWeeks(2) as $week
                                                        <option value='{{ $week[2] }}'>
                                                        <!-- {{ date('F d, Y',strtotime($week[0])) }} to  -->
                                                        <!-- {{ date('F d, Y',strtotime($week[1]))  }} -->
                                                        Func,ListWeeks(2) as $week
                                                        </option>
                                                        <!-- @endforeach -->
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


                  <!-- End of UPS Form Function -->

                

			</div>

		</div>
				
	</div> <!-- end of container-fluid -->
</body>
</html>
