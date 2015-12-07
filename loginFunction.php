<?php

require 'functions.php';

$title = 'Latham FD';

echo createHeader($title);

if ($_GET['action']=="submit") {
  echo processLoginForm();
}
else {
  echo createLoginForm();
}

echo createFooter($title);

?>