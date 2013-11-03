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

/**
 * A function for easily uploading files. This function will automatically generate a new
 *        file name so that files are not overwritten.
 * Taken From: http://www.bin-co.com/php/scripts/upload_function/
 * Arguments:    $file_id- The name of the input field contianing the file.
 *                $folder    - The folder to which the file should be uploaded to - it must be writable. OPTIONAL
 *                $types    - A list of comma(,) seperated extensions that can be uploaded. If it is empty, anything goes OPTIONAL
 * Returns  : This is somewhat complicated - this function returns an array with two values...
 *                The first element is randomly generated filename to which the file was uploaded to.
 *                The second element is the status - if the upload failed, it will be 'Error : Cannot upload the file 'name.txt'.' or something like that
 */
function upload($file_id, $folder="", $filename = "", $types="") {
    if(!$_FILES[$file_id]['name']) return array('','No file specified');

    $file_title = $_FILES[$file_id]['name'];
    //Get file extension
    $ext_arr = explode(".",basename($file_title));
    $ext = strtolower($ext_arr[count($ext_arr)-1]); //Get the last extension

    $file_save_name = ($filename!="")  ? $filename . ".". $ext : $file_title;
//    var_dump($file_save_name);

    if(file_exists($folder . $file_save_name)) {
        if(md5_file($_FILES[$file_id]['tmp_name']) == md5_file($folder . $file_save_name)) {
            $result = "'".$file_save_name."' already exists and is identical."; //Show error if any.
            return array($folder . $file_save_name ,$result);
        }
        else {
            //Not really uniqe - but for all practical reasons, it is
            $uniqer = substr(md5(uniqid(rand(),1)),0,5);
            $file_save_name = $uniqer . '_' . $file_title;//Get Unique Name
        }
    }

    $all_types = explode(",",strtolower($types));
    if($types) {
        if(in_array($ext,$all_types));
        else {
            $result = "'".$_FILES[$file_id]['name']."' is not a valid file."; //Show error if any.
            return array('',$result);
        }
    }

    //Where the file must be uploaded to
    if($folder && substr($folder, -1)!='/') $folder .= '/';//Add a '/' at the end of the folder
    if(!file_exists($folder)) {
        echo "Folder does not exist. Creating " . $folder;
        mkdir($folder, 0777, true);
    }


    $uploadfile = $folder . $file_save_name;

    $result = '';
    //Move the file from the stored location to the new location
    if (!move_uploaded_file($_FILES[$file_id]['tmp_name'], $uploadfile)) {
        $result = "Cannot upload the file '".$_FILES[$file_id]['name']."'"; //Show error if any.
        if(!file_exists($folder)) {
            $result .= " : Folder don't exist.";
        } elseif(!is_writable($folder)) {
            $result .= " : Folder not writable.";
        } elseif(!is_writable($uploadfile)) {
            $result .= " : File not writable.";
        }
        $file_save_name = '';

    } else {
        if(!$_FILES[$file_id]['size']) { //Check if the file is made
            @unlink($uploadfile);//Delete the Empty file
            $file_name = '';
            $result = "Empty file found - please use a valid file."; //Show the error message
        } else {
            chmod($uploadfile,0777);//Make it universally writable.
        }
    }

    return array($folder . $file_save_name,$result);
}

/** SAMPLE
 * PHP Part

if($_FILES['image']['name']) {
list($file,$error) = upload('image','uploads/','jpeg,gif,png');
if($error) print $error;
}
HTML Part


<form action="" method="post" enctype="multipart/form-data">
<input type="file" name="image" /><input type="submit" value="Upload" name="action" />
</form>
 */

function uploadFromArray($file_id, $folder="", $filename = "", $types="", $key="") {
    if(!$_FILES[$file_id]['name'][$key]) return array('','No file specified');

    $file_title = $_FILES[$file_id]['name'][$key];
    //Get file extension
    $ext_arr = explode(".",basename($file_title));
    $ext = strtolower($ext_arr[count($ext_arr)-1]); //Get the last extension

    $file_save_name = ($filename!="")  ? $filename . ".". $ext : $file_title;
//    var_dump($file_save_name);

    if(file_exists($folder . $file_save_name)) {
        if(md5_file($_FILES[$file_id]['tmp_name'][$key]) == md5_file($folder . $file_save_name)) {
            $result = "'".$file_save_name."' already exists and is identical."; //Show error if any.
            return array($folder . $file_save_name ,$result);
        }
        else {
            //Not really uniqe - but for all practical reasons, it is
            $uniqer = substr(md5(uniqid(rand(),1)),0,5);
            $file_save_name = $uniqer . '_' . $file_title;//Get Unique Name
        }
    }

    $all_types = explode(",",strtolower($types));
    if($types) {
        if(in_array($ext,$all_types));
        else {
            $result = "'".$_FILES[$file_id]['name'][$key]."' is not a valid file."; //Show error if any.
            return array('',$result);
        }
    }

    //Where the file must be uploaded to
    if($folder && substr($folder, -1)!='/') $folder .= '/';//Add a '/' at the end of the folder
    if(!file_exists($folder)) {
        echo "Folder does not exist. Creating " . $folder;
        mkdir($folder, 0777, true);
    }

    $uploadfile = $folder . $file_save_name;

    $result = '';
    //Move the file from the stored location to the new location
    if (!move_uploaded_file($_FILES[$file_id]['tmp_name'][$key], $uploadfile)) {
        $result = "Cannot upload the file '".$_FILES[$file_id]['name'][$key]."'"; //Show error if any.
        if(!file_exists($folder)) {
            $result .= " : Folder don't exist.";
        } elseif(!is_writable($folder)) {
            $result .= " : Folder not writable.";
        } elseif(!is_writable($uploadfile)) {
            $result .= " : File not writable.";
        }
        $file_save_name = '';

    } else {
        if(!$_FILES[$file_id]['size'][$key]) { //Check if the file is made
            @unlink($uploadfile);//Delete the Empty file
            $file_name = '';
            $result = "Empty file found - please use a valid file."; //Show the error message
        } else {
            chmod($uploadfile,0777);//Make it universally writable.
        }
    }

    return array($folder . $file_save_name,$result);
}