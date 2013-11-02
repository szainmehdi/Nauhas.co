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

/**
 * Like vsprintf, but accepts $args keys instead of order index.
 * Both numeric and strings matching /[a-zA-Z0-9_-]+/ are allowed.
 *
 * $str = "Hello, %(place)s, how is it hanning at %(place)s? %s works just as well";
 *   $find = array(
 *   'place' => 'world',
 *   'sprintf',
 *   'not used'
 *   );
 *   echo dsprintf($str, $find);
 *   // 'Hello, world, how is it hanning at world? sprintf works just as well'
 *
 * $args also can be object, then it's properties are retrieved
 * using get_object_vars().
 *
 * '%s' without argument name works fine too. Everything vsprintf() can do
 * is supported.
 *
 * @author Josef Kufner <jkufner(at)gmail.com>
 */
function dsprintf() {
    $data = func_get_args(); // get all the arguments
    $string = array_shift($data); // the string is the first one
    if (is_array(func_get_arg(1))) { // if the second one is an array, use that
        $data = func_get_arg(1);
    }
    $used_keys = array();
    // get the matches, and feed them to our function
    $string = preg_replace('/\%\((.*?)\)(.)/e',
        'dsprintfMatch(\'$1\',\'$2\',\$data,$used_keys)',$string);
    $data = array_diff_key($data,$used_keys); // diff the data with the used_keys
    return vsprintf($string,$data); // yeah!
}

function dsprintfMatch($m1,$m2,&$data,&$used_keys) {
    if (isset($data[$m1])) { // if the key is there
        $str = $data[$m1];
        $used_keys[$m1] = $m1; // dont unset it, it can be used multiple times
        return sprintf("%".$m2,$str); // sprintf the string, so %s, or %d works like it should
    } else {
        return "%".$m2; // else, return a regular %s, or %d or whatever is used
    }
}