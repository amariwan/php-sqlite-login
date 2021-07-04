<?php
	ob_start();
	session_start();
	
	if( !isset($_SESSION['account-connected']) ) {
		header("Location: index.php");
		exit;
	}
?>
<html>
	<body>
		<h3>Logged in!</h3>
		<br>
		<form method="post" action="logout.php?logout"><input type="submit" value="Sign Out"></form>
	</body>
</html>