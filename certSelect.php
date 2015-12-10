<?php 
	require "DBConnect.php";
    $name = $_POST['cert']; 
	if ($name == "*"){
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
	}
	else {
		$firefighter = mysql_query("SELECT DISTINCT * FROM Firefighter F , Has H WHERE H.ffid = F.ffid AND H.type = '".$name."'");
	
		while($row = mysql_fetch_assoc($firefighter)){
			foreach($row as $cname => $cvalue){
				print "$cvalue\t, ";
			}

			/*$certifications = mysql_query('SELECT  H.ffid, H.type FROM Has H WHERE H.type = '.$name);
			while($row2 = mysql_fetch_array($certifications)){
				if ($row2['ffid'] == $row['ffid']){
					echo $row2['type'].', ';
				}
			}
			*/
			echo '<br>';
			print "\r\n";
		}
		
	
	}

?>