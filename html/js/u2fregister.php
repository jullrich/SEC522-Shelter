<?php

#
# this file has a .php extension, so we need to set the content-type.
#

header('Content-Type: application/javascript');

require_once('db.php');
require_once('../../php-u2flib-server/src/u2flib_server/U2F.php');

#
# start session and check that the user is logged in.
#

session_start();
$sUser='';

if ( array_key_exists('username',$_SESSION) ) {
    $sUser=$_SESSION['username'];
}
if ( array_key_exists('username',$_SESSION) ) {
    $nUserID=$_SESSION['userid'];
}
if ( $sUser==='' ) {
    exit();
}

#
# establish a CSRF token for this session
#

if ( array_key_exists('csrftoken',$_SESSION) ) {
    $sCSRFToken=$_SESSION['csrftoken'];
} else {
    $sCSRFToken=bin2hex(random_bytes(10));
    $_SESSION['csrftoken']=$sCSRFToken;
}

#
# connect to database
#


$conn = pdoconnect();

#
# instantiate u2f object
#

$u2f = new u2flib_server\U2F('https://'.$_SERVER['HTTP_HOST']);
$sQuery = 'select id, userid, keyHandle, publicKey, certificate, counter from animalshelter.u2fregistrations where userid=? limit 1';
$u2fdata = pdoprepqueryobject($sQuery,array($nUserID),$conn);
$data = $u2f->getRegisterData($u2fdata);
list($req,$sigs) = $data;
$_SESSION['regReq'] = json_encode($req);
$sAppID='https://'.$_SERVER['HTTP_HOST'];
echo "var req = " . json_encode($req).";";
echo "var sigs = " . json_encode($sigs) . ";";
echo "var username = " . $nUserID . ";";
echo "var appid = \"$sAppID\"\n;";

?>
var errorCode=0;
setTimeout(function() {
  console.log("Register: ", req);
  u2f.register(appid,[req], sigs, function(data) {
    console.log("Register callback", data);
    $.post('api/u2fregister.php',{token: "<?php print $sCSRFToken; ?>", registrationData: JSON.stringify(data)},function(retdata) {
      console.log("api return", retdata);
var msg=document.getElementById('msg');
      if (retdata.errorCode && errorCode != 0) {

        msg.innerHTML='Sorry, the registration of your device failed.';
       } else {
msg.innerHTML='<b>You successlly registered your U2F token. <a href="myaccount.php">Return to My Account</a></b>';
 }
     });
   });
}, 1000);

