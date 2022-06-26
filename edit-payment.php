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

$task_id = $_GET['task_id'];



if(isset($_POST['update_task_info'])){
    $obj_admin->update_task_info($_POST,$task_id, $user_role);
}
$host_name='localhost';
		$user_name='root';
		$password='';
		$db_name='etmsh';
		$con = mysqli_connect($host_name,$user_name,$password,$db_name);
$fetch_device = "Select * from tbl_device where inuse = 0";
$result = mysqli_query($con,$fetch_device);

$page_name="Edit Task";
include("include/sidebar.php");

$sql = "SELECT * FROM task_info WHERE task_id='$task_id' ";
$info = $obj_admin->manage_all_info($sql);
$row = $info->fetch(PDO::FETCH_ASSOC);

?>

<!--modal for employee add-->

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


    <div class="row">
      <div class="col-md-12">
        <div class="panel shown mode-color">
          <div class="row">
            <div class="col-md-8 col-md-offset-2">
              <div class="panel shown">
                <h1 class="text-center title" style="padding: 7px;">Edit Task </h1>
					<div class="divider"></div>
                      <div class="row">
                        <div class="col-md-12">
                          <form class="form-horizontal" role="form" action="" method="post" autocomplete="off">
                            <div class="form-group">
			                    <label class="control-label col-sm-3">Card ID</label>
			                    <div class="col-sm-7 input">
			                      <input type="text" placeholder="Card ID" id="card_id" name="card_id" list="expense" class="" value="<?php echo $row['card_id']; ?>" <?php if($user_role != 1){ ?> readonly <?php } ?> val required>
			                    </div>
			                </div>
			                 <div class="form-group row">
								<label class="control-label col-sm-3">Device ID</label>
								<div class="col-sm-7 input">
									<div class="input">
									<select class="" name="txtdeviceid" id="txtdeviceid" required>
										<option value="" selected disabled>Select Device...</option>
										<?php
										while($row1 = mysqli_fetch_array($result))
										{
										?>
										<option value ="<?php echo $row1['deviceid']; ?>"
										<?php 
										if($row['deviceid']==$row1['deviceid'])
										{
											echo "selected";
										}
										?>> <?php echo $row1['devicename']; ?> </option>
										<?php }?>
									</select>
								   </div>
								</div>
							  </div>
			                   <div class="form-group">
								<label class="control-label col-sm-3">Type</label>
								<div class="col-sm-7 input">
								 <select class="" name="txttype" id="txttype" required>
									<option value=""<>Select Type...</option>
									<option value="0"<?php if($row['player_type']==0){echo "selected";} ?>>Single Player</option>
									<option value="1"<?php if($row['player_type']==1){echo "selected";} ?>>Multiplayer</option>
								   </select>
								</div>
							</div>
			                   <div class="form-group">
								<label class="control-label col-sm-3">Duration</label>
								<div class="col-sm-7 input">
								 <select class="" name="txtduration" id="txtduration" required>
									<option value="">Select Duration...</option>
									<option value="0"<?php if($row['duration']==0){echo "selected";} ?>>1/2 Hour</option>
									<option value="1"<?php if($row['duration']==1){echo "selected";} ?>>1 Hour</option>
								   </select>
								</div>
								</div>
			                  

			                 


			                 
                            
                            <div class="form-group">
                            </div>
                            <div class="form-group">
                              <div class="col-sm-offset-5">
                                <button type="submit" name="update_task_info" class="button success">Update Now</button>
                              </div>
                            </div>
                          </form> 
                        </div>
                      </div>

              </div>
            </div>
          </div>

        </div>
      </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

	<script type="text/javascript">
	  flatpickr('#t_start_time', {
	    enableTime: true
	  });

	  flatpickr('#t_end_time', {
	    enableTime: true
	  });

	</script>


<?php

include("include/footer.php");

?>

