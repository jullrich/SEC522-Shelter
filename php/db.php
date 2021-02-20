<?php

/**
 * 
 *  Quick PDO wrapper 
 *
 */

function pdoconnect($dbname='insurance') {
   $dsn='mysql:dbname='.$dbname.';host=localhost';
   $user='root';
   $password='training';
   $dbh=false;
   try {
       $dbh=new PDO($dsn,$user,$password);
       $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
   } catch ( PDOException $e ) {
       printerror('Database Connection failed',"connect to $dsn username $user password $password",$e);
   }
   return $dbh;
}

function pdoexec($sql,$dbh) {
    try {
        $dbh->query($sql);
    } catch ( PDOException $e ) {
        printerror('Query Failed',$sql,$e);
    }
    return true;
}



function pdoquery($sql,$dbh) {
   try {
       $result=$dbh->query($sql);
   } catch ( PDOException $e ) {
       printerror('Query Failed',$sql,$e);
   }
   if ( ! $result ) {
     return false;
   }
   return $result->fetchAll();
}

function pdoprepquery($sql,$param,$dbh) {
   $sth=pdoprep($sql,$param,$dbh);
   return $sth->fetchAll();
}

function pdoprepqueryobject($sql,$param,$dbh) {
   $sth=pdoprep($sql,$param,$dbh);
   return $sth->fetchAll(PDO::FETCH_OBJ);
}

function pdoprepqueryhash($sql,$param,$dbh) {
   $sth=pdoprep($sql,$param,$dbh);
   return $sth->fetchAll(PDO::FETCH_ASSOC);
}

function pdoprep($sql,$param,$dbh) {
   try {
     $sth=$dbh->prepare($sql);
   } catch ( PDOException $e ) {
       printerror('Query prep failed',$sql,$e);
   }
   try  {
      $sth->execute($param);
   } catch ( PDOException $e ) {
       printerror('Query exec failed',$sql,$e);
   }
   return $sth;
}


function templatequery($sql, $param, $template, $dbh) {
  $data=pdoprepquery($sql, $param, $dbh);
  $r='';
  foreach ( $data as $row) {
    $r=$r.templateprint($template,$row);
  }
  return $r;
}

function pdoprepsingle($sql,$param,$dbh) {
	 $result=pdoprepquery($sql,$param,$dbh);
	 if ( is_array($result) && array_key_exists(0,$result) ) {
         	 return $result[0][0];
	}
	return false;
}

function templateprint($template,$data) {
    foreach ( $data as $key=>$value) {
      $insert=htmlentities($data[$key]);
      $template=str_replace('%%'.$key.'%%',$insert,$template);
    }
    $template=preg_replace('/%%[^%]+%%/','',$template);
    return $template;
}


function printerror($message,$query,$e) {
    print "<div style=\"background: darkred; color: white; padding: 10px;\">DATABASE QUERY ERROR<br/><hr>";
    print "<pre>$message\n$query</pre><hr><pre>".$e->getMessage()."</pre></div>";
    exit();
}


?>