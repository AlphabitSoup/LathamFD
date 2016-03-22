<?php 
/**
 * This file will update active and inactive firefighers and echo active firefighter table
 *
 */
	require "DBConnect.php";
	$ffidsActive = $_POST['ffidActive'];//array of active firefighters
	$allActive = $_POST['allActive'];//variable to see if all firefighters so be inactive 


	/**
	* checks if allActive is one and if it is it will update Firefighter
	* it will set active to zero essentaily allowing for a reset 
	*/
	if($allActive == '1'){
		$sql2 = "UPDATE Firefighter SET active='0' WHERE active = '1' ";
		$retval = mysql_query( $sql2);
	}
	else
	{
		
		//will take all of the ffids in ffidActive to zero 
		foreach ($ffidsActive as $value) {
			$temp = (int) $value;
			$sql = "UPDATE Firefighter SET active='0' WHERE ffid = ".$temp." ";
			$retval = mysql_query( $sql);
	            
	            if(! $retval ) {
	               die('Could not update data: ' . mysql_error());
	            }
	            echo "Updated data successfully\n";

		}

		$ffidsInactive = $_POST['ffidInactive'];
		// will take all of the ffids in ffidInactive to one 
		foreach ($ffidsInactive as $value) {
			$temp = (int) $value;
			$sql = "UPDATE Firefighter SET active='1' WHERE ffid = ".$temp." ";
			$retval = mysql_query( $sql);
	            
	            if(! $retval ) {
	               die('Could not update data: ' . mysql_error());
	            }
	            echo "Updated data successfully\n";

		}
	}


	/**
	 * after all tables in the databases are changes this will re-echo the active table
	 *allow for all active firefighters to be put into a table that will be styles green 
	 */
	$firefighter = mysql_query('SELECT * FROM Firefighter');
	echo '<tr style="font-weight: bold;"><td>Firefighter ID</td><td>First Name</td><td> Last Name</td>
		<td>Change Status</td></tr>';
	while($row = mysql_fetch_assoc($firefighter)){
			if ($row['active'] == '1' ){
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
				<input type="checkbox" name="vehicle" class="active" id='.$row["ffid"].'>
				</td></tr>';
				print "\r\n";
			}

		}




?>