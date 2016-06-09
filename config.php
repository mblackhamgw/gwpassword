<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pl" xml:lang="pl">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>GroupWise Password Change</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="css/navi.css" media="screen" />
    <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
    <?php
        include('lib/sqllib.php');
        $db = new sqllib();
		if (!file_exists('db')){
            mkdir('db', 0777);
        }
    ?>
</head>
<body>
<div class="wrap">
    <div id="header">
        <div id="top">
            <div class="left">
                <h2 style="color:#ebebeb">GroupWise Password Change</h2>
            </div>
        </div>
        <div id="nav"></div>
	<div id="content">
            <div id="main">
                <div class="clear"></div>
                    <div class="full_w">
                        <div class="h_title">Application Configuration</div>
                
                            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="configure">
                                <h2>Adminstrator Settings</h2>
                                <table>
                                    <tr><td><label for="admin">Administrator</label></td>
                                        <td><input type="text" size="35" name="admin"</input></td>
                                    </tr>
                                    <tr><td><label for="adminpass">Administrator Password:</label></td>
                                        <td><input id="pass" name="adminpass" size="35" type="text"  /></td>
                                    </tr>
                                </table>
                                <h2>GroupWise Configuration</h2>
                                <table>
                                    <tr><td><label for="gwhost">GroupWise Admin Server IP/Hostname</label></td>
                                        <td><input type="text" size="35" name="gwhost"</input></td>
                                    </tr>
                                    <tr><td><label for="port">Admin Service Port</label></td>
                                        <td><input type="text" size="35" name="gwport"</input></td>
                                    </tr>
                                    <tr><td><label for="gwadmin">GroupWise System Administrator</label></td>
                                        <td><input id="gwadmin" name="gwadmin" type="text" size="35"></td>
                                    </tr>
                                    <tr><td><label for="gwpass">GroupWise Administrator Password</label></td>
                                        <td><input id="gwpass" name="gwpass" type="text" size="35"></td>
                                    </tr>
                                </table>

                                </br></br>
                                <button type="submit" name="submit">OK</button>
                            </form>
                            <?php
                            if (isset($_POST['submit'])) {
                                $admin = $_POST['admin'];
                                $adminpass = $_POST['adminpass'];
                                $gwhost= $_POST['gwhost'];
                                $gwport = $_POST['gwport'];
                                $gwadmin = $_POST['gwadmin'];
                                $gwpass = $_POST['gwpass'];

                                $ret = $db->createUserTable();
                                if(!$ret) { 
                                    echo "<h3>Create user table failed</h3>";
                                }	
                                else {
                                    echo "<h3>user table treated\n</h3>";
                                }
                                $result = $db->createadmin($admin, $adminpass, 'Administrator');
                                if ($result == 0){
                                    echo "<h3>User: {$row['USERID']}\n created as Administrator\n</h3>";
                                }
                                $ret = $db->createGwTable($gwhost,$gwport,$gwadmin,$gwpass);
                                if($ret == 1) { 
                                    echo "<h3>Create gw table failed</h3>";
                                }	
                                else {
                                    echo "<h3>gw table created\n</h3>";
                                    echo "<script>location.replace('configdone.html');</script>";
                                }
                            }
                            ?>
                   
</div><!--  end full_w -->            
</div><!--  end Main -->
</div> <!-- end wrap -->
</body>
</html>
