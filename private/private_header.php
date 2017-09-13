<html>
	<head>
	<title>Job Search</title>
	<link rel="stylesheet" href="../style.css" type="text/css" />
	</head>
	<body>

		<form method="POST" action="admin.php">
            
            <input id="button" type="button" value="Search">
            <input id="button" name="search" type="text" placeholder="Search for article..." required>
		</form>

		<a id="button" href="logout.php">Logout</a>
		<a id="button" href="removeadmin.php">Remove admin</a>
		<a id="button" href="addadmin.php">Create new admin</a>
		<a id="button" href="addarticle.php">Add article</a>
		<a id="button" href="uploadimages.php">Upload image</a>

		
		
		

		<nav>
			<ul id="menu">
			<li><a href="admin.php">Article Categories</a></li>
			<?php 		
					
					$result1 = $pdo->query('SELECT * FROM categories');					
					foreach ($result1 as $row) {
	        		echo '<li><a href="admin.php?cat=' . $row['id'] . '">' . $row['id'] . ' ' . $row['cat_name'] . '</a></li>';        	
					}
					echo '<li><a id="button" href="managecat.php">Add/Delete categories</a></li><br>';	
					
				?>
			</ul>

			
		</nav>