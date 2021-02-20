<?php
session_start();
require_once('../../../../vendor/autoload.php');
require('db.php');
$webauthn = new \Davidearl\WebAuthn\WebAuthn($_SERVER['HTTP_HOST']);
$conn = pdoconnect();
if ( array_key_exists('username',$_SESSION) ) {
    $sUser=$_SESSION['username'];
}
if ( array_key_exists('username',$_SESSION) ) {
    $nUserID=$_SESSION['userid'];
}
$oUser=pdoprepqueryobject('SELECT u2f.userid, u.username, u2f.webauthnkeys as webauthnkeys FROM animalshelter.u2fregistrations u2f join animalshelter.users u using (userid) where userid=?',
    array($nUserID),$conn);
$oUser=$oUser[0];
if ( ! $webauthn->authenticate($_POST['login'],json_decode($oUser->webauthnkeys)) ) {
    $j = 'failed';
} else {
    $j = 'ok';
}
header("Content-Type: application/json");
echo json_encode('ok');

