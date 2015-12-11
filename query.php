<?php
//require('./pickCert.js');
require('./header.php');
require('DBConnect.php');
 
$dbh = mysql_connect(DB_SERVER.':'.DB_PORT,DB_USERNAME,DB_PASSWORD);
if (!$dbh) {
    echo "Oops! Something went horribly wrong.";
    exit();
}
mysql_selectdb(DB_NAME,$dbh);
session_start();

echo'
<h1>Latham Fire</h1>
<form  method="post">
<div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Cert Types
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a href="#" name="*">All Firefighters</a></li>
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
</form> 
  
<div id="result">
</div>

<div id="sortable2" class="connectedSortable">
</div>
  
<div id="sortable3" class="connectedSortable">
</div>
    
<div id="sortable4" class="connectedSortable">
</div>

    
<div id="sortable5" class="connectedSortable">
</div>

<div id="sortable6" class="connectedSortable">
</div>
    
    <div id="sortable7" class="connectedSortable">
</div>';









require('./footer.php');

?>


<script type="text/javascript">
    $(document).ready(function(){
        $("a").click(function(){
            $.ajax({
                type: 'POST',
                url: 'certSelect.php',
				data: {cert:this.name},
                success: function(data) {
                   $('#result').html(data);
                }
            });
   });
   

	  

});


$(function() {
		$( "#sortable1, #sortable2, #sortable3, #sortable4, #sortable5, #sortable6, #sortable7" ).sortable({
		  connectWith: ".connectedSortable"
		}).disableSelection();
	  });
</script>