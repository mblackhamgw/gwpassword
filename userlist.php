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
    include('lib/gwlib.php');
    session_start();
    $users = $_SESSION['userlist'];
    $dbrole = $_SESSION['role'];
    $dbuser = $_SESSION['dbuser'];
    $c = $_SESSION['curl'];
?>
<script language="javascript">
$(document).ready(function(){
	$("#button").click ( function()
	{
		alert('button clicked');
	}
	);
)};
	
</script>
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
                            <p><strong><?php echo $dbuser;?> | <a href="logout.php">Logout</a></strong></p>
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
                                <div class="h_title">GroupWise Users </div>
                                
                                    <?php
                                        if(!isset($dbrole)){
                                            echo "<script>location.replace('index.php');</script>";
                                        }
                                    unset($_SESSION['gwuser']);
                                    unset($_SESSION['userlist']);
                                    if (count($users) == 1){
                                        $gwuser = $users[0];
                                        $_SESSION['gwid'] = $gwuser['name'];
                                        $ldap = $c->checkLdap($gwuser['postOfficeName']);
                                        if ($ldap == 1 && isset($gwuser['ldapDn'])) {
                                            echo "<script>location.replace('diruser.php');</script>";
                                        }
                                        else {
                                            echo "<script>location.replace('changepwd.php');</script>";
                                        }
                                    }
                                    else {
                                    ?>
                                    <table>
                                    <tr>
                                    <th>Userid</th>
                                    <th>Last Name</th>
                                    <th>First Name</th>
                                    <th>Post Office</th>
                                    <th></th>
                                    </tr>
                                    <?php
                                        foreach($users as $gwuser){
                                    ?>
                                        <form name="<?php echo $gwuser['name'];?>" method="POST" action="changepwd.php">
                                            <input name="gwusername" value="<?php echo $gwuser['name'];?>" type="hidden">
                                            <input name="gwuserurl" value="<?php echo $gwuser['@url'];?>" type="hidden">
                                            <tr>
                                                <?php
                                                    echo "<td>" . $gwuser['name'] . "</td><td>" .  $gwuser['surname'] . "</td><td>" .  $gwuser['givenName'] . "</td>";
                                                    echo "<td>" . $gwuser['postOfficeName'] . "</td>";
                                                    
                                            
                                                    $ldap = $c->checkLdap($gwuser['postOfficeName']);
                                                    if ($ldap == 1 && isset($gwuser['ldapDn'])) {
                                                        echo "<td>Directory associated user and PO is set for LDAP AUTH</td></tr>";
                                                    }
                                                    else {
                                                        echo "<td><button onclick='location.href=\"changepwd.php\"' name=\"" . $gwuser['name'] . "pwd\"'>Change Pwd</button></td></tr>";
                                                    }
                                            echo "</form>";
                                            echo "</td>";
                                        }
                                    }
                                    ?>
                                </table>
                            </div>  
                    </div>
            </div>

</body>
</html>