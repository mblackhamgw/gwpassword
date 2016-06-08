<?php
   include('lib/logger.php');
   include('lib/sqllib.php');
   session_start();
   $dbuser = $_SESSION['dbuser'];
   $log = new Logging();
   $db = new sqllib();
   $user = $_POST['userid'];
   $db->deladmin($user);
   $log->write("Administrator: " . $user . " deleted" , $dbuser);
   echo "<script>location.replace('adduser.php');</script>";
?>