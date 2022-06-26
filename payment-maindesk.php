<?php
require 'authentication.php'; // admin authentication check 

date_default_timezone_set("Asia/Calcutta");

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

if(isset($_POST['add_new_payment'])){
	$obj_admin->add_new_payment($_POST);
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
		<script>
			setInterval(() => {
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.open("GET","avgtime.php",false);
				xmlhttp.send(null);
				document.getElementById("avgtime").innerHTML = xmlhttp.responseText;
			}, 1000);
		</script>
		<div class="menu horizontal button text-center" style="background:none;border:0;">
			<a href="customer-maindesk.php">Customer</a>
			<a href="player_queue.php">Player Queue</a>
			<a href="payment-maindesk.php" class="active">Payment</a>
			<a href="bar-item-maindesk.php">BAR</a>
		</div>
	</div>
	<div class="panel shown row">
		<div class="col-md-4 mx-auto">
			<div class="panel shown modal-body">
			<h2 class="title text-center">Payment Module</h2>
			<div class="divider"></div>
				<div class="row">
					<div class="col-sm-offset-1 col-sm-10">
						<form role="form" action="" method="post">
							<div class="form-horizontal">
								<div class="form-group row">
									<div class="col-sm-12">
										<div class="input">
											<?php $cid = "";
											if(isset($_GET['card_id'])){
												$cid = $_GET['card_id'];
											} ?>
											<input id="taskcardid" type="number" name="txtcardid" placeholder="Card ID" value="<?= $cid ?>" required/>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-12">
										<div class="input">
											<select name="pay_mode" id="pay_mode" required>
												<option value="" disabled selected>Select...</option>
												<option value="Cash">Cash</option>
												<option value="Online">Online</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-12">
										<div class="input">
											<input id="txtamount" type="number" min="1" name="txtamount" placeholder="Amount" required/>
										</div>
									</div>
								</div>
								<div class="form-group row chk">
									<div class="col-sm-12">
										<div class="input">
											<input id="txtgivenamount" type="number" min="1" name="txtamountgiven" placeholder="Accepted Amount"/>
										</div>
									</div>
								</div>
								<div class="form-group row chk">
									<div class="col-sm-12">
										<div class="input">
											<input id="txtamountchange" type="number" min="0" name="txtamountchange" placeholder="Change Amount" readonly/>
										</div>
									</div>
								</div>
								<input type="submit" name="add_new_payment" class="button success pull-right" onclick="sound0.play()" value="Payment">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	<div class="col-md-8">
	    <div class="panel shown">
    		<div class="input">
        		<h2 class="title text-center">Search Card Detail</h2>
        		<div class="divider"></div>
				<div class="d-flex justify-content-center">
					<input type='text' placeholder="Card ID" name="txtsearchbox" id="txtsearchbox">
					<button name="searchbox" class="button warning pull-right" onclick="searchbox()">Search</button>
				</div>
    		</div>
		</div>
		<div class="table-responsive panel shown">
			<h3 class="text-center title">Client List</h3>
			<div class="divider"></div>
			<table class="table table-codensed table-custom">
				<thead>
					<tr>
						<th>Card ID</th>
						<th>Username</th>
						<th>Email</th>
						<th>Phone</th>
						<th>DOB</th>
						<th>Gender</th>
						<th>Amount</th>
					</tr>
				</thead>
				<tbody id="searchedbox">
					<tr>
						<td colspan="7" class="alert">No Data</td>
					</tr>
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
			$("#taskcardid").autocomplete({
				source: 'searchclients.php',
				minLength: 0,
			});
			$("#tskcardid").autocomplete({
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
		$('select').on('change', function() {
			if(this.value == "Cash"){
				$('.chk').css({"display":"block"});
			}else{
				$('.chk').css({"display":"none"});
			}
		});
		$('#txtgivenamount').on('change', function(){
		    if(this.value != " "){
		        if((this.value - $('#txtamount').val())>0){
		            $('#txtamountchange').val((this.value - $('#txtamount').val()));
		        }
		    }
		});
	</script>
	<script>
	    function searchbox(){
	        let val = document.getElementById('txtsearchbox').value;
	        var xmlhttp = new XMLHttpRequest();
			xmlhttp.open("GET","searchbox.php?cardid="+val+"&amount=0",false);
			xmlhttp.send(null);
			document.getElementById("searchedbox").innerHTML = xmlhttp.responseText;
	    }
	</script>
	<script type="text/javascript">
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