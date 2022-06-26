<?php
    include('config.php');
    $id = $_GET["task_id"];
	$query = $conn->query("SELECT * FROM `task_info` WHERE `status` = 0 and `task_id` = ".$id."") or die(mysqli_connect_errno());
	$rows = $query->num_rows;
	
	if($rows > 0){
		$fetch = $query->fetch_array();
        $counter = $fetch['counteresets'];
        if($counter == 0)
        {
            $query1 = $conn->query("SELECT * FROM `tbl_cards` WHERE `card_id` = ".$fetch['card_id']."") or die(mysqli_connect_errno());
            $fetch1 = $query1->fetch_array();
            $money = $fetch1['amount'];
            if($fetch['duration'] == 0){
                $duration = 25;
                $money = $money - 250;
            }else if($fetch['duration'] == 1){
                $duration = 55;
                $money = $money - 500;
            }
            $cquery = mysqli_query($conn, "update tbl_cards set amount = '".$money."' where card_id='".$fetch['card_id']."'");
        }
        $start_time = date("H:i:s");
        $end_time = strtotime("+".$duration." minutes",strtotime($start_time));
        $end_time = date('H:i:s', $end_time);
	}
    $counter++;
    $uquery = mysqli_query($conn, "update task_info set stime = '".$start_time."', etime = '".$end_time."', countresets = '".$counter."', status = 1 where task_id='".$id."'");
    header("location:waiting-info.php");
?>