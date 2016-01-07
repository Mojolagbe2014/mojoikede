<?php
session_start();
include '../classes/WebPage.php'; //Set up page as a web page
$thisPage = new WebPage('../includes/constants.php'); //Create new instance of webPage class

//If user is not loggedIn reject the user 
if(!isset($_SESSION['LoggedIn'])){$thisPage->redirectTo('index');}//redirect user to login page

$msg = ""; //Success or failure message 
$errorArr = array(); //Array of errors
if(isset($_SESSION['msg'])){ $msg = $_SESSION['msg'];}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Dashboard - NST Blog</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
        rel="stylesheet">
<link href="css/font-awesome.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
<link href="css/pages/dashboard.css" rel="stylesheet">
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
            <div class="widget-header"> <i class="icon-bookmark"></i>
              <h3>Shortcuts</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <div class="shortcuts"> 
                  <a href="posts" class="shortcut"><i class="shortcut-icon icon-list-alt"></i><span class="shortcut-label">Posts</span> </a>
                  <a href="comments" class="shortcut"><i class="shortcut-icon icon-comments"></i><span class="shortcut-label">Comments</span> </a>
                  <a href="new-post" class="shortcut"><i class="shortcut-icon icon-upload-alt"></i> <span class="shortcut-label">Add Post</span> </a>
                  <a href="media" class="shortcut"> <i class="shortcut-icon icon-picture"></i><span class="shortcut-label">Media</span> </a>
              </div>
              <!-- /shortcuts --> 
            </div>
            <!-- /widget-content --> 
          </div>
         
        </div>
        <!-- /span6 --> 
      </div>
      <!-- /row --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /main-inner --> 
</div>

<?php include ('includes/footer.php'); ?>
<!-- Le javascript
================================================== --> 
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="js/excanvas.min.js"></script> 
<script src="js/chart.min.js" type="text/javascript"></script> 
<script src="js/bootstrap.js"></script>
<script language="javascript" type="text/javascript" src="js/full-calendar/fullcalendar.min.js"></script>
<script src="js/base.js"></script> 
<script>
    function GetImage(){
       facebox().close()
    }
</script>
<script src="js/jquery.validate-1.13.1.min.js" type="text/javascript"></script>
<script src="js/jquery.validate.additional-methods.min.js" type="text/javascript"></script>
<script>
function validatePassword(){ 
 var validator = $("#changepassform").validate({
  rules: {  
   password1 :"required",
   password :"required",
   passwordagain:{
    equalTo: "#password"
      }  
     },                             
     messages: {
      password1 : "Supply current password",
      password :" Enter new password",
      confirmpassword :" New password mismatch, please try again !"
     }
 });
 if(validator.form()){
  //alert('Sucess');
 }
}
</script>
</body>
</html>
