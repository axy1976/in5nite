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
  $action_id = $_GET['user_id'];
/*
  $task_sql = "DELETE FROM task_info WHERE t_user_id = $action_id";
  $delete_task = $obj_admin->db->prepare($task_sql);
  $delete_task->execute();

  $attendance_sql = "DELETE FROM attendance_info WHERE atn_user_id = $action_id";
  $delete_attendance = $obj_admin->db->prepare($attendance_sql);
  $delete_attendance->execute();
 */
  $sql = "DELETE FROM tbl_admin WHERE user_id = :id";
  $sent_po = "admin-manage-user.php";
  $obj_admin->delete_data_by_this_method($sql,$action_id,$sent_po);
}

$page_name="Admin";
include("include/sidebar.php");

if(isset($_POST['add_new_staff'])){
  $error = $obj_admin->add_new_staff($_POST);
}

?>
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog mode-color">
      <div class="modal-content panel shown">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="sound4.play()">&times;</button>
          <h2 class="modal-title text-center">Add New Member</h2>
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
                    <label class="control-label col-sm-4">Staff Name</label>
                    <div class="col-sm-6">
                      <div class="input">
                        <input type="text" placeholder="Staff Name" name="txtname" class="form-control input-custom" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-4">Staff Email</label>
                    <div class="col-sm-6">
                      <div class="input">
                        <input type="email" placeholder="Staff Email" name="txtemail" class="form-control input-custom" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-4">staff Number</label>
                    <div class="col-sm-6">
                      <div class="input">
                        <input type="number" placeholder="Staff Mobile Number" name="txtnumber" class="form-control input-custom" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-4">password</label>
                    <div class="col-sm-6">
                      <div class="input">
                        <input type="text" placeholder="Enter Password" name="txtpass" class="form-control input-custom" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-4">Type</label>
                    <div class="col-sm-6">
                      <div class="input">
                        <select name="txtrole" id="txtrole" required>
                          <option value="" selected disabled>Select role...</option>
                          <option value="1">Administrator</option>
                          <option value="2">Receptionist</option>
                          <option value="3">onGround Staff</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-3">
                      <button type="submit" name="add_new_staff" class="button success" onclick="sound0.play()">Add Member</button>
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
            <button class="button btn-menu" data-toggle="modal" data-target="#myModal" onclick="sound2.play()">Add New Staff</button>
          </div>
          <?php } ?>
        <ul class="nav nav-tabs nav-justified">
          <li class="active"><a href="manage-admin.php" onclick="sound2.play()">Manage Staff</a></li>
          <li><a href="admin-manage-user.php" onclick="sound2.play()">Manage Devices</a></li>
          <li><a href="manage-items.php" onclick="sound2.play()">Manage Items</a></li>
        </ul>
        <div class="table-responsive">
          <table class="table table-codensed table-custom">
            <thead>
              <tr>
                <th>Serial No.</th>
                <th>Username</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Details</th>
              </tr>
            </thead>
            <tbody>

            <?php 
              $sql = "SELECT * FROM tbl_admin WHERE user_role != 1";
              $info = $obj_admin->manage_all_info($sql);
              $serial  = 1;
              $num_row = $info->rowCount();
                if($num_row==0){
                  echo '<tr><td colspan="5">No Data found</td></tr>';
                }
              while( $row = $info->fetch(PDO::FETCH_ASSOC) ){
            ?>
              <tr>
                <td><?php echo $serial; $serial++; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><a title="Update Client" href="update-admin.php?user_id=<?php echo $row['admin_id']; ?>"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;<a title="Delete" href="?delete_user=delete_user&user_id=<?php echo $row['admin_id']; ?>" onclick=" return check_delete();"><span class="glyphicon glyphicon-trash"></span></a></td>
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