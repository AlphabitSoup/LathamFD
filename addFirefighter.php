<?php
/**
 * functions call to add a fire fighter to 
 * the database. Requires the functions.php script
 * as well as header.php and footer.php. Directs the
 * user to the login page if not logged in or to the
 * display fire fighter table if all information is 
 * added correctly.
 *
 *@author Alphabit Soup
 */
 
require_once 'functions.php';
require_once 'header.php';

//$title = 'Latham FD';

if (empty($_SESSION['loggedin'])) {
  header('Location: ./login.php');
}
else {
  if ($_GET['action']=="submit") {
    echo processFirefighter();
  }
  else {
    echo addFirefighterForm();
  }
}

?>