<!DOCTYPE html>
<html>
<head>
    <title>Advert Banner</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="description" content="Custom Animation Banner with jQuery" />
    <meta name="keywords" content="jquery, animation, banner, customize, css3, fadein, slider, slideshow"/>
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen"/>
    <script src="js/cufon-yui.js" type="text/javascript"></script>
    <script src="js/Bebas_400.font.js" type="text/javascript"></script>
    <script type="text/javascript"> Cufon.replace('a, li, h1'); Cufon('h1',{ textShadow: '1px 1px #fff' }); </script>
    <style type="text/css">
            span.reference{
                    font-family:Arial;
                    position:fixed;
                    left:10px;
                    bottom:10px;
                    font-size:12px;
            }
            span.reference a{
                    color:#999;
                    text-transform:uppercase;
                    text-decoration:none;
            }
            .ca_banner{
                /* [disabled]margin:20px; */
                /* [disabled]float:left; */
            }
            .content{
                    width:960px;
                    margin:0 auto;
            }
    </style>
</head>

<body>
    <div id="ca_banner2" class="ca_banner ca_banner2">
        <div class="ca_slide ca_bg2">
            <div class="ca_zone ca_zone1"><!--Product Top-->
                    <div class="ca_wrap ca_wrap1">
                            <img src="images/smallProduct1.png" class="ca_shown" alt=""/>
                            <img src="images/smallProduct2.png" alt="" style="display:none;"/>
                    </div>
            </div>
            <div class="ca_zone ca_zone2"><!--Product Middle-->
                    <div class="ca_wrap ca_wrap2">
                            <img src="images/smallProduct3.png" class="ca_shown" alt=""/>
                            <img src="images/smallProduct4.png" alt="" style="display:none;"/>
                    </div>
            </div>

            <div class="ca_zone ca_zone3"><!--Product Middle-->
                    <div class="ca_wrap ca_wrap3">
                            <img src="images/smallProduct10.png" class="ca_shown" alt=""/>
                    </div>
            </div>
        </div>
    </div>



<!-- The JavaScript -->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
<script type="text/javascript" src="jquery.easing.1.3.js"></script>
<script src="jquery.transform-0.8.0.min.js"></script>
<script src="jquery.banner.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {
        //we want 4 steps/slides for the second banner:
        $('#ca_banner2').banner({
            steps : [
                    [
                            //1 step:
                            [{"to" : "2"}, {"effect": "slideOutTop-slideInTop"}],
                            [{"to" : "2"}, {"effect": "slideOutTop-slideInTop"}]
                    ],
                    [
                            //2 step:
                            [{"to" : "1"}, {"effect": "slideOutRight-slideInRight"}],
                            [{"to" : "1"}, {"effect": "slideOutLeft-slideInLeft"}],
                    ],
                    [
                            //3 step:
                            [{"to" : "2"}, {"effect": "slideOutLeft-slideInLeft"}],
                            [{"to" : "2"}, {"effect": "slideOutRight-slideInRight"}]
                    ],
                    [
                            //4 step:
                            [{"to" : "1"}, {"effect":"zoomOutRotated-zoomInRotated"}],
                            [{"to" : "1"}, {}],
                    ],
//                        [
//                                //4 step:
//                                [{"to" : "1"}, {"effect":"zoomOutRotated-zoomInRotated"}],
//                                [{"to" : "1"}, {"effect": "zoomOutRotated-zoomInRotated"}],
//                        ]
            ],
            total_steps	: 4,
            speed 		: 2000
        });
    });
</script>
</body>
</html>