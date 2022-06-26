<?php
    require 'authentication.php';
	$page_name="Player Registration";
	include("include/login_header.php");

	if(isset($_POST['add_new_client'])){
		$error = $obj_admin->add_new_user($_POST);
	}
?>
	<div class="container-full">
		<div class="row">
			<div class="panel immediate">
				<div class="header">
				<h1 class="title center">IN<span class="alert" style="margin:0;padding:0;">5</span>NITE player Registration</h1>
				</div>
				<div class="body">
				    <form role="form" class="form-horizontal form-custom-login" action="" method="post">
						<div class="body">
							<div class="input">
								<label for="txtcardid">CARD ID</label>
								<input id="txtcardid" type="text" name="txtcardid" placeholder="Card ID" required/>
							</div>
							<div class="input">
								<label for="txtname">Player Name</label>
								<input type="text" placeholder="Name" name="txtname" required>
							</div>
							<div class="input">
								<label for="txtemail">Player Email</label>
								<input type="email" placeholder="Email" name="txtemail" required>
							</div>
							<div class="input">
								<label for="txtnumber">Player Contact no</label>
								<input type="number" placeholder="Phone No" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" name="txtnumber" required>
							</div>
							<div class="input">
								<label for="txtdob">Player DOB</label>
								<input type="date" placeholder="Birthdate" id="dob" name="txtdob" required>
							</div>
							<div class="input">
								<label for="gender">Gender</label>
								<select name="gender" id="gender" required>
									<option value="" disabled selected>Select...</option>
									<option value="Male">Male</option>
									<option value="Female">Female</option>
									<option value="Other">Other</option>
								</select>
							</div>
                            <div class="input checkbox p-3">
                                <input type="checkbox" id="test3" name="test3" required/>
                                <label for="test3">Accept our <a href="termsandconditions.php" class="info">Terms & Conditions</a> AND <a href="privacypolicy.php" class="info">Privacy Policy</a></label>
                            </div>
							<button type="submit" name="add_new_client" class="button success pull-right" onclick="sound0.play()">Register</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<script>
	    function chalu(){
			var v = '<?=date('Y')?>';
			var minv = v - 13;
			var maxv = v - 100;
			document.getElementById('dob').max = minv+"<?=date('-m-d')?>";
			document.getElementById('dob').min = maxv+"<?=date('-m-d')?>";
		}
		chalu();
    </script>
	<script>
	    <?php
			if(isset($_SESSION['messagex'])){
				echo "toastr.success('".$_SESSION['messagex']."','Successfully!');";
				unset($_SESSION['messagex']);
			}
			if(isset($_SESSION['messagey'])){
				echo "toastr.error('".$_SESSION['messagey']."','Alert!');";
				unset($_SESSION['messagey']);
			}
		?>
	</script>
<?php include("include/footer.php"); ?>
