<?php
require("functions.php");
databaseConnect();
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST") {
      // email and password sent from form 
      
      $myemail = mysqli_real_escape_string(databaseConnect(),$_POST['email']);
      $mypassword = mysqli_real_escape_string(databaseConnect(),$_POST['password']); 
      
      $mysqli = "SELECT * FROM admin WHERE email = ".$_POST['$myemail']." and password = ".$_POST['$mypassword'].;
      $result = mysql_query(databaseConnect(),$mysqli);
      $row = mysql_fetch_array($result,MYSQLI_ASSOC);
      $active = $row['active'];
      
      $count = mysqli_num_rows($result);
      
      // If result matched $myemail and $mypassword, table row must be 1 row
		
      if($count == 1) {
         session_register('email');
         
         header('location: query.php');
      }else {
         $error = 'Your Login Name or Password is invalid';
      }
   }
 ?>
<html>
   
   <head>
      <title>Latham Fire Log in</title>
      
      <style type = "text/css">
         body {
            font-family:Arial, Helvetica, sans-serif;
            font-size:14px;
         }
         
         label {
            font-weight:bold;
            width:150px;
            font-size:14px;
         }
         
         .box {
            border:#666666 solid 1px;
         }
      </style>
      
   </head>
   
   <body bgcolor = "#FFFFFF">
	
      <div align = "center">
         <div style = "width:300px; border: solid 1px #333333; " align = "left">
            <div align = "center" style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Latham Fire Department Login</b></div>
				
            <div style = "margin:30px">
               
               <form align = "center" action = "" method = "post">
                  <label>Email:    </label><input type = "text" name = "email" class = "box"/><br /><br />
                  <label>Password: </label><input type = "password" name = "password" class = "box" /><br/><br />
                  <input type = "submit" value = " Submit "/><br />
               </form>
               
               <div align = "center" style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
					
            </div>
				
         </div>
			
      </div>

   </body>
</html>
