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
    $obj_admin->update_user_data($_POST,$user_id);
}

if(isset($_POST['btn_user_password'])){
    $obj_admin->update_user_password($_POST,$admin_id);
}

$sql = "SELECT * FROM tbl_clients WHERE user_id='$user_id' ";
$info = $obj_admin->manage_all_info($sql);
$row = $info->fetch(PDO::FETCH_ASSOC);
             
$page_name="Client";
include("include/sidebar.php");
?>
    <div class="row">
      <div class="col-md-12">
        <div class="panel shown mode-color">
          <div class="row">
            <div class="col-md-10 col-md-offset-1">
              <div class="panel shown">
                <h1 class="text-center title" style="margin: 7px;">Edit Client Details</h1>
                <div class="divider"></div>
                  <div class="row">
                    <div class="col-md-7">
                      <form class="form-horizontal" role="form" action="" method="post" autocomplete="off">
                        <div class="form-horizontal">
                          <div class="form-group">
                            <label class="control-label col-sm-4">Card ID </label>
                            <div class="col-sm-6 input">
                              <input type="text" placeholder="Enter Card ID " name="txtcardid" list="expense" value="<?php echo $row['card_id']; ?>" id="default" required readonly>
                            </div>
                          </div>
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
                            <label class="control-label col-sm-4">Client Birthdate</label>
                            <div class="col-sm-6 input">
                              <input type="date" placeholder="Enter Client Birthdate" name="txtdob" value="<?php echo $row['dob']; ?>" required>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-sm-4">Gender</label>
                            <div class="col-sm-6 input">
                              <select name="gender" id="gender" required>
                                <option value="">Select...</option>
                                <option  value="male" <?php if($row['gender']=="Male"){ echo "selected" ;} ?>>Male</option>
                                <option value="female" <?php if($row['gender']=="Female"){ echo "selected" ;} ?>>Female</option>
                                <option value="other" <?php if($row['gender']=="Other"){ echo "selected" ;} ?>>Other</option>
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