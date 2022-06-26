<?php
require 'authentication.php'; // admin authentication check 

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

$page_name="MainDesk";

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
	<title>Employee Task Management System</title>
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
    /* delete function confirmation  */
    function check_delete() {
      var check = confirm('Are you sure you want to delete this?');
      if (check) {
          return true;
      } else {
          return false;
      }
    }
    
    var sound = new Howl({
      src: ['./audio/buzz_blink.wav']
    });
    var sound0 = new Howl({
      src: ['./audio/Docs1.wav']
    });
    var sound1 = new Howl({
      src: ['./audio/Docs2.wav']
    });
    var sound2 = new Howl({
      src: ['./audio/Docs3.wav']
    });
    var sound3 = new Howl({
      src: ['./audio/Docs4.wav']
    });
    var sound4 = new Howl({
      src: ['./audio/Docs5.wav']
    });
    var sound5 = new Howl({
      src: ['./audio/Docs6.wav']
    });
    var sound6 = new Howl({
      src: ['./audio/Docs7.wav']
    });
    
    sound.play();
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
	<div class="panel shown" style="padding:50px;">
		<a href="maindesk.php" style="font-size:32px;">IN<span class="alert" style="margin:0;padding:0;border:0;">5</span>NITE VR</a>
		<a href="?logout=logout" class="button alert pull-right" onclick="sound5.play()">Logout <span style="margin-top:3px;margin-left:10px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-log-out"></span></a>
		<span class="button warning lg pull-right" style="margin-top:-6px;margin-right:50px;">Average Waiting Time [ 00:00:00 ] </span>
	</div>
	<div class="panel shown row">
		<div class="col-md-4">
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
											<input id="txtcardid" type="text" name="txtcardid" placeholder="Card ID" required/>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-12">
										<div class="input">
											<input type="text" placeholder="Enter Client Name" name="txtname" required>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-12">
										<div class="input">
											<input type="email" placeholder="Enter Client Email" name="txtemail" required>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-12">
										<div class="input">
											<input type="number" placeholder="Enter Client Number" name="txtnumber" required>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-12">
										<div class="input">
											<input type="date" placeholder="Enter Client Birthdate" name="txtdob" required>
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
								<button type="submit" name="add_new_client" class="button success pull-right" onclick="sound0.play()">Add Client</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel shown modal-body">
				<h2 class="title text-center">Add player gameplay</h2>
				<div class="divider"></div>
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<form role="form" action="" method="post" autocomplete="off">
							<div class="form-horizontal">
								<div class="form-group row">
									<div class="col-sm-12">
										<div class="input autocomplete">
											<input type="text" name="txtcardid" id="taskcardid" placeholder="Card ID Of Client" list="expense" required>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-12">
										<div class="input">
											<select name="txttype" id="txttype" required>
												<option value="" selected disabled>Select Type...</option>
												<option value="0">Single Player</option>
												<option value="1">Multi Player</option>
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
									<button type="submit" name="add_task_post" class="button success pull-right" onclick="sound0.play()">Add Player</button>
								</div>
							</div>
						</form> 
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
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
											<input id="taskcardid" type="text" name="txtcardid" placeholder="Card ID" required/>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-12">
										<div class="input">
											<select name="gender" id="gender" required>
												<option value="" disabled selected>Select...</option>
												<option value="Male">Cash</option>
												<option value="Female">Online</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-12">
										<div class="input">
											<input id="txtamount" type="text" name="txtamount" placeholder="Amount" required/>
										</div>
									</div>
								</div>
								<button type="submit" name="add_new_payment" class="button success pull-right" onclick="sound0.play()">Accept Payment</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="panel shown row">
		<h3 class="text-center title">Task Management Panel</h3>
		<div class="divider"></div>
		<div class="table-responsive">
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
				<tbody>

				<?php 
					$sql = "SELECT * FROM tbl_clients";
					$info = $obj_admin->manage_all_info($sql);
					$serial = 1;
					$num_row = $info->rowCount();
						if($num_row==0){
							echo '<tr><td colspan="8">No Data found</td></tr>';
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
							<a title="Update Client" href="update-client.php?user_id=<?php echo $row['user_id']; ?>"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;
							<?php if($user_role == 1){ ?>
							<a title="Delete" href="?delete_user=delete_user&user_id=<?php echo $row['user_id']; ?>" onclick=" return check_delete();"><span class="glyphicon glyphicon-trash"></span></a>
							<?php } ?>
						</td>
					</tr>
				<?php  } ?>
				</tbody>
			</table>
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
		});
	</script>
	<script>
		setInterval(() => {
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.open("GET","response.php",false);
			xmlhttp.send(null);
			document.getElementById("response").innerHTML = xmlhttp.responseText;
		}, 1000);
	</script>
</body>
</html>