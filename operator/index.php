<?php
session_start();
include '../classes/WebPage.php'; //Set up page as a web page
$thisPage = new WebPage('../includes/constants.php');//Create new instance of webPage class

$msg = ""; //Success or failure message 
$errorArr = array(); //Array of errors

$dbObj = new Database(); //create database object
$thisUser = new User(); //Instantiate user class

//Login Handler
if(filter_input(INPUT_POST, "login")!==NULL){
    $postVars = ['username','password']; // Login Form field names
    foreach ($postVars as $postVar){
        $thisUser->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
        if(filter_input(INPUT_POST, $postVar) == "") {array_push ($errorArr, "Please enter a $postVar ");}
    }
    if(count($errorArr) < 1){
        switch ($thisUser->login($dbObj,'users')){
            case 'success': $thisPage->redirectTo('dashboard'); break;
            case 'error': $msg = $thisPage->messageBox('Login Failed. Please re-enter you login details.', 'error'); break;
        }
    } 
    else{ $msg = $thisPage->showError($errorArr); }//Display error messages
}
//Logout Handler 
if(!isset($_SESSION['LoggedIn']) && filter_input(INPUT_GET, base64_encode('loggedout'))!==NULL && filter_input(INPUT_POST, "login") ===NULL){
    $msg = $thisPage->messageBox('You are now successfully logged out', 'success');
}
?>
<!DOCTYPE html>
<html lang="en">
  
<head>
<meta charset="utf-8">
<title>Login - Custom Advert Manager </title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes"> 
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
<link href="css/font-awesome.css" rel="stylesheet">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/pages/signin.css" rel="stylesheet" type="text/css">
</head>

<body>
	
	<div class="navbar navbar-fixed-top">
	
	<div class="navbar-inner">
		
		<div class="container">
			
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			
			<a class="brand" href="index.html">
				Custom Advert Manager				
			</a>		

		</div> <!-- /container -->
		
	</div> <!-- /navbar-inner -->
	
</div> <!-- /navbar -->

<div class="account-container">
	
	<div class="content clearfix">
		
		<form action="#" method="post">
		
			<h1>Authentication Form</h1>		
			
			<div class="login-fields">
				<?php echo $msg;?>
				<p>Please provide your details</p>
				
				<div class="field">
					<label for="username">Manager ID</label>
					<input type="text" id="username" name="username" value="" placeholder="Manager ID" class="login username-field" />
				</div> <!-- /field -->
				
				<div class="field">
					<label for="password">Secret PIN:</label>
					<input type="password" id="password" name="password" value="" placeholder="Secret PIN" class="login password-field"/>
				</div> <!-- /password -->
				
			</div> <!-- /login-fields -->
			
			<div class="login-actions">
				
				<span class="login-checkbox">
					<input id="Field" name="Field" type="checkbox" class="field login-checkbox" value="First Choice" tabindex="4" />
					<label class="choice" for="Field">Keep me signed in</label>
				</span>
									
                            <button class="button btn btn-success btn-large" name="login">Sign In</button>
				
			</div> <!-- .actions -->
			
			
			
		</form>
		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->
<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/signin.js"></script>
</body>
</html>
