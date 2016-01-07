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
if(filter_input(INPUT_POST, "delete-post")!==NULL){
    $postToDel = new Post(); //Instantiate post class
    $postToDel->id = filter_input(INPUT_POST, 'hidden-post-id') ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, 'hidden-post-id', FILTER_VALIDATE_INT)) :  ''; 
    if(filter_input(INPUT_POST, 'hidden-post-id') === "") {array_push ($errorArr, "Illegal Operation.");}
    
    //If validated and not empty submit it to database
    if(count($errorArr) < 1)   {if($postToDel->delete($dbObj)==='success') {$msg = $thisPage->messageBox('Post successfully deleted.', 'success');} else {$msg = $thisPage->messageBox('Post deletion failed.', 'error');}}
    //Else show error messages
    else{ $msg = $thisPage->showError($errorArr); }
}
//Edit Post button click
if(filter_input(INPUT_POST, "edit-post")!==NULL){
    if(filter_input(INPUT_POST, 'hidden-post-id') === "") {array_push ($errorArr, "Illegal Operation.");}
    if(count($errorArr) < 1)   { 
        $_SESSION['postToEdit'] = filter_input(INPUT_POST, 'hidden-post-id', FILTER_VALIDATE_INT);//Set id of the psot to edit into s session var
        $thisPage->redirectTo('edit-post');
    }
    else{ $msg = $thisPage->showError($errorArr); }
}
//Post Activation button click handler
if(filter_input(INPUT_POST, "activate-post")!==NULL){
    if(filter_input(INPUT_POST, 'hidden-post-id') === "") {array_push ($errorArr, "Illegal operation parameter 1.");}
    if(filter_input(INPUT_POST, 'hidden-post-status') === "") {array_push ($errorArr, "Illegal operation parameter 2.");}
    if(count($errorArr) < 1)   { 
        $postStatusVar = 1; //set status to activate 
        if(filter_input(INPUT_POST, 'hidden-post-status', FILTER_VALIDATE_INT) == 1){ $postStatusVar = 0;}//if activated already deactivate
        Post::updateSingle($dbObj, 'status', $postStatusVar, filter_input(INPUT_POST, 'hidden-post-id', FILTER_VALIDATE_INT));//Update the status
    }
    else{ $msg = $thisPage->showError($errorArr); }
}
?>
<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="utf-8">
    <title>All Posts</title>
    
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
                            <i class="icon-flag"></i>
                            <h3>All Posts</h3>
                        </div> <!-- /widget-header -->
            <div class="widget-content">
                <button class="btn btn-danger" onclick="window.location='new-post'" type="button"><i class="icon-plus"></i> Add Post</button>
                <br /><br/>
                <?php echo $msg; ?>
              <table class="table table-striped table-bordered">
                  <thead>
                  <tr>
                    <th> Post Title </th>
                    <th> Category</th>
                    <th> Comments</th>
                    <th class="td-actions"> Actions</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                $fetchedPosts = $sitePost->fetch($dbObj); //Fetch all post details
                foreach ($fetchedPosts as $fetchedPost){
                    //Fetch the category of the post and convert it into array ofintegers
                    $fetPostCatIds = explode(':', $fetchedPost['category']); $fetchedPostsCats = '';
                    //Using each number/integer from the array above then fetch the name of the category
                    for($i=0; $i<count($fetPostCatIds)-1; $i++){
                        $fetchedPostsCats .= '  <button class="btn btn-invert" type="button">'.Category::getName($dbObj,$fetPostCatIds[$i]).'</button> ';//$fetPostCatId;
                    }
                    $fetPostStatus = 'icon-check-empty'; $fetPostStatCol = 'btn-warning';
                    if($fetchedPost['status']==1){$fetPostStatus = 'icon-check'; $fetPostStatCol = 'btn-success';}
                    echo '<tr>
                      <td>'.$fetchedPost['title'].'</td>
                      <td> '.$fetchedPostsCats.'</td>
                      <td> <a href="comments?id='.$fetchedPost['id'].'" title="View the comments">'.count($postComment->fetch($dbObj, "*", " post_id=".$fetchedPost['id'])).'</a></td>
                      <form action="" method="post">
                      <input type="hidden" name="hidden-post-id" value="'.$fetchedPost['id'].'"><input type="hidden" name="hidden-post-status" value="'.$fetchedPost['status'].'">
                      <td class="td-actions"><button type="submit" name="delete-post" class="btn btn-danger btn-small" title="Delete"><i class="btn-icon-only icon-trash"> </i></button> <button type="submit" name="edit-post" class="btn btn-info btn-small"  title="Edit"><i class="btn-icon-only icon-pencil"> </i></button> <button type="submit" name="activate-post" class="btn '.$fetPostStatCol.' btn-small"  title="Activate"><i class="btn-icon-only '.$fetPostStatus.' "> </i></button></td>
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
