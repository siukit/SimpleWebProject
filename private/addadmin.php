<?php require_once '../sqlconnect.php'; ?>
<?php require_once 'private_functions.php'; ?>

<?php checkLogin(); ?>
<?php require_once 'private_header.php'; ?>


		<!-- Display a form which user can enter the new admin data, 
		and a button for creating the admin -->
		<form id="details"  method="POST">
		Enter the data of new admin:<br><br>
		Username:<br>
		<input type="text" name="username" ><br>		
		Password:<br>
		<input type="password" name="password"><br>
		Confirm password:<br>
		<input type="password" name="cpassword"><br>
		<input type="submit" name="addadmin" value="Add new admin"><br>


		<?php 
			/** check if the password and confirm password are the same, if not then an error
			message will be displayed, and the admin will not be created */
			if(isset($_POST['password']) && isset($_POST['cpassword'])){
				if ($_POST["password"] == $_POST["cpassword"]) {
					if(isset($_POST['addadmin'])){
							$hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
							
			        		$pdo->query('INSERT INTO admins (username, password)
			        			VALUES ("' . $_POST['username'] . '", "' . $hash . '")');
			        		echo 'Sucessfully added new admin.';
			        		echo '</form>';

					}
				}else{
					echo 'The passwords you put were not the same, please try again.';
				}
			}	
		?>

		

	</body>

</html>




















