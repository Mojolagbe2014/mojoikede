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
    <div id="leftBanner" data-current="0" data-length="2" data-all="1,2"></div><!-- data-all will contain fetch ids of adverts -->
    <div class="footer">
        <br/><br/>
        <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>"> <<< Return</a>
    </div>


<!-- The JavaScript -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script src="js/jquery.transform-0.8.0.min.js"></script>
<script src="js/jquery.banner.js" type="text/javascript"></script>
<script>
    $(function() { 
        var current;
        setInterval(function(){
            loadAdverts('#leftBanner');
        }, 7000);
        function loadAdverts(selector){
            current = $(selector).attr('data-current');
            totalAdvertisers = $(selector).attr('data-all').split(',');
            if(current<totalAdvertisers.length) {
                $(selector).load("main.php?id="+totalAdvertisers[current]);
                current++; $(selector).attr('data-current', current);
            }
            else{$(selector).attr('data-current', '0'); loadAdverts(selector);}
        }
        
    });
</script>

</body>
</html>