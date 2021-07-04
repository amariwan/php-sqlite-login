<?php
	ob_start();
	session_start();
	require_once 'db_connection.php';
	$page_messages = Array();
	
	if( isset($_SESSION['account-connected']) ) {
		header("Location: home.php");
		exit;
	}
	
	if( isset($_POST['submit']) ){
		
		$cleanedUsername = strtolower(strip_tags(trim($_POST['username'])));
		$cleanedPassword = strip_tags(trim($_POST['password']));
		$cleanedCPassword = strip_tags(trim($_POST['cpassword']));
		
		if(strcmp($cleanedPassword, $cleanedCPassword)){
			array_push($page_messages,"ERROR: Passwords do not match.");
		} else {
			$sql = "SELECT COUNT(*) FROM accounts WHERE lower(user) = '$cleanedUsername'";
			$checkusername = $conn -> query($sql);
			
			if ($checkusername->fetchColumn()) {
				array_push($page_messages, "ERROR: That username currently exists.");
			} else {
				$create_account = $conn -> prepare("INSERT INTO `accounts`(`user`,`pass`,`ipaddress`) VALUES ('$cleanedUsername','$cleanedPassword',NULL)");
				$create_account -> execute();
				$_SESSION['account-created'] = true;
				header("Location: index.php");
			}
		}
	}
?>

<html>
	<body>
		<h3>Register Account</h3>
		
		<?php
		if($page_messages){
			foreach($page_messages as $txt){
				echo "<p>".$txt."</p>";
			}
		}
		?>
		
		<form method="post">
			Username: <input type="input"		name="username" required><br>
			Please enter the name by which you would like to log-in and be known on this site.<br>
			<br><br>
			
			Password: <input type="password"	name="password" required><br>
			Confirm Password: <input type="password"	name="cpassword" required><br>
			Please enter a password for your user account. Note that passwords are case-sensitive.<br>
			
			<br>
			<input type="submit"	name="submit"		value="Create">
			<button onclick="location.href = 'index.php';" id="register-account" >Cancel</button>
		</form>
	</body>
</html>