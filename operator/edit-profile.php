<?php
session_start();
include '../classes/WebPage.php'; //Set up page as a web page
$thisPage = new WebPage('../includes/constants.php'); //Create new instance of webPage class

//If user is not loggedIn reject the user 
if(!isset($_SESSION['LoggedIn'])){$thisPage->redirectTo('index');}//redirect user to login page

$msg = ""; //Success or failure message 
$errorArr = array(); //Array of errors

$dbObj = new Database(); //create database object
$thisUser = new User(); //Instantiate user class
$thisUser->id = $_SESSION['USERID'];//set this user id

//User Profile Update Handler
if(filter_input(INPUT_POST, "submit")!==NULL){
    $postVars = ['username','fname','lname', 'role']; // User creation Form fields names
    //Validate the POST variables and add up to error message if empty
    foreach ($postVars as $postVar){
        switch($postVar){
            case 'role':if(filter_input(INPUT_POST, "role")==NULL){$thisUser->$postVar = 'Editor';}
                        else{$thisUser->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                        if(filter_input(INPUT_POST, $postVar) === "") {array_push ($errorArr, "Please enter $postVar ");}}
                        break;
            default:    $thisUser->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                        if(filter_input(INPUT_POST, $postVar) === "") {array_push ($errorArr, "Please enter $postVar ");}
                        break;
        }
    }
    //If validated and not empty submit it to database
    if(count($errorArr) < 1)   {if($thisUser->update($dbObj, 'users')==='success') {$msg = $thisPage->messageBox('Profile successfully updated.', 'success');} else {$msg = $thisPage->messageBox('Profile update failed.', 'error');}}
    //Else show error messages
    else{ $msg = $thisPage->showError($errorArr); }
}

?>
<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="utf-8">
    <title>Edit Profile</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">    
    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
    
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet">
    
    <link href="css/style.css" rel="stylesheet">
    
    
    <link href="css/pages/plans.css" rel="stylesheet"> 

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
                            <i class="icon-user"></i>
                            <h3>Edit Profile</h3>
                        </div> <!-- /widget-header -->
			<div class="widget-content">
                            <div class="content clearfix">
                                <?php echo $msg;?>
                                <?php 
                                    $thisUserDetails = $thisUser->fetchById($dbObj, 'users');
                                    foreach ($thisUserDetails as $thisUserDetail) {
                                ?>
                                <form id="edit-profile" class="form-horizontal" method="post">
                                <fieldset>						
                                    <div class="control-group">											
                                        <label class="control-label" for="username">Username</label>
                                        <div class="controls">
                                    <input type="text" class="span4 " id="username" name="username" value="<?php echo $thisUserDetail['username']; ?>" >
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
										
                                    <div class="control-group">											
                                        <label class="control-label" for="fname">First Name</label>
                                        <div class="controls">
                                            <input type="text" class="span4" id="fname" name="fname" value="<?php echo $thisUserDetail['firstname']; ?>">
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
															
                                    <div class="control-group">											
                                        <label class="control-label" for="lname">Last Name</label>
                                        <div class="controls">
                                            <input type="text" class="span4" id="lname" name="lname" value="<?php echo $thisUserDetail['lastname']; ?>">
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <?php if(isset($_SESSION['USERTYPE'])&& $_SESSION['USERTYPE']=='Admin') {echo '<div class="control-group">											
                                        <label class="control-label" for="radiobtns">Admin Role</label>
                                         <div class="controls">
                                            <select name="role" value="'.$thisUserDetail['role'].'">
                                                <option value="Admin" >Admin</option>
                                            </select>
                                        </div>	<!-- /controls -->			
                                    </div> <!-- /control-group -->';}} ?>
                                     
					 <br />
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-primary" name="submit">Update</button> 
                                        <button class="btn btn-danger" type="button" onclick="window.history.back()">Cancel/Return</button>
					</div> <!-- /form-actions -->
                                </fieldset>
                                
                            </form>
		
	</div> <!-- /content -->
						
					</div> <!-- /widget-content -->
						
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

  </body>

</html>
