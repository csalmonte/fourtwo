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

    {{ HTML::script("js/jquery-3.3.1.min.js")}}
    {{ HTML::script("js/bootstrap.min.js")}}
    {{ HTML::script("js/myscript1.js")}}
	{{ HTML::style("css/bootstrap.min.css")}}
	{{ HTML::style("css/mystyle.css")}}
	
    <script>
       $( document ).ready(function() {
            $('#txtNumber').on('input', function () {
              var txtNumber = $('#txtNumber').val();
                console.log(txtNumber.toMoney('2','.',','));
           });

        });
    </script>
</head>
<body>
	<h1>Show Exercise</h1>
    <div class="col-md-4">
         <input class="form-control dateto" type="text" id="txtNumber" name="txtNumber" placeholder="Enter Number" />
    </div>    
</body>
</html>
