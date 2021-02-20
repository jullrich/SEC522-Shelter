<?php
require('db.php');
include('header.html');
$name='';
$debug='';
if ( array_key_exists('name',$_GET) ) {
    $name=$_GET['name'];
}
if ( array_key_exists('debug',$_GET) ) {
    $debug=$_GET['debug'];
}
?>
<link rel="stylesheet" href="/css2/shelter.css" type="text/css" media="screen, projection, print" />
<link rel="stylesheet" href="donations.css" type="text/css" />
<script src="/js/jquery.js"></script>
<script src="donations.js"></script>
<blockquote>
<h1>SEC522 Animal Shelter</h1>
<h2>Where Good Dogs and Bad Cats Find Homes</h2>

<p>
    Help us feed our cats and dogs by donating here:
    <form method="post" action="donations.php" id="paymentform">
    <label for="cc">Credit Card Nuber</label>
    <input type="text" id="cc" size="20"><br/>
    <label for="name">Your full name</label>
    <input type="text" id="text" size="50"><br/>
    <label for="amount">Ammount</label>
    <input type="phone" id="amount" size="10"><br/>
    <button type="button" id="donate">Donate</button>
    </form>
</p>

</body></html>