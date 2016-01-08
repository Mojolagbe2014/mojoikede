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

//Advert Addition Handler
if(filter_input(INPUT_POST, "submit")!==NULL && filter_input(INPUT_POST, "actionField")=='add'){
    $postVars = array('name','link','format','follow', 'status', 'background', 'zoneOne', 'zoneOneAlt', 'zoneTwo', 'zoneTwoAlt', 'zoneThree'); // Form fields names
    //Validate the POST variables and add up to error message if empty
    foreach ($postVars as $postVar){
        switch ($postVar){
            case 'follow':  $advertObj->follow = filter_input(INPUT_POST, $postVar);
                            break;
            case 'status':  $advertObj->status = filter_input(INPUT_POST, $postVar);
                            break;
            case 'background':   $advertObj->$postVar = basename($_FILES["background"]["name"]) ? rand(100000, 1000000)."_background".".".pathinfo(basename($_FILES["background"]["name"]),PATHINFO_EXTENSION): ""; 
                                if($advertObj->$postVar == "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
            case 'zoneOne':   $advertObj->$postVar = basename($_FILES["zoneOne"]["name"]) ? rand(100000, 1000000)."_zoneone".".".pathinfo(basename($_FILES["zoneOne"]["name"]),PATHINFO_EXTENSION): ""; 
                                if($advertObj->$postVar == "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
            case 'zoneOneAlt':   $advertObj->$postVar = basename($_FILES["zoneOneAlt"]["name"]) ? rand(100000, 1000000)."_zoneonealt".".".pathinfo(basename($_FILES["zoneOneAlt"]["name"]),PATHINFO_EXTENSION): ""; 
                                if($advertObj->$postVar == "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
            case 'zoneTwo':   $advertObj->$postVar = basename($_FILES["zoneTwo"]["name"]) ? rand(100000, 1000000)."_zonetwo".".".pathinfo(basename($_FILES["zoneTwo"]["name"]),PATHINFO_EXTENSION): ""; 
                                if($advertObj->$postVar == "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
            case 'zoneTwoAlt':   $advertObj->$postVar = basename($_FILES["zoneTwoAlt"]["name"]) ? rand(100000, 1000000)."_zonetwoalt".".".pathinfo(basename($_FILES["zoneTwoAlt"]["name"]),PATHINFO_EXTENSION): ""; 
                                if($advertObj->$postVar == "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
            case 'zoneThree':   $advertObj->$postVar = basename($_FILES["zoneThree"]["name"]) ? rand(100000, 1000000)."_zonethree".".".pathinfo(basename($_FILES["zoneThree"]["name"]),PATHINFO_EXTENSION): ""; 
                                if($advertObj->$postVar == "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
            default :       $advertObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                            if($advertObj->$postVar === "") {array_push ($errorArr, "Please enter $postVar ");}
                            break;
        }
    }
    //If validated and not empty submit it to database
    if(count($errorArr) < 1)   {
        $uploadOk = 1; $msg = '';
        
        if($uploadOk == 1 && move_uploaded_file($_FILES["background"]["tmp_name"], MEDIA_FILES_PATH. $advertObj->background) && 
           move_uploaded_file($_FILES["zoneOne"]["tmp_name"], MEDIA_FILES_PATH. $advertObj->zoneOne) &&
           move_uploaded_file($_FILES["zoneOneAlt"]["tmp_name"], MEDIA_FILES_PATH. $advertObj->zoneOneAlt) && 
           move_uploaded_file($_FILES["zoneTwo"]["tmp_name"], MEDIA_FILES_PATH. $advertObj->zoneTwo) &&
           move_uploaded_file($_FILES["zoneTwoAlt"]["tmp_name"], MEDIA_FILES_PATH. $advertObj->zoneTwoAlt) && 
           move_uploaded_file($_FILES["zoneThree"]["tmp_name"], MEDIA_FILES_PATH. $advertObj->zoneThree)){
            if($advertObj->add($dbObj)==='success') {
                $msg = $thisPage->messageBox('Advert successfully added.', 'success');

            } else {$msg = $thisPage->messageBox('Advert addition failed.', 'error');}
        }        
    }
    else{ $msg = $thisPage->showError($errorArr); }//Else show error messages
}

//Advert Deletion Handler
if(filter_input(INPUT_POST, "delete-advert")!==NULL){
    $advertToDel = new Advert(); //Instantiate post class
    $advertToDel->id = filter_input(INPUT_POST, 'hidden-advert-id') ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, 'hidden-advert-id', FILTER_VALIDATE_INT)) :  ''; 
    if(filter_input(INPUT_POST, 'hidden-advert-id') === "") {array_push ($errorArr, "Illegal Operation.");}
    
    //If validated and not empty submit it to database
    if(count($errorArr) < 1)   {
        $advertToDel->background = Advert::getSingle($dbObj, 'background', $advertToDel->id) ? MEDIA_FILES_PATH.Advert::getSingle($dbObj, 'background', $advertToDel->id) : '';
        $advertToDel->zoneOne = Advert::getSingle($dbObj, 'zone_one', $advertToDel->id) ? MEDIA_FILES_PATH.Advert::getSingle($dbObj, 'zone_one', $advertToDel->id) : '';
        $advertToDel->zoneOneAlt = Advert::getSingle($dbObj, 'zone_one_alt', $advertToDel->id) ? MEDIA_FILES_PATH.Advert::getSingle($dbObj, 'zone_one_alt', $advertToDel->id) : '';
        $advertToDel->zoneTwo = Advert::getSingle($dbObj, 'zone_two', $advertToDel->id) ? MEDIA_FILES_PATH.Advert::getSingle($dbObj, 'zone_two', $advertToDel->id) : '';
        $advertToDel->zoneTwoAlt = Advert::getSingle($dbObj, 'zone_two_alt', $advertToDel->id) ? MEDIA_FILES_PATH.Advert::getSingle($dbObj, 'zone_two_alt', $advertToDel->id) : '';
        $advertToDel->zoneThree = Advert::getSingle($dbObj, 'zone_three', $advertToDel->id) ? MEDIA_FILES_PATH.Advert::getSingle($dbObj, 'zone_three', $advertToDel->id) : '';
        
        if($advertToDel->delete($dbObj)==='success' && StringManipulator::arrayNotEmpty($advertToDel->background,$advertToDel->zoneOne,$advertToDel->zoneOneAlt,$advertToDel->zoneTwo,$advertToDel->zoneTwoAlt,$advertToDel->zoneThree)) {
            $postVars = array('background', 'zoneOne', 'zoneOneAlt', 'zoneTwo', 'zoneTwoAlt', 'zoneThree');
            foreach ($postVars as $postVar){
                switch ($postVar){default: if(file_exists($advertToDel->$postVar)){unlink($advertToDel->$postVar);} break;}
            }
            $msg = $thisPage->messageBox('Advert successfully deleted.', 'success');
        } else {$msg = $thisPage->messageBox('Advert deletion failed.', 'error');}
    }
    else{ $msg = $thisPage->showError($errorArr); }//Else show error messages
}
//Edit Post button click
if(filter_input(INPUT_POST, "submit")!==NULL && filter_input(INPUT_POST, "actionField")=='edit'){
    $postVars = array('id','name','link','format','follow', 'status', 'background', 'zoneOne', 'zoneOneAlt', 'zoneTwo', 'zoneTwoAlt', 'zoneThree'); // Form fields names
    $old = new stdClass();
    $old->background = filter_input(INPUT_POST, 'backgroundOld'); $old->zoneOne = filter_input(INPUT_POST, 'zoneOneOld');
    $old->zoneOneAlt = filter_input(INPUT_POST, 'zoneOneAltOld'); $old->zoneTwo = filter_input(INPUT_POST, 'zoneTwoOld');
    $old->zoneTwoAlt = filter_input(INPUT_POST, 'zoneTwoAltOld'); $old->zoneThree = filter_input(INPUT_POST, 'zoneThreeOld');
    //Validate the POST variables and add up to error message if empty
    foreach ($postVars as $postVar){
        switch ($postVar){
            case 'follow':  $advertObj->follow = filter_input(INPUT_POST, $postVar);
                            break;
            case 'status':  $advertObj->status = filter_input(INPUT_POST, $postVar);
                            break;
            case 'background':   $advertObj->$postVar = basename($_FILES["background"]["name"]) ? rand(100000, 1000000)."_background".".".pathinfo(basename($_FILES["background"]["name"]),PATHINFO_EXTENSION): ""; 
                                //if($advertObj->$postVar == "") {$advertObj->$postVar = $backgroundOld;}
                                break;
            case 'zoneOne':   $advertObj->$postVar = basename($_FILES["zoneOne"]["name"]) ? rand(100000, 1000000)."_zoneone".".".pathinfo(basename($_FILES["zoneOne"]["name"]),PATHINFO_EXTENSION): ""; 
                                //if($advertObj->$postVar == "") {$advertObj->$postVar = $zoneOneOld;}
                                break;
            case 'zoneOneAlt':   $advertObj->$postVar = basename($_FILES["zoneOneAlt"]["name"]) ? rand(100000, 1000000)."_zoneonealt".".".pathinfo(basename($_FILES["zoneOneAlt"]["name"]),PATHINFO_EXTENSION): ""; 
                                //if($advertObj->$postVar == "") {$advertObj->$postVar = $zoneOneAltOld;}
                                break;
            case 'zoneTwo':   $advertObj->$postVar = basename($_FILES["zoneTwo"]["name"]) ? rand(100000, 1000000)."_zonetwo".".".pathinfo(basename($_FILES["zoneTwo"]["name"]),PATHINFO_EXTENSION): ""; 
                                //if($advertObj->$postVar == "") {$advertObj->$postVar = $zoneTwoOld;}
                                break;
            case 'zoneTwoAlt':   $advertObj->$postVar = basename($_FILES["zoneTwoAlt"]["name"]) ? rand(100000, 1000000)."_zonetwoalt".".".pathinfo(basename($_FILES["zoneTwoAlt"]["name"]),PATHINFO_EXTENSION): ""; 
                                //if($advertObj->$postVar == "") {$advertObj->$postVar = $zoneTwoAltOld;}
                                break;
            case 'zoneThree':   $advertObj->$postVar = basename($_FILES["zoneThree"]["name"]) ? rand(100000, 1000000)."_zonethree".".".pathinfo(basename($_FILES["zoneThree"]["name"]),PATHINFO_EXTENSION): ""; 
                                //if($advertObj->$postVar == "") {$advertObj->$postVar = $zoneThreeOld;}
                                break;
            default :       $advertObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                            if($advertObj->$postVar === "") {array_push ($errorArr, "Please enter $postVar ");}
                            break;
        }
    }
    //If validated and not empty submit it to database
    if(count($errorArr) < 1)   {
        //move_uploaded_file($_FILES["zoneOne"]["tmp_name"], MEDIA_FILES_PATH. $advertObj->zoneOne);
        $postVars = array('background', 'zoneOne', 'zoneOneAlt', 'zoneTwo', 'zoneTwoAlt', 'zoneThree');

        foreach ($postVars as $postVar){
            switch ($postVar){
                default:    if($advertObj->$postVar != "") {
                                if(!file_exists(MEDIA_FILES_PATH.$advertObj->$postVar)){
                                    move_uploaded_file($_FILES["$postVar"]["tmp_name"], MEDIA_FILES_PATH.$advertObj->$postVar);
                                    if(file_exists(MEDIA_FILES_PATH.$old->$postVar)) unlink(MEDIA_FILES_PATH.$old->$postVar);
                                } 
                            } else{
                                $advertObj->$postVar = $old->$postVar;
                            }
                            break;
            }
        }
        if($advertObj->update($dbObj)==='success') { $msg = $thisPage->messageBox('Advert successfully Updated.', 'success'); } 
        else {$msg = $thisPage->messageBox('Advert update failed.', 'error');}
    }
    else{ $msg = $thisPage->showError($errorArr); }//Else show error messages
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
                                <form id="form-advert-manager" class="form-horizontal" method="POST" enctype="multipart/form-data">
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
                                                    <label class="control-label" for="format">Advert Format: </label>
                                                    <div class="controls">
                                                        <input type="text" class="span6" name="format" id="format" value="" placeholder="Advert Format">
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
                                            <div class="control-group">											
                                                    <label class="control-label" for="background">Advert Background: </label>
                                                    <div class="controls">
                                                        <input type="hidden" name="backgroundOld" id="backgroundOld"/>
                                                        <input type="file" class="span6" name="background" id="background" value="">
                                                    </div> <!-- /controls -->				
                                            </div> <!-- /control-group -->
                                            <div class="control-group">											
                                                    <label class="control-label" for="zoneOne">First Section Image: </label>
                                                    <div class="controls">
                                                        <input type="hidden" name="zoneOneOld" id="zoneOneOld"/>
                                                        <input type="file" class="span6" name="zoneOne" id="zoneOne" value="">
                                                    </div> <!-- /controls -->				
                                            </div> <!-- /control-group -->
                                            <div class="control-group">											
                                                    <label class="control-label" for="zoneOneAlt">First Section Alternate Image: </label>
                                                    <div class="controls">
                                                        <input type="hidden" name="zoneOneAltOld" id="zoneOneAltOld"/>
                                                        <input type="file" class="span6" name="zoneOneAlt" id="zoneOneAlt" value="">
                                                    </div> <!-- /controls -->				
                                            </div> <!-- /control-group -->
                                            <div class="control-group">											
                                                    <label class="control-label" for="zoneTwo">Middle Section Image: </label>
                                                    <div class="controls">
                                                        <input type="hidden" name="zoneTwoOld" id="zoneTwoOld"/>
                                                        <input type="file" class="span6" name="zoneTwo" id="zoneTwo" value="">
                                                    </div> <!-- /controls -->				
                                            </div> <!-- /control-group -->
                                            <div class="control-group">											
                                                    <label class="control-label" for="zoneTwoAlt">Middle Section Alternate Image: </label>
                                                    <div class="controls">
                                                        <input type="hidden" name="zoneTwoAltOld" id="zoneTwoAltOld"/>
                                                        <input type="file" class="span6" name="zoneTwoAlt" id="zoneTwoAlt" value="">
                                                    </div> <!-- /controls -->				
                                            </div> <!-- /control-group -->
                                            <div class="control-group">											
                                                    <label class="control-label" for="zoneThree">Last Section Image: </label>
                                                    <div class="controls">
                                                        <input type="hidden" name="zoneThreeOld" id="zoneThreeOld"/>
                                                        <input type="file" class="span6" name="zoneThree" id="zoneThree" value="">
                                                    </div> <!-- /controls -->				
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
                                <table class="table table-striped table-bordered table-condensed">
                                    <thead>
                                    <tr>
                                      <th> ID </th>
                                      <th> Advert Name </th>
                                      <th> Format</th>
                                      <th> Link</th>
                                      <th> Follow</th>
                                      <th> Background</th>
                                      <th> 1st Section</th>
                                      <th> 1st Section 2</th>
                                      <th> 2nd Section</th>
                                      <th> 2nd Section 2</th>
                                      <th> 3rd Section</th>
                                      <th> 3rd Section 2</th>
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
                                      echo '<tr>
                                        <td>'.$fetchedAdvert['id'].'</td>
                                        <td>'.$fetchedAdvert['name'].'</td>
                                        <td>'.$fetchedAdvert['format'].'</td>
                                        <td>'.$fetchedAdvert['link'].'</td>
                                        <td>'.$followCond.'</td>
                                        <td><img src="'.MEDIA_FILES_PATH1.$fetchedAdvert['background'].'" style="width:16px;height:60px"></td>
                                        <td>'.$followCond.'</td>
                                        <td><img src="'.MEDIA_FILES_PATH1.$fetchedAdvert['zone_one'].'" style="width:52px;height:38px"></td>
                                        <td><img src="'.MEDIA_FILES_PATH1.$fetchedAdvert['zone_one_alt'].'" style="width:52px;height:38px"></td>
                                        <td><img src="'.MEDIA_FILES_PATH1.$fetchedAdvert['zone_two'].'" style="width:52px;height:38px"></td>
                                        <td><img src="'.MEDIA_FILES_PATH1.$fetchedAdvert['zone_two_alt'].'" style="width:52px;height:38px"></td>
                                        <td><img src="'.MEDIA_FILES_PATH1.$fetchedAdvert['zone_three'].'" style="width:52px;height:24px"></td>
                                        <td><a href="'.SITE_URL.'?id='.$fetchedAdvert['id'].'">Preview Advert</a></td>
                                        <form action="" method="post">
                                        <input type="hidden" name="hidden-advert-id" value="'.$fetchedAdvert['id'].'"><input type="hidden" name="hidden-advert-status" value="'.$fetchedAdvert['status'].'">
                                        <td class="td-actions"><div style="white-space:nowrap;"><button type="submit" name="delete-advert" class="btn btn-danger btn-small" title="Delete"><i class="btn-icon-only icon-trash"> </i> </button> 
                                        <button type="button" data-id="'.$fetchedAdvert['id'].'" data-name="'.$fetchedAdvert['name'].'" data-link="'.$fetchedAdvert['link'].'" data-follow="'.$fetchedAdvert['follow'].'" data-status="'.$fetchedAdvert['status'].'" data-format="'.$fetchedAdvert['format'].'" data-background="'.$fetchedAdvert['background'].'" data-zone-one="'.$fetchedAdvert['zone_one'].'" data-zone-one-alt="'.$fetchedAdvert['zone_one_alt'].'" data-zone-two="'.$fetchedAdvert['zone_two'].'" data-zone-two-alt="'.$fetchedAdvert['zone_two_alt'].'"  data-zone-three="'.$fetchedAdvert['zone_three'].'" name="edit-advert" class="btn btn-info btn-small edit-advert-btn"  title="Edit"><i class="btn-icon-only icon-pencil"> </i> <span class="hidden" id="hiddenAdvLink">'.$fetchedAdvert['link'].'</span> </button> <button type="submit" name="activate-advert" class="btn '.$fetAdvertStatCol.' btn-small"  title="'.$fetAdvertStatTxt.'"><i class="btn-icon-only '.$fetAdvertStatus.' "> </i></button></div></td>
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
            var formVar = {id:$(this).attr('data-id'),name:$(this).attr('data-name'), link:$(this).attr('data-link'), format:$(this).attr('data-format'), background:$(this).attr('data-background'), zoneOne:$(this).attr('data-zone-one'), zoneOneAlt:$(this).attr('data-zone-one-alt'), zoneTwo:$(this).attr('data-zone-two'), zoneTwoAlt:$(this).attr('data-zone-two-alt'), zoneThree:$(this).attr('data-zone-three'), follow:$(this).attr('data-follow'), status:$(this).attr('data-status')};
            $('#btn-add-advert').find('i').toggleClass('icon-plus').toggleClass('icon-minus');
            $('#hidden-add-advert').slideDown().removeClass('hidden');
            $('form#form-advert-manager #actionField').val('edit');
            $.each(formVar, function(key, value) { 
                if(key == 'status'){ $('form#form-advert-manager input[value='+value+'].status-btn').attr('checked', 'checked');}
                else if(key == 'follow'){ $('form#form-advert-manager input[value='+value+'].follow-btn').attr('checked', 'checked');}
                else if(key === 'background' || key === 'zoneOne' || key === 'zoneOneAlt' || key === 'zoneTwo' || key === 'zoneTwoAlt' || key === 'zoneThree'){ $('form#form-advert-manager #'+key+'Old').val(value); }
                else $('form#form-advert-manager #'+key).val(value); 
            });
        });
    });
</script>

  </body>

</html>
