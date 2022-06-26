<?php
    require 'authentication.php';
    include('config.php');
	$fetch_device = "Select * from tbl_device where inuse = 0";
	$result = mysqli_query($conn,$fetch_device);
	$devices = mysqli_num_rows($result);
	if($devices >= 1){
		$sql = "SELECT a.task_id,b.deviceid FROM task_info a,tbl_device b WHERE a.task_date = '".date("Y-m-d")."' AND a.deviceid = 0 AND b.inuse = 0 LIMIT 1";
		$info = $obj_admin->manage_all_info($sql);
		$row = $info->fetch(PDO::FETCH_ASSOC);
        $a = $row['task_id'];
        $b = $row['deviceid'];
        $obj_admin->update_task_device($a,$b);
	}
?>