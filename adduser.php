<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pl" xml:lang="pl">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="Pawel 'kilab' Balicki - kilab.pl" />
    <title>GroupWise Password Change</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="css/navi.css" media="screen" />
    <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
</head>
<body>
<?php
   session_start();
   $dbrole = $_SESSION['role'];
   $db = new SQLite3('config/helpdesk.db') or die("Unable to open DB");
   $q = 'Select * FROM users';
   $users = $db->query($q);
?>
<div class="wrap">
    <div id="header">
       <div id="top">
           <div class="left">
               <h2 style="color:#ebebeb">GroupWise Password Change</h2>
           </div>
       </div>
       <div id="nav"></div>
       <div id="content">
           <div id="sidebar">
               <div class="box">
                   <div class="h_title">&#8250; Menu</div>
                   <ul id="home">
                       <li class="b1"><a class="icon config" href="search.php">User Search</a></li>
                        <?php
                           if (isset($dbrole) && $dbrole == "SUPERADMIN"){
                           echo '<ul><li class="b1"><a class="icon config" href="adduser.php">Add Administrator</a></li></ul>';
                           }
                       ?>
                   </ul>
               </div>
           </div>
        <div id="main">
	    <div class="clear"></div>
	    <div class="full_w">
		<div class="h_title">Existing Users</div>
                <table>
                    <tr><th>Userid</th><th>Role</th></tr>
                    <?php
                        While ($row = $users->fetchArray())
                        {
                        echo "<tr><td>{$row['USERID']}</td><td>{$row['ROLE']}</td></tr>";
                        }
                    ?>
                </table>
                <div class="h_title">Add User</div>
                    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="add">
                        <table>
                            <tr><td><label for="user">Administrator</label></td>
                                <td><input type="text" size="35" name="user"</input></td>
                            </tr>
                            <tr><td><label for="userpass">Administrator Password:</label></td>
                                <td><input id="pass" name="userpass" size="35" type="password"  /></td>
                            </tr>
                        </table>
                        </br></br>
                        <button type="submit" name="submit">Add User</button>
                    </form>
<?php
if (isset($_POST['submit'])) {
    $user = $_POST['user'];
    $password = $_POST['userpass'];
    $role = "admin";
    $db = new SQLite3('config/helpdesk.db') or die("Unable to open DB");
    $sql2 = "INSERT INTO users (USERID, PASSWORD, ROLE)
        VALUES('$user', '$password', '$role')";

$db->exec($sql2);
$query = 'Select * FROM users WHERE USERID="' . $user . '"';
$result = $db->query($query);
While ($row = $result->fetchArray())
{
    echo "<h3>User: {$row['USERID']}\n  Created as Admin\n</h3>";
}
$db->close();
}
?>
</div><!--  end full_w -->            
</div><!--  end Main -->
</div> <!-- end wrap -->
</body>
</html>
