<?php
include('header.html');
session_start();
?>
<script src="/js/jquery.js"></script>
<script src="js/login.js"></script>
<link rel="stylesheet" href="/css2/ex.css" type="text/css" />
<blockquote>
<h1>SEC522 Animal Shelter</h1>
<h2>Where Good Dogs and Bad Cats Find Homes</h2>
<div class="login-page">
   <div class="form">    
      <form class="loginform">
          <input id="username" type="text" placeholder="username" />
          <input id="password" type="password" placeholder="password" />
          <button id="login" type="button">Login</button>
      </form>
   </div>
</div>
<p>
Hints: <br/>
    Admin account credentials: sec522/training<br/>
    User account credentials: hackercat/training
</p>
<p>
<a href="resetu2f.php">Reset U2f Data</a>
</p>

    
</blockquote>




<?php
include('footer.html');
?>
