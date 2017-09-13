<?php session_start(); ?>

<?php require_once 'public_header.php'; ?>
<?php require_once 'public_functions.php'; ?>


	<?php 
		/*run the function displayArticles() which displays all the articles if user didn't interact with other functions*/
		if(!isset($_GET['cat']) && !isset($_GET['id']) && !isset($_POST['search']) && !isset($_GET['comment']) && !isset($_GET['nestedcomment'])){
			displayArticles();
		}
		/*When the 'Search' button being clicked, all the other functions will stop running */
		if(isset($_GET['cat']) && !isset($_POST['search'])){
			$_SESSION['cat'] = $_GET['cat'];
		 	displayArticlesList();
		}
		
		if(isset($_GET['id']) && !isset($_POST['search'])){
			$_SESSION['id'] = $_GET['id'];
			getContent();
		}

		if(isset($_POST['search'])){
			$_SESSION['search'] = $_POST['search'];
			//header("Location: http://192.168.56.2/result.php");
			searchJob();
		}

		if(isset($_GET['comment']) && !isset($_POST['search'])){
			$_SESSION['comment'] = $_GET['comment'];
			comment();
		}

		if(isset($_GET['nestedcomment']) && !isset($_POST['search'])){
			$_SESSION['nestedcomment'] = $_GET['nestedcomment'];
			nestedComment();
		}

		
	?>
	


		

	</body>

</html>