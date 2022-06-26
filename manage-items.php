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

if(isset($_POST['add_new_game'])){
    $error = $obj_admin->add_new_game($_POST);
}

if(isset($_POST['add_new_bar'])){
    $error = $obj_admin->add_new_bar($_POST);
}

?>
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog mode-color">
      <div class="modal-content panel shown">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="sound4.play()">&times;</button>
          <h2 class="modal-title text-center">Add Game Items</h2>
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
                    <label class="control-label col-sm-4">Game Name</label>
                    <div class="col-sm-6">
                      <div class="input">
                        <input type="text" placeholder="Enter Game Name" name="txtgname" class="form-control input-custom" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-4">Game Price</label>
                    <div class="col-sm-6">
                      <div class="input">
                        <input type="number" placeholder="Enter Game Price" name="txtgprice" class="form-control input-custom">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-3">
                      <button type="submit" name="add_new_game" class="button success" onclick="sound0.play()">Add Game</button>
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
  <div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog mode-color">
      <div class="modal-content panel shown">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="sound4.play()">&times;</button>
          <h2 class="modal-title text-center">Add Bar Items</h2>
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
                    <label class="control-label col-sm-4">Item Name</label>
                    <div class="col-sm-6">
                      <div class="input">
                        <input type="text" placeholder="Item Name" name="txtname" class="form-control input-custom" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-4">Item Price</label>
                    <div class="col-sm-6">
                      <div class="input">
                        <input type="number" placeholder="Enter Item Price" name="txtprice" class="form-control input-custom" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-3">
                      <button type="submit" name="add_new_bar" class="button success" onclick="sound0.play()">Add Item</button>
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
            <button class="button btn-menu" data-toggle="modal" data-target="#myModal" onclick="sound2.play()">Add New Game</button>
            <button class="button btn-menu" data-toggle="modal" data-target="#myModal1" onclick="sound2.play()">Add New Item</button>
          </div>
          <?php } ?>
        <ul class="nav nav-tabs nav-justified">
          <li><a href="manage-admin.php" onclick="sound2.play()">Manage Staff</a></li>
          <li><a href="admin-manage-user.php" onclick="sound2.play()">Manage Devices</a></li>
          <li class="active"><a href="manage-items.php" onclick="sound2.play()">Manage Items</a></li>
        </ul>
        <div class="row">
            <div class="col-md-6">
                <div class="panel shown table-responsive">
                    <h1 class="heading text-center">Game Items</h1>
                    <table class="table table-codensed table-custom">
                      <thead>
                        <tr>
                          <th>Serial No.</th>
                          <th>Game ID</th>
                          <th>Game Name</th>
                          <th>Played Counter</th>
                          <th>Price</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                      $sql = "SELECT * FROM tbl_play_items";
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
                          <td><?php echo $row['play_item_id']; ?></td>
                          <td><?php echo $row['play_item_name']; ?></td>
                          <td><?php echo $row['play_item_counter']; ?></td>
                          <td><?php echo $row['play_item_price']; ?></td>
                          <!-- <td><a title="Update Client" href="update-admin.php?user_id=<?php //echo $row['admin_id']; ?>"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;<a title="Delete" href="?delete_user=delete_user&user_id=<?php echo $row['admin_id']; ?>" onclick=" return check_delete();"><span class="glyphicon glyphicon-trash"></span></a></td> -->
                        </tr>
                      <?php  } ?>
                      </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel shown table-responsive">
                    <h1 class="heading text-center">Bar Items</h1>
                    <table class="table table-codensed table-custom">
                        <thead>
                        <tr>
                            <th>Serial No.</th>
                            <th>Item ID</th>
                            <th>Item Name</th>
                            <th>Item Counter</th>
                            <th>Price</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $sql = "SELECT * FROM tbl_bar_items";
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
                            <td><?php echo $row['bar_item_id']; ?></td>
                            <td><?php echo $row['bar_item_name']; ?></td>
                            <td><?php echo $row['bar_item_counter']; ?></td>
                            <td><?php echo $row['bar_item_price']; ?></td>
                            <!-- <td><a title="Update Client" href="update-admin.php?user_id=<?php //echo $row['admin_id']; ?>"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;<a title="Delete" href="?delete_user=delete_user&user_id=<?php echo $row['admin_id']; ?>" onclick=" return check_delete();"><span class="glyphicon glyphicon-trash"></span></a></td> -->
                        </tr>
                        <?php  } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
  <?php
include("include/footer.php");

?>