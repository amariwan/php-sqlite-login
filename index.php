<?php
	ob_start();
	session_start();
	require_once 'db_connection.php';
	$page_messages = Array();
	
	if( isset($_POST['submit']) ){

		$cleanedUsername = strtolower(strip_tags(trim($_POST['username']))); // Lowercase (strtolower) to make SQL case insensitive.
		$cleanedPassword = strip_tags(trim($_POST['password']));
	
		$loginquery = $conn -> prepare("SELECT * FROM accounts WHERE lower(user) = '$cleanedUsername' LIMIT 1");
		$loginquery->execute();
		$loginresult = $loginquery->fetchAll();
		
		if(isset($loginresult[0]['user']) && !strcmp($cleanedPassword, $loginresult[0]['pass'])){
			$_SESSION['account-username'] = $loginresult[0]['user'];
			$_SESSION['account-ipaddress'] =  $loginresult[0]['ipaddress'];
			$_SESSION['account-connected'] = true;
			header("Location: home.php");
		}
		else { array_push($page_messages, "Invalid username or password."); }
	}
?>

<html>
	<body>
		<h3>SQLite Login Scheme</h3>
		
		<?php
		if(isset($_SESSION['account-created'])){
			echo "<p>Account created successfully!</p>";
			unset($_SESSION['account-created']);
		}
		if($page_messages){
			foreach($page_messages as $txt){
				echo "<p>".$txt."</p>";
			}
		}
		?>
		
		<form method="post">
			<input type="input"		name="username"	placeholder="Username" required>
			<input type="password"	name="password"	placeholder="Password" required>
			<br><br>
			<input type="submit"	name="submit"		value="Login">
			<button onclick="location.href = 'register.php';" id="register-account" >Register</button>
		</form>
	</body>
</html>