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

<script src="/js/jquery.js"></script>
<link rel="stylesheet" href="/css2/ex.css" type="text/css" />
<blockquote>
<h1>SEC522 Animal Shelter</h1>
<h2>Where Good Dogs and Bad Cats Find Homes</h2>

<p>
    Search for a cat or dog by name:
    <form method="get" action="index.php">
Debug: <input type="checkbox" name="debug" value="checked" <?php print $debug ?>></br>
    
    <input style="width: 70vw;" type="text" name="name" value="<?php print $name ?>">

    <input type="submit">
    </form>
    <a target="_blank" href="hints.php">Hints (opens as new tab)</a>
    
    </p>
    </blockquote>
    <p>
<?php

$conn = pdoconnect();

    if ( $name=='' ) {
        $name='%';
    }
$query = 'SELECT animalid,animalname, species, comments, catagressive, dogagressive, kidagressive from animalshelter.animals where animalname like \''.$name.'\' order by species, animalname';

    if ( $debug=='checked' ) {
        print "<pre>SQL Query\n$query</pre>";
    }
$template='
<div class="animalpic" id="animal%%animalid%%">
  <img class="animalpic" src="/images/%%species%%%%animalid%%.jpg">
  <div class="animalname">%%animalname%%</div>
<div>
  <span class="catagressive%%catagressive%%"></span>
  <span class="dogagressive%%dogagressive%%"></span>
  <span class="kidagressive%%kidagressive%%"></span>
</div>
  <div class="comments">%%comments%%</div>
</div>';
print templatequery($query,null,$template,$conn);

?>
</p>

</body></html>