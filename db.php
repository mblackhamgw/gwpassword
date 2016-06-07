<?php


$db = new SQLite3('helpdesk.db') or die("Unable to open DB");

#if (!$db) die;
#$db->exec('DROP TABLE IF EXISTS users');

#$admin = 'skippy';
#$adminpass = 'novell';

        

#$sql = <<<EOD
#CREATE TABLE IF NOT EXISTS users (
#ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
#USERID TEXT NOT NULL,
#PASSWORD TEXT NOT NULL,
#ROLE TEXT NOT NULL)
#EOD;


#$ret = $db->exec($sql) or die("table create failed") ;

#if(!$ret) { 
#    echo "Create Table failed.";
#}	

#else {
#	echo "Table Created\n";
#}

#$role = 'SUPERADMIN';
#$sql2 = "INSERT INTO users (USERID, PASSWORD, ROLE)
#        VALUES('$admin', '$adminpass', '$role')";
       


#$db->exec($sql2);
$user = "rand";
#$result = $db->query('SELECT * FROM users WHERE USERID="mblackham"');
$query = 'Select * FROM users WHERE USERID="' . $user . '"';
echo $query;
$result = $db->query($query);
While ($row = $result->fetchArray())
{
    echo "User: {$row['USERID']}\n Password:{$row['ROLE']}\n";
}
var_dump( $result);

$db->close();


?>