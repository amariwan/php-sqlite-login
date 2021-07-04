<?php
	session_start();
	
	if (!isset($_SESSION['account-connected'])) 
		header("Location: index.php");
	else if(isset($_SESSION['account-connected'])!="") 
		header("Location: home.php");
	
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION);
		header("Location: index.php");
		exit;
	}
?>