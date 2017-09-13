
<?php require_once '../sqlconnect.php'; ?>
<?php require_once 'private_functions.php'; ?>
<?php checkLogin(); ?>
<?php require_once 'private_header.php'; ?>

		<?php
			$apps = $pdo->query('SELECT * FROM comments');
			echo '<table id=\'table\'><tr><th>Job ID</th><th>Firstname</th>
			<th>Lastname</th><th>Email</th><th>File name</th><th>File size</th><th>Download</th></tr><tr>';
			foreach ($apps as $row) {
							echo '<td>' . $row['id'] . '</td>';
							echo '<td>' . $row['firstname'] . '</td>';
							echo '<td>' . $row['lastname'] . '</td>';
							echo '<td>' . $row['email'] . '</td>';
							echo '<td>' . $row['filename'] . '</td>';
							echo '<td>' . $row['filesize'] . ' bytes</td>';
							echo '<td><a href=' . $row['filepathway'] . '>Download</a></td></tr>';
							
							
			}				
			echo '</table>';

		?>




		<?php 
			 


			


		
		?>

		

	</body>

</html>




















