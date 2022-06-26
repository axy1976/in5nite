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

if(isset($_GET['delete_user'])){
  $action_id = $_GET['user_id'];
  $sql = "DELETE FROM tbl_clients WHERE user_id = :id";
  $sent_po = "manage-clients.php";
  $obj_admin->delete_data_by_this_method($sql,$action_id,$sent_po);
}

$page_name="Customer Desk";

if(isset($_POST['add_new_client'])){
  $error = $obj_admin->add_new_user($_POST);
}

if(isset($_GET['delete_task'])){
	$action_id = $_GET['task_id'];  
	$sql = "DELETE FROM task_info WHERE task_id = :id";
	$sent_po = "task-info.php";
	$obj_admin->delete_data_by_this_method($sql,$action_id,$sent_po);
}

if(isset($_POST['add_task_post'])){
	$obj_admin->add_new_task($_POST);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $page_name;?></title>
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
	<script type="text/javascript">
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
		th{
			font-weight:10px;
		}
		input[type=number] {
			-moz-appearance:textfield;
		}

		input[type=number]::-webkit-inner-spin-button,
		input[type=number]::-webkit-outer-spin-button {
			-webkit-appearance: none;
			margin: 0;
		}
	</style>
</head>
<body>
	<div class="panel shown" style="padding:50px;padding-bottom:0;">
		<a href="customer-maindesk.php" style="font-size:32px;">IN<span class="alert" style="margin:0;padding:0;border:0;box-shadow: none;">5</span>NITE VR</a>
		<a href="?logout=logout" class="button alert pull-right">Logout <span style="margin-top:3px;margin-left:10px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-log-out"></span></a>
		<span class="button warning lg pull-right round" style="margin-top:-6px;margin-right:50px;">Average Waiting Time [ <span id="avgtime"></span> ] </span>
		<div class="menu horizontal button text-center" style="background:none;border:0;">
			<a href="customer-maindesk.php" class="active">Customer</a>
			<a href="player_queue.php">Player Queue</a>
			<a href="payment-maindesk.php">Payment</a>
			<a href="bar-item-maindesk.php">BAR</a>
        </div>
	</div>
	<div class="panel shown row">
		<div class="col-md-4 mx-auto">
			<div class="panel shown modal-body">
			<h2 class="title text-center">Add New Client</h2>
			<div class="divider"></div>
				<div class="row">
					<div class="col-sm-offset-1 col-sm-10">
						<form role="form" action="" method="post">
							<div class="form-horizontal">
								<div class="form-group row">
									<div class="col-sm-12">
										<div class="input">
											<input id="txtcardid" type="number" name="txtcardid" placeholder="Card ID" required/>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-12">
										<div class="input">
											<input type="text" placeholder="Name" name="txtname" required>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-12">
										<div class="input">
											<input type="email" placeholder="Email ID (optional)" name="txtemail">
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-12">
										<div class="input">
											<input type="number" placeholder="Mobile Number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" name="txtnumber" required>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-12">
										<div class="input">
											<input type="date" placeholder="Birth Date" id="dob" name="txtdob">
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-12">
										<div class="input">
											<select name="gender" id="gender" required>
												<option value="" disabled selected>Select...</option>
												<option value="Male">Male</option>
												<option value="Female">Female</option>
												<option value="Other">Other</option>
											</select>
										</div>
									</div>
								</div>
								<button type="submit" name="add_new_client" class="button success pull-right">Add Client</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-8">
		    <div class="panel shown">
    		    <div class="input">
        			<h2 class="title text-center">Search Player</h2>
        			<div class="divider"></div>
					<div class="d-flex">
						<input type='text' placeholder="Card ID" name="txtsearchbox" id="txtsearchbox">
						<button name="searchbox" class="button warning pull-right m-0" onclick="searchbox()">Search</button>
					</div>
    		    </div>
		    </div>
			<div class="table-responsive panel shown">
				<h3 class="text-center title">Client List</h3>
				<div class="divider"></div>
				<table class="table table-codensed table-custom">
					<thead>
						<tr>
							<th>Serial No.</th>
							<th>Card ID</th>
							<th>Username</th>
							<th>Email</th>
							<th>Phone</th>
							<th>DOB</th>
							<th>Gender</th>
							<th>Details</th>
						</tr>
					</thead>
					<tbody id="searchedbox">
					<?php 
						$limit = 20;
						if(!isset($_GET['till'])){
							$sql = "SELECT a.*,b.amount FROM tbl_clients a, tbl_cards b where a.card_id = b.card_id order by user_id desc limit 0,". $limit;
						}else{
							$limit = $limit * $_GET['till'];
							$sql = "SELECT a.*,b.amount FROM tbl_clients a, tbl_cards b where a.card_id = b.card_id order by user_id desc limit ". $limit-20 .",". $limit;
						}
						$info = $obj_admin->manage_all_info($sql);
						$serial = 1;
						$num_row = $info->rowCount();
							if($num_row==0){
								echo '<tr><td colspan="9">No Data found</td></tr>';
							}
						while( $row = $info->fetch(PDO::FETCH_ASSOC) ){
					?>
						<tr>
							<td><?php echo $serial; $serial++; ?></td>
							<td><?php echo $row['card_id']; ?></td>
							<td><?php echo $row['username']; ?></td>
							<td><?php echo $row['email']; ?></td>
							<td><?php echo $row['phone']; ?></td>
							<td><?php echo $row['dob']; ?></td>
							<td><?php echo $row['gender']; ?></td>
							<td>
								<a title="Update Client" href="payment-maindesk.php?card_id=<?php echo $row['card_id']; ?>"><span class="glyphicon glyphicon-edit"></span></a>
							</td>
						</tr>
					<?php  } ?>
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
	    function searchbox(){
	        let val = document.getElementById('txtsearchbox').value;
	        var xmlhttp = new XMLHttpRequest();
			xmlhttp.open("GET","searchbox.php?cardid="+val,false);
			xmlhttp.send(null);
			document.getElementById("searchedbox").innerHTML = xmlhttp.responseText;
	    }
	</script>
	<script>
	    function chalu(){
			var v = '<?=date('Y')?>';
			var minv = v - 13;
			var maxv = v - 100;
			document.getElementById('dob').max = minv+"<?=date('-m-d')?>";
			document.getElementById('dob').min = maxv+"<?=date('-m-d')?>";
		}
		chalu();
    </script>
    <script>
		setInterval(() => {
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.open("GET","avgtime.php",false);
			xmlhttp.send(null);
			document.getElementById("avgtime").innerHTML = xmlhttp.responseText;
		}, 10000);
	</script>
	<script>
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