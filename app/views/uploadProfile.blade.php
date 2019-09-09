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


    <title>Image Profile Picture uploader</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    

    {{ HTML::style("css/bootstrap.min.css")}}

   

    {{ HTML::style("css/mystyle.css")}}

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/cropper/4.0.0/cropper.min.css">

    {{ HTML::script("js/jquery-3.3.1.min.js")}}

    {{ HTML::script("js/bootstrap.min.js")}}

    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropper/4.0.0/cropper.min.js"></script>

    {{ HTML::script("js/myscript.js")}}

    <style type="text/css">
        
        img {
              max-width: 100%; /* This rule is very important, please do not ignore this! */
            }

            #canvas {
              height: 100%;
              width:  100%;
              background-color: #ffffff;
              cursor: default;
              border: 1px solid black;
            }

    </style>
    
	
</head>
<body>
	<div class="container-fluid">
     
        <div class="row">
            <div class="col-md-4">
                <h2>Sample Profile Picture Image Upload</h2>
            </div>
        </div>
        <div class="container">
          <div class="col-md-3">
              <div class="row">
                <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>
              </div> 
          </div>
        </div>


        <div id="cropPicture"></div>
        <!-- start of modal-->
        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">User Information</h4>
              </div>
              <div class="modal-body">
              <form class="form-horizontal" action="upload" method="POST" files="true" enctype="multipart/form-data" id="avatarUpload">
               <div class="container-fluid">
                   <div class="row">
                    <!-- start left col -->
                    <div class="col-md-6">
                      <!-- <div class="form-group">
                        <label class="control-label" for="firstName">First Name:</label>
                        <div>          
                          <input type="text" class="form-control" id="fName" placeholder="First Name" name="fName" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label" for="middleName">Middle Name:</label>
                        <div>          
                          <input type="text" class="form-control" id="mName" placeholder="Middle Name" name="mName" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label" for="lastName">Last Name:</label>
                        <div>          
                          <input type="text" class="form-control" id="lName" placeholder="Last Name" name="lName" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label" for="Birthdate">Birthdate:</label>
                        <div>          
                          <input type="date" class="form-control" id="birthDate" name="birthDate" required>
                        </div>
                      </div> -->
                      <div class="form-group">
                        <label class="control-label" for="username">Username:</label>
                        <div>          
                          <input type="text" class="form-control" id="username" placeholder="username" name="username" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label" for="email">Email:</label>
                        <div>
                          <input type="email" class="form-control" id="email" placeholder="Email" name="email" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label" for="password">Password:</label>
                        <div>          
                          <input type="password" class="form-control" id="password" placeholder="Enter password" name="pwd">
                        </div>
                      </div>
                 <!--      <div class="form-group">
                        <label class="control-label" for="currAddress">Current Address:</label>
                        <div>          
                          <input type="text" class="form-control" id="currAddress" placeholder="Current Address" name="currAddress" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label" for="permAddress">Permanent Address:</label>
                        <div>          
                          <input type="text" class="form-control" id="permAddress" placeholder="Permanent Address" name="permAddress" required>
                        </div>
                      </div> -->
                    </div>
                    <!-- start right col -->
                    <div class="col-md-6">
                      <div class="form-group">
                      <label class="control-label" for="profPicture">Profile Picture:</label>
                      <div style="margin-left: 3%">          
                         <input type="file" name="fileInput" id="fileInput" accept="image/*" class="form-control">
                         <input type="button" id="btnCrop" value="Crop" />
                        <input type="button" id="btnRestore" value="Restore" />
                      </div>
                    </div>
                    <div>
                      <canvas id="canvas" style="margin-left: 5%">
                        Your browser does not support the HTML5 canvas element.
                      </canvas>
                    </div>  
                  </div>
                  <div class="row">
                    <div id="result" style="margin-left: 5%; padding-top: 2%"></div>
                     <div class="form-group">
                      <a id="btnSubmit" class="btn btn-success" style="margin-left: 5%" data-dismiss="modal">Submit</a>
                     </div>
                  </div>
               </div>
              </form>
              </div>
              <div class="modal-footer">
                <button  class="btn btn-primary" data-dismiss="modal">CLOSE</button>
              </div>
            </div>

          </div>
        </div>
        <!-- end of modal -->

     
    </div> <!-- End of container fluid -->

    <script type="text/javascript">


       var croppedImageDataURL = '';

        $('#fileInput').on('change',function(){

        var canvas  = $("#canvas");
        var context = canvas.get(0).getContext("2d");
        $result = $('#result');

            //check if file is loaded
             if (this.files && this.files[0]) {
                //check if file is an image
                 if ( this.files[0].type.match(/^image\//) ) {
                    //start
                      var reader = new FileReader();
                      reader.onload = function(evt) {
                         var img = new Image();
                         //sets canvass width and height
                         img.onload = function() {
                           context.canvas.height = img.height;
                           context.canvas.width  = img.width;
                           context.drawImage(img, 0, 0);
                           var cropper = canvas.cropper({
                             aspectRatio: 4 / 4
                           });
                           $('#btnCrop').click(function() {
                              // Get the width and height and converts a string base 64 data url
                              //croppedImageDataURL = canvas.cropper('getCroppedCanvas').toDataURL("image/png");
                              croppedImageDataURL = canvas.cropper('getCroppedCanvas').toDataURL("image/png");
                              //console.log(croppedImageDataURL);
                              $result.append( $('<img>').attr('src', croppedImageDataURL).attr('width', 250).attr('height', 250) );
                           });
                          $('#btnRestore').click(function() {
                             canvas.cropper('reset');
                             $result.empty();
                           });
                         };
                        img.src = evt.target.result;
                       }
                       //displays the image in canvass
                       reader.readAsDataURL(this.files[0]);
                    //end
                 }else {
                    alert("Please upload an image file type");
                 }
            // no file is loaded 
             } else {
                alert("no file is loaded");
             }
        });

        $('#btnSubmit').click(function() {
              
             $cropPicture = $('#cropPicture');  

            $.ajax({
              type:'POST',
              url:'upload',
              data: {
                _croppedImageDataURL: croppedImageDataURL
              },
              success:function(data){
               
               //console.log(data);//$('<img>').attr('src', data).attr('width', 250).attr('height', 250)
               //cropPicture.append( '<img src="'+ data +'" />' );
               $("img#cropPicture").attr('src' , data); 
              } 
            });

           
        });

       
    </script>
</body>
</html>

