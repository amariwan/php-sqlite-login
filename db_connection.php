<?php
	if(!file_exists('./site_db.db')) {
		echo "ERROR: Database file not found.";
		exit;
	} else { $conn = new PDO('sqlite:./site_db.db'); }
?>