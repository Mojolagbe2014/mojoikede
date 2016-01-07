<?php
session_start();
include '../classes/WebPage.php'; //Set up page as a web page
$thisPage = new WebPage('../includes/constants.php'); //Create new instance of webPage class

//If user is not loggedIn reject the user 
if(!isset($_SESSION['LoggedIn'])){$thisPage->redirectTo('index');}//redirect user to login page

$msg = ""; //Success or failure message 
$errorArr = array(); //Array of errors

$dbObj = new Database(); //create database object
$postObj = new Post(); //Instantiate post class
$catObj = new Category();//Create category object

//Post Submission Handler
if(filter_input(INPUT_POST, "submit")!==NULL){
    $postVars = ['title','content','featuredImage', 'category', 'metaDescription', 'status']; // Form fields names
    //Validate the POST variables and add up to error message if empty
    foreach ($postVars as $postVar){
        switch($postVar){
            case 'status':  if(filter_input(INPUT_POST, $postVar) !== NULL ){ $postObj->$postVar = mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar));}
                            break;
            case 'category':if(filter_input(INPUT_POST, $postVar) !== NULL ) {$categoryList ='';
                                foreach($_REQUEST['category'] as $category){$categoryList .= $category.":";}
                                $postObj->$postVar = $categoryList;
                            }
                            elseif($postObj->$postVar === "" || filter_input(INPUT_POST, $postVar) === NULL) {array_push ($errorArr, "Please enter $postVar for your post");}
                            break;
                            
            default     :   $postObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                            if(filter_input(INPUT_POST, $postVar) === "") {array_push ($errorArr, "Please enter $postVar for your post");}
                            break;
        }
    }
    //If validated and not empty submit it to database
    if(count($errorArr) < 1)   {if($postObj->add($dbObj)==='success') {$msg = $thisPage->messageBox('Post successfully submitted.', 'success');} else {$msg = $thisPage->messageBox('Post submission failed.', 'error');}}
    //Else show error messages
    else{ $msg = $thisPage->showError($errorArr); }
}

?>
<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="utf-8">
    <title>Create New Post</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">    
    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
    
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet">
    
    <link href="css/style.css" rel="stylesheet">
    
    
    <link href="css/pages/plans.css" rel="stylesheet"> 
    <!-- Add jQuery library -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
    <!-- Add venobox -->
    <link href="js/facebox/src/facebox.css" media="screen" rel="stylesheet" type="text/css" />
    <script src="js/facebox/src/facebox.js" type="text/javascript"></script>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script type="text/javascript">
    jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        loadingImage : 'js/facebox/src/loading.gif',
        closeImage   : 'js/facebox/src/closelabel.png'
      });
    });
  </script>
    
    <style>
        .image-full{
            display: block;
            border-radius: 5px 5px 5px 5px;
            -moz-border-radius: 5px 5px 5px 5px;
            -webkit-border-radius: 5px 5px 5px 5px;
            border: 1px solid #000000;
            padding: 3px;
            margin-bottom: 5px;
            height: 100px;
        }
    </style>
  </head>

<body>

<?php include 'includes/header.php';?>
    
    
<div class="main">
	
    <div class="main-inner">

        <div class="container">
	
	    <div class="row">
	      	<form id="" class="form-inline" method="post">
                  <div class="span8">
	      		
                    <div class="widget">
						
			<div class="widget-header">
                            <i class="icon-comment"></i>
                            <h3>Add New Post</h3>
                        </div> <!-- /widget-header -->
			<div class="widget-content">
                            <div class="content clearfix">
                                <?php echo $msg;?>
                                <fieldset>						
                                    <div class="control-group">											
                                        <label class="control-label" for="title">Post Title</label>
                                        <div class="controls">
                                            <input type="text" class="span7 input-large " id="title" name="title" value="" placeholder="Enter post title">
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
										
                                    <div class="control-group">											
                                        <label class="control-label" for="content"><a href="media-list" class="btn btn-danger" rel="facebox"><i class="icon-camera"></i> Select image</a></label>
                                        <div class="controls">
                                            <textarea name="content" placeholder="enter post content" id="content" class="span7"></textarea>
                                            <script type="text/javascript">
                                                CKEDITOR.replace( 'content' );
                                            </script>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                   
                                    <div class="control-group">											
                                        <label class="control-label" for="metaDescription">Meta Description</label>
                                         <div class="controls">
                                            <textarea name="metaDescription" placeholder="Enter meta description" id="metaDescription" class="span7"></textarea>
                                        </div>	<!-- /controls -->			
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                       
                                        <div class="controls">
                                            <input type="checkbox" id="status" name="status" value="1"> <label for="status">Publish Now?</label>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <input type="hidden" name="featuredImage" id="featuredImage">
                                        
					 <br />
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-primary" name="submit">Submit Post</button>
					</div> <!-- /form-actions -->
                                </fieldset>
 
                            </div> <!-- /content -->
						
                        </div> <!-- /widget-content -->
						
                    </div> <!-- /widget -->					
				
		    </div> <!-- /span12 -->     	
	      	
                  <div class="span4">
	      		
                    <div class="widget">
						
			<div class="widget-header">
                            <i class="icon-indent-left"></i>
                            <h3>Category</h3>
                        </div> <!-- /widget-header -->
			<div class="widget-content">
                            <div class="content clearfix">
                            <?php
                                //Display all Categories
                                $categories = $catObj->fetch($dbObj,"*");$list="";
                                if(count($categories)> 0){ 
                                    $list = '<ul>';
                                    foreach($categories as $categories){
                                       $list .= '<li style="list-style-type: none;"><input type="checkbox" id="category'.$categories['id'].'" name="category[]" value="'.$categories['id'].'"> <label for="category'.$categories['id'].'">'.$categories['name'].'</label></li>';    
                                    }
                                    $list .= '</ul>';
                                }
                                echo $list;
                            ?>		
                            </div> <!-- /content -->
						
                        </div> <!-- /widget-content -->
						
                    </div> <!-- /widget -->					
				
		</div> <!-- /span12 -->   
                
                <div class="span4">
	      		
                    <div class="widget">
						
			<div class="widget-header">
                            <i class="icon-picture"></i>
                            <h3>Featured Image</h3>
                        </div> <!-- /widget-header -->
			<div class="widget-content">
                            <div class="content clearfix">
                                <div class="image-full col-md-12" style="height:150px;" id="featured">
                                            <!-- image here -->
                                    </div>
                                <div>
                                    <a href="media-list?featured" class="btn btn-primary" rel="facebox" ><i class="icon-camera"></i> Select Image</a>
				</div> <!-- /form-actions -->
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


<script src="js/bootstrap.js"></script>
<script src="js/base.js"></script>
<script>
    function GetImage(){
       facebox().close()
    }
</script>
  </body>

</html>
