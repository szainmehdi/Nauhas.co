<?php
require_once $cfg['root_dir'] . 'includes/global.inc.php';

session_start();

if(isset($_POST['username']) && isset($_POST['password']) && strlen($_POST['username'])>0 && strlen($_POST['password'])>0) {
    $result = $db->where("username",$_POST['username'])->get($cfg['tables']['users']);
    if($result) {
        $user_current = new User($result[0]);

        $user = strip_tags(substr($user_current->username,0,32));
        $plain_pw = strip_tags(substr($_POST['password'],0,32));
        $password = crypt(md5($plain_pw),md5($user));

        if($user_current->login($password)) {
            $_SESSION['userID'] = $user_current->id;
            $_SESSION['login'] = true;
            echo "<span class='success'>Logged in successfully!</span>";
        }
        else {
            echo "<span class='error'>Your username and password do not match. Try again.</span>";
        }
    }
    else {
        echo "<span class='error'>Your username could not be found. Try again.</span>";
    }
}
else {
    echo "<span class='error'>The username and password cannot be blank.</span>";
}