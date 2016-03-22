<?php
/**
 * functions call to grab a fire fighter to edit
 * Requires the functions.php script as well as 
 * header.php and footer.php. Directs the user to 
 * the edit form when the edit button is clicked and the
 * display fire fighter table if all information is 
 * updated as desired.
 *
 *@author Alphabit Soup
 */
 
require 'functions.php';
require 'header.php';

//gets the fire fighter's id number from URL
$id = $_GET['id'];
//echo $id;

if ($_GET['action']=="submit") {
  updateFirefighter($id);
  header('Location: ./displayFirefighter.php');
}
else{
  $_POST = getFirefighter($id);
 //var_dump($_POST);
  echo createEditForm();
}


require 'footer.php';
?>