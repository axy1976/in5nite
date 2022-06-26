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
  if($user_role == 2) {
    header('Location: customer-maindesk.php');
  }else{
    header('Location: waiting-info.php');
  }
}

if(isset($_GET['delete_task'])){
  $action_id = $_GET['task_id'];
  $sql = "DELETE FROM task_info WHERE task_id = :id";
  $sent_po = "task-info.php";
  $obj_admin->delete_data_by_this_method($sql,$action_id,$sent_po);
}

if(isset($_POST['add_task_post'])){
  $obj_admin->add_new_task($_POST);
}
include('config.php');
$fetch_device = "Select * from tbl_device where inuse = 0";
$result = mysqli_query($conn,$fetch_device);
$page_name="Task_Info";
include("include/sidebar.php");
// include('ems_header.php');

?>

  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog add-category-modal mode-color">
      <div class="panel shown modal-content">
        <div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal" onclick="sound4.play()">&times;</button>
			    <h2 class="modal-title text-center">Assign New Task</h2>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <form role="form" action="" method="post" autocomplete="off">
                <div class="form-horizontal">
                  <div class="form-group row">
                    <div class="col-sm-12">
                      <div class="input autocomplete">
                        <input type="text" name="txtcardid" id="taskcardid" placeholder="Card ID Of Client" list="expense" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-12">
						          <div class="input">
						            <select name="txtdeviceid" id="txtdeviceid" required>
                          <option value="" selected disabled>Select Device...</option>
                          <?php while($row = mysqli_fetch_array($result)) { ?>
                          <option value ="<?php echo $row['deviceid']; ?>"> <?php echo $row['devicename']; ?> </option>
                          <?php }?>
                        </select>
					            </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-12">
						          <div class="input">
                        <select name="txttype" id="txttype" required>
                          <option value="" selected disabled>Select Type...</option>
                          <option value="0">Single Player</option>
                          <option value="1">Multi Player</option>
                        </select>
					            </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-12">
						          <div class="input">
                        <select name="txtduration" id="txtduration" required>
                          <option value="" selected disabled>Select Duration...</option>
                          <option value="0">1/2 Hour</option>
                          <option value="1">1 Hour</option>
                        </select>
					            </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-3">
                      <button type="submit" name="add_task_post" class="button success" onclick="sound0.play()">Assign Task</button>
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
      <div class="panel shown p-4">
        <!-- <div class="row">
          <div class="btn-group pull-right m-3">
            <div class="btn-group">
              <button class="button btn-menu" data-toggle="modal" data-target="#myModal" onclick="sound2.play()">Assign New Task</button>
            </div>
          </div>
        </div> -->
        <div class="header">
          <h1 class="title text-center">Task Management Section</h1>
        </div>
        <div class="table-responsive">
        <table class="table table-codensed table-custom text-center">
          <thead>
            <tr>
              <th>Serial No.</th>
              <th>Client Name</th>
              <th>Device Name</th>
              <th>Date</th>
              <th>Type</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $sql = "SELECT a.*, b.*, c.* 
                    FROM task_info a
                    INNER JOIN tbl_clients b ON(a.card_id = b.card_id)
                    INNER JOIN tbl_device c ON(a.deviceid = c.deviceid)
                    ORDER BY a.task_id DESC"; 
              $info = $obj_admin->manage_all_info($sql);
              $serial  = 1;
              $num_row = $info->rowCount();
              if($num_row==0){
                echo '<tr><td colspan="6" class="alert">No Data found</td></tr>';
              }
              while( $row = $info->fetch(PDO::FETCH_ASSOC) ){
            ?>
            <tr>
              <td><?php echo $serial++; ?></td>
              <td><?php echo $row['username']; ?></td>
              <td><?php echo $row['devicename']; ?></td>
              <td><?php echo $row['task_date']; ?></td>
              <td>
                <?php if($row['player_type']==1) { ?>
                  <i class="fa fa-user" aria-hidden="true"></i>
                <?php } else if($row['player_type']>1) { ?>
                  <i class="fa fa-users" aria-hidden="true"></i>
                <?php } ?>
              </td>    
              <td>
                <a title="Update Task" href="edit-task.php?task_id=<?php echo $row['task_id'];?>" onclick="sound2.play()"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;
                <a title="View" href="task-details.php?task_id=<?php echo $row['task_id']; ?>" onclick="sound2.play()"><span class="glyphicon glyphicon-folder-open"></span></a>&nbsp;&nbsp;
                <?php if($user_role == 1){ ?>
                  <a title="Delete" href="?delete_task=delete_task&task_id=<?php echo $row['task_id']; ?>" onclick="return check_delete();"><span class="glyphicon glyphicon-trash"></span></a>
                <?php } ?>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
<?php include("include/footer.php"); ?>