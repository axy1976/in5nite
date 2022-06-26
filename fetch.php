<?php
include('config.php');
print_r($_POST);
$x = $_POST['task_id'];
$query = mysqli_query($connection, "select * from task_info where task_id=$x");

$result = "";

$result .= "<div id='display'>";
$result .="<table border=\"1\">";
$result .="<tr><th>Card ID</th><th>Device ID</th><th>Duration</th></tr>";
while($row = mysqli_fetch_assoc($query)){
	if($row['duration']==0)
	{
		$time = "25 MIN";
	}
	else
	{
		$time = "55 MIN";
	}
	$result .= "<tr><td> {$row['card_id']}</td>"."<td> {$row['deviceid']}</td>"."<td> {$time}</td></tr></p>";
}
$result .="</table>";

$result .= "</div>";
echo $result;

?>