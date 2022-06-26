<?php
    date_default_timezone_set("Asia/Calcutta");
	$conn = new mysqli('localhost', 'root', '', 'iqjdhyaf_in5nite');
	if(!$conn){
		die("Error: Can't connect to database");
	}
?>