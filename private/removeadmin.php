<?php require_once '../sqlconnect.php'; ?>
<?php require_once 'private_functions.php'; ?>

<?php checkLogin(); ?>
<?php require_once 'private_header.php'; ?>

<form id="details"  method="POST">
Admin name:<br>
<input type="text" name="username" ><br>
<input type="submit" name="removeadmin" value="Remove this admin"><br>

<?php

	if(isset($_POST['removeadmin'])){
		$adminTable = new DatabaseTable($pdo, 'admins');
		$adminTable->delete('username', $_POST['username']);
		echo 'Sucessfully added new admin.';
		echo '</form>';
	}
?>