<html>
	<head>
	<title>Job Search</title>
	<script src="script.js"></script>
	<link rel="stylesheet" href="style.css" type="text/css" />
	</head>
	<body>

	<!-- Display the text field and button for searching jobs -->
		<form method="POST">
            
            <input id="button" type="button" value="Search">
            <input id="button" name="search" type="text" placeholder="Search for article..." required>
		</form>

		<a id="button" href="login.php">Admin login</a>

		

		<nav>
			<ul id="menu">
			<li><a href="index.php">Article Categories</a></li>
			
			<?php 	
			require 'sqlconnect.php';
				/** Display all the categories from the catgories table to the left menu */
				$result = $pdo->query('SELECT * FROM categories');
				foreach ($result as $row) {
	        		echo '<li><a href="index.php?cat=' . $row['id'] . '">' . $row['cat_name'] . '</a></li>';
	        	}
			?>
			</ul>
			
		</nav>

		
