<?php

require_once($cfg['root_dir'] . "includes/global.inc.php");

?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
         <title>Nauhakhans | Nauhas.co | Urdu Nauha Kalaam/Lyrics/Write-ups</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=920">

        <?php require_once($cfg['root_dir'] . "includes/favicon.inc.php"); ?>

        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/Nauhakhans.css">
        <link rel="stylesheet" href="css/fonts.css">
        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 9]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <?php printSiteHeader("nauhakhans"); ?>

        <div class="main-wrap">
            <div class="background background-nauhakhans">
                <div class="background-overlay"></div>
            </div>
            <div class="main-content-wrap">
                <div class="main-content">
                    <h2><strong>Top</strong> Nauhakhans</h2>
                        <section id="top_nauhakhans" class="content-section">
                            <?php
                            $output = array();
                            foreach($db->get("nauhakhans","id",4) as $nkid) {
                                $nauhakhan = Nauhakhan::get("id",$nkid['id']);
                                $args = $nauhakhan->toArray();
                                $args['description'] = strip_tags($args['description'], "<strong><em>");
                                array_push($output, dsprintf(Nauhakhan::FORMAT_TOPNAUHAKHANS, $args));
                            }
                            echo implode("<!-- -->", $output);

                            ?>
                        </section>
                    <h2><strong>All</strong> Nauhakhans</h2>
                        <section id="all_nauhakhans" class="content-section">
                            <?php
                            $output = array();
                            foreach($db->orderBy("name")->get("nauhakhans","id") as $nkid) {
                                $nauhakhan = Nauhakhan::get("id",$nkid['id']);
                                $args = $nauhakhan->toArray();
                                $args['description'] = strip_tags($args['description'], "<strong><em>");
                                array_push($output, dsprintf(Nauhakhan::FORMAT_SMALL_CARD, $args));
                            }
                            echo implode("<!-- -->", $output);

                            ?>
                        </section>
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
