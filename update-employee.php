
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
if ($user_role != 1) {
  header('Location: task-info.php');
}

$device_id = $_GET['device_id'];

if(isset($_POST['update_current_device'])){

    $obj_admin->update_device_data($_POST,$device_id);
}

if(isset($_POST['btn_user_password'])){

    $obj_admin->update_user_password($_POST,$admin_id);
}



$sql = "SELECT * FROM tbl_device WHERE id='$device_id' ";
$info = $obj_admin->manage_all_info($sql);
$row = $info->fetch(PDO::FETCH_ASSOC);
        
$page_name="Admin";
include("include/sidebar.php");
?>

    <div class="row">
      <div class="col-md-12">
        <div class="panel shown mode-color">
          <ul class="nav nav-tabs nav-justified nav-tabs-custom">
            <li><a href="manage-admin.php" onclick="sound2.play()">Manage Clients</a></li>
            <li><a href="admin-manage-user.php" onclick="sound2.play()">Manage Devices</a></li>
          </ul>
          <div class="gap"></div>

          <div class="row">
            <div class="col-md-10 col-md-offset-1">
              <div class="panel shown">
                <h3 class="text-center title" style="margin: 7px;">Edit Devices</h3><br>


                      <div class="row">
                        <div class="col-md-7">
                          <form class="form-horizontal" role="form" action="" method="post" autocomplete="off">
                           <div class="form-horizontal">

                  <div class="form-group">
                    <label class="control-label col-sm-4">Device ID </label>
                    <div class="col-sm-6 input">
                      <input type="text" placeholder="Enter Device ID " name="txtdeviceid" value="<?php echo $row['deviceid']; ?>" list="expense" id="default" required>
                    </div>
                  </div>
				   <div class="form-group">
                    <label class="control-label col-sm-4">Device Name</label>
                    <div class="col-sm-6 input">
                      <input type="text" placeholder="Enter Name" name="txtname" value="<?php echo $row['devicename']; ?>" required>
                    </div>
                  </div>
                   <div class="form-group">
                    <label class="control-label col-sm-4">Device FB ID</label>
                    <div class="col-sm-6 input">
                      <input type="email" placeholder="Enter FB ID" name="txtfb" value="<?php echo $row['devicefbid']; ?>" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-4">Device PIN</label>
                    <div class="col-sm-6 input">
                      <input type="number" placeholder="Enter Device PIN" name="txtpin" value="<?php echo $row['devicepin']; ?>" required>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="control-label col-sm-4">Arena Number</label>
                    <div class="col-sm-6 input">
                      <input type="number" placeholder="Enter Arena Number" name="txtarena" value="<?php echo $row['devicearena']; ?>" required>
                    </div>
                  </div>
                            <div class="form-group">
                            </div>
                            <div class="form-group">
                              <div class="col-sm-offset-4 col-sm-3">
                                <button type="submit" name="update_current_device" class="button success">Update Now</button>
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


<?php

include("include/footer.php");

?>

<script type="text/javascript">

$('#emlpoyee_pass_btn').click(function(){
    $('#employee_pass_cng').toggle('slow');
});

</script>