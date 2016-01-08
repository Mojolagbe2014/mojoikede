<?php
session_start();
include 'classes/WebPage.php'; //Set up page as a web page
$thisPage = new WebPage('includes/constants.php');//Create new instance of webPage class
$msg = ""; //Success or failure message 
$errorArr = array(); //Array of errors
$dbObj = new Database(); //create database object
$advertObj = new Advert(); //Instantiate user class
$advertObj->id = filter_input(INPUT_GET, "id") ? filter_input(INPUT_GET, "id") : '';
list($advertWidth, $advertHeight, $advertType, $advertAttr) = getimagesize(MEDIA_FILES_PATH1.Advert::getSingle($dbObj, "background", $advertObj->id));
?>
<!DOCTYPE html>
<html>
<head>
    <title>Advert Banner</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="description" content="Custom Animation Banner with jQuery" />
    <meta name="keywords" content="jquery, animation, banner, customize, css3, fadein, slider, slideshow"/>
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
<!--    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen"/>-->
    <style> .ca_zone{ position:absolute; width:100%; left: 0px; top: 499px; } </style>
<!--    <script src="js/cufon-yui.js" type="text/javascript"></script>-->
<!--    <script src="js/Bebas_400.font.js" type="text/javascript"></script>-->
</head>

<body>
    <div id="ca_banner2" class="ca_banner ca_banner2" style="width:<?php echo $advertWidth ? $advertWidth :  "160" ;?>px;height:<?php echo $advertHeight ? $advertHeight :  "600" ;?>px;position:relative; overflow:hidden; background:#f0f0f0; padding:0px; border:1px solid #fff; -moz-box-shadow:0px 0px 2px #aaa inset;">
        <div class="ca_slide ca_bg2" style="background:#fff url(<?php echo $advertObj->id ? MEDIA_FILES_PATH1.Advert::getSingle($dbObj, "background", $advertObj->id): "images/bgSmall.jpg"; ?>) no-repeat top left;width:100%; height:100%; position:relative; overflow:hidden;">
            <div class="ca_zone ca_zone1" style="top:<?php echo intVal($advertHeight/60); ?>px;left:0px;"><!--Product Top-->
                    <div class="ca_wrap ca_wrap1" style="height:<?php echo intVal($advertHeight/3.0768); ?>px;width:<?php echo $advertWidth ? $advertWidth :  "160" ;?>px;position:relative; display:table-cell; vertical-align:middle; text-align:center;">
                        <img src="<?php echo $advertObj->id ? MEDIA_FILES_PATH1.Advert::getSingle($dbObj, "zone_one", $advertObj->id): "images/smallProduct1.png"; ?>" class="ca_shown" alt=""/>
                        <img src="<?php echo $advertObj->id ? MEDIA_FILES_PATH1.Advert::getSingle($dbObj, "zone_one_alt", $advertObj->id): "images/smallProduct2.png"; ?>" alt="" style="display:none;"/>
                    </div>
            </div>
            <div class="ca_zone ca_zone2" style="top:<?php echo intVal($advertHeight/2.4); ?>px; left:0px;"><!--Product Middle-->
                <div class="ca_wrap ca_wrap2" style="height:<?php echo intVal($advertHeight/3.0768); ?>px;width:<?php echo $advertWidth ? $advertWidth :  "160" ;?>px;position:relative; display:table-cell; vertical-align:middle; text-align:center;">
                    <img src="<?php echo $advertObj->id ? MEDIA_FILES_PATH1.Advert::getSingle($dbObj, "zone_two", $advertObj->id): "images/smallProduct3.png"; ?>" class="ca_shown" alt=""/>
                    <img src="<?php echo $advertObj->id ? MEDIA_FILES_PATH1.Advert::getSingle($dbObj, "zone_two_alt", $advertObj->id): "images/smallProduct4.png"; ?>" alt="" style="display:none;"/>
                </div>
            </div>

            <div class="ca_zone ca_zone3" style="top:<?php echo intVal($advertHeight/1.1538); ?>px;"><!--Product Middle-->
                <div class="ca_wrap ca_wrap3" style="height:<?php echo intVal($advertHeight/10); ?>px;width:<?php echo $advertWidth ? $advertWidth :  "160" ;?>px;position:relative; display:table-cell; vertical-align:middle; text-align:center;">
                    <img src="<?php echo $advertObj->id ? MEDIA_FILES_PATH1.Advert::getSingle($dbObj, "zone_three", $advertObj->id): "images/smallProduct10.png"; ?>" class="ca_shown" alt="" style="display:inline !important;"/>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        <br/><br/>
        <a href="<?php echo SITE_URL."operator/advert-manager"; ?>"> <<< Return</a>
    </div>


<!-- The JavaScript -->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script src="js/jquery.transform-0.8.0.min.js"></script>
<script src="js/jquery.banner.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {
        $('#ca_banner2').banner({steps : [[ [{"to" : "2"}, {"effect": "slideOutTop-slideInTop"}], [{"to" : "2"}, {"effect": "slideOutTop-slideInTop"}] ],[[{"to" : "1"}, {"effect": "slideOutRight-slideInRight"}], [{"to" : "1"}, {"effect": "slideOutLeft-slideInLeft"}] ],[[{"to" : "2"}, {"effect": "slideOutLeft-slideInLeft"}], [{"to" : "2"}, {"effect": "slideOutRight-slideInRight"}]],[[{"to" : "1"}, {"effect":"zoomOutRotated-zoomInRotated"}],[{"to" : "1"}, {"to" : "1"}, {"effect": "zoomOutRotated-zoomInRotated"}]]],total_steps	: 4, speed: 4000});
    });
</script>
</body>
</html>