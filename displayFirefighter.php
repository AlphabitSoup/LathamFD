<?php
/**
 * functions call to display all fire fighters
 * Requires the functions.php script as well as 
 * header.php and footer.php. Directs the user to 
 * the login if not logged in and the display fire
 * fighter table if session is logged in.
 *
 *@author Alphabit Soup
 */
 
require 'functions.php';
require 'header.php';
echo '<div class="container">';
if (isset($_SESSION['loggedin'])) {
	
	echo editTable();

}
else {
  header('Location: ./login.php');
}


echo '</div>';
?>