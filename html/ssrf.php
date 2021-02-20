<?php
include('header.html');
session_start();
$sError='';
$sPreview='';
$sURL='';
$bSolved=FALSE;
if ( $_SERVER['REQUEST_METHOD']==='POST' ) {
    $sURL=$_POST['url'];
    if ( preg_match('/^http/',$sURL) && filter_var($sURL,FILTER_VALIDATE_URL,FILTER_FLAG_SCHEME_REQUIRED|FILTER_FLAG_HOST_REQUIRED)) {
        $oCurl=curl_init();
        curl_setopt_array($oCurl,array(CURLOPT_URL=>$sURL,
        CURLOPT_RETURNTRANSFER=>TRUE));
        $sResponse=curl_exec($oCurl);
        curl_close($oCurl);
        if ( ! $sResponse ) {
            $sError='An error occured retrieving the URL<br/>';
        } else {
            $sPreview=htmlentities($sResponse);
            if ( preg_match('/Token/',$sResponse) ) {
                $bSolved=TRUE;
            }
        }
    } else {
        $sError='Sorry, the URL is not valid.';
    }
}
?>
<script src="/js/jquery.js"></script>
<link rel="stylesheet" href="/css2/ex.css" type="text/css" />
<blockquote>
<h1>SEC522 Animal Shelter</h1>
<h2>Where Good Dogs and Bad Cats Find Homes</h2>
<p>
    Our shelter is always interested in sharing information about adoptable pets with other organizations. If you have an RSS feed to share: Just enter ther URL below and we will retrieve it to insert the data into our system.
    </P>
<p>
    <?php
    if ( $sError!=='' ) {
        print $sError;
    }
?>
</p>
<p>
<form method="post" action="ssrf.php">
    <label for="url">Feed URL</label>
    <input type="text" name="url" id="url" value="<?php print $sURL ?>" size="50">
</form>
</p>
<p>
<?php
if ( $sPreview!=='' ) {
    print "<h3>Preview of your feed</h3>";
    print "<pre>".$sPreview."</pre>";
    if ( $bSolved ) {
        print "<p>You got the access tokens. Now use the SANS Animal Welfare Shelter (s-aws) tool to access the backend storage. On the command line, type 's-aws -h' for details.</p>";
    }
}
?>
</p>    
</blockquote>




<?php

include('footer.html');
?>
