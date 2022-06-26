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
if ($user_role == 2) {
  header('Location: task-info.php');
}

if(isset($_GET['delete_task'])){
  $action_id = $_GET['task_id'];  
  $sql = "DELETE FROM task_info WHERE task_id = :id";
  $sent_po = "task-info.php";
  $obj_admin->delete_data_by_this_method($sql,$action_id,$sent_po);
}

$page_name="waiting";

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
			<a href="waiting-info.php">Reload</a>
		</div>
	</div>
    <div class="row">
      <div class="col-md-12">
        <div class="panel shown p-4">
          <h3 class="text-center title">Standard Queue</h3>
          <div class="divider"></div>
          <div class="table-responsive">
            <table class="table table-codensed table-custom text-center">
              <thead>
                <tr>
                  <th>Serial No.</th>
                  <th>Arena No.</th>
                  <th>Client Name</th>
                  <th>Game Name</th>
                  <th>End Time</th>
                  <th>Type</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $sql = "SELECT a.*, b.*, c.*, d.*
                        FROM task_info a
                        INNER JOIN tbl_clients b ON(a.card_id = b.card_id)
                		INNER JOIN tbl_device c ON(a.deviceid = c.deviceid)
                		INNER JOIN tbl_play_items d ON(a.game_id = d.play_item_id) AND a.task_date = '".date("Y-m-d")."' AND a.status != 2";                
                  $info = $obj_admin->manage_all_info($sql);
                  $serial = 1;
                  $num_row = $info->rowCount();
                  if($num_row==0){
                    echo '<tr><td colspan="7" class="alert">No Data found</td></tr>';
                  }
                  while( $row = $info->fetch(PDO::FETCH_ASSOC) ){
                ?>
                <tr>
					<td><?php echo $row['token_no']; ?></td>
                    <td><?php if($row['deviceid'] != 0){echo $row['devicearena'];} ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['play_item_name']; ?></td>
                    <td>
                        <div class="example stopwatch stopwatch<?php echo $serial; ?>" id="response<?php echo $serial; ?>"></div>
                        <?php if($row['stime'] != "00:00:00"){
                          echo '<script>
                          setInterval(() => {
                            var xmlhttp = new XMLHttpRequest();
                            xmlhttp.open("GET","response.php?task_id='.$row["task_id"].'",false);
                            xmlhttp.send(null);
                            document.getElementById("response'.$serial.'").innerHTML = xmlhttp.responseText;
                          }, 1000);
                        </script>';
                        } ?>
                    </td>
					<td><?php if($row['player_type']==1){?><i class="fa fa-user" aria-hidden="true"></i> <?php } else if($row['player_type']>1) {?>  <i class="fa fa-users" aria-hidden="true"></i> <?php }?></td>
					<td>
                        <?php if($row['stime'] == "00:00:00"){
                            echo '<a class="button success" href="timer.php?task_id='.$row['task_id'].'"><i class="fa fa-play-circle-o text-white" style="font-size: 24px;"></i></a></span>';
                        }?>
                        <!-- <button class="button error stop<?php //echo $serial; ?> pbtx<?php //echo $serial; ?>"><i class="fa fa-pause-circle text-white" style="font-size: 24px;"></i></button> -->
                        <?php if($row['stime'] != "00:00:00" && $row['status'] < 2){
                            echo '<a class="button warning" href="reseter.php?task_id='.$row["task_id"].'"><i class="fa fa-retweet text-white" style="font-size: 24px;"></i></a>';
                        }?>
                    </td>
                </tr>
              	<?php $serial++;} ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="panel shown table-responsive">
			<h3 class="text-center title">Waiting Queue</h3>
			<div class="divider"></div>
				<table class="table table-codensed table-custom text-center">
					<thead>
						<tr>
							<th>Serial No.</th>
							<th>Arena No.</th>
							<th>Client Name</th>
							<th>Game Name</th>
							<th>End Time</th>
							<th>Type</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$sql = "SELECT a.*, b.*, c.*
								FROM task_info a
								INNER JOIN tbl_clients b ON(a.card_id = b.card_id)
								INNER JOIN tbl_play_items c ON(c.play_item_id = a.game_id)
                                WHERE a.task_date = '".date("Y-m-d")."' AND a.deviceid = 0
								ORDER BY a.token_no asc"; 
						$info = $obj_admin->manage_all_info($sql);
						$serial = 1;
						$num_row = $info->rowCount();
						if($num_row==0){
							echo '<tr><td colspan="7" class="alert">No Data found</td></tr>';
						}
						while( $row = $info->fetch(PDO::FETCH_ASSOC) ){
						
						if($row['player_type'] > 1){ ?>
						<tr>
							<td colspan="7">
								<?php for($i=0; $i < $row['player_type']; $i++) { ?>
									<tr>
										<td><?php echo $serial."[<span class='alert'>".($i+1)."</span>]"; ?></td>
										<td><?php if($row['deviceid'] != 0){echo $row['devicearena'];} ?></td>
										<td><?php echo $row['username']; ?></td>
										<td><?php echo $row['play_item_name']; ?></td>
										<?php if($i == 0) {
											echo "<td rowspan=".$row['player_type']."></td>";
										}?>
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
							<td><?php if($row['deviceid'] != 0){echo $row['devicearena'];} ?></td>
							<td><?php echo $row['username']; ?></td>
							<td><?php echo $row['play_item_name']; ?></td>
							<td></td>
							<td>
								<?php if($row['player_type']==1) { ?>
								<i class="fa fa-user" aria-hidden="true"></i>
								<?php } else if($row['player_type']>1) { ?>
								<i class="fa fa-users" aria-hidden="true"></i>
								<?php } ?>
							</td>    
							<td>
							</td>
						</tr>
						<?php } } ?>
					</tbody>
				</table>
			</div>
		</div>
    <script>
        setInterval(() => {
    		var xmlhttp = new XMLHttpRequest();
			xmlhttp.open("GET","assigndevice.php",false);
			xmlhttp.send(null);
        }, 1000);
    </script>
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
			$('.chk').css({"display":"none"});
		});
	</script>
	<script type="text/javascript">
		$('select').on('change', function() {
			$('#txtamount').val(this.value);
		});
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