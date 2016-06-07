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
    include('lib/gwlib.php');
    session_start();
    $users = $_SESSION['userlist'];
    $dbrole = $_SESSION['role'];
    $c = $_SESSION['curl'];
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
                                <div class="h_title">GroupWise Users </div>
                                <table>
                                    <th>Userid</th>
                                    <th>Last Name</th>
                                    <th>First Name</th>
                                    <th>Post Office</th>
                                    <th>Change Password</th>
                                    <?php
                                    foreach($users as $gwuser){
                                        $ldap = $c->checkLdap($gwuser['postOfficeName']);
                                        echo "<tr>";
                                        echo "<td>" . $gwuser['name'] . "</td><td>" .  $gwuser['surname'] . "</td><td>" .  $gwuser['givenName'] . "</td>";
                                        echo "<td>" . $gwuser['postOfficeName'] . "</td>";
                                        if ($ldap == 1 && isset($gwuser['ldapDn'])) {
                                            if (count($users) == 1){
                                                $_SESSION['gwid'] = $gwuser['name'];
                                                echo "<script>location.replace('diruser.php');</script>";
                                            }
                                            else {
                                                echo "<td>Directory associated user and PO is set for LDAP AUTH</td></tr>";
                                            }
                                        }
                                        else {
                                            $_SESSION[gwuser] = $gwuser;
                                            if (count($users) == 1) {
                                                echo "<script>location.replace('changepwd.php');</script>";
                                            }
                                            echo "<td><button onclick='location.href=\"changepwd.php\"' name=\"" . $gwuser['name'] . "pwd\">Change Pwd</button></td></tr>";
                                        }
                                    }
                                    ?>
                                </table>
                
                            </div>  
        
                    </div>
            </div>
</body>
</html>