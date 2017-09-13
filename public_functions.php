
<?php require_once 'index.php'; ?>

<?php
	require 'DatabaseTable.php';
	/** When user click on any of the category on the menu, the articles from that category 
			will be displayed in a table **/
	function displayArticlesList(){
		require 'sqlconnect.php';
		$_GET['cat'] = $_SESSION['cat'];
		$articlesTable = new DatabaseTable($pdo, 'articles');
		$result = $articlesTable->find('category', $_GET['cat']);
		echo '<table id=\'table\'><tr><th>Article id</th><th>Article name</th><th>Publish date</th><th>Author</th></tr><tr>';
						
		while($row = $result->fetch()) {
			echo '<td>' . $row['id'] . '</td>';
			echo '<td>' . $row['article_name'] . '</td>';
			echo '<td>' . $row['date_posted'] . '</td>';
			echo '<td>' . $row['author'] . '</td>';
			//This is a link which set the page id to the corresponding id of that article
			echo '<td><a id="button" href="index.php?id=' . $row['id'] . '">View</a></td></tr>';						
							
		}
						
		echo '</table>';		
	}


	/** When user click the "View" or "Read more" button of a article, content of that article will be displayed */
	function getContent(){
		require 'sqlconnect.php';
		$_GET['id'] = $_SESSION['id'];
		$articlesTable = new DatabaseTable($pdo, 'articles');
		$result = $articlesTable->find('id', $_GET['id']);
		while($row = $result->fetch()){
			echo '<div id="details"><div>';			
			echo '<h2>' . $row['article_name'] . '</h2><h4>By ' . $row['author'] . '</h4><h4>Publish date: ' . $row['date_posted'] . '</h4>';
			echo '<img src="' . $row['image_pathway'] . '" style="width:600px;height:300px;">';
			echo '<br><br>' . $row['content'];
			echo '<br><br><br><a id="button" href="index.php?comment=' . $_GET['id'] . '">Comment</a>';
			//allows user to share the article with Facebook or Google+ from the links below
			echo '<img src="https://simplesharebuttons.com/images/somacro/facebook.png" alt="Facebook" style="width:25px;height:25px;"/>';
			echo '<a id="sharebutton" href="http://www.facebook.com/sharer.php?u=https://simplesharebuttons.com" target="_blank">Share on Facebook</a><br><br>';
			echo '<img src="https://simplesharebuttons.com/images/somacro/google.png" alt="Google" style="width:25px;height:25px;"/>';
			echo '<a id="sharebutton" href="https://plus.google.com/share?url=https://simplesharebuttons.com" target="_blank">Share on Google+</a>';	
			//user can reply to the article, allows maximum of three nested comments
			$result2 = $pdo->query('SELECT * FROM comments WHERE article_id =\'' . $_GET['id'] . '\'');
			foreach($result2 as $row) {
				if($row['parent_id'] == null){
					echo '<div class="comments">';	
					echo '<p>' . $row['comment'] . '</p><br>';
					echo '<h4>By ' . $row['author'] . '&nbsp&nbsp&nbsp&nbsp' . $row['date'] . '</h4>';
					echo '<a id="button" href="index.php?nestedcomment=' . $row['id'] . '">Reply</a><br><br>';
					echo '</div>';
				}else{
					echo '<div class="nestedcomments">';
					echo '<p>' . $row['comment'] . '</p>';
					echo '<h4>By ' . $row['author'] . '&nbsp&nbsp&nbsp&nbsp' . $row['date'] . '</h4>';
					echo '<a id="button" href="index.php?nestedcomment=' . $row['id'] . '">Reply</a><br><br>';
					echo '</div>';
					$result3 = $pdo->query('SELECT * FROM comments WHERE parent_id =\'' . $row['id'] . '\'');
					foreach($result3 as $row2){
						echo '<div class="doublenestedcomments">';	
						echo '<p>' . $row2['comment'] . '</p>';
						echo '<h4>By ' . $row2['author'] . '&nbsp&nbsp&nbsp&nbsp' . $row2['date'] . '</h4>';
						echo '</div>';
					}
				}
			}
	
			echo '</div>';
			echo '</div>';
		}				
			
	}

	/** allows user to search for articles with the article's name or publish date */
	function searchJob(){
		require 'sqlconnect.php';
		$_POST['search'] = $_SESSION['search'];
		$myArray = explode(' ', $_POST['search']);
		foreach($myArray as $keyword) {	
			$result = $pdo->query("SELECT * FROM articles WHERE article_name LIKE'%$keyword%' OR date_posted LIKE'%$keyword%'");
			echo '<table id=\'table\'><tr><th>Article id</th><th>Article name</th><th>Publish Date</th><th>Author</th></tr><tr>';	
			foreach ($result as $row) {
				echo '<td>' . $row['id'] . '</td>';
				echo '<td>' . $row['article_name'] . '</td>';
				echo '<td>' . $row['date_posted'] . '</td>';
				echo '<td>' . $row['author'] . '</td>';
				echo '<td><a id="button" href="index.php?id=' . $row['id'] . '">Details</a></td></tr>';						
				
			}				
			echo '</table>';
		}

			
	}

	/** When the 'Comment' button being clicked, user can then leave his/her name 
	and message and reply it to the article publisher*/
	function comment(){
		require 'sqlconnect.php';
		$_GET['comment'] = $_SESSION['comment']; 		
		echo '<form id="details" method="POST" enctype="multipart/form-data">';
		echo '<fieldset>';
		echo '<legend>Please enter you details and leave the comment in the text box:</legend>';
		echo '<br>';
		echo 'Name:<br>';
		echo '<input type="text" name="author" value="">';
		echo '<br><br>';
		echo 'Email:<br>';
		echo '<input type="text" name="email" value="">';
		echo '<br><br>';
		echo '<textarea type="text" cols="40" rows="7" name="content"></textarea><br>';
		echo '<br><br><br>';
		echo '<input type="submit" name="comment" value="Comment">';	
		if(isset($_POST['comment'])){
			//email the admin when someone applied for job
			/*
			$message = $_POST['firstname'] . ' ' . $_POST['lastname'] . ' has applied for job ' . $_GET['apply'] . '. 
			His/her email is ' . $_POST['email'];
			mail('robineq001@gmail.com', 'Someone applied for a job', $message);
			$pathway = 'http://192.168.56.2/cv_files/' . $_FILES['cvupload']['name'];	
			*/
			
			$comment = [
				'author' =>  $_POST['author'],
				'comment' => $_POST['content'],
				'article_id' => $_GET['comment'],
				'date' => date("Y-m-d")
			];
			$commentsTable = new DatabaseTable($pdo, 'comments');
			$commentsTable->insert($comment);
			/*
			$pdo->query("INSERT INTO comments (author, comment, article_id, date) ".
			"VALUES ('" . $_POST['author'] . "', '" . $_POST['content'] . "', '" . $_GET['comment']
			  . "', '" . date("Y-m-d") . "')");
			*/
			echo '<br>Comment posted.<br>';
		} 
		echo '<a id="button" href="index.php?id=' . $_GET['comment'] . '">Go back</a>';
		echo '</fieldset>';
	}

	/*When the 'Reply' button being clicked, user can then leave his/her name 
	and message and reply it to other user's comment*/
	function nestedcomment(){
		require 'sqlconnect.php';
		$_GET['nestedcomment'] = $_SESSION['nestedcomment']; 		
		echo '<form id="details" method="POST" enctype="multipart/form-data">';
		echo '<fieldset>';
		echo '<legend>Please enter you details and leave the comment in the text box:</legend>';
		echo '<br>';
		echo 'Name:<br>';
		echo '<input type="text" name="author" value="">';
		echo '<br><br>';
		echo 'Email:<br>';
		echo '<input type="text" name="email" value="">';
		echo '<br><br>';
		echo '<textarea type="text" cols="40" rows="7" name="content"></textarea><br>';
		echo '<br><br><br>';
		echo '<input type="submit" name="comment" value="Comment">';
		$commentsTable = new DatabaseTable($pdo, 'comments');
		$result = $commentsTable->find('id', $_GET['nestedcomment']);
		$articleId = $result->fetch();
		if(isset($_POST['comment'])){
			
			$comment = [
				'author' =>  $_POST['author'],
				'comment' => $_POST['content'],
				'article_id' => $articleId[3],
				'date' => date("Y-m-d"),
				'parent_id' => $_GET['nestedcomment']
			];
			
			$commentsTable->insert($comment);	
			/*
			$commentsTable = new DatabaseTable($pdo, 'comments');
			$result = $commentsTable->find('id', $_GET['nestedcomment']);
			$articleId = $result->fetch();		
			$pdo->query("INSERT INTO comments (author, comment, article_id, date, parent_id) ".
			"VALUES ('" . $_POST['author'] . "', '" . $_POST['content'] . "', '" . $articleId[3]
			  . "', '" . date("Y-m-d") . "', '" . $_GET['nestedcomment'] . "')");
			*/
			echo "<br>Comment posted.<br>";
		}
		echo '<a id="button" href="index.php?id=' . $articleId[3] . '">Go back</a>';
		echo '</fieldset>';
	}

	//display all the articles on the main page (index.php)
	function displayArticles(){
		require 'sqlconnect.php';
		$result = $pdo->query('SELECT * FROM articles');
		echo '<div id="details">';
		foreach ($result as $row) {
			echo '<h2>' . $row['article_name'] . '</h2>';
			echo '<h3>By ' . $row['author'] . '&nbsp&nbsp&nbsp&nbsp' . 'Publish date: ' . $row['date_posted'] . '</h3>';
			//echo '<h3>Date posted: ' . $row['date_posted'] . '</h3>';
			echo '<p id=\'preview\'>' . $row['content'] . '</p><p> . . . . . . . </p>';
			echo '<a id="button" href="index.php?id=' . $row['id'] . '">Read more</a><br><br><br>';
    		
    	}
		echo '</div>';
	}











?>