<?php
session_start();
$_SESSION=array();
$aParams=session_get_cookie_params();
setcookie(session_name(), '',time()-99999,$aParams["path"], $aParams["domain"], $aParams["secure"], $aParams["httponly"]);
if ( session_status() === PHP_SESSION_ACTIVE )  {
   session_destroy();
}
header('Location: login.php?logout');
exit();

