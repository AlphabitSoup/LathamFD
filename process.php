<?php
	require('./DBConnect.php');


	$firefighter = mysql_query('SELECT * FROM Firefighter');
	  var_dump($firefighter);
     $result = mysql_query("SELECT password FROM Admin WHERE email = '".$_POST["email"]."'");
	 $row = mysql_fetch_assoc($result);
	 $saved_password = $row['password'];
	 //echo $saved_password . "==" . $_POST['password'];
	  if ($_POST['password'] == $saved_password ) {
	     session_start();
		 
		 $_SESSION['loggedin'] = true;
	     header('Location: ./trucks.php');
	  }
	  else{
		  header('Location: ./login.php');
	  }
	 


  ?>