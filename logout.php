<?php
session_start();
$_SESSION = Array();
unset($c);
unset($dbrole);
unset($dbuser);
unset($db);
echo "<script>location.replace('index.php');</script>";
?>