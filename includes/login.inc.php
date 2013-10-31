<?php

session_start();

//refresh session variables if logged in
if(isset($_SESSION['login'])) {
    $db = new Database();
    $user_current = User::getUser("id",$_SESSION['userID']);
}
else { 
	header("Location: login.php");
}