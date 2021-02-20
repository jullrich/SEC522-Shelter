<?php
header("Access-Control-Allow-Origin: *");
?>
<table>
<thead>
<tr><th>Date</th><th>Time</th><th>Task</th></tr>
<tbody>
<?php
$nOld=0;
$aTasks=array('Pet the Cats','Walk the Dogs','Feed the Dogs','Feed the Cats','Clean the Dogs');
for($x=0;$x<5;$x++) {
    $nOld=$nOld+rand(3,5);
    $sDate=date('Y-m-d',time()+86400*$nOld);
    $sTime=rand(8,19).':00';
    $sTask=$aTasks[rand(0,4)];
    print "<tr><td>$sDate</td><td>$sTime</td><td>$sTask</td></tr>";
    
}
?>
</tbody></table>
<p>Now that you see how the app works, learn about the  <a href="http://www.sec522.org/shelter/oauthissue.php">problem</a>...
    </p>