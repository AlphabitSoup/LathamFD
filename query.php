<?php
//require('./pickCert.js');
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

echo'<form  method="post">
<div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Cert Types
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a href="#" name="All Firefighters">All Firefighters</a></li>
    <li><a href="#" name="Driver">Driver</a></li>
    <li><a href="#" name="EMS">EMS</a></li>
    <li><a href="#" name="Exterior">Exterior</a></li>
    <li><a href="#" name="Hazardous">Hazardous</a></li>
    <li><a href="#" name="Hurst Tools">Hurst Tool</a></li>
    <li><a href="#" name="Interior">Interior</a></li>
    <li><a href="#" name="Paramedic">Paramedic</a></li>
    <li><a href="#" name="Pump">Pump</a></li>
  </ul>
</div>
</form>';



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
        $("a").click(function(){
                $_POST['cert'] = this.name;
            $.ajax({
                type: 'POST',
                url: 'certSelect.php',
                success: function(data) {
                    alert(data);
                    $("p").text(data);

                }
            });
   });
});
</script>