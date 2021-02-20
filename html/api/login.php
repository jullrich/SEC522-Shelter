<?php

require('db.php');
ini_set("display_errors", 1);
ini_set("error_reporting", E_ALL);
session_start();
session_regenerate_id(TRUE);
$json=file_get_contents('php://input');
$username=$_POST['username'];
$password=$_POST['password'];
$sCSRFToken=bin2hex(random_bytes(10));
$_SESSION['csrftoken']=$sCSRFToken;
$conn = pdoconnect();
$hash='';
$query = 'SELECT password, role,userid FROM animalshelter.users WHERE username=?';
$result = pdoprepquery($query,array($username),$conn);
if ( $result ) {
    $hash=$result[0]['password'];
    if ( password_verify($password,$hash)) {
        print $result[0]['role'];
        $_SESSION['username']=$username;
        $_SESSION['userid']=$result[0]['userid'];
        $_SESSION['role']=$result[0]['role'];
        syslog(LOG_NOTICE,"wrote session for $username");
        exit();
    }   
}

print "$password $username $hash FAILED";

?>