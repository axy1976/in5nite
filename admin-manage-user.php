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
if($user_role != 1){
  header('Location: task-info.php');
}


if(isset($_GET['delete_user'])){
  $action_id = $_GET['device_id'];
/*
  $task_sql = "DELETE FROM task_info WHERE t_user_id = $action_id";
  $delete_task = $obj_admin->db->prepare($task_sql);
  $delete_task->execute();

  $attendance_sql = "DELETE FROM attendance_info WHERE atn_user_id = $action_id";
  $delete_attendance = $obj_admin->db->prepare($attendance_sql);
  $delete_attendance->execute();
*/  
  $sql = "DELETE FROM tbl_device WHERE id = :id";
  $sent_po = "admin-manage-user.php";
  $obj_admin->delete_data_by_this_method($sql,$action_id,$sent_po);
}

$page_name="Admin";
include("include/sidebar.php");

if(isset($_POST['add_new_device'])){
  $error = $obj_admin->add_new_device($_POST);
}

?>



<!--modal for employee add-->
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog mode-color">

    
      <!-- Modal content-->
      <div class="modal-content panel shown">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="sound4.play()">&times;</button>
          <h2 class="modal-title text-center">Add Device Info</h2>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <?php if(isset($error)){ ?>
                <h5 class="alert alert-danger"><?php echo $error; ?></h5>
                <?php } ?>
              <form role="form" action="" method="post" autocomplete="off">
                <div class="form-horizontal">

                  <div class="form-group">
                    <label class="control-label col-sm-4">Device ID </label>
                    <div class="col-sm-6 input">
                      <input type="text" placeholder="Enter Device ID " name="txtdeviceid" list="expense" class="form-control input-custom" id="default" required>
                    </div>
                  </div>
				   <div class="form-group">
                    <label class="control-label col-sm-4">Device Name</label>
                    <div class="col-sm-6 input">
                      <input type="text" placeholder="Enter Name" name="txtname" class="form-control input-custom" required>
                    </div>
                  </div>
                   <div class="form-group">
                    <label class="control-label col-sm-4">Device FB ID</label>
                    <div class="col-sm-6 input">
                      <input type="email" placeholder="Enter FB ID" name="txtfb" class="form-control input-custom" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-4">Device PIN</label>
                    <div class="col-sm-6 input">
                      <input type="number" placeholder="Enter Device PIN" name="txtpin" class="form-control input-custom" required>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="control-label col-sm-4">Arena Number</label>
                    <div class="col-sm-6 input">
                      <input type="number" placeholder="Enter Arena Number" name="txtarena" class="form-control input-custom" required>
                    </div>
                  </div>
				           
                  
                  
                  <div class="form-group">
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-3">
                      <button type="submit" name="add_new_device" class="button success" onclick="sound0.play()">Add Device</button>
                    </div>
                    <div class="col-sm-3">
                      <button type="submit" class="button error" data-dismiss="modal" onclick="sound4.play()">Cancel</button>
                    </div>
                  </div>
                </div>
              </form> 
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>



<!--modal for employee add-->



    <div class="row">
      <div class="col-md-12">
        <div class="row">
            
          <div class="panel shown p-4">
          <?php if(isset($error)){ ?>
          <script type="text/javascript">
            $('#myModal').modal('show');
          </script>
          <?php } ?>
            <?php if($user_role == 1){ ?>
                <div class="btn-group">
                  <button class="button btn-menu" data-toggle="modal" data-target="#myModal" onclick="sound2.play()">Add New Device</button>
                </div>
              <?php } ?>
          <ul class="nav nav-tabs nav-justified">
            <li><a href="manage-admin.php" onclick="sound2.play()">Manage Staff</a></li>
            <li class="active"><a class="button" href="admin-manage-user.php" onclick="sound2.play()">Manage Devices</a></li>
            <li><a href="manage-items.php" onclick="sound2.play()">Manage Items</a></li>
          </ul>
          <div class="gap"></div>
          <div class="table-responsive">
            <table class="table table-codensed table-custom">
              <thead>
                <tr>
                  <th>Serial No.</th>
				          <th>Device ID</th>
                  <th>Device Name</th>
                  <th>Device Email</th>
                  <th>Device Pin</th>
                  <th>Arena Number</th>
			            <th>Details</th>
                </tr>
              </thead>
              <tbody>

              <?php 
                $sql = "SELECT * FROM tbl_device";
                $info = $obj_admin->manage_all_info($sql);
                $serial  = 1;
                $num_row = $info->rowCount();
                  if($num_row==0){
                    echo '<tr><td colspan="7">No Data found</td></tr>';
                  }
                while( $row = $info->fetch(PDO::FETCH_ASSOC) ){
              ?>
                <tr>
                  <td><?php echo $serial; $serial++; ?></td>
                  <td><?php echo $row['deviceid']; ?></td>
				          <td><?php echo $row['devicename']; ?></td>
                  <td><?php echo $row['devicefbid']; ?></td>
                  <td><?php echo $row['devicepin']; ?></td>
                  <td><?php echo $row['devicearena']; ?></td>
                  <td><a title="Update Employee" href="update-employee.php?device_id=<?php echo $row['id']; ?>"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;<a title="Delete" href="?delete_user=delete_user&device_id=<?php echo $row['id']; ?>" onclick=" return check_delete();"><span class="glyphicon glyphicon-trash"></span></a></td>
                </tr>
                
              <?php  } ?>


                
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>


<?php
if(isset($_SESSION['update_user_pass'])){

  echo '<script>alert("Password updated successfully");</script>';
  unset($_SESSION['update_user_pass']);
}
include("include/footer.php");

?>