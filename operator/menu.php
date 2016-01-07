<?php
session_start();
include '../classes/WebPage.php';
$webPage = new WebPage('../includes/constants.php');
//If user is not loggedIn reject the user 
if(!isset($_SESSION['LoggedIn'])){$webPage->redirectTo('index');}//redirect user to login page

$msg = ""; //Success or failure message 
$errorArr = array(); //Array of errors
if(isset($_SESSION['msg'])){ $msg = $_SESSION['msg'];}

$dbObj = new Database(); //create database object
$menuObj = new Menu();//Instantiate menu class

//Menu Addition Handler  for Caategory
if(filter_input(INPUT_POST, "catasmenuname")!==NULL){
    //Validate the POST variables and add up to error message if empty
    $menuObj->title = mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, "catasmenuname")); 
    $menuObj->type = 'category';
    $menuObj->link = str_replace(' ', '-', strtolower(trim(filter_input(INPUT_POST, "catasmenuname"))));
    if(filter_input(INPUT_POST, "catasmenuname") === "") {array_push ($errorArr, "Please select a category to be added to menu");}
    //If validated and not empty submit it to database
    if(count($errorArr) < 1)   {if($menuObj->add($dbObj)==='success') {$msg = $webPage->messageBox('Menu successfully added.', 'success');} else {$msg = $webPage->messageBox('Menu addition failed.', 'error');}}
    else{ $msg = $webPage->showError($errorArr); }//Else show error messages
}
//Menu Addition Handler  for Custom
if(filter_input(INPUT_POST, "custom-menu-submit")!==NULL){
    //Validate the POST variables and add up to error message if empty
    $menuObj->title = mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, "custom-menu-title")); 
    $menuObj->type = 'custom';
    $menuObj->link = str_replace(' ', '-', strtolower(trim(filter_input(INPUT_POST, "custom-menu-link"))));
    if(filter_input(INPUT_POST, "custom-menu-title") === "") {array_push ($errorArr, "Please enter a title ");}
    if(filter_input(INPUT_POST, "custom-menu-link") === "") {array_push ($errorArr, "Please select a link ");}
    //If validated and not empty submit it to database
    if(count($errorArr) < 1)   {if($menuObj->add($dbObj)==='success') {$msg = $webPage->messageBox('Menu successfully added.', 'success');} else {$msg = $webPage->messageBox('Menu addition failed.', 'error');}}
    else{ $msg = $webPage->showError($errorArr); }//Else show error messages
}
//Menu Deletion Handler
if(filter_input(INPUT_POST, "removemenu")!==NULL){
    //Validate the POST variables and add up to error message if empty
    $menuObj->id = mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, "removemenu")); 
    if(filter_input(INPUT_POST, "removemenu") === "") {array_push ($errorArr, "Please select a menu to be deleted");}
    //If validated and not empty submit it to database
    if(count($errorArr) < 1)   {if($menuObj->delete($dbObj)==='success') {$msg = $webPage->messageBox('Menu successfully deleted.', 'success');} else {$msg = $webPage->messageBox('Menu deletion failed.', 'error');}}
    //Else show error messages
    else{ $msg = $webPage->showError($errorArr); }
}
?>
<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="utf-8">
    <title>Menu</title>
    
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
	      	<form id="" class="form-inline" method="post">
                  <div class="span5">
	      		
                    <div class="widget">
						
			<div class="widget-header">
                            <i class="icon-list"></i>
                            <h3>Menus</h3>
                        </div> <!-- /widget-header -->
			<div class="widget-content" style="min-height: 200px">
                            <div class="content clearfix"></div> <!-- /content -->
                            <?php 
                            $fetchedMenuObj = new Menu();//Create a menu object
                            $fetchedMenus = $fetchedMenuObj->fetch($dbObj);//Fetch all menus
                            foreach ($fetchedMenus as $fetchedMenu) {
                                if(!empty($fetchedMenu)){
                                    echo '<form action="" method="POST"><div class="control-group">
                                              <div class="btn-group">
                                              <input type="hidden" name="removemenu" value="'.$fetchedMenu['id'].'">
                                              <a class="btn btn-primary" href="javascript:;">'.$fetchedMenu['title'].'</a>
                                              <button class="btn btn-default" type="submit" name="removethismenu[]" title="Remove Menu"><i class="icon-trash"></i></button>
                                            </div></div></form>'; 
                                }
                            }
                            ?>
                        </div> <!-- /widget-content -->
						
                    </div> <!-- /widget -->					
				
		    </div> <!-- /span12 -->     	
	      	
	      	<div class="span3">
	      		
                    <div class="widget">
						
			<div class="widget-header">
                            <i class="icon-indent-left"></i>
                            <h3>Category</h3>
                        </div> <!-- /widget-header -->
			<div class="widget-content">
                            <div class="content clearfix"></div> <!-- /content -->
                            <?php
                                //Display all Categories
                                $catObj = new Category();
                                $categories = $catObj->fetch($dbObj,"*");$list="";
                                if(count($categories)> 0){ 
                                    foreach($categories as $category){
                                       echo '<form action="" method="POST"><div class="control-group">
                                              <div class="btn-group">
                                              <input type="hidden" name="catasmenuname" value="'.$category['name'].'">
                                              <a class="btn btn-default" href="javascript:;">'.$category['name'].'</a>
                                              <button class="btn btn-default" type="submit" name="addtomenu[]" title="Add to menu"><i class="icon-pushpin"></i></button>
                                            </div></div></form>'; 
                                    }
                                }
                            ?>
                        </div> <!-- /widget-content -->
						
                    </div> <!-- /widget -->					
				
		</div> <!-- /span12 -->   
                
                <div class="span3">
	      		
                    <div class="widget">
						
			<div class="widget-header">
                            <i class="icon-flag"></i>
                            <h3>Custom Link</h3>
                        </div> <!-- /widget-header -->
			<div class="widget-content">
                            <div class="content clearfix"></div> <!-- /content -->
                            <?php echo '<form action="" method="POST">'; ?>
                                <div class="controls">
                                    <div class="">
                                        <input class="" name="custom-menu-title" id="custom-menu-title" type="text" placeholder="Menu title"><br><br>
                                    </div>
                                </div>
                                <div class="controls">
                                    <div class="input-append">
                                        <input class="span2 m-wrap" value="" name="custom-menu-link" id="custom-menu-link" type="url" placeholder="URL">
                                        <button class="btn btn-success"  style="margin-top:-8px" name="custom-menu-submit" type="submit">Go!</button>
                                     </div>
                                </div>
                            <?php echo '</form>'; ?>
                        </div> <!-- /widget-content -->
						
                    </div> <!-- /widget -->					
				
                  </div> <!-- /span12 --> 
                </form>
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
<script src="js/jquery-ui.min.1.8.9.js" type="text/javascript"></script>
<script>
    $('#custom-menu-title').on('input', function() {
        $('#custom-menu-link').attr('value', 'http://blog.yoursite.com/'+$(this).val().replace(' ', '-').toLowerCase());
    });
</script>
  </body>

</html>
