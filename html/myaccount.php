<?php
include('header.html');

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
    header('Location: login.php?myaccount');
    exit();
}


?>
<script src="/js/jquery.js"></script>
<script src="js/login.js"></script>
<link rel="stylesheet" href="/css2/ex.css" type="text/css" />
<blockquote>
<h1>SEC522 Animal Shelter</h1>
<h2>Where Good Dogs and Bad Cats Find Homes</h2>
<p>
my account. not much to see here.
</p>    
<p>
<a href="logout.php">Log Out</a><br/>    
<a href="resetu2f.php">Reset U2f Data</a>
</p>

    
</blockquote>




<?php
include('footer.html');
?>
