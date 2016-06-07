<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pl" xml:lang="pl">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="author" content="Paweł 'kilab' Balicki - kilab.pl" />
<title>GroupWise Helpdesk</title>
<link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/navi.css" media="screen" />
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<?php 
    session_start();
    $dbrole = $_SESSION['role'];
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
                    <div class="h_title">Directory User </div>
                    <h3>User: <?php echo $gwid; ?>, is associated to a directory and the post office is set for LDAP Authentication </h3>
                    <h3>Setting GroupWise Password is disabled</h3>
                    </br>
                    <h3>
                        <a href="search.php">Search for another user</a>
                    </h3>
                </div>
            </div>
        </div>