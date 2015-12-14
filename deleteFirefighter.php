<?php

require 'functions.php';

deleteFirefighter($_GET['id']);
  header('Location: ./displayFirefighter.php');
  //echo editTable();



?>