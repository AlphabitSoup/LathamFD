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

echo'<form  method="post">
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
</script>