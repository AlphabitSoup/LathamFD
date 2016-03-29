<?php
/**
* This file allows for firefighters to be active or inctive for calls comming into the firehouse 
*
*
*/
require('./header.php'); //inlcudes nave bar, jquery, bootstrap, and other libraries 
require('DBConnect.php');// allows us to connect to the datbase 
require 'security.php';//adds security to the pages 

$firefighter = mysql_query('SELECT * FROM Firefighter');
/**
 * grabs all firefighters fron the database 
 * sorts then into two tables based on the active entity 
 * if active status is one they are put in table one, otherwise they are put in table 2
 */
echo '
<div class = "row">
<div class = "col-md-4 col-md-offset-2">
<div class = "text-center">
<h4> Available</h4>
<table class="table table-hover table-responsive" style="background-color:#b3ffb3" id="table1">
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

	echo '</table> </div> </div>';


$firefighter2 = mysql_query('SELECT * FROM Firefighter');
echo '
<div class = "col-md-4">
<div class = "text-center">
<h4> Unavailable</h4>
<table class="table table-hover table-responsive" style="background-color:#ff9999" id="table2">	
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
	echo '</table> <br></div></div></div>
	<p>&nbsp;</p>
	<div class = "row">
	<button type="submit" class="btn btn-success">Submit</button><br></div>
	<br>
	<div class = "row">
	<button style = "margin-bottom: 5px;" type="button" class="btn btn-danger" id="reset" >Reset</button> <br></div>
	<p style = "font-weight: bold; text-align: center; margin-left: 15px; "> Available implies all firefighters are currently present at the station, ready for truck assignment.</p>
	<p style = "font-weight: bold; text-align: center; margin-left: 15px;">If a firefighter is shown as available, but is not presentat the station, select their name from the "Available" list and click submit. </p>
	<p style = "font-weight: bold; text-align: center; margin-left: 15px; ">If a firefighter who is listed as unavailable is currently present at the station, select their
	name from the "Unavailable" list and click submit.</p>
	<p style = "font-weight: bold; text-align: center; margin-left: 15px;"> To make all firefighters unavailable, click "Reset".</p>';

?>


<script type="text/javascript">
    $(document).ready(function(){
    	/**
    	 * Button Click Function
    	 *
    	 * triggerd when submit of reset is clicked 
    	 * checks to see what button was clicked 
    	 * adds checked boxed to active and inactive arrays
    	 *
    	 * @param (array)ffidActive array of all active firefighters ffids
    	 * @oaram (array)ffidInactive array of all inactive firefighters ffids
    	 * @param (int) int will be zero if reset button is not pressed and one if it was 
    	 * @return echo of both active and inactive tables 
    	 */ 
        $("button").click(function(){
        	$allActive = "0"
        	if (this.id == "reset"){ //checks if reset was pressed 
        		$allActive = "1"
        	}
        	$ffidActive = [];
        	$ffidInactive = [];
        	$("input:checkbox").each(function(){
        		var $this = $(this);
        		 if($this.is(":checked")){
        		 	//grabs all active firefighters
        		 	if ($this.attr("class")== "active"){
        				$ffidActive.push($this.attr("id"));
        			}
        			//grabs all inactive firefighters 
        			else if ($this.attr("class")== "inactive"){
        				$ffidInactive.push($this.attr("id"));
        			}
        		}
        	});
        	/**
        	 * nested ajax functions update table based on boxes checked 
        	 * or will change all firefighters to inactive if reset was clicked
        	 * dynamicly updates both table 1 and table 2
        	*/
        	$.ajax({
                type: 'POST',
                url: 'updateActiveFirefighters.php',
				data: { ffidActive: $ffidActive, ffidInactive: $ffidInactive, allActive: $allActive},
                success: function(data) {
                   $('#table1').html(data);

                   $.ajax({
		                type: 'POST',
		                url: 'updateInactiveFirefighters.php',
						data: {},
		                success: function(data) {
		                  $('#table2').html(data);
		                }
	            	});

                }
            });



			});
		
   		});
 </script>