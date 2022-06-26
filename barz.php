<?php
    include('config.php');
    $id = $_GET["bar_item_id"];
	$query = $conn->query("Select * from tbl_bar_items where bar_item_id = ".$id."") or die(mysqli_connect_errno());
	$rows = $query->num_rows;

	if($rows > 0){
		$fetch = $query->fetch_array();
        echo $fetch['bar_item_price'];
	}
?>