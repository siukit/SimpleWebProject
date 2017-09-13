<?php require_once '../sqlconnect.php'; ?>
<?php require_once 'private_functions.php'; ?>
<?php checkLogin(); ?>
<?php require_once '../DatabaseTable.php'; ?>



		
		
		

		<?php
			echo '<form id="details"  method="POST" enctype="multipart/form-data">';
			echo '<fieldset>';
			echo 'Choose the article which the image will upload to:<br><br>';
			echo '<select name="article">';
			$result = $pdo->query('SELECT * FROM articles');
			foreach ($result as $row) {
        		echo '<option value="' . $row['article_name'] . '">' . $row['article_name'] . '</option>';
        	}
			echo '</select>';
			echo '<br><br>';
			echo 'Upload image:<br>';
			echo '<input type="hidden" name="MAX_FILE_SIZE" value="2000000">';
			echo '<input type="file" name="image">';
			echo '<br><br>';
			echo '<input type="submit" name="uploadimage" value="Upload image"><br>';
			echo '</fieldset>';
			//the maximum file size is 2 megabytes
			$maxSize = 2097152;	
			//file MIME types that will be accepted by the server
			$accept = array(
        		'image/jpeg',
        		'image/png'
    		);

			if(isset($_POST['uploadimage']) && $_FILES['image']['size'] > 0){
				$pathway = 'http://192.168.56.2/private/images/' . $_FILES['image']['name'];
				if($_FILES['image']['size'] >= $maxSize) {
	        		die('File is too large. It must be less than two megabytes.');
	        		echo ('File is too large. It must be less than two megabytes.');
    			}
    			if((!in_array($_FILES['image']['type'], $accept)) && (!empty($_FILES["image"]["type"]))) {
	        		die('Invalid file type. Only .pdf, .doc and .docx are allowed.');
	        		echo ('Invalid file type. Only .pdf, .doc and .docx are allowed.');
    			}
    			// Check if the file exists
				if(file_exists('images/' . $_FILES['image']['name'])){
			    	die('File with the same name already exists.');
			    	echo ('File with the same name already exists.');
				}
				// Upload file
				if(!move_uploaded_file($_FILES['image']['tmp_name'], 'images/' . $_FILES['image']['name'])){
			    	die('Failed to upload file, please contact admin (email: admin@mail.com)');
			    	echo ('Failed to upload file, please contact admin (email: admin@mail.com)');
				}

				$pdo->query("UPDATE articles SET image_name = '" . $_FILES['image']['name'] . "', image_size = '" . 
				$_FILES['image']['size'] . "', image_pathway = '" . $pathway . "'WHERE article_name = '" . $_POST['article'] . "'");

				echo "<br>Image uploaded<br>";

			}
		?>