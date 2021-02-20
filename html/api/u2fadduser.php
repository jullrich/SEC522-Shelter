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
$conn = pdoconnect();
$webauthn = new \Davidearl\WebAuthn\WebAuthn($_SERVER['HTTP_HOST']);
$sWebAuthnKeys=$webauthn->cancel();
$oUser=pdoprep('INSERT IGNORE INTO animalshelter.u2fregistrations (userid, webauthnkeys) values (?,?)', array( $nUserID, $sWebAuthnKeys),$conn);
$j=['challenge'=>$webauthn->prepareChallengeForRegistration($sUser,$nUserID,'Yes')];
header('Content-type: application/json');
echo json_encode($j);
