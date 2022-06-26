<?php
    require 'authentication.php'; // admin authentication check 
    include('config.php');
    $sql = "SELECT * FROM tbl_device WHERE in_service = 0"; 
	$info = $obj_admin->manage_all_info($sql);
	$num_device = $info->rowCount();
    $sql = "SELECT * FROM task_info WHERE status != 2 AND task_date = '".date('y-m-d')."'"; 
	$info = $obj_admin->manage_all_info($sql);
	$num_players = 0;
	while( $row = $info->fetch(PDO::FETCH_ASSOC) ){
		$num_players = $num_players + $row['player_type'];
	}
    $sql = "SELECT * FROM task_info WHERE status != 2 AND task_date = '".date('y-m-d')."'"; 
	$info = $obj_admin->manage_all_info($sql);
	$time = 0;
	if($num_players <= $num_device){
		$time = 0;
	}else{
    	while( $row = $info->fetch(PDO::FETCH_ASSOC) ){
    		if($row['duration'] == 0){
    		    $time = $time + (25 * $row['player_type'] * 60);
    		}else if($row['duration'] == 1){
    		    $time = $time + (55 * $row['player_type'] * 60);
    		}
    	}
    	$time = $time / $num_device;
	}
    echo gmdate("H:i:s",$time);
?>