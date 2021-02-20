<?php
include('header.html');
require_once('db.php');
$conn = pdoconnect();

session_start();
$sUser='';
if ( array_key_exists('username',$_SESSION) ) {
    $sUser=$_SESSION['username'];
}
if ( array_key_exists('userid',$_SESSION) ) {
    $nUserID=$_SESSION['userid'];
}
if ( $sUser==='' ) {
    header('Location: login.php?otp');
    exit();
}
$count = pdoprepsingle('select count(*) from animalshelter.u2fregistrations where userid=?',array($nUserID),$conn);
if ( $count===0 ) {
    header("Location: login.php?nootp");
    exit();
}
?>
<script src="/js/jquery.js"></script>
<script src="js/webauthnlogin.js"></script>
<link rel="stylesheet" href="/css2/ex.css" type="text/css" />
<blockquote>
<h1>SEC522 Animal Shelter</h1>
<h2>Where Good Dogs and Bad Cats Find Homes</h2>
<div class="login-page">
<div id="msg">Please use your u2f key to complete the logins</div>
</div>
<p>
</blockquote>

<?php
include('footer.html');
?>
