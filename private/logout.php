<?php

	/** when 'Logout' button being clicked, unset SESSION value, 
	and move browser back to index.php */
	session_start();
	unset($_SESSION['loggedin']);
	
	echo '<h3 id="details">You are now logged out</h3>';
	echo '<a id="button" href="../index.php">Back to homepage</a>';


?>