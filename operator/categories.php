<?php
session_start();
include '../classes/WebPage.php'; //Set up page as a web page
$thisPage = new WebPage('../includes/constants.php'); //Create new instance of webPage class

//If user is not loggedIn reject the user 
if(!isset($_SESSION['LoggedIn'])){$thisPage->redirectTo('index');}//redirect user to login page

$msg = ""; //Success or failure message 
$errorArr = array(); //Array of errors

$dbObj = new Database(); //create database object

//Category Deletion Handler
if(filter_input(INPUT_POST, "delete-cat")!==NULL){
    $catToDel = new Category(); //Instantiate post class
    $catToDel->id = filter_input(INPUT_POST, 'hidden-cat-id') ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, 'hidden-cat-id', FILTER_VALIDATE_INT)) :  ''; 
    if(filter_input(INPUT_POST, 'hidden-cat-id') === "") {array_push ($errorArr, "Illegal operation parameter 1.");}
    
    //If validated and not empty submit it to database
    if(count($errorArr) < 1)   {if($catToDel->delete($dbObj)==='success') {$msg = $thisPage->messageBox('Category successfully deleted.', 'success');} else {$msg = $thisPage->messageBox('Category deletion failed.', 'error');}}
    //Else show error messages
    else{ $msg = $thisPage->showError($errorArr); }
}
//Edit Category button click handler
if(filter_input(INPUT_POST, "edit-cat")!==NULL){
    if(filter_input(INPUT_POST, 'hidden-cat-id') === "") {array_push ($errorArr, "Illegal operation parameter 1.");}
    if(count($errorArr) < 1)   { 
        $_SESSION['catToEdit'] = filter_input(INPUT_POST, 'hidden-cat-id', FILTER_VALIDATE_INT);//Set id of the psot to edit into s session var
        $thisPage->redirectTo('edit-category');
    }
    else{ $msg = $thisPage->showError($errorArr); }
}

?>
<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="utf-8">
    <title>All Categories</title>
    
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
                            <h3>All Categories</h3>
                        </div> <!-- /widget-header -->
            <div class="widget-content">
                <button class="btn btn-danger" onclick="window.location='new-category'" type="button"><i class="icon-plus"></i> Add Category</button>
                <br /><br/>
                <?php echo $msg; ?>
              <table class="table table-striped table-bordered">
                  <thead>
                  <tr>
                    <th> Category Name </th>
                    <th> Meta Description</th>
                    <th> Meta Title</th>
                    <th> Parent Category</th>
                    <th class="td-actions"> Actions</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                $catObj = new Category(); //Instantiate Category class
                $fetchedCats = $catObj->fetch($dbObj); //Fetch all categories details
                foreach ($fetchedCats as $fetchedCat){
                    //Fetch the parent category of the category
                    $fetchedCatsPar = '';
                    //Using each number/integer from the $fetchedCatsPar above then fetch the name of the parent category
                    if($fetchedCat['parent'] !=0){$fetchedCatsPar .= '  <button class="btn btn-invert" type="button">'.Category::getName($dbObj,$fetchedCat['parent']).'</button> ';}
                    
                    
                    echo '<tr>
                      <td>'.$fetchedCat['name'].'</td>
                      <td> '.$fetchedCat['meta'].'</td>
                      <td> '.$fetchedCat['title'].'</td>
                      <td> '.$fetchedCatsPar.'</td>
                      <form action="" method="post">
                      <input type="hidden" name="hidden-cat-id" value="'.$fetchedCat['id'].'">
                      <td class="td-actions"><button type="submit" name="delete-cat" class="btn btn-danger btn-small"><i class="btn-icon-only icon-trash"> </i></button> <button type="submit" name="edit-cat" class="btn btn-info btn-small"><i class="btn-icon-only icon-pencil"> </i></button> </td>
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
