<?php

require 'functions.php';
require 'header.php';

$title = 'Latham FD';

if ($_GET['action']=="submit") {
  echo processFirefighter();
}
else {
  echo addFirefighterForm();
}

require 'footer.php';
?>