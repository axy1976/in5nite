<?php
	require 'authentication.php'; // admin authentication check 

	// auth check
	if(isset($_SESSION['admin_id'])){
		$user_id = $_SESSION['admin_id'];
		$user_name = $_SESSION['admin_name'];
		$security_key = $_SESSION['security_key'];
		if ($user_id != NULL && $security_key != NULL) {
			header('Location: task-info.php');
		}
	}

	if(isset($_POST['login_btn'])){
		$info = $obj_admin->admin_login_check($_POST);
	}

	$page_name="Login";
	include("include/login_header.php");
?>
	<div class="container-full">
		<div class="row">
			<div class="panel immediate">
				<div class="header">
				<h1 class="title center">IN<span class="alert" style="margin:0;padding:0;">5</span>NITE Desk App</h1>
				</div>
				<div class="body">
					<form class="form-horizontal form-custom-login" action="" method="POST">
						<div class="body">
							<div class="input">
								<label for="username">Username</label>
								<input type="text" name="username" id="username" placeholder="username">
							</div>
							<div class="input" ng-class="{'has-error': loginForm.password.$invalid && loginForm.password.$dirty, 'has-success': loginForm.password.$valid}">
								<label for="admin_password">Password</label>
								<input type="password" name="admin_password" id="admin_password" placeholder="password">
							</div>
							<div class="divider"></div>
							<button type="submit" name="login_btn" class="button" data-toggle="popup" data-target="#alarmPopup">Log In <i class="ri-check-line"></i></button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php include("include/footer.php"); ?>
