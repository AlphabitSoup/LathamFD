<?php

require 'functions.php';

$title = 'Ice Cream.com';

echo createHeader($title);

if ($_GET['action']=="submit") {
  echo processLoginForm();
}
else {
  echo createLoginForm();
}

echo createFooter($title);

?>