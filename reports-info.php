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
if ($user_role == 2) {
  header('Location: task-info.php');
}
else if ($user_role == 3) {
  header('Location: waiting-info.php');
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

$host_name='localhost';
$user_name='root';
$password='';
$db_name='etmsh';
$con = mysqli_connect($host_name,$user_name,$password,$db_name);
$fetch_device = "Select * from tbl_device where inuse = 0";
$result = mysqli_query($con,$fetch_device);
$page_name="Reports";
include("include/sidebar.php");
// include('ems_header.php');

?>
<style>
td {
  vertical-align:CENTER;
  text-align: center;
}
</style>
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script type="text/javascript" src="jquery-3.3.1.min.js"></script>
  <script type="text/javascript" src="TimeCircles.js"></script>
  <link rel="stylesheet" type="text/css" href="TimeCircles.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
  <div class="row">
    <div class="col-md-12">
      <div class="panel shown p-4">
        <h3 class="text-center title">Reports</h3>
        <div class="divider"></div>
        <div class="table-responsive">
          <table class="table table-codensed table-custom text-center">
            <thead>
              <tr>
                <th>Serial No.</th>
                <th>Client Name</th>
                <th>Device Name</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Type</th>
              </tr>
            </thead>
            <tbody>
            <?php 
              $sql = "SELECT a.*, b.*, c.* 
                    FROM task_info a
                    INNER JOIN tbl_admin b ON(a.card_id = b.card_id)
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
                <td><?php echo $serial; $serial++; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['devicename']; ?></td>
                <td><?php echo $row['stime']; ?></td>
                <td><?php echo $row['etime']; ?></td>
                <td>
                  <?php if($row['player_type'] == 0) {?>
                    <i class="fa fa-user" aria-hidden="true"></i> 
                  <?php } else if($row['player_type']==1) {?>  
                    <i class="fa fa-users" aria-hidden="true"></i>
                  <?php }?>
                </td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
<?php include("include/footer.php"); ?>