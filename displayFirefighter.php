<?php

require 'functions.php';
require 'header.php';

if (isset($_SESSION['loggedin'])) {
	
	echo editTable();

}
else {
  header('Location: ./login.php');
}

require 'footer.php';

?>