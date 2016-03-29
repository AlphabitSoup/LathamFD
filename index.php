<!DOCTYPE html>
<html>
<?php 
require('./header.php'); 
require('DBConnect.php');
require './security.php';
?>
<body>
	<div class="container">
    	<h1>Truck Assignments</h1>
    	<?php
    		$lastCall = mysql_query('SELECT callid FROM responded ORDER BY callid DESC LIMIT   1;');
    		$result = mysql_fetch_assoc($lastCall);

    		$ffids = mysql_query("SELECT ffid, type FROM responded WHERE callid = ".$result["callid"]." ORDER BY type");
    		$ffids2 = mysql_query("SELECT ffid, type FROM responded WHERE callid = ".$result["callid"]." ORDER BY type");
    		$row1 = mysql_fetch_assoc($ffids2);


    		



    		//function makeTruck () {
    		$truckType = $row1["type"];
    		echo '
    		<p>&nbsp;</p>
    		<div class = "col-xs-12 col-sm-6 col-md-4 col-lg-4 text-center" style="background-color:#ff9999; margin: 5px;" ><table class="table table-hover " style="" id="table5">
    		<tr colspan = "3"><h3>'.$truckType.'</h3></tr>
    		<tr style="font-weight:bold"><td>Fire Fighter ID</td><td>First Name</td><td>Last Name</td></tr>';
			  while($row = mysql_fetch_assoc($ffids) ){
			  		if ($truckType != $row["type"]){
			  			echo '</table>
			  				</div>';
			  			$truckType = $row["type"];
			  			echo '<div class = "col-xs-12 col-sm-6 col-md-4 col-lg-4 text-center" style="background-color:#ff9999; margin: 5px;">
			  			<table class="table table-hover " style="" id="table5">
    						<tr colspan = "3"><h3>'.$truckType.'</h3></tr>
    						<tr><td>ffid</td><td>First Name</td><td>Last Name</td></tr>';
			  		}
			        echo'<tr id ="'.$row["callid"].'">';
			        $firefighters = mysql_query('SELECT ffid, fname, lname FROM Firefighter WHERE ffid ='.$row["ffid"].'');
			         while($row2 = mysql_fetch_assoc($firefighters)){
			         	foreach($row2 as $cname => $cvalue){
					          echo '<td>';
					          print "$cvalue\t ";
					          echo '</td>';
					        } 
			         }  
			      }
			  echo '</table>
			  		</div>';
			//}




			  ?>
				</div>
</body>	  

</html>
