<?php

require_once($cfg['root_dir'] . "includes/global.inc.php");

if(!isset($_GET['n']) || !isset($_GET['id'])) {
    echo "<script>window.history.back();</script>";
    exit();
}
else {
    $n = $_GET['id'];
    $nauha = Nauha::get("id",$n);
    if(!$nauha) {
        echo "<script>window.history.back();</script>";
        exit();
    }
    $album = NauhaAlbum::get("id",$nauha->album);
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
        <title><?php echo $nauha->title; ?> - <?=$nauha->nauhakhan->name?> | Nauhas.co | Urdu Nauha Kalaam/Lyrics/Write-ups</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=920">

        <?php require_once($cfg['root_dir'] . "includes/favicon.inc.php"); ?>

        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/fonts.css">
        <link rel="stylesheet" href="css/NauhaAlbum.css">
        <link rel="stylesheet" href="css/Nauha.css">

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <link rel="stylesheet" href="js/player/jquery.playerHTML5.css">
        <script src="js/player/jquery.playerHTML5.js"></script>
        <script src="js/vendor/modernizr-2.6.2.min.js"></script>

        <style type="text/css">
            /* viewNauhakhan.php styles */

            .main-content-wrap {
                margin-top: 220px;
            }

            #nauha_wrap {
                width: 480px;

                box-sizing: border-box;
                    -moz-box-sizing: border-box;

                display: inline-block;
                vertical-align: top;

                margin-bottom: 32px;
                position: relative;

            }
            #nauha_wrap p {
                color: #555;
                font-size: 16px;
                font-weight: 400;
            }
            #nauha_header h1 {

                margin: 0;
                padding: 2px 6px;
                text-transform: uppercase;
                font-weight: 200;
                color: #777;
                text-shadow: 0 1px rgba(255,255,255,0.5);
                font-size: 36px;
                line-height: 56px;

            }
            #nauha_header h1 strong {
                font-weight: 200;
                color: #fff;
                background-color: #ecaa20;
                padding: 0 4px;
            }
            /*#nauha_wrap #nauha_header {
                padding: 16px 16px 16px 16px;
                background-color: rgba(0,0,0,0.3);
                position: absolute;
                top: -150px;
                left: 0;
                width: 872px;
                box-sizing: border-box;
                    -moz-box-sizing: border-box;
            }*/

            #nauha_header {
                padding: 16px 16px 16px 16px;
                background-color: #fff;
                width: 100%;
                box-sizing: border-box;
                    -moz-box-sizing: border-box;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                    -moz-box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                    -ms-box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                    -webkit-box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                margin-bottom: 24px;
            }

            #nauha_wrap #nauha_content {
                padding: 8px 16px 16px 16px;
                background-color: white;
                 box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                     -moz-box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                     -ms-box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                     -webkit-box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }
            #nauha_wrap #nauha_content p.indent {
                margin-left: 24px;
            }
            #nauhakhan-header {
                width: 320px;
                text-align: center;
                margin-bottom: 48px;
                display: inline-block;
                vertical-align: top;
                margin-left: 48px;
            }
            #nauhakhan_details {
               /* background-color: #ffffff;

                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                    -moz-box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                    -ms-box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                    -webkit-box-shadow: 0 2px 4px rgba(0,0,0,0.1);*/

                width: 100%;
                height: 150px;
                padding: 8px;
                margin-top: 20px;


                box-sizing: border-box;
                    -moz-box-sizing: border-box;

                display: inline-block;
                vertical-align: top;
            }
            #nauhakhan_details h1 {
                margin: 0;
                padding: 2px 6px;
                text-transform: uppercase;
                font-weight: 200;
                color: #444;
                border-bottom: 1px solid #bbbbbb;
                text-shadow: 0 1px rgba(255,255,255,0.5);
                font-size: 28px;
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


                box-sizing: border-box;
                    -moz-box-sizing: border-box;

                display: inline-block;
                vertical-align: middle;

                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
            }

            .background.background-nauhakhans  {
                background-image: url(img/backgrounds/imam-hussain-a-s-as-414346.jpg);
            }

            /* AUDIO PLAYER */
            #nauha_wrap #nauha_audio {
                padding: 16px;
                background-color: white;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                -moz-box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                -ms-box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                -webkit-box-shadow: 0 2px 4px rgba(0,0,0,0.1);

                text-align: center;

                margin-bottom: 16px;
            }
            #nauha_wrap #nauha_audio audio {
                display: none;
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
                    <div id="nauha_header">
                        <h1><?=$nauha->title?> <strong><?=$album->year_gregorian?></strong></h1>
                    </div>
                    <div id="nauha_wrap">
                        <section id="nauha" class="content-section">
                            <?php
                            if($nauha->getMP3()) {
                            ?>
                            <div id="nauha_audio">
                                <audio src="<?=$nauha->getMP3()?>" preload="auto" controls>
                                    <p class="err">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
                                </audio>
                                <div class="player">
                                    <a href="#" class="rr"></a>
                                    <a href="#" class="play"></a>
                                    <a href="#" class="ff"></a>
                                </div>
                            </div>
                            <?php } ?>
                            <div id="nauha_content">
                                <?php
                                echo (strlen($nauha->text)>0) ? $nauha->text : Nauha::ERROR_NO_WRITEUP;
                                ?>
                            </div>
                        </section>
                    </div><!--
                ---><div id="nauhakhan-header">
                        <div id="nauhakhan_image" style="background-image: url(<?=$nauha->nauhakhan->getImage()?>);">
                        </div>
                        <section id="nauhakhan_details" class="content-section">
                            <h1><?=$nauha->nauhakhan->getFirstName()?> <strong><?=$nauha->nauhakhan->getLastName()?></strong></h1>
                            <div id="nauhakhan-links">
                                <a class="nauhakhan-links" href="#"><img src="img/icons/long-shadow-social/32/Facebook.png" /></a>
                                <a class="nauhakhan-links" href="#"><img src="img/icons/long-shadow-social/32/Google-plus.png" /></a>
                                <a class="nauhakhan-links" href="#"><img src="img/icons/long-shadow-social/32/Twitter.png" /></a>
                                <a class="nauhakhan-links" href="#"><img src="img/icons/long-shadow-social/32/Youtube.png" /></a>
                                <a class="nauhakhan-links" href="#"><img src="img/icons/long-shadow-social/32/Link.png" /></a>
                            </div>
                        </section>
                    </div>

                        <?php
                        /*
                         * <h2><strong>Similar</strong> Nauhas</h2>
                         * <section id="top_nauhas" class="content-section">
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
                                </div><!--
                            ---><div class="nauha-content">
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
                         */
                        ?>
                    <h2>In This <strong>Album</strong></h2>
                        <section id="all_nauhas" class="content-section">
                            <?php
                            $printData = $album->toArray();
                            $printData['tracks'] = $album->formatTracklist(NauhaAlbum::FORMAT_FULL_TRACKLIST);
                            $printData['releaseDate'] = date("F j, Y", $printData['releaseDate']);
                            echo dsprintf(NauhaAlbum::FORMAT_FULL, $printData);
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
