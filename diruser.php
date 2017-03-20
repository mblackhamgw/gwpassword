<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pl" xml:lang="pl">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="author" content="Paweł 'kilab' Balicki - kilab.pl" />
<title>GroupWise Password Change</title>
<link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/navi.css" media="screen" />
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<?php 
    session_start();
    include('lib/logger.php');
    $log = new Logging();
    $dbrole = $_SESSION['role'];
    $dbuser = $_SESSION['dbuser'];
    $gwid = $_SESSION['gwid'];
    
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
                    <div class="h_title">Directory User</div>
                    <div class="n_error"><p>
                    User: <?php echo $gwid; ?>, is associated to a directory and the post office is set for LDAP Authentication.                  
                         <?php $log->write($gwid . ' is a directory associated user and PO set for LDAP Authentication', $dbuser);
                          $log->write('Password Change disabled', $dbuser);
                          $log->close();
                          ?>
                    <br>
                    Setting or changing GroupWise Password is disabled.
                    </br>
                        </p>
                    </div>
                    <h3>
                        <button onclick="window.location.href='search.php'">Search for another user</button>
                    </h3>
                </div>
            </div>
        </div>