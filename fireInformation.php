<?php
require 'functions.php';
require 'DBConnect.php';

echo'
<html>

<head>
  <title> Fire Address </title>
</head>
<style>
table {
    background-color: lightgrey;
}

</style>
<body>
<!--
<div>
<p>Fire Address: "Here is where fire address will go"</p>
<p>Type of Fire:  "Here is where the type of fire will go"</p>
<p>Time Call was Placed:  "Here is where the time of the phone call will go"</p>
<p>Unit Responded:  "Here is the Fire department that is responding to the fire"</p>
<p>Time Truck Left Firehouse: "Here is where the time which the firetruck left the firehouse will go"</p>
<p>Time Truck Got to Fire: "Here is where the time which the firetruck reached the fire will go"</p>
</div>
-->

<!--
   <form action="query.php" method="post">
   <h3>Fire Address:</h3>
   <input type="text" name="post_address">
   <h3>Fire type:</h3>
   <input type="text" name="post_fireType" >
   <h3>Time of Call:</h3>
   <input type="text" name="post_timeOfCall" >
   <h3>Responding Unit:</h3>
   <input type="text" name="post_respondingUnit" >
   <h3>Time Truck Leaves Firehouse:</h3>
   <input type="text" name="post_truckLeaves">
   <h3>Time Truck arrives at Fire:</h3>
   <input type="text" name="post_truckArrives">
   <h3></h3>
   <input type="submit" value= "Submit" style="position: relative; top:25 px; left: 10%;">
   </form>
-->';

echo displayCallTable();
echo '
</body>
</html>';
/* entering something into the text box should:
    -- create a new div with the contents
    -- send to the database if this stuff gets sent to the database
    -- also the page should be generated from the database
 */

/*
   <?php
   echo'
   <html>

   <body>
   <form action="query.php" method="post">
   <h3>Fire Address:</h3>
   <input type="text" name="post_address">
   <h3>Fire type:</h3>
   <input type="text" name="post_fireType" >
   <h3>Time of Call:</h3>
   <input type="text" name="post_timeOfCall" >
   <h3>Responding Unit:</h3>
   <input type="text" name="post_respondingUnit" >
   <h3>Time Truck Leaves Firehouse:</h3>
   <input type="text" name="post_truckLeaves">
   <h3>Time Truck arrives at Fire:</h3>
   <input type="text" name="post_truckArrives">
   <h3></h3>
   <input type="submit" value= "Submit" style="position: relative; top:25 px; left: 10%;">
   </form>
   </body>
   </html>';
   ?> */


/* <div class="row">'.
   createTextField("fire_address", "Fire Address", 1024).
   createTextField("fire_type", "Fire Type", 256).
   createTextField("call_time", "Time of Call", 256).
   createTextField("responding_unit", "Responding Unit", 256).
   createTextField("departure_time", "Time Truck Leaves Firehouse", 256).
   createTextField("arrival_time", "Time Truck Arrives at Fire", 256).
   '<button type="submit" class="btn btn-success">Submit</button>
   </div> */



?>
