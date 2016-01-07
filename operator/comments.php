<?php
session_start();
include '../classes/WebPage.php'; //Set up page as a web page
$thisPage = new WebPage('../includes/constants.php'); //Create new instance of webPage class

//If user is not loggedIn reject the user 
if(!isset($_SESSION['LoggedIn'])){$thisPage->redirectTo('index');}//redirect user to login page

$msg = ""; //Success or failure message 
$errorArr = array(); //Array of errors

$dbObj = new Database(); //create database object
$sitePost = new Post(); //Instantiate post class
$postComment = new Comment(); //Create comment object

//Post Deletion Handler
if(filter_input(INPUT_POST, "delete-comment")!==NULL){
    $commentToDel = new Comment(); //Instantiate post class
    $commentToDel->id = filter_input(INPUT_POST, 'hidden-comment-id') ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, 'hidden-comment-id', FILTER_VALIDATE_INT)) :  ''; 
    if(filter_input(INPUT_POST, 'hidden-comment-id') === "") {array_push ($errorArr, "Illegal Operation.");}
    
    //If validated and not empty submit it to database
    if(count($errorArr) < 1)   {if($commentToDel->delete($dbObj)==='success') {$msg = $thisPage->messageBox('Comment successfully deleted.', 'success');} else {$msg = $thisPage->messageBox('Comment deletion failed.', 'error');}}
    //Else show error messages
    else{ $msg = $thisPage->showError($errorArr); }
}
//Post Activation button click handler
if(filter_input(INPUT_POST, "activate-comment")!==NULL){
    if(filter_input(INPUT_POST, 'hidden-comment-id') === "") {array_push ($errorArr, "Illegal operation parameter 1.");}
    if(filter_input(INPUT_POST, 'hidden-comment-status') === "") {array_push ($errorArr, "Illegal operation parameter 2.");}
    if(count($errorArr) < 1)   { 
        $postStatusVar = 1; //set status to activate 
        if(filter_input(INPUT_POST, 'hidden-comment-status', FILTER_VALIDATE_INT) == 1){ $postStatusVar = 0;}//if activated already deactivate
        Comment::updateSingle($dbObj, 'status', $postStatusVar, filter_input(INPUT_POST, 'hidden-comment-id', FILTER_VALIDATE_INT));//Update the status
    }
    else{ $msg = $thisPage->showError($errorArr); }
}
?>
<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="utf-8">
    <title>Comments</title>
    
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
                            <i class="icon-comment"></i>
                            <h3>All comments</h3>
                        </div> <!-- /widget-header -->
            <div class="widget-content">
               
              <table class="table table-striped table-bordered">
                  <thead>
                  <tr>
                      <th>Date</th>
                    <th style="width:20%"> Comments </th>
                    <th> Post Title</th>
                    <th> Name</th>
                    <th> Email</th>
                    <th class="td-actions"> Operations </th>
                  </tr>
                </thead>
                <tbody>
                <?php
                $reqCommCond = "";
                if(filter_input(INPUT_GET, "id") != NULL){ 
                    $reqCommCond = " post_id = ".filter_input(INPUT_GET, "id");
                } 
                $fetchedComments = $postComment->fetch($dbObj, "*", "$reqCommCond", " date,post_id DESC "); //Fetch all post details
                foreach ($fetchedComments as $fetchedComment){
                    $commentPostDet = $sitePost->fetch($dbObj, "*", " id=".$fetchedComment['post_id']);
                    $commentPostTit ='';
                    foreach ($commentPostDet as $commentPost) {
                        $commentPostTit = $commentPost['title'];
                    }
                    $fetPostStatus = 'icon-check-empty'; $fetPostStatCol = 'btn-warning';
                    if($fetchedComment['status']==1){$fetPostStatus = 'icon-check'; $fetPostStatCol = 'btn-success';}
                    echo '<tr>
                      <td>'.$fetchedComment['date'].'</td>
                      <td>'.utf8_encode($fetchedComment['comment']).'</td>
                      <td>'.$commentPostTit.'</td>
                      <td> '.$fetchedComment['name'].'</td>
                      <td> '.$fetchedComment['email'].'</td>
                      <form action="" method="post">
                      <input type="hidden" name="hidden-comment-id" value="'.$fetchedComment['id'].'"><input type="hidden" name="hidden-comment-status" value="'.$fetchedComment['status'].'">
                      <td class="td-actions"><button type="submit" name="delete-comment" class="btn btn-danger btn-small" title="Delete"><i class="btn-icon-only icon-trash"> </i></button> <button type="submit" name="activate-comment" class="btn '.$fetPostStatCol.' btn-small"  title="Activate"><i class="btn-icon-only '.$fetPostStatus.' "> </i></button></td>
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
    
<?php require 'includes/footer.php'; ?>

<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/jquery-1.7.2.min.js"></script>

<script src="js/bootstrap.js"></script>
<script src="js/base.js"></script>

  </body>

</html>
