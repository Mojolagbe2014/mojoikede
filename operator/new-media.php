<?php
session_start();
include '../classes/WebPage.php';

$webPage = new WebPage('../includes/constants.php');
?>
<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="utf-8">
    <title>Add New Media</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">    
    
    
    
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet">
    
    <link href="css/style.css" rel="stylesheet">
    <link href="css/pages/plans.css" rel="stylesheet"> 
    
    <link href="media-uploader/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="media-uploader/css/uploader.css" rel="stylesheet" type="text/css"/>
    <link href="media-uploader/css/demo.css" rel="stylesheet" type="text/css"/>
    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

  </head>

<body>
<br><br><br>
<?php include 'includes/header.php';?>    
    
<div class="container demo-wrapper">
      <div class="row demo-columns">
        <div class="col-md-6">
          <!-- D&D Zone-->
          <div id="drag-and-drop-zone" class="uploader">
            <div>Drag &amp; Drop Images Here</div>
            <div class="or">-or-</div>
            <div class="browser">
              <label>
                <span>Click to open the file Browser</span>
                <input type="file" name="files[]"  accept="image/*" multiple="multiple" title='Click to add Images'>
              </label>
            </div>
          </div>
          <!-- /D&D Zone -->

          <!-- Debug box -->
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Status/Result</h3>
            </div>
            <div class="panel-body demo-panel-debug">
              <ul id="demo-debug">
              </ul>
            </div>
          </div>
          <!-- /Debug box -->
        </div>
        <!-- / Left column -->

        <div class="col-md-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Uploads</h3>
            </div>
            <div class="panel-body demo-panel-files" id='demo-files'>
              <span class="demo-note">No Files have been selected/dropped yet...</span>
            </div>
          </div>
        </div>
        <!-- / Right column -->
      </div>
    </div>


<?php include ('includes/footer.php'); ?>
    

<!-- Le javascript ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/jquery-1.7.2.min.js" type="text/javascript"></script>

<script src="js/bootstrap.js"></script>
<script src="js/base.js"></script>

<script src="media-uploader/js/jquery-1.10.1.min.js" type="text/javascript"></script>
<script src="media-uploader/js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<script src="media-uploader/js/demo-preview.min.js" type="text/javascript"></script>
<script src="media-uploader/js/dmuploader.min.js" type="text/javascript"></script>

<script type="text/javascript">
    $('#drag-and-drop-zone').dmUploader({
      url: 'media-uploader/upload.php',
      extraData: {submit: 'submit'},
      method: 'POST',
      dataType: 'json',
      allowedTypes: 'image/*',
      onInit: function(){
        $.danidemo.addLog('#demo-debug', 'default', 'Plugin initialized correctly');
      },
      onBeforeUpload: function(id){
        $.danidemo.addLog('#demo-debug', 'default', 'Starting the upload of #' + id);

        $.danidemo.updateFileStatus(id, 'default', 'Uploading...');
      },
      onNewFile: function(id, file){
        $.danidemo.addFile('#demo-files', id, file);

        /*** Begins Image preview loader ***/
        if (typeof FileReader !== "undefined"){

          var reader = new FileReader();

          // Last image added
          var img = $('#demo-files').find('.demo-image-preview').eq(0);

          reader.onload = function (e) {
            img.attr('src', e.target.result);
          }

          reader.readAsDataURL(file);

        } else {
          // Hide/Remove all Images if FileReader isn't supported
          $('#demo-files').find('.demo-image-preview').remove();
        }
        /*** Ends Image preview loader ***/

      },
      onComplete: function(){
        $.danidemo.addLog('#demo-debug', 'default', 'All pending tranfers completed');
      },
      onUploadProgress: function(id, percent){
        var percentStr = percent + '%';

        $.danidemo.updateFileProgress(id, percentStr);
      },
      onUploadSuccess: function(id, data){
        $.danidemo.addLog('#demo-debug', 'success', 'Upload of file #' + id + ' completed');

        $.danidemo.addLog('#demo-debug', 'info', 'Server Response for file #' + id + ': ' + JSON.stringify(data));

        $.danidemo.updateFileStatus(id, 'success', 'Upload Complete');

        $.danidemo.updateFileProgress(id, '100%');
      },
      onUploadError: function(id, message){
        $.danidemo.updateFileStatus(id, 'error', message);

        $.danidemo.addLog('#demo-debug', 'error', 'Failed to Upload file #' + id + ': ' + message);
      },
      onFileTypeError: function(file){
        $.danidemo.addLog('#demo-debug', 'error', 'File \'' + file.name + '\' cannot be added: must be an image');
      },
      onFileSizeError: function(file){
        $.danidemo.addLog('#demo-debug', 'error', 'File \'' + file.name + '\' cannot be added: size excess limit');
      },
      onFallbackMode: function(message){
        $.danidemo.addLog('#demo-debug', 'info', 'Browser not supported(do something else here!): ' + message);
      }
    });
  </script>

</body>

</html>
