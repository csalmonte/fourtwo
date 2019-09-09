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
	<!-- Start of Navigation -->

	<div class="container-fluid">
			
			<div class="col-md-6">
			 	<img src="../images/mainlogo2.png" id="main-logo-top">
			</div>
			<div class="col-md-6">

				<div class="row">
					 <div class="col-md-6 col-md-push-5">

					 	<div class="section-optimizer">	
					    	<i class="fab fa-facebook-square"></i>
					    	<i class="fab fa-twitter-square"></i>
					    	<i class="fab fa-instagram"></i>
					    	<i class="fab fa-linkedin"></i>
					    	<i class="fab fa-google-plus-g"></i>
						</div>

					    <div class="section-optimizer">
					    	<div class="input-group">
						      <input type="text" class="form-control" placeholder="Search for...">
						      <span class="input-group-btn">
						        <button class="btn btn-default" type="button"><i class="fas fa-search-plus"></i></button>
						      </span>
						    </div><!-- /input-group -->
						</div>
						<div class="section-optimizer">
						    <div class="input-group">
						      <input type="text" class="form-control" placeholder="Find Location...">
						      <span class="input-group-btn">
						        <button class="btn btn-default" type="button"><i class="fas fa-map-marker-alt"></i></button>
						      </span>
						    </div><!-- /input-group -->
					    </div> <!-- section optimizer -->
					    <br>
					  </div><!-- /.col-lg-6 -->
				</div>

			</div>

	</div>

	<nav class="navbar">
	 	 <div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	        <i class="fas fa-bars"></i>
	      </button>
	      <a class="navbar-brand" href="#"></a>
	    </div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav">
	        <li><a href="#">HOME</a></li>
	        <li><a href="#">ABOUT US</a></li>
	        <!-- Start of Dropdown -->
	        <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">PRODUCTS & SERVICES<span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li><a href="#">REMIT</a></li>
	            <li><a href="#">LOAN</a></li>
	            <li><a href="#">TRAVEL</a></li>
	            <li><a href="#">PAY</a></li>
	            <li><a href="#">PALIT</a></li>
	            <li><a href="#">PROTECT</a></li>
	            <li><a href="#">LOAD</a></li>
	            <li><a href="#">DALI</a></li>
	          </ul>
	        </li>
	        <!-- End of Dropdown -->
	        <li><a href="#">WESTERN UNION BUSINESS SOLUTIONS</a></li>
	        <li><a href="#">PARTNERS</a></li>
	        <li><a href="#">NEWS</a></li>
	        <li><a href="#">PROMO</a></li>
	        <li><a href="#">CAREERS</a></li>
	        <li><a href="#">CONTACT US</a></li>
	        <li><a href="{{ url('/access') }}">ACCESS</a></li>
	      </ul>
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>

	<!-- End of Navigation -->

	<div class="container-fluid">

		<div class="section-optimizer">
			
			<div class="first-title-greeting">
				WELCOME TO
			</div>


			<img src="../images/mainlogo.png" class="img-responsive center-block">

			<div class="first-title-greeting">
				The largest agent network of Western Union in the Philippines with over 
				2,500 locations nationwide.
			</div> 

		</div>

		<div class="section-optimizer">
			<div class="row">

				<div class="col-md-6">
					<div class="card">
					  <div class="card-body">Youtube video Here</div>
					</div>
				</div>
				<div class="col-md-6">
				
				<p>
					Complete Urgent Transaction Center. Pera Hub serves the community by offering a variety of transaction services in customer-friendly locations across the Philippines. We can be absolutely counted on to deliver warm and efficient service, to always have your cash ready, and always make the process easier and faster.
				</p>		
				
				<p>
					Warm, personalized service. Pera Hub acknowledges that the most important component of their business is the human touch. With this in mind, Pera Hub sees to it that anyone who walks into their centers is treated with the utmost care, respect, and warmth.
				</p>
				
				<p>
					Partnerships with top providers in their categories. Pera Hub's line of transaction services is backed by global and local partners that are leaders in their respective categories, like Western Union, Aboitiz, Unionbank, and City Savings Bank, among other companies.
				</p>
				
				<p>
					Expertise and knowledge of the business. Pera Hub nurtures and strengthens its core values and beliefs that guide them to be the best in what they do. Pera Hub's expertise and knowledge allow the company to create long-term value for all its stakeholders.
				</p>
				
				 <button type="button" class="btn btn-warning btn-lg">Learn More...</button>
				</div>
				
			</div>
		</div>

		<div class="section-optimizer">

			<div class="second-title-greeting">OUR VALUES</div>
			<div class="row">

				<div class="col-md-2 col-md-offset-1">
					<div class="well"><h4>INTEGRITY</h4>

					<img src="../images/value1.png" class="img-responsive center-block">

					<p>
						Our expertise, consistency, and sense of fairness not only allow us to deliver on what we promise, but also to operate with transparency and accountability for our actions.
					</p>
					</div>
				</div>


				<div class="col-md-2">
					<div class="well"><h4>TEAMWORK</h4>

					<img src="../images/value2.png" class="img-responsive center-block">
						
					<p>
						We apply an integrative, inter-disciplinary approach to achieve our objectives and thrive on interdependence while promoting cooperation and mutual respect.
					</p>
					</div>
				</div>

				<div class="col-md-2">
					<div class="well"><h4>INNOVATION</h4>

					<img src="../images/value3.png" class="img-responsive center-block">
						
					<p>
						We continuously look for newer and better ways to provide efficient services while ensuring a high level of quality in everything that we do.
					</p>
					</div>
				</div>

				<div class="col-md-2">
					<div class="well"><h4>RESPONSIBILITY</h4>

					<img src="../images/value4.png" class="img-responsive center-block">

					<p>
						We see to it that as we provide top-notch services to our customers, we also advocate sustainability and caring for our environment, adhere to good corporate governance, and take care of all our stakeholders.
					</p>
					</div>
				</div>

				<div class="col-md-2">
					<div class="well"><h4>FRIENDLINESS</h4>

					<img src="../images/value5.png" class="img-responsive center-block">
						
					<p>
						We strive to conduct our business with warmth and familiarity while maintaining respect and proper conduct in all aspects of our operations.
					</p>
					</div>
				</div>

				
			</div>
		</div>

		<div class="section-optimizer">
			<div class="row">
				<div class="col-md-6">

					<div class="third-title-greeting">LATEST NEWS</div>

					<p>
						Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
						cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
					</p>
				</div>
				<div class="col-md-6">
					<div class="third-title-greeting">OUR PARTNERS IN SERVICE</div>

					<p>
						Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
						cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
					</p>
				</div>
			</div>
		</div>


		

		<div class="section-optimizer">
			<div class="second-title-greeting">TESTIMONIALS</div>
			<!-- start of carousel -->
			<div id="myCarousel" class="carousel slide" data-ride="carousel">
			  <!-- Indicators -->
			  <ol class="carousel-indicators">
			    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
			    <li data-target="#myCarousel" data-slide-to="1"></li>
			    <li data-target="#myCarousel" data-slide-to="2"></li>
			  </ol>

			  <!-- Wrapper for slides -->
			  <div class="carousel-inner">
			    <div class="item active">
			      <!-- start -->
			      <div class="row">
						<div class="col-md-6">
							<img src="../images/man.png" class="img-responsive right-block">
						</div>
						<div class="col-md-6">
							<div class="rem">
								<div class="well">
								"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
								tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam."
							</div>
							</div>
						</div>
					</div>
			      <!-- end -->
			    </div>

			    <div class="item">
			      <!-- start -->
			      <div class="row">
						<div class="col-md-6">
							<img src="../images/man.png" class="img-responsive right-block">
						</div>
						<div class="col-md-6">
							<div class="rem">
								<div class="well">
								"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
								tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam."
							</div>
							</div>
						</div>
					</div>
			      <!-- end -->
			    </div>

			    <div class="item">
			     <!-- start -->
			      <div class="row">
						<div class="col-md-6">
							<img src="../images/man.png" class="img-responsive right-block">
						</div>
						<div class="col-md-6">
							<div class="rem">
								<div class="well">
								"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
								tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam."
							</div>
							</div>
						</div>
					</div>
			      <!-- end -->
			    </div>
			  </div>

			  <!-- Left and right controls -->
			  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
			    <span class="glyphicon glyphicon-chevron-left"><i class="fas fa-arrow-left"></i></span>
			  </a>
			  <a class="right carousel-control" href="#myCarousel" data-slide="next">
			    <span class="glyphicon glyphicon-chevron-right"><i class="fas fa-arrow-right"></i></span>
			  </a>
			</div>
			<!-- end of carousel -->
		</div>


		<!-- Footer Section -->
		
			<div class="class-section-optimizer">
				<div class="footer-design">
					<div class="row rem-margin">
					
						<div class="col-md-2  col-md-offset-1">
							<div class="fourth-title-greeting">
								CONTACT US 
							</div>
						</div>
						<div class="col-md-2">
							<div class="fourth-title-greeting">
								ABOUT US 
							</div>
						</div>
						<div class="col-md-2">
							<div class="fourth-title-greeting">
								CAREER OPPORTUNITIES 
							</div>
						</div>
						<div class="col-md-2">
							<div class="fourth-title-greeting">
								CUSTOMER TOOLS
							</div>
						</div>
						<div class="col-md-2">
							<div class="fourth-title-greeting">
								USEFUL LINKS 
							</div>
						</div>
					</div>
				</div>
			</div>
		


				
	</div> <!-- end of container-fluid -->
</body>
</html>
