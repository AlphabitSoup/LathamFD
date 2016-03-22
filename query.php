<?php
//require('./pickCert.js');
require('./header.php');
require('DBConnect.php');
require 'security.php';
 
$dbh = mysql_connect(DB_SERVER.':'.DB_PORT,DB_USERNAME,DB_PASSWORD);
if (!$dbh) {
    echo "Oops! Something went horribly wrong.";
    exit();
}
mysql_selectdb(DB_NAME,$dbh);


$callinfo = mysql_query('SELECT callid, address, fire_type FROM CallInfo ORDER BY  callid DESC
LIMIT     2;');
echo '
<div class="container">
<h1>Load Trucks</h1>
<table class="table table-hover" style="" id="table5">
    <tr style="font-weight: bold;"><td>Call  ID</td><td>Adress</td><td>Fire Type</td></tr>';
  while($row = mysql_fetch_assoc($callinfo)){
        echo'<tr id ="'.$row["callid"].'">';
        foreach($row as $cname => $cvalue){

          echo '<td>';
          print "$cvalue\t ";
          echo '</td>';
        }    
      }
  echo '</table>';





session_start();
?>
<div class = "row">

  <div id="result">
  </div>

  <div class= "sort col-xs-12 col-sm-4 col-md-4 col-lg-2 text-center"> 

    <form  method="post">
      <div class= "btn-group">
        <button id = "cert" class="btn btn-small " data-toggle="dropdown">
        Cert Types
        <span class="caret"></span></button>
        <ul id = "cert" class=" dropdown-menu"role = "menu">
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

    <div id="sortable1" class="connectedSortable">
    </div>
  </div>


  <div class= "sort col-xs-12 col-sm-4 col-md-4 col-lg-2 text-center"> 
    <h4>latter</h4>
    <div id="Latter_Truck" class="connectedSortable">
    </div>
  </div>

  <div class= "sort col-xs-12 col-sm-4 col-md-4 col-lg-2 text-center"> 
  <h4>Rescue</h4>
    <div id="Rescue_Truck" class="connectedSortable">
    </div>
    </div>

  <div class= "sort col-xs-12 col-sm-4 col-md-4 col-lg-2 text-center"> 
  <h4>Tanker</h4>
    <div id="Tanker_Truck" class="connectedSortable ">
    </div>
  </div>

  <div class= "sort col-xs-12 col-sm-4  col-md-4 col-lg-2 text-center"> 
  <h4>Utility</h4>
    <div id="Utility_Truck" class="connectedSortable">
    </div>
  </div>

  <div class= "sort col-xs-12 col-sm-4 col-md-4 col-lg-2 text-center"> 
  <h4>Brush</h4>
    <div id="Brush_Truck" class="connectedSortable">
    </div>
  </div>

</div>

<br><br>
<button style = "left: 550px; bottom: 100px" class="btn btn-success" id="Submit">Submit Trucks</button>
</div>  

<script type="text/javascript">
    $(document).ready(function(){

      $("tbody").on("click", "tr", function(e) {     
       $(this)
     .toggleClass("selected")
     .siblings(".selected")
         .removeClass("selected");
      });

        $("a").click(function(){
			$ffids = [];
			$('.ui-state-default').each(function() {
			if ($(this).parent().attr("id") == "sortable1"){
			}
			else {
			$ffids.push(this.id);
			}
			});

		
            $.ajax({
                type: 'POST',
                url: 'certSelect.php',
				        data: {cert:this.name, ffids: $ffids},
                success: function(data) {
                   $('#sortable1').html(data);
                }
            });
   });

$trClick = null;
$("tr").click(function(){

  $trClick = this.id;

});

$("#Submit").click(function(){
var $submit=true;

  if($trClick == null){
    $submit = false;
    alert("please select a call");
  }

  $('.connectedSortable').each(function() {
        if ($(this).attr("id") == "sortable1"){
            return true;
        } 
      if(($('#'.concat(this.id.concat(' li'))).length)>0){
          if(($('#'.concat(this.id.concat(' li'))).length)<4) {
              alert("Need at least 4 firefighters in ".concat(this.id));
              $submit=false;
          }
          
      var $myArray = [];
      $Driver = false;
      $('#'.concat(this.id.concat(' li'))).each( function() {
           if ($(this).text().indexOf("Driver") >= 0){
            $Driver = true;
           }
      });
      if($Driver == false)
      {
          alert("Need at least one Driver in ".concat(this.id));
          $submit=false;
      }
          }
        });
    if($submit){

      $latter = [];
      $rescue = [];
      $utility = [];
      $brush = [];
      $tanker=[];
      $('.ui-state-default').each(function() {
      if ($(this).parent().attr("id") == "Latter_Truck"){
      $latter.push(this.id);
      }
      else if ($(this).parent().attr("id") == "Rescue_Truck") {
      $rescue.push(this.id);
      }
      else if ($(this).parent().attr("id") == "Tanker_Truck"){
      $tanker.push(this.id);
      }
      else if ($(this).parent().attr("id") == "Utility_Truck"){
      $utility.push(this.id);
      }
      else if ($(this).parent().attr("id") == "Brush_Truck"){
      $brush.push(this.id);
      }
      else {
      }
    });
        $.ajax({
                type: 'POST',
                url: 'latestRespond.php',
                data: {call: $trClick, latter: $latter, rescue: $rescue, tanker: $tanker, utility: $utility, brush: $brush},
                success: function(data) {
                   $('.container').html(data);
                }
            });
    }
   });
        
        

    
$(function(){
  
  $("#cert.dropdown-menu li a").click(function(){
    
    $("#cert.btn:first-child").text($(this).text());
     $("#cert.btn:first-child").val($(this).text());
  });

});	  

});





$(function() {
		$( "#sortable1, #Latter_Truck, #Rescue_Truck, #Tanker_Truck, #Utility_Truck, #Brush_Truck" ).sortable({
		  connectWith: ".connectedSortable"
		}).disableSelection();
	  });
</script>