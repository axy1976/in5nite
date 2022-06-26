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
  $sql = "DELETE FROM tbl_clients WHERE user_id = :id";
  $sent_po = "manage-clients.php";
  $obj_admin->delete_data_by_this_method($sql,$action_id,$sent_po);
}

$page_name="Client";
include("include/sidebar.php");

if(isset($_POST['add_new_client'])){
  $error = $obj_admin->add_new_user($_POST);
}

?>
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog mode-color">
      <div class="modal-content panel shown">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="sound4.play()">&times;</button>
          <h2 class="modal-title text-center">Add Clients Info</h2>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <?php if(isset($error)){ ?>
                <h5 class="alert alert-danger"><?php echo $error; ?></h5>
              <?php } ?>
              <form role="form" action="" method="post">
                <div class="form-horizontal">
                  <div class="form-group">
                    <label class="control-label col-sm-4">Card ID </label>
                    <div class="col-sm-6 input">
                      <input id="txtcardid" type="text" name="txtcardid" class="form-control input-custom" placeholder="Card ID" required/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-4">Client Name</label>
                    <div class="col-sm-6">
                      <div class="input">
                        <input type="text" placeholder="Enter Client Name" name="txtname" class="form-control input-custom" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-4">Client Email</label>
                    <div class="col-sm-6">
                      <div class="input">
                        <input type="email" placeholder="Enter Client Email" name="txtemail" class="form-control input-custom" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-4">Client Number</label>
                    <div class="col-sm-6">
                      <div class="input">
                        <input type="number" placeholder="Enter Client Number" name="txtnumber" class="form-control input-custom" required>
                      </div>
                    </div>
                  </div>
				          <div class="form-group">
                    <label class="control-label col-sm-4">Client Birthdate</label>
                    <div class="col-sm-6 input">
                      <input type="date" placeholder="Enter Client Birthdate" name="txtdob" class="form-control input-custom" required>
                    </div>
                  </div>
                  <div class="form-group">
				            <label class="control-label col-sm-4">Gender</label>
                    <div class="col-sm-6">
                      <div class="input">
                        <select class="form-control input-custom" name="gender" id="gender" required>
                          <option value="">Select...</option>
                          <option value="Male">Male</option>
                          <option value="Female">Female</option>
                          <option value="Other">Other</option>
						            </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-3">
                      <button type="submit" name="add_new_client" class="button success" onclick="sound0.play()">Add Client</button>
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
          <?php if($user_role == 1 || $user_role == 2){ ?>
          <div class="btn-group">
            <button class="button btn-menu" data-toggle="modal" data-target="#myModal" onclick="sound2.play()">Add New Client</button>
          </div>
          <?php } ?>
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
					<!--<a title="Delete" href="?delete_user=delete_user&user_id=<?php echo $row['user_id']; ?>" onclick=" return check_delete();"><span class="glyphicon glyphicon-trash"></span></a>-->
					<?php } ?>
				</td>
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