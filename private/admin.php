<?php session_start(); ?>
<?php require_once '../sqlconnect.php'; ?>
<?php require_once 'private_functions.php'; ?>

<?php checkLogin(); ?>
<?php require_once 'private_header.php'; ?>




		<?php 
			 
			 if(isset($_GET['cat'])){
			 	$_SESSION['cat'] = $_GET['cat'];
			 	displayArticles();
			 }

					
			if(isset($_GET['delete'])){
				$_SESSION['delete'] = $_GET['delete'];
			 	deleteArticles();
												
			}

			if(isset($_GET['edit'])){
				$_SESSION['edit'] = $_GET['edit'];
				editArticles();
			}

			if(isset($_POST['search'])){
				$_SESSION['search'] = $_POST['search'];
				searchArticles();
			}

			/*
			if(isset($_GET['app'])){
				$_SESSION['app'] = $_GET['app'];
				viewApplication();
			}
			*/
	
		?>

		

	</body>

</html>




















