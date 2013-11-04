<?php

require_once($cfg['root_dir'] . "includes/global.inc.php");

if(!isset($_GET['n'])) {
    header("Location: nauhakhans.php");
    exit();
}
else {
    $n = $_GET['n'];
    $nauhakhan = Nauhakhan::get("name",$n);
    if(!$nauhakhan) {
        header("Location: nauhakhans.php");
        exit();
    }
}

?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?=$nauhakhan->name?> | Nauhas.co | Urdu Nauha Kalaam/Lyrics/Write-ups</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=1028">

        <?php require_once($cfg['root_dir'] . "includes/favicon.inc.php"); ?>

        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/fonts.css">
        <link rel="stylesheet" href="css/NauhaAlbum.css">
        <link rel="stylesheet" href="css/Nauha.css">
        <script src="js/vendor/modernizr-2.6.2.min.js"></script>

        <style type="text/css">
            /* viewNauhakhan.php styles */



            #nauhakhan-header {
                margin-top: -180px;
                width: 100%;
                height: 300px;
                text-align: center;
                margin-bottom: 48px;
            }
            #nauhakhan_details {
                background-color: #ffffff;

                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                    -moz-box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                    -ms-box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                    -webkit-box-shadow: 0 2px 4px rgba(0,0,0,0.1);

                width: 400px;
                height: 150px;
                padding: 8px;
                margin-top: 20px;


                box-sizing: border-box;
                    -moz-box-sizing: border-box;

                display: inline-block;
                vertical-align: middle;
            }
            #nauhakhan_details h1 {
                margin: 0;
                padding: 2px 6px;
                text-transform: uppercase;
                font-weight: 200;
                color: #444;
                border-bottom: 1px solid #bbbbbb;
                text-shadow: 0 1px rgba(255,255,255,0.5);
            }
            #nauhakhan_details h1 strong {
                color: #ecaa20;
                font-weight: 700;
                color: #ecaa20;
                border-bottom: 4px solid #ecaa20;
                padding: 0 4px;
            }
            #nauhakhan_details #nauhakhan-links {
                margin-top: 24px
            }
            #nauhakhan_details #nauhakhan-links .nauhakhan-links {
                display: inline-block;
                height: 32px;
                width: 32px;
                margin: 4px;
            }
            #nauhakhan_image {
                background-color: #ffffff;

                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                -moz-box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                -ms-box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                -webkit-box-shadow: 0 2px 4px rgba(0,0,0,0.1);

                width: 300px;
                height: 300px;
                padding: 8px;
                margin-right: 48px;


                box-sizing: border-box;
                    -moz-box-sizing: border-box;

                display: inline-block;
                vertical-align: middle;

                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
            }

            .background.background-nauhakhans  {
                background-image: url(img/backgrounds/kerbala_hussain.jpg);
            }

        </style>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <?php printSiteHeader("nauhakhans"); ?>

        <div class="main-wrap">
            <div class="background background-nauhakhans">
                <div class="background-overlay"></div>
            </div>
            <div class="main-content-wrap">
                <div class="main-content">
                    <div id="nauhakhan-header">
                        <div id="nauhakhan_image" style="background-image: url(<?=$nauhakhan->getImage()?>)">
                        </div>
                        <section id="nauhakhan_details" class="content-section">
                            <h1><?=$nauhakhan->getFirstName()?> <strong><?=$nauhakhan->getLastName()?></strong></h1>
                            <div id="nauhakhan-links">
                                <a class="nauhakhan-links" href="#"><img src="img/icons/long-shadow-social/32/Facebook.png" /></a>
                                <a class="nauhakhan-links" href="#"><img src="img/icons/long-shadow-social/32/Google-plus.png" /></a>
                                <a class="nauhakhan-links" href="#"><img src="img/icons/long-shadow-social/32/Twitter.png" /></a>
                                <a class="nauhakhan-links" href="#"><img src="img/icons/long-shadow-social/32/Youtube.png" /></a>
                                <a class="nauhakhan-links" href="#"><img src="img/icons/long-shadow-social/32/Link.png" /></a>
                            </div>
                        </section>
                    </div>
                    <?php if($nauhakhan->countNauhas()>0) { ?>
                    <h2><strong>Top</strong> Nauhas</h2>
                        <section id="top_nauhas" class="content-section">
                            <?php
                            $out = array();
                            foreach($db->where("nauhakhan",$nauhakhan->id)->orderBy("updated")->get(Nauha::TABLE,"*",2) as $data) {
                                $nauha = new Nauha($data);
                                $printData = $nauha->toArray();
                                $out[] =  dsprintf(Nauha::FORMAT_FEATURED, $printData);
                            }
                            echo implode("<!-- -->", $out);

                            ?>
                        </section>
                    <h2><strong>All</strong> Nauhas</h2>
                        <section id="all_nauhas" class="content-section">
                            <?php
                            $count = 0;
                            foreach($db->where("nauhakhan",$nauhakhan->id)->orderBy("releaseDate")->get(NauhaAlbum::TABLE) as $data) {
                                $album = new NauhaAlbum($data);
                                $printData = $album->toArray();
                                $printData['tracks'] = $album->formatTracklist(NauhaAlbum::FORMAT_FULL_TRACKLIST);
                                $printData['releaseDate'] = date("F j, Y", $printData['releaseDate']);
                                echo dsprintf(NauhaAlbum::FORMAT_FULL, $printData);
                                $count++;
                            }
                            ?>
                        </section>
                    <?php }
                    else {
                      echo "<p class='err'>We have no nauhas for " . $nauhakhan->name . "</p>";
                    }
                    ?>
                </div>
            </div>
        </div>

        <?php printSiteFooter(); ?>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X');ga('send','pageview');
        </script>
    </body>
</html>
