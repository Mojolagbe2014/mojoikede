<?php
session_start();
include '../classes/WebPage.php'; //Set up page as a web page
$thisPage = new WebPage('../includes/constants.php'); //Create new instance of webPage class

//If user is not loggedIn reject the user 
if(!isset($_SESSION['LoggedIn'])){$thisPage->redirectTo('index');}//redirect user to login page

$msg = ""; //Success or failure message 
$errorArr = array(); //Array of errors


?>
<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="utf-8">
    <title>Media</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">    
    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
    
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet">
    
    <link href="css/style.css" rel="stylesheet">
    
    
    <link href="css/pages/plans.css" rel="stylesheet"> 
    
    <script type="text/javascript" src="ckeditor/ckeditor.js"></script>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

  </head>

<body>

<?php include 'includes/header.php';?>
    
    
<div class="main">
	
    <div class="main-inner">

        <div class="container">
	
	    <div class="row">
                <div class="span12">
                    <div class="widget">			
			<div class="widget-header">
                            <i class="icon-camera"></i>
                            <h3>All Media</h3>
                        </div> <!-- /widget-header -->
                        <div class="widget-content">
                            <a href="new-media" class="btn btn-success" type="button"><i class="icon-plus"></i> Add Image</a>
                            <br />
                            <br />
                          <table class="table table-striped table-bordered">
                            <tbody>
                              <tr>
                                <td> Preview</td>
                                <td> Image Name</td>
                                <td> Operations</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                    </div> <!-- /widget -->					
				
                </div> <!-- /span12 -->
	      </div> <!-- /row -->
	
	    </div> <!-- /container -->
	    
	</div> <!-- /main-inner -->
    
</div> <!-- /main -->
    


<?php include ('includes/footer.php'); ?>
    

<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/jquery-1.7.2.min.js"></script>

<script src="js/bootstrap.js"></script>
<script src="js/base.js"></script>
<script>
    var fileextension = Array('.jpg','.gif','.bmp','.png');
    //var fileextension = '.jpg';
    $.ajax({
        url: "get-images.php",
        dataType: "json",
        success: function (data) {
            $.each(data, function(i,filename) {
                $.each(fileextension, function(j, ext){
                    if(filename.indexOf(ext)>=0)
                        $('table').append('<tr><td><img width="40px" height="40px" src="'+ filename +'"></td><td>'+ filename.replace('../media/','') +'</td><td class="td-actions"><a href="delete-images?file='+ filename.replace('../media/','') +'" class="btn btn-danger btn-small"><i class="btn-icon-only icon-trash"> </i></a></td></tr>');
                });
            });
        }
    });
</script>
  </body>

</html>
