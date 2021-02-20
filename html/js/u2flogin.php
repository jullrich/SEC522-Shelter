<?php
/**
 * Created by PhpStorm.
 * User: Johannes Ullrich
 * Date: 2/9/17
 * Time: 10:29 PM
 */
header('Content-Type: application/javascript');
session_start();
$sUser='';
require('db.php');
$conn = pdoconnect();
$sAppID='https://'.$_SERVER['HTTP_HOST'];

$sCSRFToken=bin2hex(random_bytes(10));
if ( array_key_exists('username',$_SESSION) ) {
    $sUser=$_SESSION['username'];
}
if ( array_key_exists('username',$_SESSION) ) {
    $nUserID=$_SESSION['userid'];
}
if ( array_key_exists('csrftoken',$_SESSION) ) {
    $sCSRFToken=$_SESSION['csrftoken'];
} else {
    $_SESSION['csrftoken']=$sCSRFToken;
}
if ( $sUser==='' ) {
    exit();
}

$sQuery='select id,userid, keyHandle,publicKey,certificate,counter from animalshelter.u2fregistrations where userid=? limit 1';
require_once('../../php-u2flib-server/src/u2flib_server/U2F.php');
$result = pdoprepqueryobject($sQuery,array($nUserID),$conn);
$u2f = new u2flib_server\U2F($sAppID);
$reqs=$u2f->getAuthenticateData($result);
$_SESSION['authReq']=json_encode($reqs);
echo "var req = ".json_encode($reqs).";";
echo 'var challenge = "'.$reqs[0]->challenge."\"\n";
echo 'var keyHandle = "'.$result->keyHandle."\"\n";
echo "var username = " . $nUserID . ";\n";
echo "var appid = \"$sAppID\";\n";
?>
var errorCode=0;
setTimeout(function() {
    var keys=[];
    
    u2f.sign(appid, req[0].challenge,[req[0].keyHandle], function(data) {
    console.log("Login callback", data);
    $.post('api/u2flogin.php',{token: "<?php print $sCSRFToken; ?>", loginData: JSON.stringify(data)},function(retdata) {
      console.log("api return", retdata);
      if (retdata.errorCode && errorCode != 0) {
          msg.innerHTML='u2f login error';
      } else {
          document.location='account.html';
      }
    });
  });
}, 1000);

