<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="author" content="Paweł 'kilab' Balicki - kilab.pl" />
<link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/navi.css" media="screen" />
<title>GroupWise Password Change</title>
<!-- link rel="stylesheet" type="text/css" href="css/login.css" media="screen" /> -->
</head>
<body>

<div class="wrap">
    <?php
        include("lib/gwlib.php");
        session_start();
        $appdir = getcwd();
        $_SESSION['appdir'] = $appdir;
        $db = new SQLite3('config/helpdesk.db') or die("Unable to open DB");
        $c = new gw($appdir) or die("SOMETHING WRONG");
        $_SESSION['curl'] = $c;
    ?>
    <div id="header">
        <div id="top">
            <div class="left">
                <h2 style="color:#ebebeb">GroupWise Password Change</h2>
            </div>
        </div>
        <div id="nav">
        </div>
    </div>
	<div id="content"> 
		<div id="main">
                    <div class="clear"></div>
			<div class="full_w">
                            <div class="h_title">Login</div>
                            <form id="login" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                                <table> 
                                    <tr><td><label for="username">Username:</label></td>
                                        <td><input id="username" name="username" size="35" class="text" /></td></tr>
                                        <tr><td><label for="pass">Password:</label></td>
                                            <td><input id="pass" name="pass" type="password" size="35" class="text" /></td></tr>
                                </table>
                                <div class="sep"></div>
                                <button type="submit" class="ok" name="submit">Login</button>
                            </form>
                            <?php
                                if (isset($_POST['submit'])){
                                    $user = $_POST['username'];
                                    $query = 'Select * FROM users WHERE USERID="' . $user . '"';

                                    $result = $db->query($query);
                                    While ($row = $result->fetchArray())
                                    {
                                        #echo "{$row['USERID']}";
                                        $dbuser = "{$row['USERID']}";
                                        $dbpass = "{$row['PASSWORD']}";
                                        $dbrole = "{$row['ROLE']}";
                                    }
                                    if ($_POST['username'] == $dbuser && $_POST['pass'] == $dbpass) {
                                        if ($gwlogin == 0) {
                                             $_SESSION['role'] = $dbrole;
                                            echo "<script>location.replace('search.php');</script>";
                                        }
                                    }
                                    else {
                                        echo "<div class='sep'></div><h3>Login Failed, Try again.</h3><p></br></p>";
                                    }
                                }
                            ?>
			</div>
			
</div>
</div>
</body>
</html>