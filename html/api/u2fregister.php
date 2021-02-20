<?php
session_start();
require_once('../../../../vendor/autoload.php');
require('db.php');
$conn = pdoconnect();
if ( array_key_exists('username',$_SESSION) ) {
    $sUser=$_SESSION['username'];
}
if ( array_key_exists('username',$_SESSION) ) {
    $nUserID=$_SESSION['userid'];
}
$webauthn = new \Davidearl\WebAuthn\WebAuthn($_SERVER['HTTP_HOST']);
$conn = pdoconnect();
$oUser=pdoprepqueryobject('SELECT u2f.userid, u.username, u2f.webauthnkeys as webauthnkeys FROM animalshelter.u2fregistrations u2f join animalshelter.users u using (userid) where userid=?',
    array($nUserID),$conn);
$oWebAuthnKeys=json_decode($oUser->webauthnkeys);
$sWebAuthnKeys=$webauthn->register($_POST['register'],$oWebAuthnKeys);
pdoprep('UPDATE animalshelter.u2fregistrations set webauthnkeys=? where userid=?', array( json_encode($sWebAuthnKeys),$nUserID),$conn);
header("Content-Type: application/json");
echo json_encode('ok');
