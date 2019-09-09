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
  
</head>
<body>
    <div id="cropPicture"></div>
<button type="button" id="showDataImage">click Me to show image</button>
<script type="text/javascript">
     $('#showDataImage').click(function() {

            $.ajax({
              type:'POST',
              url:'showImageUpload',
              success:function(data){
               
               //console.log(data);

               /*start*/

                    //$('#cropPicture').html(data);
                $cropPicture  = $("#cropPicture");
                var reader  = new FileReader();
                /*start*/
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
                         };
                        img.src = evt.target.cropPicture;
                       }
                       //displays the image in canvass
                       //reader.readAsDataURL(this.files[0]);
                       reader.readAsDataURL(data);
                /*end*/
                //cropPicture.append( $('<img>').attr('src', data).attr('width', 250).attr('height', 250) );
               /*end*/
                
              } 
            });

           
        });
</script>
</body>
</html>


