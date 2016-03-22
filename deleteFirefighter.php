<?php
/**
 * functions call to delete a fire fighter from 
 * the database. Requires the functions.php script.
 * Directs the user to the display fire fighter table.
 *
 *@author Alphabit Soup
 */
 
require 'functions.php';

deleteFirefighter($_GET['id']);
  header('Location: ./displayFirefighter.php');
  //echo editTable();



?>