<?php require_once '../sqlconnect.php'; ?>
<?php require_once 'private_functions.php'; ?>
<?php checkLogin(); ?>
<?php require_once '../DatabaseTable.php'; ?>



			
		
		<!-- Display a form for admin to create new job-->
		<form id="details"  method="POST">
		Enter the data of the new article:<br><br><br>
		Article name:<br>
		<input type="text" name="articlename" ><br><br>	
		Publish date (in YYYY-MM-DD format):<br>
		<input type="text" name="dateposted"><br><br>
		
		Author:<br>
		<input type="text" name="author" ><br><br>
			
		Content:<br>
		<textarea type="text" cols="40" rows="7" name="content"></textarea><br><br>
				
		Category (must be existing category, otherwise use Add Categories feature):<br>
		<?php
			echo '<select name="category">';
			$result = $pdo->query('SELECT * FROM categories');
			foreach ($result as $row) {
        		echo '<option value="' . $row['id'] . '">' . $row['cat_name'] . '</option>';
        	}
			echo '</select>';
		?>
		<br><br>
		<input type="submit" name="addarticle" value="Add Article"><br>


		<?php 
			
			/** Insert data of the new job to the jobs table in the database */
			if(isset($_POST['addarticle'])){

				$newArticle = [
				'article_name' => $_POST['articlename'],
				'date_posted' => $_POST['dateposted'],
				'author' => $_POST['author'],
				'content' => $_POST['content'],
				'category' => $_POST['category'],
				'image_name' => '',
				'image_size' => '',
				'image_pathway' => ''
				];	
				$articlesTable = new DatabaseTable($pdo, 'articles');
				$check = $articlesTable->insert($newArticle);
				/*
	        		$check = $pdo->query('INSERT INTO jobs (job_name, date_posted, job_type, salary, details, category)
	        			VALUES ("' . $_POST['jobname'] . '", "' . $_POST['dateposted'] . '", "' . $_POST['jobtype'] . 
	        				'", "' . $_POST['salary'] . '", "' . $_POST['details'] . '", "' . $_POST['category'] . '")');
	        	*/
	        		//check if the query was successful or not
        		if (!$check) {
					echo "Failed to add article, plz make sure all the fields were filled";
				}else{
        			echo 'Successfully added new article.';
        			echo '</form>';
        		}

				}

		
		?>

		

	</body>

</html>




















