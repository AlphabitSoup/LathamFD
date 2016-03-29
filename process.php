<?php
	require('./DBConnect.php');
	     session_start();

	$firefighter = mysql_query('SELECT * FROM Admin');
	  //var_dump($firefighter);
     $result = mysql_query("SELECT password FROM Admin WHERE email = '".$_POST["email"]."'");
	 $row = mysql_fetch_assoc($result);
	 $saved_password = $row['password'];
	 //echo $saved_password . "==" . $_POST['password'];
	 $email = mysql_query("SELECT email FROM Admin WHERE email = '".$_POST["email"]."'");
	 $erow = mysql_fetch_assoc($email);
	 $saved_email = $erow['email'];
	 if($saved_email == NULL)
	 {
	
	 header('Location: ./login.php');
	 }
	 else{
	 if($_POST['email'] == $saved_email) {
	 
	  if ($_POST['password'] == $saved_password ) {

		 
		 $_SESSION['loggedin'] = true;
	     header('Location: ./query.php');
	  }
	  else{
		  header('Location: ./login.php');
	  }
	  }
	  else{
		  header('Location: ./login.php');
	  }
	  }
	 


  ?>