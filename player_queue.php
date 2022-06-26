<?php
require 'authentication.php'; // admin authentication check 
include('config.php');
// auth check
$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];
if ($user_id == NULL || $security_key == NULL) {
    header('Location: index.php');
}

// check admin 
$user_role = $_SESSION['user_role'];
if($user_role != 2){
  header('Location: index.php');
}

$page_name="MainDesk";

if(isset($_POST['add_task_post'])){
	$obj_admin->add_new_task($_POST);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Player Queue</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="assets/bootstrap-datepicker/css/datepicker.css">
	<link rel="stylesheet" href="assets/bootstrap-datepicker/css/datepicker-custom.css">
	<link rel="stylesheet" href="assets/jquery-ui-1.13.0/jquery-ui.css">
	<link rel="stylesheet" href="Demo%20SciUI_files/toastr.css" crossorigin="anonymous">
	<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/custom.css">
	<link href="Demo%20SciUI_files/grid.css" rel="stylesheet" type="text/css">
	<link href="Demo%20SciUI_files/styles.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="TimeCircles.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/custom.js"></script>
	<script src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script src="assets/bootstrap-datepicker/js/datepicker-custom.js"></script>
	<script src="Demo%20SciUI_files/jquery_002.js" crossorigin="anonymous"></script>
	<script src="Demo%20SciUI_files/toastr.js" crossorigin="anonymous"></script>
	<script src="Demo%20SciUI_files/howler.js" crossorigin="anonymous"></script>
	<script src="Demo%20SciUI_files/jquery.js"></script>
	<script src="Demo%20SciUI_files/progressbar.js"></script>
	<script type="text/javascript" src="TimeCircles.js"></script>
	<script src="Demo%20SciUI_files/base.js" crossorigin="anonymous"></script>
    <link rel="icon" href="https://www.vdream.co.in/wp-content/uploads/2021/08/cropped-VDREAM-01-1-32x32.png" sizes="32x32" />
    <link rel="icon" href="https://www.vdream.co.in/wp-content/uploads/2021/08/cropped-VDREAM-01-1-192x192.png" sizes="192x192" />
    <link rel="apple-touch-icon" href="https://www.vdream.co.in/wp-content/uploads/2021/08/cropped-VDREAM-01-1-180x180.png" />
    <meta name="msapplication-TileImage" content="https://www.vdream.co.in/wp-content/uploads/2021/08/cropped-VDREAM-01-1-270x270.png" />
  	<script type="text/javascript">
    /* delete function confirmation  */
    function check_delete() {
      var check = confirm('Are you sure you want to delete this?');
      if (check) {
          return true;
      } else {
          return false;
      }
    }
 	</script>
	<style>
		td {
			vertical-align:CENTER;
			text-align: center;
		}
		.mode-color{
			background-color: #152a3b;
			border: 1px solid rgba(34,69,97,0.4);
		}
		a,
		a:hover{
			text-decoration: none;
		}
		ul.ui-autocomplete {
			z-index: 1100;
		}
	</style>
</head>
<body>
	<div class="panel shown" style="padding:50px;padding-bottom:0px;">
		<a href="customer-maindesk.php" style="font-size:32px;">IN<span class="alert" style="margin:0;padding:0;border:0;">5</span>NITE VR</a>
		<a href="?logout=logout" class="button alert pull-right" onclick="sound5.play()">Logout <span style="margin-top:3px;margin-left:10px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-log-out"></span></a>
		<span class="button warning lg pull-right round" style="margin-top:-6px;margin-right:50px;">Average Waiting Time [ <span id="avgtime"></span> ] </span>
		<div class="menu horizontal button text-center" style="background:none;border:0;">
			<a href="customer-maindesk.php">Customer</a>
			<a href="player_queue.php" class="active">Player Queue</a>
			<a href="payment-maindesk.php">Payment</a>
			<a href="bar-item-maindesk.php">BAR</a>
		</div>
	</div>
	<div class="panel shown row">
		<div class="col-md-4">
			<div class="panel shown modal-body">
				<h2 class="title text-center">player queue</h2>
				<div class="divider"></div>
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<form role="form" action="" method="post" autocomplete="off">
							<div class="form-horizontal">
								<div class="form-group row">
									<div class="col-sm-12">
										<div class="input autocomplete">
											<input type="number" name="txtcardid" id="taskcardid" placeholder="Card ID" list="expense" required>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-12">
										<div class="input">
											<select name="txttype" id="txttype" required>
												<option value="" selected disabled>Select Game...</option>
												<?php
													$sql = "SELECT * FROM tbl_play_items";
													$info = $obj_admin->manage_all_info($sql);
													while( $row = $info->fetch(PDO::FETCH_ASSOC) ){
														echo '<option value="'.$row['play_item_id'].'">'.$row['play_item_name'].'</option>';
													}
												?>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-12">
										<div class="input">
											<select name="txtgtype" id="txtgtype" required>
												<option value="" selected disabled>Select Players...</option>
												<?php
													$fetch_device = "Select * from tbl_device where in_service = 0";
													$result = mysqli_query($conn,$fetch_device);
													$v = mysqli_num_rows($result);
													for ($i=1; $i <= $v; $i++) {
														echo '<option value="'.$i.'">'.$i.' Player</option>';
													} ?>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-12">
										<div class="input">
											<select name="txtduration" id="txtduration" required>
												<option value="" selected disabled>Select Duration...</option>
												<option value="0">30 Minutes</option>
												<option value="1">60 Minutes</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group">
									<button type="submit" name="add_task_post" class="button success pull-right" onclick="sound0.play()">Update Queue</button>
								</div>
							</div>
						</form> 
					</div>
				</div>
			</div>
		</div>
	<div class="col-md-8">
		<div class="panel shown table-responsive">
			<h3 class="text-center title">Play Queue Chart</h3>
			<div class="divider"></div>
				<table class="table table-codensed table-custom text-center">
					<thead>
						<tr>
							<th>Serial No.</th>
							<th>Arena Number</th>
							<th>Client Name</th>
							<th>Game Name</th>
							<th>Date</th>
							<th>Type</th>
							<th>Timer</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$sql = "SELECT a.*, b.*, c.*
								FROM task_info a
								INNER JOIN tbl_clients b ON(a.card_id = b.card_id)
								INNER JOIN tbl_play_items c ON(a.game_id = c.play_item_id)
								AND a.task_date = '".date("Y-m-d")."'
								ORDER BY a.token_no asc"; 
						$info = $obj_admin->manage_all_info($sql);
						$serial  = 1;
						$num_row = $info->rowCount();
						if($num_row==0){
							echo '<tr><td colspan="7" class="alert">No Data found</td></tr>';
						}
						while( $row = $info->fetch(PDO::FETCH_ASSOC) ){
						
						if($row['player_type'] > 1){ ?>
						<tr>
							<td colspan="6">
								<?php for ($i=0; $i < $row['player_type']; $i++) { ?>
									<tr>
										<td><?php echo $serial."[<span class='alert'>".($i+1)."</span>]"; ?></td>
										<?php if($row['deviceid'] != 0){
											$sql1 = "SELECT * FROM tbl_device WHERE deviceid = '".$row['deviceid']."'"; 
											$info1 = $obj_admin->manage_all_info($sql);
											$data = $info1->fetch(PDO::FETCH_ASSOC);
											echo "<td>".$data['devicearena']."</td>";
										}else{
											echo "<td></td>";
										} ?>
										<td><?php echo $row['username']; ?></td>
										<td><?php echo $row['play_item_name']; ?></td>
										<td><?php echo $row['task_date']; ?></td>
										<td>
											<?php if($row['player_type']==1) { ?>
											<i class="fa fa-user" aria-hidden="true"></i>
											<?php } else if($row['player_type']>1) { ?>
											<i class="fa fa-users" aria-hidden="true"></i>
											<?php } ?>
										</td>
										<?php if($i == 0) {
											echo "<td rowspan=".$row['player_type']."></td>";
										}?>
									</tr>
								<?php }$serial++; ?>
							</td>
						</tr>
						<?php } else { ?>
						<tr>
							<td><?php echo $serial++; ?></td>
							<?php if($row['deviceid'] != 0){
								$sql1 = "SELECT * FROM tbl_device WHERE deviceid = '".$row['deviceid']."'"; 
								$info1 = $obj_admin->manage_all_info($sql);
								$data = $info1->fetch(PDO::FETCH_ASSOC);
								echo "<td>".$data['devicearena']."</td>";
							}else{
								echo "<td></td>";
							} ?>
							<td><?php echo $row['username']; ?></td>
							<td><?php echo $row['play_item_name']; ?></td>
							<td><?php echo $row['task_date']; ?></td>
							<td>
								<?php if($row['player_type']==1) { ?>
								<i class="fa fa-user" aria-hidden="true"></i>
								<?php } else if($row['player_type']>1) { ?>
								<i class="fa fa-users" aria-hidden="true"></i>
								<?php } ?>
							</td>
							<td></td>
						</tr>
						<?php } } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<script src="assets/jquery-ui-1.13.0/external/jquery/jquery.js"></script>
  	<script src="assets/jquery-ui-1.13.0/jquery-ui.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
	<script type="text/javascript">
		flatpickr('#t_start_time', {
			enableTime: true
		});
		flatpickr('#t_end_time', {
			enableTime: true
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#txtcardid").autocomplete({
				source: 'search.php',
				minLength: 0,
			});
			$("#taskcardid").autocomplete({
				source: 'searchclients.php',
				minLength: 0,
			});
			$("#txtsearchbox").autocomplete({
				source: 'searchclients.php',
				minLength: 0,
			});
		});
	</script>
	<script>
		setInterval(() => {
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.open("GET","avgtime.php",false);
			xmlhttp.send(null);
			document.getElementById("avgtime").innerHTML = xmlhttp.responseText;
		}, 1000);
		<?php
			if(isset($_SESSION['messagex'])){
				echo "toastr.success('".$_SESSION['messagex']."','Successfully!');";
				unset($_SESSION['messagex']);
			}
			if(isset($_SESSION['messagey'])){
				echo "toastr.error('".$_SESSION['messagey']."','Alert!');";
				unset($_SESSION['messagey']);
			}
		?>
	</script>
</body>
</html>