<?php require_once '../sqlconnect.php'; ?>
<?php session_start(); ?>
<?php require_once 'private_header.php'; ?>

	

<?php

	$stmt = $pdo->prepare('SELECT * FROM admins WHERE username = :username'); 
	$check = ['username' => $_POST['username']];
	$stmt->execute($check);
	$user = $stmt->fetch();
	if (password_verify($_POST['password'], $user['password'])) { 
		$_SESSION['loggedin'] = $user['id'];
		echo "<h1 id='details'>You are loged in</h1>";
	} else {
		echo "<h1 id='details'>Login failed</h1>";
	}

?>

</body>
</html>