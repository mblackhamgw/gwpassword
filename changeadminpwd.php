<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="author" content="Paweł 'kilab' Balicki - kilab.pl" />
<link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/navi.css" media="screen" />
<title>GroupWise Password Change</title>
<?php
        include("lib/logger.php");
    $log = new Logging();
    session_start();
    $dbrole = $_SESSION['role'];
    $dbuser = $_SESSION['dbuser'];
?>
</head>
<body>
<div class="wrap">
    <div id="header">
        <div id="top">
            <div class="left">
                <h2 style="color:#ebebeb">GroupWise Password Change</h2>
            </div>
            <div class="right">
                <div class="align-right">
                    <p><strong><?php echo $dbuser;?> | <a href="changeadminpwd.php">Change Password</a> | <a href="logout.php">Logout</a></strong></p>
                </div>
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
                            if (isset($dbrole) && $dbrole == "Administrator"){
                            echo '<ul><li class="b1"><a class="icon config" href="adduser.php">Add Administrator</a></li></ul>';
                            }
                        ?>
                    </ul>
                </div>
            </div>
		<div id="main">
                    <div class="clear"></div>
			<div class="full_w">
                            <div class="h_title">Change Password for <b> <?php echo $dbuser; ?></b></div>
                            <form id="change" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                                <label for="pwd1">Enter New Password:</label>
                                <input id="pwd1" name="pwd1" type="password" class="text" />
                                <label for="pwd2">Re-enter Password:</label>
                                <input id="pwd2" name="pwd2" type="password" class="text" />
                                <div class="sep"></div>
                                <button type="submit" class="ok" name="submit">Set Password</button>
                            </form>
                            <?php
                                if (isset($_POST['submit'])){
                                    if ($_POST['pwd1'] == $_POST['pwd2']) {
                                        require_once('lib/sqllib.php');
                                        $db = new sqllib();
                                        $results = $db->changepwd($dbuser, $_POST['pwd1']);
                                        echo "<h3>Password Changed</h3>";
                                        $log->write($dbuser . "changed password", $dbuser);
                                        $log->close();
                                        echo "<h3><a href='search.php'>Search for new user</a></h3>";
                                    }
                                    else {
                                        echo "<h3>Passwords do not match, Re-Enter passwords<h3>";
                                    }
                                }
                            ?>
			</div>
		</div>

</div>
</body>
</html>
