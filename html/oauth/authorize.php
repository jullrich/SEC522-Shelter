<?php

###
#
# Authorize Controller
#
#   this code will be used to issue an authentication token to a user
#
###

session_start();
$sUser='';
$nUserID=0;


if ( array_key_exists('userid',$_SESSION) ) {
    $nUserID=$_SESSION['userid'];
}
if ( $nUserID===0 ) {
    $sQueryString=urlencode($_SERVER['QUERY_STRING']);
    header("Location: ../login.php?qs=$sQueryString&mode=oauth");
    exit();
}

// include our OAuth2 Server object
require_once __DIR__.'/server.php';

$request = OAuth2\Request::createFromGlobals();
$response = new OAuth2\Response();

// validate the authorize request
if (!$server->validateAuthorizeRequest($request, $response)) {
    $response->send();
    die;
}
// display an authorization form
if (empty($_POST)) {
  exit('
<form method="post">
  <label>Do You Authorize the Shelter Volunteer App?</label><br />
  <input type="submit" name="authorized" value="yes">
  <input type="submit" name="authorized" value="no">
</form>');
}

// print the authorization code if the user has authorized your client
$is_authorized = ($_POST['authorized'] === 'yes');
$server->handleAuthorizeRequest($request, $response, $is_authorized,$nUserID);
if ($is_authorized) {
  // this is only here so that you get to see your code in the cURL request. Otherwise, we'd redirect back to the client
  $code = substr($response->getHttpHeader('Location'), strpos($response->getHttpHeader('Location'), 'code=')+5, 40);
#  exit("SUCCESS! Authorization Code: $code");
}
$response->send();