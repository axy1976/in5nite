<?php
    include('config.php');
    $id = $_GET["task_id"];
	$query = $conn->query("SELECT * FROM `task_info` WHERE `status` = 1 and `task_id` = ".$id."") or die(mysqli_connect_errno());
	$rows = $query->num_rows;

	if($rows > 0){
		$fetch = $query->fetch_array();
        $from_timer = date("H:i:s");
        $to_timer = $fetch['etime'];
        $did = $fetch['deviceid'];
        
        $var1 = strtotime($from_timer);
        $var2 = strtotime($to_timer);

        $differenceinseconds = $var2-$var1;

        if($differenceinseconds == "00:00:00"){
            $uquery = mysqli_query($conn, "update task_info set status = 2 where task_id=".$id."");
            $uquery = mysqli_query($conn, "update tbl_device set inuse = 0 where deviceid=".$did."");
        }

        echo gmdate("H:i:s",$differenceinseconds);
	}
?>