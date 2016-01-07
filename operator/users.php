<?php
session_start();
include '../classes/WebPage.php'; //Set up page as a web page
$thisPage = new WebPage('../includes/constants.php'); //Create new instance of webPage class

//If user is not loggedIn reject the user 
if(!isset($_SESSION['LoggedIn']) || $_SESSION['USERTYPE']!='Admin'){$thisPage->redirectTo('index');}//redirect user to login page

$msg = ""; //Success or failure message 
$errorArr = array(); //Array of errors

$dbObj = new Database();
$userObj = new User();

//User Deletion Handler
if(filter_input(INPUT_POST, "delete-user")!==NULL){
    $userToDel = new User(); //Instantiate user class
    $userToDel->id = filter_input(INPUT_POST, 'hidden-user-id') ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, 'hidden-user-id', FILTER_VALIDATE_INT)) :  ''; 
    if(filter_input(INPUT_POST, 'hidden-user-id') === "") {array_push ($errorArr, "Illegal Operation.");}
    
    //If validated and not empty submit it to database
    if(count($errorArr) < 1)   {if($userToDel->delete($dbObj,'users')==='success') {$msg = $thisPage->messageBox('User successfully deleted.', 'success');} else {$msg = $thisPage->messageBox('User deletion failed.', 'error');}}
    //Else show error messages
    else{ $msg = $thisPage->showError($errorArr); }
}
//Admin Role Changer button click handler
if(filter_input(INPUT_POST, "upgrade-user")!==NULL){
    if(filter_input(INPUT_POST, 'hidden-user-id') === "") {array_push ($errorArr, "Illegal operation parameter 1.");}
    if(filter_input(INPUT_POST, 'hidden-user-role') === "") {array_push ($errorArr, "Illegal operation parameter 2.");}
    if(count($errorArr) < 1)   { 
        $postRoleVar = 'Admin'; //set default role to activate 
        if(filter_input(INPUT_POST, 'hidden-user-role') == 'Admin'){ $postRoleVar = 'Editor';}//if admin already make editor
        User::updateSingle($dbObj, 'users', 'role', $postRoleVar, filter_input(INPUT_POST, 'hidden-user-id'));//Update the role
    }
    else{ $msg = $thisPage->showError($errorArr); }
}
?>
<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="utf-8">
    <title>All Users</title>
    
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
                            <h3>All Users</h3>
                        </div> <!-- /widget-header -->
            <div class="widget-content">
                <a href="new-user" class="btn btn-success" type="button"><i class="icon-plus"></i> Add User</a>
                <br />
                <br />
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th> First Name</th>
                    <th> Last Name</th>
                    <th> Role</td>
                    <th> Operations</th>
                  </tr>
                </thead
                <tbody>
                  <?php 
                  $fetchedUsers = $userObj->fetch($dbObj, 'users');
                  
                  foreach ($fetchedUsers as $fetchedUser) {
                    $fetUserRole = 'icon-check-empty'; $fetUserRolCol = 'btn-warning'; $fetUserTitle='Make User Admin';
                    if($fetchedUser['role']=='Admin'){$fetUserRole = 'icon-check'; $fetUserRolCol = 'btn-success'; $fetUserTitle='Make User Editor';}
                    echo '<tr>
                    <td>'.$fetchedUser['firstname'].'</td>
                    <td>'.$fetchedUser['lastname'].'</td>
                    <td>'.$fetchedUser['role'].'</td>
                    <form action="" method="post">
                    <input type="hidden" name="hidden-user-id" value="'.$fetchedUser['id'].'"><input type="hidden" name="hidden-user-role" value="'.$fetchedUser['role'].'">
                    <td class="td-actions"><button type="submit" name="delete-user" class="btn btn-danger btn-small" title="Delete"><i class="btn-icon-only icon-trash"> </i></button> <button type="submit" name="upgrade-user" class="btn '.$fetUserRolCol.' btn-small" title="'.$fetUserTitle.'"><i class="btn-icon-only '.$fetUserRole.' "> </i></button></td>
                    </form>
                  </tr>';
                  }
                  ?>
                </tbody>
              </table>
            </div>
            <!-- /widget-content --> 
						
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
