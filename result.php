<?php //session_start(); ?>
<?php require_once 'sqlconnect.php'; ?>
<?php require_once 'public_header.php'; ?>
<?php require_once 'public_functions.php'; ?>


	<?php 

		//$_SESSION['search'] = $_POST['search'];
		searchJob();

		if(isset($_GET['cat'])){
			$_SESSION['cat'] = $_GET['cat'];
		 	displayArticles();
		}
		
		if(isset($_GET['id'])){
			$_SESSION['id'] = $_GET['id'];
			jobDetails();
		}

		if(isset($_GET['apply'])){
			$_SESSION['apply'] = $_GET['apply'];
			applyJob();
		}
			
	?>
	


		

	</body>

</html>