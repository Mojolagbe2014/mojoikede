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
                                    echo '<form action="" method="GET"><div class="controls">
                                              <div class="btn-group">
                                              <a class="btn btn-primary" href="#">'.$fetchedMenu['title'].'</a>
                                              <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                                              <ul class="dropdown-menu">
                                                <li><a href="#"><i class="icon-trash"></i> Remove</a></li>
                                              </ul>
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
                                              <input type="hidden" name="catasmenuname[]" value="'.$category['name'].'">
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
                            <div class="controls">
                                <div class="">
                                    <input class="" id="custom-menu-title" type="text" placeholder="Menu title"><br><br>
                                </div>
                            </div>
                            <div class="controls">
                                <div class="input-append">
                                    <input class="span2 m-wrap" id="custom-menu-link" type="url" placeholder="URL">
                                   <button class="btn btn-danger" type="button">Go!</button>
                                 </div>
                            </div>
						
                        </div> <!-- /widget-content -->
						
                    </div> <!-- /widget -->					
				
                  </div> <!-- /span12 --> 
                </form>
	      </div> <!-- /row -->
	
	    </div> <!-- /container -->
	    
	</div> <!-- /main-inner -->
    
</div> <!-- /main -->
    


<div class="extra">

	<div class="extra-inner">

		<div class="container">

			<div class="row">
                    <div class="span3">
                        <h4>
                            About Free Admin Template</h4>
                        <ul>
                            <li><a href="javascript:;">EGrappler.com</a></li>
                            <li><a href="javascript:;">Web Development Resources</a></li>
                            <li><a href="javascript:;">Responsive HTML5 Portfolio Templates</a></li>
                            <li><a href="javascript:;">Free Resources and Scripts</a></li>
                        </ul>
                    </div>
                    <!-- /span3 -->
                    <div class="span3">
                        <h4>
                            Support</h4>
                        <ul>
                            <li><a href="javascript:;">Frequently Asked Questions</a></li>
                            <li><a href="javascript:;">Ask a Question</a></li>
                            <li><a href="javascript:;">Video Tutorial</a></li>
                            <li><a href="javascript:;">Feedback</a></li>
                        </ul>
                    </div>
                    <!-- /span3 -->
                    <div class="span3">
                        <h4>
                            Something Legal</h4>
                        <ul>
                            <li><a href="javascript:;">Read License</a></li>
                            <li><a href="javascript:;">Terms of Use</a></li>
                            <li><a href="javascript:;">Privacy Policy</a></li>
                        </ul>
                    </div>
                    <!-- /span3 -->
                    <div class="span3">
                        <h4>
                            Open Source jQuery Plugins</h4>
                        <ul>
                            <li><a href="http://www.egrappler.com">Open Source jQuery Plugins</a></li>
                            <li><a href="http://www.egrappler.com;">HTML5 Responsive Tempaltes</a></li>
                            <li><a href="http://www.egrappler.com;">Free Contact Form Plugin</a></li>
                            <li><a href="http://www.egrappler.com;">Flat UI PSD</a></li>
                        </ul>
                    </div>
                    <!-- /span3 -->
                </div> <!-- /row -->

		</div> <!-- /container -->

	</div> <!-- /extra-inner -->

</div> <!-- /extra -->

<div class="footer">
	
	<div class="footer-inner">
		
		<div class="container">
			
			<div class="row">
				
    			<div class="span12">
    				&copy; 2013 <a href="http://www.egrappler.com/">Bootstrap Responsive Admin Template</a>.
    			</div> <!-- /span12 -->
    			
    		</div> <!-- /row -->
    		
		</div> <!-- /container -->
		
	</div> <!-- /footer-inner -->
	
</div> <!-- /footer -->
    

<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/jquery-1.7.2.min.js"></script>

<script src="js/bootstrap.js"></script>
<script src="js/base.js"></script>
<script src="js/jquery-ui.min.1.8.9.js" type="text/javascript"></script>
<script>
    $('button').draggable();
    
</script>
  </body>

</html>
