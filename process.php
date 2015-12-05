<?php
	require('./DBConnect.php');
function process(){

	$firefighter = mysql_query('SELECT * FROM Firefighter');
	  var_dump($firefighter);
	  
	  if ($_POST['password'] = mysql_query('SELECT password FROM Admin WHERE email = $_POST["email"]')) {
	     session_start();
	     header('Location: ./trucks.php');
	  }
}

  ?>