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
        <title>Nadeem Sarwar | Nauhas.co | Urdu Nauha Kalaam/Lyrics/Write-ups</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/fonts.css">
        <script src="js/vendor/modernizr-2.6.2.min.js"></script>

        <style type="text/css">
            /* viewNauhakhan.php styles */

            .topNauha {
                width: 420px;
                height: 276px;
                margin: 8px;
                padding: 8px;
                display: inline-block;
                vertical-align: top;
                overflow: hidden;
                position: relative;
                background: white;

                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                    -moz-box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                    -ms-box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                    -webkit-box-shadow: 0 2px 4px rgba(0,0,0,0.1);

                transition-duration: 0.2s;
                    -webkit-transition-duration: 0.2s;
                    -moz-transition-duration: 0.2s;

                box-sizing: border-box;
                    -moz-box-sizing: border-box;
            }
            .topNauha .nauhakhan-image {
                width: 64px;
                height: 64px;

                background-size: cover;
                background-position: center;
                margin: 8px;;

                display: inline-block;
                vertical-align: middle;

                border: 1px solid #eee;

                border-radius: 2px;
                    -moz-border-radius: 2px;
                box-sizing: border-box;
                    -moz-box-sizing: border-box;
            }
            .topNauha .nauha-heading {
                display: inline-block;
                font-weight: 600;
                font-size: 18px;
                width: 324px;;
                margin-bottom: 6px;

                vertical-align: middle;
                box-sizing: border-box;
                    -moz-box-sizing: border-box;

                padding: 8px;
            }
            .topNauha .nauha-title {
                display: block;
            }
            .topNauha .nauha-details {
                color: #777;
                font-size: 12px;
                display: block;
            }
            .topNauha .nauha-details .nauha-nauhakhan {
                color: #ecaa20;
                font-weight: 600;
            }
            .topNauha .nauha-content {
                height: 180px;
                overflow: hidden;
                color: #555;
                font-size: 14px;
                position: relative;

            }
            .topNauha .nauha-content .fade {
                height: 64px;
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;

                background: linear-gradient(to bottom,  rgba(255,255,255,0) 0%,rgba(255,255,255,0.65) 50%,rgba(255,255,255,1) 100%); /* W3C */
                background: -moz-linear-gradient(top,  rgba(255,255,255,0) 0%, rgba(255,255,255,0.65) 50%, rgba(255,255,255,1) 100%); /* FF3.6+ */
                background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,255,255,0)), color-stop(50%,rgba(255,255,255,0.65)), color-stop(100%,rgba(255,255,255,1))); /* Chrome,Safari4+ */
                background: -webkit-linear-gradient(top,  rgba(255,255,255,0) 0%,rgba(255,255,255,0.65) 50%,rgba(255,255,255,1) 100%); /* Chrome10+,Safari5.1+ */
                background: -o-linear-gradient(top,  rgba(255,255,255,0) 0%,rgba(255,255,255,0.65) 50%,rgba(255,255,255,1) 100%); /* Opera 11.10+ */
                background: -ms-linear-gradient(top,  rgba(255,255,255,0) 0%,rgba(255,255,255,0.65) 50%,rgba(255,255,255,1) 100%); /* IE10+ */
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00ffffff', endColorstr='#ffffff',GradientType=0 ); /* IE6-9 */

            }
            .topNauha:hover {
                box-shadow: 0 2px 4px rgba(0,0,0,0.4);
                    -moz-box-shadow: 0 2px 4px rgba(0,0,0,0.4);
                    -ms-box-shadow: 0 2px 4px rgba(0,0,0,0.4);
                    -webkit-box-shadow: 0 2px 4px rgba(0,0,0,0.4);

            }

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
                        <div id="nauhakhan_image" style="background-image: url(img/nauhakhans/nauhakhan_nadeem_sarwar.jpg)">
                        </div>
                        <section id="nauhakhan_details" class="content-section">
                            <h1>Nadeem <strong>Sarwar</strong></h1>
                            <div id="nauhakhan-links">
                                <a class="nauhakhan-links" href="#"><img src="img/icons/long-shadow-social/32/Facebook.png" /></a>
                                <a class="nauhakhan-links" href="#"><img src="img/icons/long-shadow-social/32/Google-plus.png" /></a>
                                <a class="nauhakhan-links" href="#"><img src="img/icons/long-shadow-social/32/Twitter.png" /></a>
                                <a class="nauhakhan-links" href="#"><img src="img/icons/long-shadow-social/32/Youtube.png" /></a>
                                <a class="nauhakhan-links" href="#"><img src="img/icons/long-shadow-social/32/Link.png" /></a>
                            </div>
                        </section>
                    </div>
                    <h2><strong>Top</strong> Nauhas</h2>
                        <section id="top_nauhas" class="content-section">
                            <div class="topNauha">
                                <a href="#" class="full-box-link"></a>
                                <div class="nauhakhan-image" style="background-image: url(img/nauhakhans/nauhakhan_nadeem_sarwar.jpg);"></div><!--
                            ---><div class="nauha-heading">
                                    <span class="nauha-title">Ye Janaza Hai Ali Ka</span>
                                    <span class="nauha-details">
                                        <span class="nauha-nauhakhan">Nadeem Sarwar</span> &middot;
                                        <span class="nauha-release-year">2012</span>
                                    </span>
                                </div>

                                <div class="nauha-content">
                                    <div class="nauha-preview">
                                        <?php
                                            echo strip_tags('Haay Ali Maula, Haay Ali Maula
                                        Ye Janaza Hai Ali Ka, Ye Janaza Hai Ali Ka
                                        (Ye Janaza Hai Ali Ka, Shah-e-Khaybar Geer Ka, Ye Janaza Hai Ali Ka) x2
                                        Aaj Baba Mar Gaya Hai, Shabar-o-Shabeer Ka
                                        Ye Janaza Hai Ali Ka
                                        Ye Janaza Hai Ali Ka, Shah-e-Khaybar Geer Ka, Ye Janaza Hai Ali Ka
                                        (Fatima Zehra ke marqad se sada aane lagi) x2
                                        (Hai Sada Aane Lagi)
                                        Ye Masayab reh gaya tha, kya meri taqdeer ka
                                        Ye Janaza Hai Ali Ka
                                        Ye Janaza Hai Ali Ka, Shah-e-Khaybar Geer Ka, Ye Janaza Hai Ali Ka
                                        (Ya Rasul Allah ye Jibreel ne rokar kaha)x2
                                        (Hai Ye Rokar Kaha)
                                        Aik Halqa aur tuta noor ki zanjeer ka');
                                        ?>
                                        <div class="fade"></div>
                                    </div>
                                </div>
                            </div><!--
                        ---><div class="topNauha">
                                <a href="#" class="full-box-link"></a>
                                <div class="nauhakhan-image" style="background-image: url(img/nauhakhans/nauhakhan_nadeem_sarwar.jpg);"></div><!--
                            ---><div class="nauha-heading">
                                    <span class="nauha-title">Abad Wallah Ya Zahra</span>
                                    <span class="nauha-details">
                                        <span class="nauha-nauhakhan">Nadeem Sarwar</span> &middot;
                                        <span class="nauha-release-year">2012</span>
                                    </span>
                                </div>

                                <div class="nauha-content">
                                    <div class="nauha-preview">
                                        <?php
                                        echo strip_tags('(Hussain, Hussain)x5
                                            Wada Hai Hamara, Ya Fatima Zahra(x2)
                                            Nahi Bhoolenge Hussiana(x2)
                                            Wada Hai Hamara, Ya Fatima Zahra(x2)
                                            Nahi Bhoolenge Hussiana(x3)
                                            Usne Humko Na Bhoolaya, Humne Usko Na Bhoolaya(x2)
                                            Abad Wallah Ya Zahra,  Mayin Sa Hussaina(x3)
                                            Wada Hai ye Wallah, Ya Fatima Zehra
                                            Wada Hai Hamara, Ya Fatima Zahra(x2)
                                            Nahi Bhoolenge Hussiana(x2)
                                            Kasam Allah Ki wo jisne Hamai(n) khalq kiya
                                            Aur hume Karbobala ke liye Maqsoos Kiya
                                            Hum Wohi Log Hai Wallah Dua-e-Zehra
                                            Usne Halmin jo kaha La sirnian surna
                                            Hamne Labaik Kaha');
                                        ?>
                                        <div class="fade"></div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    <h2><strong>All</strong> Nauhas</h2>
                        <section id="all_nauhas" class="content-section">

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
