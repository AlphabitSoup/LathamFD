<?php
 
define('DB_SERVER','oraserv.cs.siena.edu');
define('DB_PORT','3306');
define('DB_USERNAME','perm_alphabit');
define('DB_PASSWORD','dour=punish-guild');
define('DB_NAME','perm_alphabit');
 
$dbh = mysql_connect(DB_SERVER.':'.DB_PORT,DB_USERNAME,DB_PASSWORD);
if (!$dbh) {
    echo "Oops! Something went horribly wrong.";
    exit();
}
mysql_selectdb(DB_NAME,$dbh);
//session_start();

?>