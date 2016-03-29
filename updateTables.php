<?php
require('DBConnect.php');
$firefighter = mysql_query('SELECT * FROM Firefighter');

echo '<div id="refresh"><table class="table table-hover" style="background-color:#b3ffb3" id="table1">	
		<tr style="font-weight: bold;"><td>Firefighter ID</td><td>First Name</td><td>Last Name</td><td>Change Status</td></tr>';
	while($row = mysql_fetch_assoc($firefighter)){
			if ($row['active'] == '1' ){
				echo'<tr>';
				foreach($row as $cname => $cvalue){
					if($cname == "rank" || $cname == "active" ){

					}
					else{
					echo '<td>';
					print "$cvalue\t ";
					echo '</td>';
				}
				}			
				echo '<td>
				<input type="checkbox" name="vehicle" class="active" id='.$row["ffid"].'>
				</td></tr>';
				print "\r\n";
			}

		}

	echo '</table>';


$firefighter2 = mysql_query('SELECT * FROM Firefighter');
echo '<table class="table table-hover" style="background-color:#ff9999" id="table2">	
		<tr style="font-weight: bold;"><td>Firefighter ID</td><td>First Name</td><td> Last Name</td>
		<td>Change Status</td></tr>';

	while($row3 = mysql_fetch_assoc($firefighter2)){
		if ($row3['active'] == '0' ){
			echo'<tr>';
			foreach($row3 as $cname => $cvalue){
				if($cname == "rank" || $cname == "active" ){

				}
				else{
				echo '<td>';
				print "$cvalue\t ";
				echo '</td>';
				}
			}
			echo '<td>
				<input type="checkbox" name="vehicle" class="inactive" id='.$row3["ffid"].'>
				</td></tr>';
				print "\r\n";
		}
	}
	echo '</table>
	<button type="submit" class="btn btn-success">Submit</button></div>';

?>