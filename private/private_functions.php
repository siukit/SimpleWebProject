
<?php require_once '../sqlconnect.php'; ?>
<?php require_once 'admin.php'; ?>



<?php

	require '../DatabaseTable.php';
	//check if user has logged in, if not then transfer back to index.php
	function checkLogin() {
		if(!isset($_SESSION['loggedin'])){
			header("Location: ../index.php");
			die();
		}
	}

	/** Display the article which has the category of the 'cat'(stands for category) value, 
			also display delete and edit buttons */

	function displayArticles(){	
		
		require '../sqlconnect.php';
		$_GET['cat'] = $_SESSION['cat'];
		$articlesTable = new DatabaseTable($pdo, 'articles');
		$result2 = $articlesTable->find('category', $_GET['cat']);
		//$result2 = $pdo->query('SELECT * FROM articles WHERE category=\'' . $_GET['cat'] . '\'');
		echo '<table id=\'table\'><tr><th>Article id</th><th>Article name</th><th>Publish date</th><th>Author</th></tr><tr>';
		while($row = $result2->fetch()) {
			echo '<td>' . $row['id'] . '</td>';
			echo '<td>' . $row['article_name'] . '</td>';
			echo '<td>' . $row['date_posted'] . '</td>';
			echo '<td>' . $row['author'] . '</td>';
			echo '<td><a id="button" href="admin.php?delete=' . $row['id'] . '">Delete</a></td>';
			echo '<td><a id="button" href="admin.php?edit=' . $row['id'] . '">Edit</a></td></tr>';
			
		}				
		echo '</table>';
			
			
	}			

	//When the 'Delete' button being clicked, that article will be deleted from the database
	function deleteArticles(){
		require '../sqlconnect.php';
		$_GET['delete'] = $_SESSION['delete'];

		echo '<form id="details"  method="POST">Are you sure you want to delete the job?<br>';
		echo '<input type="submit" name="yes" value="Yes">';
		
		if(isset($_POST['yes'])){
			$commentsTable = new DatabaseTable($pdo, 'comments');
			$commentsTable->delete('article_id', $_GET['delete']);
			$articlesTable = new DatabaseTable($pdo, 'articles');
			$articlesTable->delete('id', $_GET['delete']);
			//$pdo->query('DELETE FROM articles WHERE id="' . $_GET['delete'] . '"');
		    echo '<br><br><h3 id="details">Sucessfully deleted the job.</h3>';
		}				
			
			
	}

	/** When the 'Edit' button being clicked, a form will be displayed, 
			which allows users to view the current data of the article, and let them edit any of the 
			data */
	function editArticles(){
		require '../sqlconnect.php';
		$_GET['edit'] = $_SESSION['edit'];
		$articlesTable = new DatabaseTable($pdo, 'articles');
		$result = $articlesTable->find('id', $_GET['edit']);
		//$result = $pdo->query('SELECT * FROM articles WHERE id=\'' . $_GET['edit'] . '\'');
		//$result->execute();

		while($row = $result->fetch(PDO::FETCH_ASSOC)){
			echo '<form id="details"  method="POST">';
			echo 'Enter the data you want to update in the following fields:<br><br><br>';
			echo 'Article name:<br>';
			echo '<input type="text" name="articlename" value="' . $row['article_name'] . '"><br><br>';
			
			echo 'Publish date (in YYYY-MM-DD format):<br>';
			echo '<input type="text" name="dateposted" value="' . $row['date_posted'] . '"><br><br>';
			
			echo 'Author:<br>';
			echo '<input type="text" name="author" value="' . $row['author'] . '"><br><br>';
			
			echo 'Content:<br>';
			echo '<textarea type="text" cols="40" rows="7" name="content">' . $row['content'] . '</textarea><br><br>';
		
			echo 'Category (must be existing category, otherwise use add category feature):<br>';
			echo '<select name="category">';
			$result = $pdo->query('SELECT * FROM categories');
			foreach ($result as $row) {
        		echo '<option value="' . $row['cat_name'] . '">' . $row['cat_name'] . '</option>';
        	}
			echo '</select><br><br>';
			echo '<input type="submit" name="update" value="Update"><br>';
		}

		/** When the 'update' button being clicked, it updates 
		all the data from the form to the corespond table */
		if(isset($_POST['update'])){
			/*
			$newArticle = [
				'id' => $_GET['edit'],
				'article_name' => $_POST['articlename'],
				'date_posted' => $_POST['dateposted'],
				'author' => $_POST['author'],
				'content' => $_POST['content'],
				'category' => $_POST['category']
			];	
			$articlesTable = new DatabaseTable($pdo, 'articles');
			$articlesTable->update($newArticle, 'id');
			*/
			
    		$pdo->query('UPDATE articles SET article_name=\'' . $_POST['articlename'] . '\' WHERE id=\'' . $_GET['edit'] . '\'');
    		$pdo->query('UPDATE articles SET date_posted=\'' . $_POST['dateposted'] . '\' WHERE id=\'' . $_GET['edit'] . '\'');
    		$pdo->query('UPDATE articles SET author=\'' . $_POST['author'] . '\' WHERE id=\'' . $_GET['edit'] . '\'');
    		$pdo->query('UPDATE articles SET content=\'' . $_POST['content'] . '\' WHERE id=\'' . $_GET['edit'] . '\'');
    		$pdo->query('UPDATE articles SET category=\'' . $_POST['category'] . '\' WHERE id=\'' . $_GET['edit'] . '\'');
    		
    		echo 'Sucessfully updated.';
    		echo 'To see updated data, please refresh the page.';
    		echo '</form>';

		}	
		
	}

	/** when the search button is being clicked, the keywords that user input in the text field 
			will be processed and output the details of jobs which names contain those keywords in a table */
	function searchArticles(){
		require '../sqlconnect.php';
		$_POST['search'] = $_SESSION['search'];
		$myArray = explode(' ', $_POST['search']);
		foreach($myArray as $keyword) {
			//$keyword = mysqli_real_escape_string(trim($keyword));
			$result = $pdo->query("SELECT * FROM articles WHERE article_name LIKE'%$keyword%'");
			echo '<table id=\'table\'><tr><th>Article id</th><th>Article name</th><th>Publish Date</th><th>Author</th></tr><tr>';	
			foreach ($result as $row) {			
				echo '<td>' . $row['id'] . '</td>';
				echo '<td>' . $row['article_name'] . '</td>';
				echo '<td>' . $row['date_posted'] . '</td>';
				echo '<td>' . $row['author'] . '</td>';
				echo '<td><a id="button" href="admin.php?delete=' . $row['id'] . '">Delete</a></td>';
				echo '<td><a id="button" href="admin.php?edit=' . $row['id'] . '">Edit</a></td>';
							
				
			}				
				echo '</table>';
		}

			
	}

	/*
	//when 'view user application' button being clicked, it displays the user applications of that job
	function viewReply(){
		require '../sqlconnect.php';
		$_GET['app'] = $_SESSION['app'];
				$apps = $pdo->query('SELECT * FROM applications WHERE job=\'' . $_GET['app'] . '\'');
				echo '<table id=\'table\'><tr><th>id</th><th>firstname</th><th>lastname</th><th>email</th><th>CV file</th></tr><tr>';
				foreach ($apps as $row) {
							echo '<td>' . $row['id'] . '</td>';
							echo '<td>' . $row['firstname'] . '</td>';
							echo '<td>' . $row['lastname'] . '</td>';
							echo '<td>' . $row['email'] . '</td>';
							//echo '<td><a href="jobapps.php/' . $row['filecontent'] . ' target="_blank"">Download the CV file</a></td>';
				}		
				echo '</table>';						
			
	}
	*/















	


?>