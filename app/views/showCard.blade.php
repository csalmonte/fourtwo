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

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

	{{ HTML::style("css/mystyle.css")}}

	{{ HTML::script("js/jquery-3.3.1.min.js")}}

	{{ HTML::script("js/bootstrap.min.js")}}

    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

	{{ HTML::script("js/myscript.js")}}
	
</head>
<body>
	<!-- Start of container fluid -->
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-4">
                <button id="card1btn" name="card1btn" value="card1" onclick="togglePaneWindow(this.value)">Card 1</button>
            </div>    
           <div class="col-md-4">
                <button id="card2btn" name="card2btn" value="card2" onclick="togglePaneWindow(this.value)">Card 2</button>
            </div>  
            <div class="col-md-4">
                <button id="card3btn" name="card3btn" value="card3" onclick="togglePaneWindow(this.value)">Card 3</button>
            </div>     
            
        </div>

         <div class="row">

            <div class="col-md-4">

               <div id="card1pane">

                    <!-- Start of Card 1 pane -->
                    <h1>Card 1</h1>
                    <form action="/submitContactForm" method="post">
                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                Please fix the following errors
                            </div>
                        @endif

                        
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Title">
                            @if($errors->has('title'))
                                <span class="help-block">{{ $errors->first('title') }}</span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
                            <label for="url">Url</label>
                            <input type="text" class="form-control" id="url" name="url" placeholder="URL">
                            @if($errors->has('url'))
                                <span class="help-block">{{ $errors->first('url') }}</span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" placeholder="description"></textarea>
                            @if($errors->has('description'))
                                <span class="help-block">{{ $errors->first('description') }}</span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>

                    <!-- End of Card 1 pane -->
               </div>

            </div>    
           <div class="col-md-4">

               <div id="card2pane">

                 <!-- Start of Card 2 pane -->
                    <h1>Card 2</h1>
                    <form action="/submitContactForm" method="post">
                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                Please fix the following errors
                            </div>
                        @endif

                        
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Title">
                            @if($errors->has('title'))
                                <span class="help-block">{{ $errors->first('title') }}</span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
                            <label for="url">Url</label>
                            <input type="text" class="form-control" id="url" name="url" placeholder="URL">
                            @if($errors->has('url'))
                                <span class="help-block">{{ $errors->first('url') }}</span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" placeholder="description"></textarea>
                            @if($errors->has('description'))
                                <span class="help-block">{{ $errors->first('description') }}</span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>

                    <!-- End of Card 2 pane -->
                   
               </div>

            </div>  
            <div class="col-md-4">

               <div id="card3pane">

                     <!-- Start of Card 3 pane -->
                    <h1>Card 3</h1>
                    <form action="/submitContactForm" method="post">
                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                Please fix the following errors
                            </div>
                        @endif

                        
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Title">
                            @if($errors->has('title'))
                                <span class="help-block">{{ $errors->first('title') }}</span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
                            <label for="url">Url</label>
                            <input type="text" class="form-control" id="url" name="url" placeholder="URL">
                            @if($errors->has('url'))
                                <span class="help-block">{{ $errors->first('url') }}</span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" placeholder="description"></textarea>
                            @if($errors->has('description'))
                                <span class="help-block">{{ $errors->first('description') }}</span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>

                    <!-- End of Card 3 pane -->
                   
               </div>
                
            </div>     
            
        </div>

       


    </div> 
    <!-- End of Container Fluid -->
</body>
</html>
