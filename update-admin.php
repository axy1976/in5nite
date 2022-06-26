<?php

require 'authentication.php'; // admin authentication check 

// auth check
$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];
if ($user_id == NULL || $security_key == NULL) {
  header('Location: index.php');
}

$user_id = $_GET['user_id'];

if(isset($_POST['update_current_user'])){
  $obj_admin->update_admin_data($_POST,$user_id);
}

if(isset($_POST['btn_user_password'])){
  $obj_admin->update_user_password($_POST,$admin_id);
}

$sql = "SELECT * FROM tbl_admin WHERE admin_id='$user_id' ";
$info = $obj_admin->manage_all_info($sql);
$row = $info->fetch(PDO::FETCH_ASSOC);
             
$page_name="Admin";
include("include/sidebar.php");
?>

    <div class="row">
      <div class="col-md-12">
        <div class="panel shown mode-color">
          <ul class="nav nav-tabs nav-justified">
            <li><a href="manage-admin.php" onclick="sound2.play()">Manage Staffs</a></li>
            <li><a href="admin-manage-user.php" onclick="sound2.play()">Manage Devices</a></li>
          </ul>
          <div class="row">
            <div class="col-md-10 col-md-offset-1">
              <div class="panel shown">
                <h1 class="text-center title" style="margin: 7px;">Edit Staff Details</h1>
                <div class="divider"></div>
                  <div class="row">
                    <div class="col-md-7">
                      <form class="form-horizontal" role="form" action="" method="post" autocomplete="off">
                        <div class="form-horizontal">
                          <div class="form-group">
                            <label class="control-label col-sm-4">Client Name</label>
                            <div class="col-sm-6 input">
                              <input type="text" placeholder="Enter Client Name" name="txtname" value="<?php echo $row['username']; ?>" required>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-sm-4">Client Email</label>
                            <div class="col-sm-6 input">
                              <input type="email" placeholder="Enter Client Email" name="txtemail" value="<?php echo $row['email']; ?>" required>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-sm-4">Client Number</label>
                            <div class="col-sm-6 input">
                              <input type="number" placeholder="Enter Client Number" name="txtnumber" value="<?php echo $row['phone']; ?>" required>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-sm-4">Staff Role</label>
                            <div class="col-sm-6 input">
                              <select name="user_role" id="user_role" required>
                                <option value="">Select...</option>
                                <option value="1" <?php if($row['user_role']==1){ echo "selected" ;} ?>>Admin</option>
                                <option value="2" <?php if($row['user_role']==2){ echo "selected" ;} ?>>Reception</option>
                                <option value="3" <?php if($row['user_role']==3){ echo "selected" ;} ?>>Ground Staff</option>
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-3">
                              <button type="submit" name="update_current_user" class="button success">Update Now</button>
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
        </div>
      </div>
    </div>
<?php include("include/footer.php"); ?>
