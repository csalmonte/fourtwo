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


	<title>Modal Dropdown</title>

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

	{{ HTML::style("css/bootstrap.min.css")}}

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

    {{ HTML::style("css/mystyle.css")}}

    {{ HTML::script("js/jquery-3.3.1.min.js")}}

    {{ HTML::script("js/bootstrap.min.js")}}

    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

    {{ HTML::script("js/myscript.js")}}

  
	
</head>
<body>
	<div class="container-fluid">
        <div class="row">

            <div class="bs-example">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a href="#home" class="nav-link active" data-toggle="tab">Pending Transaction</a>
                    </li>
                    <li class="nav-item">
                        <a href="#profile" class="nav-link" data-toggle="tab">Existing Transaction</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="home">
                       <h4>Choose Loan Transaction</h4>
                       <div class="row">
                                <div class="col-md-3">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="provider" value="newLoan">
                                            NEW LOAN
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="provider" value="reLoan">
                                            RE LOAN
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="provider" value="reLoanHHL">
                                            RE LOAN W/ HHL
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="provider" value="recaptured">
                                            RECAPTURED
                                        </label>
                                    </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile">
                        
                    </div>
                </div>
            </div>
            

        </div>		
	</div> <!-- end of container-fluid -->

<script>
     $('input[name=provider]').change(function () {

        var loan_provider = $('input[name=provider]:checked').val();
        console.log(loan_provider);

          if (loan_provider == 'newLoan') {
            alert("This is for New Loan");
        } else if (loan_provider == 'reLoan') {
            alert("This is for reLoan");
        } else if (loan_provider == 'reLoanHHL') {
            alert("This is for reLoan with HHL");
        } else if (loan_provider == 'recaptured') {
            alert("This is for recaptured");
        }

     });
</script>
</body>
</html>
