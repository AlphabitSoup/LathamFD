<?php 
/**
* echo a table of firefighters with an active status of zero
*/
	require "DBConnect.php";
	/**
	 * allow for all inactive firefighters to be put into a table that will be styled red 
	 * this is done by grabing the active status of all firefighters and inserting those who's
	 * active status is set to zero  
	 */

	$firefighter = mysql_query('SELECT * FROM Firefighter');
	echo '<tr style="font-weight: bold;"><td>Firefighter ID</td><td>First Name</td><td> Last Name</td>
		<td>Change Status</td></tr>';
	while($row = mysql_fetch_assoc($firefighter)){
			if ($row['active'] == '0' ){

				foreach($row as $cname => $cvalue){
				if($cname == "rank" || $cname == "active" ){

					}
					else{
					echo '<td>';
					print "$cvalue\t ";
					echo '</td>';
				}
				}


				
				echo '</td><td>
				<input type="checkbox" name="vehicle" class="inactive" id='.$row["ffid"].'>
				</td></tr>';
				print "\r\n";
			}

		}




?>