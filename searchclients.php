<?php
    include('config.php');
	$search = $_GET['term'];
	
	$query = $conn->query("SELECT * FROM `tbl_cards` WHERE `card_id` LIKE '%$search%' AND is_assigned = 1 limit 10") or die(mysqli_connect_errno());
	
	$list = array();
	$rows = $query->num_rows;
	
	if($rows > 0){
		while($fetch = $query->fetch_assoc()){
			$data['value'] = $fetch['card_id'];
			array_push($list, $data);
		}
	}
	echo json_encode($list);
?>