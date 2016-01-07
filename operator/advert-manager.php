<?php
session_start();
include '../classes/WebPage.php'; //Set up page as a web page
$thisPage = new WebPage('../includes/constants.php'); //Create new instance of webPage class

//If user is not loggedIn reject the user 
if(!isset($_SESSION['LoggedIn'])){$thisPage->redirectTo('index');}//redirect user to login page

$msg = ""; //Success or failure message 
$errorArr = array(); //Array of errors

$dbObj = new Database(); //create database object
$advertObj = new Advert();// instantiate advert class

$sitePost = new Post(); //Instantiate post class
$postComment = new Comment(); //Create comment object

//Advert Addition Handler
if(filter_input(INPUT_POST, "submit")!==NULL && filter_input(INPUT_POST, "actionField")=='add'){
    $postVars = ['name','link','content','size', 'type', 'position', 'location', 'follow', 'status']; // Form fields names
    //Validate the POST variables and add up to error message if empty
    foreach ($postVars as $postVar){
        switch ($postVar){
            case 'follow':  $advertObj->follow = filter_input(INPUT_POST, $postVar);
                            break;
            case 'status':  $advertObj->status = filter_input(INPUT_POST, $postVar);
                            break;
            case 'content':  $advertObj->content = filter_input(INPUT_POST, $postVar);
                            break;
            case 'link':  $advertObj->link = filter_input(INPUT_POST, $postVar);
                            break;
            default :       $advertObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                            if($advertObj->$postVar === "") {array_push ($errorArr, "Please enter $postVar ");}
                            break;
        }
    }
    //If validated and not empty submit it to database
    if(count($errorArr) < 1)   {if($advertObj->add($dbObj)==='success') {$msg = $thisPage->messageBox('Advert successfully added.', 'success');} else {$msg = $thisPage->messageBox('Advert addition failed.', 'error');}}
    //Else show error messages
    else{ $msg = $thisPage->showError($errorArr); }
}

//Advert Deletion Handler
if(filter_input(INPUT_POST, "delete-advert")!==NULL){
    $advertToDel = new Advert(); //Instantiate post class
    $advertToDel->id = filter_input(INPUT_POST, 'hidden-advert-id') ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, 'hidden-advert-id', FILTER_VALIDATE_INT)) :  ''; 
    if(filter_input(INPUT_POST, 'hidden-advert-id') === "") {array_push ($errorArr, "Illegal Operation.");}
    
    //If validated and not empty submit it to database
    if(count($errorArr) < 1)   {if($advertToDel->delete($dbObj)==='success') {$msg = $thisPage->messageBox('Advert successfully deleted.', 'success');} else {$msg = $thisPage->messageBox('Advert deletion failed.', 'error');}}
    //Else show error messages
    else{ $msg = $thisPage->showError($errorArr); }
}
//Edit Post button click
if(filter_input(INPUT_POST, "submit")!==NULL && filter_input(INPUT_POST, "actionField")=='edit'){
    $postVars = ['id','name','link','content','size', 'type', 'position', 'location', 'follow', 'status']; // Form fields names
    //Validate the POST variables and add up to error message if empty
    foreach ($postVars as $postVar){
        switch ($postVar){
            case 'id':  $advertObj->$postVar = filter_input(INPUT_POST, $postVar, FILTER_VALIDATE_INT) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar, FILTER_VALIDATE_INT)) :  ''; 
                            if($advertObj->$postVar === "") {array_push ($errorArr, "Please enter $postVar ");}
                            break;
            case 'follow':  $advertObj->follow = filter_input(INPUT_POST, $postVar);
                            break;
            case 'status':  $advertObj->status = filter_input(INPUT_POST, $postVar);
                            break;
            case 'content':  $advertObj->content = filter_input(INPUT_POST, $postVar);
                            break;
            case 'link':  $advertObj->link = filter_input(INPUT_POST, $postVar);
                            break;
            default :       $advertObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                            if($advertObj->$postVar === "") {array_push ($errorArr, "Please enter $postVar ");}
                            break;
        }
    }
    //If validated and not empty submit it to database
    if(count($errorArr) < 1)   {if($advertObj->update($dbObj)==='success') {$msg = $thisPage->messageBox('Advert successfully Updated.', 'success');} else {$msg = $thisPage->messageBox('Advert update failed.', 'error');}}
    //Else show error messages
    else{ $msg = $thisPage->showError($errorArr); }
}
//Advert Activation button click handler
if(filter_input(INPUT_POST, "activate-advert")!==NULL){
    if(filter_input(INPUT_POST, 'hidden-advert-id') === "") {array_push ($errorArr, "Illegal operation parameter 1.");}
    if(filter_input(INPUT_POST, 'hidden-advert-status') === "") {array_push ($errorArr, "Illegal operation parameter 2.");}
    if(count($errorArr) < 1)   { 
        $advertStatusVar = 1; //set status to activate 
        if(filter_input(INPUT_POST, 'hidden-advert-status', FILTER_VALIDATE_INT) == 1){ $advertStatusVar = 0;}//if activated already deactivate
        Advert::updateSingle($dbObj, 'status', $advertStatusVar, filter_input(INPUT_POST, 'hidden-advert-id', FILTER_VALIDATE_INT));//Update the status
    }
    else{ $msg = $thisPage->showError($errorArr); }
}
?>
<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="utf-8">
    <title>Advert Manager</title>
    
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
                            <h3> Adverts Manager</h3>
                        </div> <!-- /widget-header -->
                        <div class="widget-content">
                            <button class="btn btn-danger" id="btn-add-advert" type="button"><i class="icon-plus"></i> Add Advert</button>
                            <br />
                            <?php echo '<br/> '.$msg; ?>
                            <br/>
                            <div id="hidden-add-advert" class="hidden">
                                <form id="form-advert-manager" class="form-horizontal" method="POST">
                                    <fieldset>
                                            <div class="control-group">											
                                                <label class="control-label" for="name">Advert Name: </label>
                                                <div class="controls">
                                                    <input type="hidden" id="actionField" name="actionField" value="add" />
                                                    <input type="hidden" id="id" name="id" />
                                                    <input type="text" class="span6" name="name" id="name" value="" placeholder="Advert name">
                                                </div> <!-- /controls -->				
                                            </div> <!-- /control-group -->
                                            <div class="control-group">											
                                                <label class="control-label" for="link">Advert Link: </label>
                                                <div class="controls">
                                                    <input type="text" class="span6" name="link" id="link" value="" placeholder="Advert link">
                                                </div> <!-- /controls -->				
                                            </div> <!-- /control-group -->
                                            <div class="control-group">											
                                                    <label class="control-label" for="content">Advert Content: </label>
                                                    <div class="controls">
                                                        <textarea class="span6" name="content" id="content" value="" placeholder="Advert source code"></textarea>
                                                    </div> <!-- /controls -->				
                                            </div> <!-- /control-group -->
                                            <div class="control-group">											
                                                    <label class="control-label" for="size">Advert Size: </label>
                                                    <div class="controls">
                                                        <select name="size" id="size">
                                                            <option value="Sky Scapper (160 x 600)">Sky Scapper(160 x 600)</option>
                                                            <option value="Landscape (728 x 90)">Landscape (728 x 90)</option>
                                                            <option value="Portrait 1 (250 x 300)">Portrait 1 (250 x 300)</option>
                                                            <option value="Portrait 2 (300 X 300)">Portrait 2 (300 X 300)</option>
                                                            <option value="Small Landscape (468 X 60)">Small Landscape (468 X 60)</option>
                                                            <option value="Small Ad (234 x 90)">Small Ad (234 x 90)</option>
                                                        </select>
                                                    </div> <!-- /controls -->				
                                            </div> <!-- /control-group -->
                                            <div class="control-group">											
                                                    <label class="control-label" for="type">Advert Type: </label>
                                                    <div class="controls">
                                                        <select name="type" id="type">
                                                            <option value="PPC (Pay Per Click)">PPC (Pay Per Click)</option>
                                                            <option value="DIA (Direct Image Ads)">DIA (Direct Image Ads)</option>
                                                        </select>
                                                    </div> <!-- /controls -->				
                                            </div> <!-- /control-group -->
                                            <div class="control-group">											
                                                    <label class="control-label" for="location">Location: </label>
                                                    <div class="controls">
                                                        <select name="location" id="location">
                                                            <option value="Main Page">Main Page</option>
                                                        </select>
                                                    </div> <!-- /controls -->				
                                            </div> <!-- /control-group -->
                                            <div class="control-group">											
                                                    <label class="control-label" for="position">Position: </label>
                                                    <div class="controls">
                                                        <select name="position" id="position">
                                                        <?php 
                                                            $positionArray = ['Top Banner', 'Page Banner Top', 'Page Banner Bottom', 'Side Banner 1', 'Side Banner 2'];
                                                            foreach ($positionArray as $positionArr) {
                                                                echo '<option value="'.$positionArr.'">'.$positionArr.'</option>';
                                                            }
                                                        ?>
                                                        </select>
                                                    </div> <!-- /controls -->				
                                            </div> <!-- /control-group -->
                                            <div class="control-group">											
                                                <label class="control-label">Follow: </label>
                                                <div class="controls">
                                                    <label class="radio inline">
                                                        <input type="radio" class="follow-btn"  name="follow" value="0"> No Follow 
                                                    </label>

                                                    <label class="radio inline">
                                                        <input type="radio" class="follow-btn" name="follow" value="1"> Follow
                                                    </label>
                                                </div>	<!-- /controls -->			
                                            </div> <!-- /control-group -->
                                            <div class="control-group">											
                                                <label class="control-label">Status: </label>
                                                <div class="controls">
                                                    <label class="radio inline">
                                                        <input type="radio" class="status-btn"  name="status" value="1"> Activate Now
                                                    </label>

                                                    <label class="radio inline">
                                                        <input type="radio" class="status-btn" name="status" value="0"> Deactivate
                                                    </label>
                                                </div>	<!-- /controls -->			
                                            </div> <!-- /control-group -->
                                            
                                            <div class="form-actions">
                                                <button type="submit" class="btn btn-primary" name="submit">Save</button> 
                                                <button class="btn" type="reset">Reset</button>
                                            </div> <!-- /form-actions -->
                                    </fieldset>
                                </form>
                                <br/>
                            </div>
                            <div id="table-all-adverts">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                      <th> Advert Name </th>
                                      <th> Type</th>
                                      <th> Format</th>
                                      <th> Page Location</th>
                                      <th> Position</th>
                                      <th> Follow</th>
                                      <th> View</th>
                                      <th class="td-actions"> Actions</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  <?php
                                  $fetchedAdverts = $advertObj->fetch($dbObj); //Fetch all post details
                                  $fetAdvertStatus = ''; $fetAdvertStatCol =''; $viewAdvert=''; $viewAdvText='';
                                  foreach ($fetchedAdverts as $fetchedAdvert){
                                      $fetAdvertStatus = 'icon-check-empty'; $fetAdvertStatCol = 'btn-warning'; $fetAdvertStatTxt = "Activate";
                                      if($fetchedAdvert['status']==1){$fetAdvertStatus = 'icon-check'; $fetAdvertStatCol = 'btn-success'; $fetAdvertStatTxt = "De-activate";}
                                      if($fetchedAdvert['follow'] == 1) { $followCond = 'Follow'; } else { $followCond = 'No Follow'; }
                                      if($fetchedAdvert['type']=='PPC (Pay Per Click)'){ $viewAdvText = 'View Code'; } else{ $viewAdvText = 'View Image'; }
                                      echo '<tr>
                                        <td>'.$fetchedAdvert['name'].'</td>
                                        <td>'.$fetchedAdvert['type'].'</td>
                                        <td>'.$fetchedAdvert['size'].'</td>
                                        <td>'.$fetchedAdvert['location'].'</td>
                                        <td>'.$fetchedAdvert['position'].'</td>
                                        <td>'.$followCond.'</td>
                                        <td><a href="'.$fetchedAdvert['link'].'">'.$viewAdvText.'</a></td>
                                        <form action="" method="post">
                                        <input type="hidden" name="hidden-advert-id" value="'.$fetchedAdvert['id'].'"><input type="hidden" name="hidden-advert-status" value="'.$fetchedAdvert['status'].'">
                                        <td class="td-actions"><button type="submit" name="delete-advert" class="btn btn-danger btn-small" title="Delete"><i class="btn-icon-only icon-trash"> </i> </button> <button type="button" data-id="'.$fetchedAdvert['id'].'" data-link="'.$fetchedAdvert['link'].'" data-follow="'.$fetchedAdvert['follow'].'" data-status="'.$fetchedAdvert['status'].'" data-position="'.$fetchedAdvert['position'].'" data-name="'.$fetchedAdvert['name'].'" data-location="'.$fetchedAdvert['location'].'" data-type="'.$fetchedAdvert['type'].'" data-size="'.$fetchedAdvert['size'].'" name="edit-advert" class="btn btn-info btn-small edit-advert-btn"  title="Edit"><i class="btn-icon-only icon-pencil"> </i> <span class="hidden" id="hiddenAdvLink">'.$fetchedAdvert['link'].'</span> </button> <button type="submit" name="activate-advert" class="btn '.$fetAdvertStatCol.' btn-small"  title="'.$fetAdvertStatTxt.'"><i class="btn-icon-only '.$fetAdvertStatus.' "> </i></button></td>
                                        </form>
                                      </tr>';
                                  }
                                  ?>
                                  </tbody>
                                </table>
                            </div>
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
<script>
    $(document).ready(function(){
        $('#btn-add-advert').bind({
            click: function(){
                $(this).find('i').toggleClass('icon-plus').toggleClass('icon-minus');
                $('#hidden-add-advert').slideToggle().toggleClass('hidden');
            }
        });
        $('.edit-advert-btn').click(function(){
            var formVar = {id:$(this).attr('data-id'),name:$(this).attr('data-name'), link:$(this).attr('data-link'), content:$(this).find('span').html(), size:$(this).attr('data-size'), type:$(this).attr('data-type'), position:$(this).attr('data-position'), location:$(this).attr('data-location'), follow:$(this).attr('data-follow'), status:$(this).attr('data-status')};
            $('#btn-add-advert').find('i').toggleClass('icon-plus').toggleClass('icon-minus');
            $('#hidden-add-advert').slideDown().removeClass('hidden');
            $('form#form-advert-manager #actionField').val('edit');
            $.each(formVar, function(key, value) { 
                if(key == 'status'){ $('form#form-advert-manager input[value='+value+'].status-btn').attr('checked', 'checked');}
                else if(key == 'follow'){ $('form#form-advert-manager input[value='+value+'].follow-btn').attr('checked', 'checked');}
                else $('form#form-advert-manager #'+key).val(value); 
            });
        });
    });
</script>

  </body>

</html>
