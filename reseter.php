<?php
include('config.php');
$ti = $_GET['task_id'];
$query = $conn->query("SELECT * FROM `task_info` WHERE `task_id` = ".$ti."") or die(mysqli_connect_errno());
$fetch = $query->fetch_array();
if($fetch['status'] != 2){
    $query = mysqli_query($conn, "update task_info set stime = '00:00:00', etime = '00:00:00', status = 0 where task_id='".$ti."'");
}
header("location: waiting-info.php")
?>