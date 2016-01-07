<?php
include '../classes/WebPage.php';

$webPage = new WebPage('../includes/constants.php');
?>
<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="utf-8">
    <title>Create New Post</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">    
    
    <style>
        .rounded-coner{
            display: block;
            border-radius: 5px 5px 5px 5px;
            -moz-border-radius: 5px 5px 5px 5px;
            -webkit-border-radius: 5px 5px 5px 5px;
            border: 1px solid #000000;
            padding: 3px;
            cursor: pointer;
            width: 70px;
            height: 70px;
            float: left;
            margin:6px;
        }
        .selected-img {
            border: 1px solid #1c2de6;
        }
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

<?php //include 'includes/header.php';?>
    
    <div class="col-md-12" style="width:1000px;">
	      		
                    <div class="widget">
						
			<div class="widget-header">
                            <i class="icon-camera"></i>
                            <h3>Media Files</h3>
                        </div> <!-- /widget-header -->
                        <div class="widget-content" style="padding:0px;">
                            <div class="content clearfix" style="width:95%;">
                                <div class="pull-left" style="width:630px;">
                                <?php
                                $image = Folder::getImages(MEDIA_PATH);
                                foreach($image as $img){
                                    ?>
                                    <img src="<?php echo SITE_URL;?>media/<?php echo $img;?>" class="rounded-coner media" style="width:70px; height: 70px;"/> 
                                    <?php  
                                 }
                                 ?>
                                </div>
                                <div class="pull-right" style="width:300px;">
                                    <div class="image-full col-md-12" style="height:150px;" id='showimg'>
                                        <!-- image here -->
                                    </div>
                                    <form id="" class="form-inline" method="post">
                                        <div class="control-group">											
                                            <label class="control-label" for="username">Image Link</label>
                                            <div class="controls">
                                                <input type="text" class="input" id="input" readonly style="height:30px; width: 100%; cursor: default">
                                            </div>
                                        </div>
                                        <?php 
                                        if(isset($_GET['featured'])){
                                        ?>
                                        <a href="javascript:void()" class="btn btn-primary" id="setImage"><i class="icon-picture"></i>Set as featured image</a>
                                        <?php
                                        }
                                        ?>
                                    </form>
                                </div>

 
                            </div> <!-- /content -->
						
					</div> <!-- /widget-content -->
						
				</div> <!-- /widget -->					
				
		    </div> <!-- /span12 -->  


<script>
    $(document).ready(function(){
        $('.media').click(function(){
            var source = $(this).attr('src')
            $(this).css("border","1px solid #59B200");
            $('#showimg').html('<img src="'+source+'" style="width:100%; height:140px;"/>');
            $('#input').val(source);
        });
        $('#input').click(function(){
            $(this).select();
        });
        $('#setImage').click(function(){
             
             var src = $('#input').val();
             $('#featuredImage').val(src);
             $('#featured').html('<img src="'+src+'" style="width:100%; height:140px;" />');
             $('#facebox').fadeOut(function() {
             $('#facebox .content').removeClass().addClass('content')
             $('#facebox .loading').remove()
             $('#facebox_overlay').hide();
            })
            
        });
    });
    
</script>
  </body>

</html>
