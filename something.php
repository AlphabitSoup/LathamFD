<?php
#require('./pickCert.js');
require('./header.php');
define('DB_SERVER','oraserv.cs.siena.edu');
define('DB_PORT','3306');
define('DB_USERNAME','perm_alphabit');
define('DB_PASSWORD','dour=punish-guild');
define('DB_NAME','perm_alphabit');
 
$dbh = mysql_connect(DB_SERVER.':'.DB_PORT,DB_USERNAME,DB_PASSWORD);
if (!$dbh) {
    echo "Oops! Something went horribly wrong.";
    exit();
}
mysql_selectdb(DB_NAME,$dbh);
session_start();

echo'<div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Cert Types
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a href="#">All Firefighters</a></li>
    <li><a href="#">Driver</a></li>
    <li><a href="#">EMS</a></li>
    <li><a href="#">Exterior</a></li>
    <li><a href="#">Hazardous</a></li>
    <li><a href="#">Hurst Tool</a></li>
    <li><a href="#">Interior</a></li>
    <li><a href="#">Paramedic</a></li>
    <li><a href="#">Pump</a></li>
  </ul>
</div>';



$firefighter = mysql_query('SELECT * FROM Firefighter');

while($row = mysql_fetch_assoc($firefighter)){
    foreach($row as $cname => $cvalue){
        print "$cvalue\t, ";
    }

    $certifications = mysql_query('SELECT  H.ffid, H.type FROM Has H ');
    while($row2 = mysql_fetch_array($certifications)){
		if ($row2['ffid'] == $row['ffid']){
			echo $row2['type'].', ';
		}
	}
    echo '<br>';
    print "\r\n";
}






require('./footer.php');

?>


<script type="text/javascript">
    $(document).ready(function(){
        $("button").click(function(){

            $.ajax({
                type: 'POST',
                url: 'script.php',
                success: function(data) {
                    alert(data);
                    $("p").text(data);

                }
            });
   });
});
</script>