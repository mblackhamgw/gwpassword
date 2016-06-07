<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pl" xml:lang="pl">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>GroupWise Helpdesk</title>
<link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/navi.css" media="screen" />
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript">
$(function(){
	$(".box .h_title").not(this).next("ul").hide("normal");
	$(".box .h_title").not(this).next("#home").show("normal");
	$(".box").children(".h_title").click( function() { $(this).next("ul").slideToggle(); });
});
<?php 
    session_start();
    $dbrole = $_SESSION['role'];
    $gwid = $_SESSION['gwid'];
?>
</script>
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
                <?php
		echo "<h1>User Not Found:  " . $gwid . " </h1>";
                ?>
		</br>
		<h3>
		<a href="search.php">Retry Search</a>
                </h3>
                
                
            </div>
        
            </div>
        </div>
