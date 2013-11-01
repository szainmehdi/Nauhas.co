<?php
require_once($cfg['root_dir'] . "classes/User.class.php");
require_once($cfg['root_dir'] . "classes/Database.class.php");

//functions.inc.php
function printSiteHeader($page="home") {
    echo '
    <header>
        <div id="header-content-wrap">
            <div id="header-content">
                <div class="site-logo"><h1 class="title ir">Nauhas.co</h1></div>
                <nav>
                    <a href="index.php"'; if($page=="home") echo ' class="active"'; echo '>Home</a>
                    <a href="nauhakhans.php"'; if($page=="nauhakhans") echo ' class="active"'; echo '>Nauhakhans</a>
                    <a href="nauhas.php"'; if($page=="nauhas") echo ' class="active"'; echo '>Submit Nauhas</a>
                </nav>';echo '
            </div>
        </div>
        <div class="background background-' . $page . '">
            <div class="background-overlay"></div>
        </div>
    </header>';
}
function printSiteFooter() {
    echo '<footer>
            <a href="index.php"><div class="site-logo-footer"></div></a>
            <p>Copyright &copy; 2013 Z Computers. Designed and developed by <a href="http://google.com/+ZainMehdi" target="_blank" title="S. Zain Mehdi&apos;s Google+">Syed Zain Mehdi</a>.</p>
        </footer>';
}