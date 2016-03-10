<?php

require 'functions.php';
require 'header.php';

$title = 'Latham FD';

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
  require 'footer.php';
}

?>