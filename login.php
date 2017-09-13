<?php require_once 'sqlconnect.php'; ?>
<?php require_once 'public_header.php'; ?>

<!-- Display a form which asks admin to enter his/her username and password, 
when 'Login' button being clicked, it moves to 'checklogin.php' -->
<form id="details" action="private/checklogin.php" method="POST">
	<fieldset>
	   	<legend>Please enter your username and password:</legend>
	   	<br>
		 Username:
		 <input type="username" name="username" >
		 <br>
		 Password:
		 <input type="password" name="password" >
		 <br><br>
		 <input type="submit" value="Login">
	</fieldset>
</form>


