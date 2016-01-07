<?php
session_start();
include '../classes/WebPage.php';

$webPage = new WebPage('../includes/constants.php');

$msg = ""; //Success or failure message 
$errorArr = array(); //Array of errors

$dbObj = new Database(); //create database object
$catObj = new Category();//Create category object

//Category Addition Handler
if(filter_input(INPUT_POST, "submit")!==NULL){
    $postVars = ['name','meta','title','parent']; // Form fields names
    //Validate the POST variables and add up to error message if empty
    foreach ($postVars as $postVar){
        $catObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
        if(filter_input(INPUT_POST, $postVar) === "") {array_push ($errorArr, "Please enter $postVar for your category");}
    }
    //If validated and not empty submit it to database
    if(count($errorArr) < 1)   {if($catObj->add($dbObj)==='success') {$msg = $webPage->messageBox('Category successfully added.', 'success');} else {$msg = $webPage->messageBox('Category addition failed.', 'error');}}
    //Else show error messages
    else{ $msg = $webPage->showError($errorArr); }
}
?>
<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="utf-8">
    <title>Categories</title>
    
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
                  <div class="span6">
	      		
                    <div class="widget">
						
			<div class="widget-header">
                            <i class="icon-list"></i>
                            <h3>New Category</h3>
                        </div> <!-- /widget-header -->
			<div class="widget-content">
                            <div class="content clearfix">
                                <?php echo $msg;?>
                                <fieldset>						
                                    <div class="control-group">											
                                        <label class="control-label" for="name">Category Name</label>
                                        <div class="controls">
                                            <input type="text" class="span5 input-large " id="name" name="name" value="" placeholder="Enter category name" required="required">
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
										
                                 
                                    <div class="control-group">											
                                        <label class="control-label" for="title">Meta Title</label>
                                         <div class="controls">
                                            <input type="text" class="span5" id="title" name="title" value="" required="required">
                                        </div>	<!-- /controls -->			
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                        <label class="control-label" for="meta">Meta Description</label>
                                         <div class="controls">
                                            <textarea name="meta" placeholder="Enter meta description" id="meta" class="span4" required="required"></textarea>
                                        </div>	<!-- /controls -->			
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
				
                                    </div> <!-- /control-group -->
                                    
                                    
                                  
					 <br />
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-primary" name="submit">Create Category</button> <button type="reset" class="btn btn-primary" name="reset">Reset Form</button>
					</div> <!-- /form-actions -->
                                </fieldset>
                            </div> <!-- /content -->
						
			</div> <!-- /widget-content -->
						
                    </div> <!-- /widget -->					
				
		    </div> <!-- /span12 -->     	
	      	
	      	<div class="span6">
	      		
                    <div class="widget">
						
			<div class="widget-header">
                            <i class="icon-indent-left"></i>
                            <h3>Select Parent Category</h3>
                        </div> <!-- /widget-header -->
			<div class="widget-content">
                            <div class="content clearfix">
                            <?php
                                //Display all Categories
                                echo $catObj->fetchFormatted($dbObj, '<ul>', '<li style="list-style-type: none;"><input type="radio" id="parent" name="parent" value="[parent-identity-code]"> '); 
                            ?> 
                            </div> <!-- /content -->
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

  </body>

</html>
