<?php
require('db.php');
ini_set("display_errors", 1);
ini_set("error_reporting", E_ALL);
$conn = pdoconnect();
$sQuery='DELETE from animalshelter.u2fregistrations';
pdoprep($sQuery,array(),$conn);
header("Location: login.php?u2fresetdone");
?>