<?php
	$cookie_name= "auth_betaconvenzioni";
	if(isset($_COOKIE[$cookie_name])) 			 				
		header("Location: homepage.php");
?>
<!DOCTYPE HTML> 
<html>
	<head>
		<title>Betacom</title>
	</head>
	<body> 
		<h2>Betacom Login</h2>
		<form method="post" action="login.php">  
			<input type="text" name="email" value="" placeholder="Email">			
			<br><br>
			<input type="password" name="password" value="" placeholder="Password">
			<br><br>
			<input type="submit" name="submit" value="Login">
		</form>
		<br>
		<a href="/registrazione.php" >Registrati</a>
	</body>
</html>
<?php
	require_once('functions/functions.php');
	$conn = InstauraConnessione();
	
	if ( isset($_POST['submit'] )){
		$email = $_POST['email'];
		$pw = $_POST['password'];		
	
		$new_pw = md5($pw);
		
		$sql = "SELECT * FROM tbl_utenti WHERE password = '" . $new_pw ."' AND email = '" . $email ."' AND attivo = '1'" ;
		$result = $conn->query($sql);
			
		if ($result->num_rows > 0) {			
			$row = mysqli_fetch_row($result);
			$cookie_value = Encryption($row[0], 'e');
			$cookie_name = 'auth_betaconvenzioni';
			
			setcookie ($cookie_name, $cookie_value, time() + (86400 * 30), '/');
			AbbattiConnessione($conn);
			header("Location: homepage.php");
			
			//se il cookie e settato e torno a login reindirizza su homepage
		}else{
			echo "Email o Password errate";
			AbbattiConnessione($conn);
		}
	}
?>	