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
    header('Location: login.php?u2freg');
    exit();
}

?>
<script src="/js/jquery.js"></script>

<link rel="stylesheet" href="/css2/ex.css" type="text/css" />
<blockquote>
<h1>SEC522 Animal Shelter</h1>
<h2>Where Good Dogs and Bad Cats Find Homes</h2>
<div class="login-page">
<div id="msg">All users are now required to use two factor authentication. Please register your U2F key.</div>
<script src="js/webauthnregister.js"></script>
</div>
<p>
</blockquote>

<?php
include('footer.html');
?>