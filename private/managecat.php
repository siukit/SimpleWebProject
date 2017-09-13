<?php require_once '../sqlconnect.php'; ?>
<?php require_once 'private_functions.php'; ?>
<?php require_once 'private_header.php'; ?>
<?php checkLogin(); ?>


		<form id="details" method="POST">		
	   	<legend>Enter the category name:</legend>
	   	<br>
		 
		 <input type="text" name="category" >
		 
		 <input type="submit" name="add" value="Add">
		 <input type="submit" name="delete" value="Delete"><br>
			
		<?php

			/* Allows admin to add or delete category by entering the name of the category */
			if($_POST){
				$newCategory = [
				'cat_name' => $_POST['category']
				];
				$categoryTable = new DatabaseTable($pdo, 'categories');

				if (isset($_POST['add'])) {
		        	//$pdo->query('INSERT INTO categories (cat_name) VALUES ("' . $_POST['category'] . '")');
		        	$categoryTable->insert($newCategory);
		        	echo 'Sucessfully added ' . $_POST['category'] . ' into the categories.';
		        	echo '</form>';
			    } elseif (isset($_POST['delete'])){
			        //$pdo->query('DELETE FROM categories WHERE cat_name="' . $_POST['category'] . '"');
			        $categoryTable->delete('cat_name', $_POST['category']);
			        echo 'Sucessfully deleted ' . $_POST['category'] . ' from the categories.';
			        echo '</form>';
			    }
			}
		?>	

		

	</body>

</html>