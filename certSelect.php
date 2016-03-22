
<?php 
	require "DBConnect.php";
    $name = $_POST['cert']; 
	$ffids = $_POST['ffids'];
	echo'<div id="sortable1" class="connectedSortable">';
	if ($name == "*"){
	$firefighter = mysql_query('SELECT * FROM Firefighter F WHERE F.active = "1"' );
	
		while($row = mysql_fetch_assoc($firefighter)){
			if (in_array($row['ffid'], $ffids)){
			
			}
			else{
					echo'<li class="ui-state-default 1" id ='.$row['ffid'].'>';
					foreach($row as $cname => $cvalue){
						if($cname == 'active'){
						
					}
					else{
						print "$cvalue\t, ";
					}
					}

					$certifications = mysql_query('SELECT  H.ffid, H.type FROM Has H ');
					while($row2 = mysql_fetch_array($certifications)){
						if ($row2['ffid'] == $row['ffid']){
							
							echo $row2['type'].', ';
						}
					}
					echo'</li>';
					echo '<br>';
					print "\r\n";
				}
		}
	}
	else {
		$firefighter = mysql_query("SELECT DISTINCT F.ffid, F.fname, F.lname, F.rank FROM Firefighter F , Has H WHERE H.ffid = F.ffid AND F.active = '1' AND H.type = '".$name."'");
		
		while($row = mysql_fetch_assoc($firefighter)){
			if (in_array($row['ffid'], $ffids)){
			
			}
			else{
					echo'<li class="ui-state-default 1" id ='.$row['ffid'].'>';
					foreach($row as $cname => $cvalue){
						if($cname == 'active'){
						
					}
					else{
						print "$cvalue\t, ";
					}
					}

					$certifications = mysql_query("SELECT  H.ffid, H.type FROM Has H WHERE H.ffid = '".$row['ffid']."'");
					while($row2 = mysql_fetch_array($certifications)){
							echo $row2['type'].', ';

					}
					echo'</li>';
					echo '<br>';
					print "\r\n";
				}
		}
		
	
	}
	echo '</div>
	<script>
	$(function() {
		$( "#sortable1, #sortable2, #sortable3, #sortable4, #sortable5, #sortable6, #sortable7" ).sortable({
		  connectWith: ".connectedSortable"
		}).disableSelection();
	  });
	</script>';

?>