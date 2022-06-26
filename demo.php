<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/custom.js"></script>
	<script src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script src="assets/bootstrap-datepicker/js/datepicker-custom.js"></script>
	<script src="Demo%20SciUI_files/jquery_002.js" crossorigin="anonymous"></script>
	<script src="Demo%20SciUI_files/toastr.js" crossorigin="anonymous"></script>
	<script src="Demo%20SciUI_files/howler.js" crossorigin="anonymous"></script>
	<script src="Demo%20SciUI_files/jquery.js"></script>
	<script src="Demo%20SciUI_files/progressbar.js"></script>
	<script type="text/javascript" src="TimeCircles.js"></script>
	<script src="Demo%20SciUI_files/base.js" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
<div class="col-md-4">
			<div class="panel shown modal-body">
				<h2 class="title text-center"> Add player gameplay</h2>
				<div class="divider"></div>
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<form role="form" action="" method="post" autocomplete="off">
							<div class="form-horizontal">
								<div class="form-group row">
									<div class="col-sm-12">
										<div class="input autocomplete">
											<input type="text" name="txtcardid" id="txtcardid" placeholder="Card ID Of Client" list="expense" required>
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
												<option value="0">30 Minutes</option>
												<option value="1">60 Minutes</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group">
									<button type="submit" name="add_task_post" class="button success pull-right" onclick="sound0.play()">Add Player</button>
								</div>
							</div>
						</form> 
					</div>
				</div>
			</div>
		</div>
	<script src="assets/jquery-ui-1.13.0/external/jquery/jquery.js"></script>
    <script src="assets/jquery-ui-1.13.0/jquery-ui.js"></script>
	<script>
		$(document).ready(function(){
			$("#txtcardid").autocomplete({
				source: 'search.php',
				minLength: 0,
			});
			$("#taskcardid").autocomplete({
				source: 'searchclients.php',
				minLength: 0,
			});
		});
	</script>
</body>
</html>