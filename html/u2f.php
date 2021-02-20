<?php
include('header.html');

#
# Include U2F Server library (need for registration)
# and database library.

require_once('db.php');

# This "AppID" has to be consistent for all U2F interactions.

$sAppID='https://'.$_SERVER['HTTP_HOST'];

#
# Start session and make sure we are logged in
#

session_start();
$sUser='';
$nUserID=0;

if ( array_key_exists('username',$_SESSION) ) {
    $sUser=$_SESSION['username'];
}
if ( array_key_exists('userid',$_SESSION) ) {
    $nUserID=$_SESSION['userid'];
}
if ( $sUser==='' ) {
    header('Location: login.php?u2f');
    exit();
}

#
# connect to database
#

$conn = pdoconnect();

#
# Check if we already have a u2f key registered . If we do: Direct to u2f login page.
# if not: redirect to the u2f registration page
#

$count = pdoprepsingle('select count(*) from animalshelter.u2fregistrations where userid=?',array($nUserID),$conn);
if ( $count>0 ) {
    header("Location: u2flogin.php");
    exit();
}
header("Location: u2fregistration.php");





