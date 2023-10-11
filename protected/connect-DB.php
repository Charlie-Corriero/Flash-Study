<?php
require '../lib/DataBase.php';
$databaseName = 'CCORRIER_cs148_final';
$dsn = 'mysql:host=webdb.uvm.edu;dbname=' . $databaseName;
$thisDataBaseWriter = new DataBase("ccorrier_writer", $databaseName);
$thisDataBaseReader = new DataBase("ccorrier_reader", $databaseName);
?>
<!-- done -->