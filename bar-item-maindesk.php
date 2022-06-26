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

if(isset($_POST['new_bar_purchase'])){
	$obj_admin->new_bar_purchase($_POST);
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
			<a href="player_queue.php">Player Queue</a>
			<a href="payment-maindesk.php">Payment</a>
			<a href="bar-item-maindesk.php" class="active">BAR</a>
		</div>
	</div>
	<div class="panel shown row">
		<div class="col-md-4 mx-auto">
			<div class="panel shown modal-body">
			<h2 class="title text-center">Bar Items</h2>
			<div class="divider"></div>
				<div class="row">
					<div class="col-sm-offset-1 col-sm-10">
						<form role="form" action="" method="post">
							<div class="form-horizontal">
							    <div class="form-group row">
									<div class="col-sm-12">
										<div class="input">
											<input id="taskcardid" type="number" name="taskcardid" placeholder="Card ID"/>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-12">
										<div class="input">
											<select name="txtdrink" id="txtdrink" required>
												<option value="0" selected disabled>Select Item...</option>
    											<?php
    											$fetch_items = "Select * from tbl_bar_items";
    											$result = mysqli_query($conn,$fetch_items);
    											while($v = $result->fetch_array(MYSQLI_ASSOC)){
    												echo '<option value="'.$v["bar_item_id"].'">'.$v["bar_item_name"].'</option>';
    											} ?>
    										</select>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-12">
										<div class="input">
											<input type="number" min="1" name="txtdrinkno" value="1" id="txtdrinkno" placeholder="Quantity" required>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-12">
										<div class="input">
											<input id="txtamount" type="number" min="0" value="0" name="txtamount" placeholder="Amount" readonly required/>
										</div>
									</div>
								</div>
								<input type="submit" name="new_bar_purchase" class="button success pull-right" value="Order a Drink">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	<div class="col-md-8">
		<div class="table-responsive panel shown">
			<h3 class="text-center title">Bar Order List</h3>
			<div class="divider"></div>
				<table class="table table-codensed table-custom">
					<thead>
						<tr>
							<th>Serial No.</th>
							<th>Card ID</th>
							<th>Drink Name</th>
							<th>No of drinks</th>
							<th>Amount</th>
						</tr>
					</thead>
					<tbody>

					<?php 
						$sql = "SELECT o.*,b.bar_item_name FROM tbl_drink_orders as o, tbl_bar_items as b where o.order_date = '".date("Y-m-d")."' and o.bar_item_id = b.bar_item_id order by o.order_id desc";
						$info = $obj_admin->manage_all_info($sql);
						$serial = 1;
						$num_row = $info->rowCount();
						if($num_row==0){
							echo '<tr><td colspan="5" class="alert">No Data found</td></tr>';
						}
						while( $row = $info->fetch(PDO::FETCH_ASSOC) ){
					?>
						<tr>
							<td><?php echo $serial; $serial++; ?></td>
							<td><?php echo $row['card_id']; ?></td>
							<td><?php echo $row['bar_item_name']; ?></td>
							<td><?php echo $row['drinks_no']; ?></td>
							<td><?php echo $row['amount']; ?>/-</td>
						</tr>
					<?php } ?>
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
			$("#taskcardid").autocomplete({
				source: 'searchclients.php',
				minLength: 0,
			});
			$("#txtsearchbox").autocomplete({
				source: 'searchclients.php',
				minLength: 0,
			});
			$('.chk').css({"display":"none"});
		});
	</script>
	<script type="text/javascript">
		$('#txtdrink').on('change', function() {
		    var xmlhttp = new XMLHttpRequest();
			xmlhttp.open("GET","barz.php?bar_item_id="+this.value,false);
			xmlhttp.send(null);
			val = xmlhttp.responseText;
			val = val * $('#txtdrinkno').val();
		    $('#txtamount').val(val);
		});
		$('#txtdrinkno').on('change', function() {
		    var xmlhttp = new XMLHttpRequest();
			xmlhttp.open("GET","barz.php?bar_item_id="+$('#txtdrink').val(),false);
			xmlhttp.send(null);
			val = xmlhttp.responseText;
			val = val * this.value;
		    $('#txtamount').val(val);
		});
	</script>
	<script type="text/javascript">
		setInterval(() => {
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.open("GET","avgtime.php",false);
			xmlhttp.send(null);
			document.getElementById("avgtime").innerHTML = xmlhttp.responseText;
		}, 1000);
	</script>
	<script type="text/javascript">
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