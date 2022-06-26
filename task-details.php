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
if ($user_role == 3) {
header('Location: waiting-info.php');
}
$task_id = $_GET['task_id'];

if(isset($_POST['update_task_info'])){
    $obj_admin->update_task_info($_POST,$task_id, $user_role);
}

$page_name="Task_Info";
include("include/sidebar.php");

$sql = "SELECT a.*, b.username 
FROM task_info a
LEFT JOIN tbl_admin b ON(a.t_user_id = b.admin_id)
WHERE task_id='$task_id'";
$info = $obj_admin->manage_all_info($sql);
$row = $info->fetch(PDO::FETCH_ASSOC);

?>

    <div class="row">
      	<div class="col-md-12">
        	<div class="panel shown mode-color">
          		<div class="row">
            		<div class="col-md-8 col-md-offset-2">
              			<div class="panel shown">
                			<h3 class="text-center title" style="padding: 7px;">Task Details </h3><br>
							<div class="row">
								<div class="col-md-12">
									<div class="table-responsive">
										<table class="table table-codensed">
											<tbody>
												<tr>
													<td>Task Title</td><td><?php echo $row['t_title']; ?></td>
												</tr>
												<tr>
													<td>Description</td><td><?php echo $row['t_description']; ?></td>
												</tr>
												<tr>
													<td>Start Time</td><td><?php echo $row['t_start_time']; ?></td>
												</tr>
												<tr>
													<td>End Time</td><td><?php echo $row['t_end_time']; ?></td>
												</tr>
												<tr>
													<td>Assign To</td><td><?php echo $row['fullname']; ?></td>
												</tr>
												<tr>
													<td>Status</td>
													<td>
														<?php  if($row['status'] == 1){
																echo "In Progress";
														}elseif($row['status'] == 2){
																echo "Completed";
														}else{
															echo "Incomplete";
														} ?>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
									<div class="form-group">
										<div class="col-sm-3">
											<a title="Update Task" class="button success" href="task-info.php"><span>Go Back</span></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php include("include/footer.php"); ?>