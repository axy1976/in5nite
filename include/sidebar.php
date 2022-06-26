<!DOCTYPE html>
<html lang="en">
<head>
  <title>Employee Task Management System</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/bootstrap-theme.min.css">
  <link rel="stylesheet" href="assets/bootstrap-datepicker/css/datepicker.css">
  <link rel="stylesheet" href="assets/bootstrap-datepicker/css/datepicker-custom.css">
  <link rel="stylesheet" href="assets/jquery-ui-1.13.0/jquery-ui.css">
  <link rel="stylesheet" href="Demo%20SciUI_files/toastr.css" crossorigin="anonymous">
	<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/custom.css">
	<link href="Demo%20SciUI_files/grid.css" rel="stylesheet" type="text/css">
	<link href="Demo%20SciUI_files/styles.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="TimeCircles.css">
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/custom.js"></script>
  <script src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
  <script src="assets/bootstrap-datepicker/js/datepicker-custom.js"></script>
	<script src="Demo%20SciUI_files/jquery_002.js" crossorigin="anonymous"></script>
	<script src="Demo%20SciUI_files/toastr.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="TimeCircles.js"></script>
  <link rel="icon" href="https://www.vdream.co.in/wp-content/uploads/2021/08/cropped-VDREAM-01-1-32x32.png" sizes="32x32" />
  <link rel="icon" href="https://www.vdream.co.in/wp-content/uploads/2021/08/cropped-VDREAM-01-1-192x192.png" sizes="192x192" />
  <link rel="apple-touch-icon" href="https://www.vdream.co.in/wp-content/uploads/2021/08/cropped-VDREAM-01-1-180x180.png" />
  <meta name="msapplication-TileImage" content="https://www.vdream.co.in/wp-content/uploads/2021/08/cropped-VDREAM-01-1-270x270.png" />
  <script type="text/javascript">
    function check_delete() {
      var check = confirm('Are you sure you want to delete this?');
      if (check) {
        return true;
      } else {
        return false;
      }
    }
  </script>
	<style>
		td {
			vertical-align:CENTER;
			text-align: center;
		}
		.mode-color{
			background-color: #152a3b;
			border: 1px solid rgba(34,69,97,0.4);
		}
    a{
      text-decoration: none;
    }
    ul.ui-autocomplete {
        z-index: 1100;
    }
	</style>
</head>
<body>
  <nav class="navbar sidebar panel shown navbar-fixed-top" role="navigation">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-sidebar-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
		    <a href="index.php" style="font-size:24px;text-decoration:none;">IN<span class="alert" style="margin:0;padding:0;border:0;box-shadow: none;">5</span>NITE VR</a>
      </div>
      <?php
        $user_role = $_SESSION['user_role'];
        if($user_role == 1){
      ?>
      <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-nav-custom">
          <li class="title <?php if($page_name == "Task_Info" ){echo "active";} ?>"><a href="task-info.php">Task Mangement<span style="font-size:16px;margin-top:7px;margin-right:7px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-tasks" ></span></a></li>
          <!-- <li class="title <?php if($page_name == "Reports" ){echo "active";} ?>"><a href="reports-info.php">Reports <span style="font-size:16px;margin-top:7px;margin-right:7px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-calendar"></span></a></li> -->
          <li class="title <?php if($page_name == "waiting" ){echo "active";} ?>"><a href="waiting-info.php">Client Waiting<span style="font-size:16px;margin-top:7px;margin-right:7px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-calendar"></span></a></li>
          <li class="title <?php if($page_name == "Admin" ){echo "active";} ?>"><a href="manage-admin.php">Administration<span style="font-size:16px;margin-top:7px;margin-right:7px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-user"></span></a></li>
          <li class="title <?php if($page_name == "Client" ){echo "active";} ?>"><a href="manage-clients.php">Customers<span style="font-size:16px;margin-top:7px;margin-right:7px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-user"></span></a></li> 
          <li class="title <?php if($page_name == "Payment" ){echo "active";} ?>"><a href="payment.php">Payment<span style="font-size:16px;margin-top:7px;margin-right:7px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-user"></span></a></li>
          <li class="title <?php if($page_name == "Manage-Cards" ){echo "active";} ?>"><a href="manage-cards.php">Membership<span style="font-size:16px;margin-top:7px;margin-right:7px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-user"></span></a></li>
          <li class="title <?php if($page_name == "Cards" ){echo "active";} ?>"><a href="generate-cards.php">Cards<span style="font-size:16px;margin-top:7px;margin-right:7px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-user"></span></a></li>
          <li class="title" ><a href="?logout=logout">Logout<span style="font-size:16px;margin-top:7px;margin-right:7px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-log-out"></span></a></li>
        </ul>
      </div>
      <?php }else if($user_role == 2){ ?>
      <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-nav-custom">
          <li class="title <?php if($page_name == "Task_Info" ){echo "active";} ?>"><a href="task-info.php">Task Mangement<span style="font-size:16px;margin-top:7px;margin-right:7px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-tasks" ></span></a></li>
          <li class="title <?php if($page_name == "Client" ){echo "active";} ?>"><a href="manage-clients.php">Customers<span style="font-size:16px;margin-top:7px;margin-right:7px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-user"></span></a></li>
          <li class="title <?php if($page_name == "Payment" ){echo "active";} ?>"><a href="payment.php">Payment<span style="font-size:16px;margin-top:7px;margin-right:7px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-user"></span></a></li>
          <li class="title" ><a href="?logout=logout">Logout<span style="font-size:16px;margin-top:7px;margin-right:7px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-log-out"></span></a></li>
        </ul>
      </div>
      <?php } else { ?>
      <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-nav-custom">
          <li class="title <?php if($page_name == "waiting" ){echo "active";} ?>"><a href="waiting-info.php">Client Waiting<span style="font-size:16px;margin-top:7px;margin-right:7px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-calendar"></span></a></li>
          <li class="title" ><a href="?logout=logout">Logout<span style="font-size:16px;margin-top:7px;margin-right:7px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-log-out"></span></a></li>
        </ul>
      </div>
      <?php } ?>
    </div>
  </nav>
  <div class="main">