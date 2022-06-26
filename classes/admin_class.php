<?php
class Admin_Class
{

	/* -------------------------set_database_connection_using_PDO---------------------- */
	
	public function __construct()
	{ 
        $host_name='localhost';
		$user_name='root';
		$password='';
		$db_name='iqjdhyaf_in5nite';
		try{
			$connection=new PDO("mysql:host={$host_name}; dbname={$db_name}", $user_name,  $password);
			$this->db = $connection;
		} catch (PDOException $message ) {
			echo $message->getMessage();
		}
	}

	/* ------------------------------- test_form_input_data ----------------------------------- */
	
	public function test_form_input_data($data)
	{
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
		return $data;
	}
 
	/* --------------------------------- Admin Login Check -------------------------------------- */

    public function admin_login_check($data)
	{
        $upass = $this->test_form_input_data($data['admin_password']);
		$username = $this->test_form_input_data($data['username']);
        try
		{
			$stmt = $this->db->prepare("SELECT * FROM tbl_admin WHERE username=:uname AND password=:upass LIMIT 1");
			$stmt->execute(array(':uname'=>$username, ':upass'=>$upass));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() > 0)
			{
          		session_start();
	            $_SESSION['admin_id'] = $userRow['admin_id'];
	            $_SESSION['name'] = $userRow['username'];
	            $_SESSION['security_key'] = 'rewsgf@%^&*nmghjjkh';
	            $_SESSION['user_role'] = $userRow['user_role'];
	            $_SESSION['temp_password'] = $userRow['temp_password'];
          		if($userRow['temp_password'] == null){
	                header('Location: task-info.php');
          		}else{
          			header('Location: changePasswordForEmployee.php');
          		}
			}else{
				$message = 'Invalid user name or Password';
				return $message;
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
    }

    public function change_password_for_employee($data)
	{
    	$password  = $this->test_form_input_data($data['password']);
		$re_password = $this->test_form_input_data($data['re_password']);
		$user_id = $this->test_form_input_data($data['user_id']);
		$final_password = $password;
		$temp_password = '';
		if($password == $re_password){
			try{
				$update_user = $this->db->prepare("UPDATE tbl_admin SET password = :x, temp_password = :y WHERE user_id = :id ");
				$update_user->bindparam(':x', $final_password);
				$update_user->bindparam(':y', $temp_password);
				$update_user->bindparam(':id', $user_id);
				$update_user->execute();
				$stmt = $this->db->prepare("SELECT * FROM tbl_admin WHERE user_id=:id LIMIT 1");
				$stmt->execute(array(':id'=>$user_id));
				$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
		        if($stmt->rowCount() > 0){
					session_start();
					$_SESSION['admin_id'] = $userRow['admin_id'];
					$_SESSION['name'] = $userRow['username'];
					$_SESSION['security_key'] = 'rewsgf@%^&*nmghjjkh';
					$_SESSION['user_role'] = $userRow['user_role'];
				    $_SESSION['temp_password'] = $userRow['temp_password'];
				    header('Location: task-info.php');
			    }
			}catch (PDOException $e) {
				echo $e->getMessage();
			}
		}else{
			$message = 'Sorry !! Password Can not match';
            return $message;
		}
    }

	/* ----------------------------------- Admin Logout ----------------------------------- */

    public function admin_logout()
	{
		session_start();
		unset($_SESSION['admin_id']);
		unset($_SESSION['admin_name']);
		unset($_SESSION['security_key']);
		unset($_SESSION['user_role']);
		header('Location: index.php');
    }

	/*---------------------------------- add_new_user ----------------------------------------*/

	public function add_new_user($data)
	{
		$user_cardid  = $this->test_form_input_data($data['txtcardid']);
		$user_username = $this->test_form_input_data($data['txtname']);
		$user_email = $this->test_form_input_data($data['txtemail']);
		$user_phone = $this->test_form_input_data($data['txtnumber']);
		$user_dob = $this->test_form_input_data($data['txtdob']);
		$user_gender = $this->test_form_input_data($data['gender']);
		if($this->test_form_input_data($data['card_type']) != null) {
			$card_type = $this->test_form_input_data($data['card_type']);
		}else{
			// $stmt = $this->db->prepare("SELECT * FROM tbl_membership WHERE card_title='Prime' LIMIT 1");
			// $stmt->execute();
			// $card_type = $stmt->fetch(PDO::FETCH_ASSOC)['id'];
			$card_type = "Prime";
		}
		$stmt = $this->db->prepare("SELECT * FROM tbl_cards WHERE card_id=:id and is_assigned = 0 LIMIT 1");
		$stmt->execute(array(':id'=>$user_cardid));
		if($stmt->rowCount() > 0) {
			if(strlen($user_phone) == 10) {
				try{
					$add_user = $this->db->prepare("INSERT INTO tbl_clients (card_id, username, email,  phone, dob, gender) VALUES (:x, :y, :z, :a, :b, :c) ");
		
					$add_user->bindparam(':x', $user_cardid);
					$add_user->bindparam(':y', $user_username);
					$add_user->bindparam(':z', $user_email);
					$add_user->bindparam(':a', $user_phone);
					$add_user->bindparam(':b', $user_dob);
					$add_user->bindparam(':c', $user_gender);
		
					$add_user->execute();
					$assign_card = $this->db->prepare("UPDATE tbl_cards SET is_assigned = 1, card_type = :cardtype WHERE card_id = :id ");
		
					$assign_card->bindparam(':id', $user_cardid);
					$assign_card->bindparam(':cardtype', $card_type);
					
					$assign_card->execute();
					$_SESSION['messagex'] = "Registered Successfully !";
				}catch (PDOException $e) {
					echo $e->getMessage();
					$_SESSION['messagey'] = "Please input data correctly !";
				}
			} else {
				$_SESSION['messagey'] = "Phone no should be 10 digits !";
			}
		} else {
			$_SESSION['messagey'] = "Card id assigned or invalid !";
		}
	}

	public function add_new_staff($data)
	{
		$staff_name = $this->test_form_input_data($data['txtname']);
		$staff_email = $this->test_form_input_data($data['txtemail']);
		$staff_phone = $this->test_form_input_data($data['txtnumber']);
		$staff_pass = $this->test_form_input_data($data['txtpass']);
		$staff_role = $this->test_form_input_data($data['txtrole']);
		try{
			$add_staff = $this->db->prepare("INSERT INTO tbl_admin (username, email, password, phone, user_role) VALUES (:x, :y, :z, :a, :b) ");

			$add_staff->bindparam(':x', $staff_name);
			$add_staff->bindparam(':y', $staff_email);
			$add_staff->bindparam(':z', $staff_pass);
			$add_staff->bindparam(':a', $staff_phone);
			$add_staff->bindparam(':b', $staff_role);

			$add_staff->execute();
		}catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
	
	public function add_new_game($data)
	{
		$game_name  = $this->test_form_input_data($data['txtgname']);
		$game_price = $this->test_form_input_data($data['txtgprice']);
		try{
			$add_game = $this->db->prepare("INSERT INTO tbl_play_items (play_item_name,play_item_counter, play_item_price) VALUES (:x, 0, :z) ");
			$add_game->bindparam(':x', $game_name);
			$add_game->bindparam(':z', $game_price);
			$add_game->execute();
		}catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function add_new_bar($data)
	{
		$bar_name  = $this->test_form_input_data($data['txtname']);
		$bar_price = $this->test_form_input_data($data['txtprice']);
		try{
			$add_bar = $this->db->prepare("INSERT INTO tbl_bar_items (bar_item_name,bar_item_counter, bar_item_price) VALUES (:x, 0, :z) ");
			$add_bar->bindparam(':x', $bar_name);
			$add_bar->bindparam(':z', $bar_price);
			$add_bar->execute();
		}catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
	
	public function new_bar_purchase($data)
	{
	    include('config.php');
		$cardid = $this->test_form_input_data($data["taskcardid"]);
		$drinkname = $this->test_form_input_data($data["txtdrink"]);
		$drinknameno = $this->test_form_input_data($data["txtdrinkno"]);
		$orderdate = date('Y-m-d');
		$price = $this->test_form_input_data($data["txtamount"]);
		if($cardid != null) {
			$stmt = $this->db->prepare("SELECT * FROM tbl_cards WHERE card_id=:id and is_assigned = 1 LIMIT 1");
			$stmt->execute(array(':id'=>$cardid));
			if($stmt->rowCount() > 0) {
				$fetch_device = "SELECT * FROM tbl_cards WHERE card_id = '".$cardid."'";
				$result = mysqli_query($conn,$fetch_device);
				$row = $result->fetch_array(MYSQLI_ASSOC);
				$moneyz = 0;
				// $fetch_device = "SELECT * FROM task_info WHERE card_id = '".$cardid."' AND task_date = '".date("Y-m-d")."'";
				// $results = mysqli_query($conn,$fetch_device);
				// $num_row = mysqli_num_rows($result);
				// $flag = true;
				// if($num_row > 0){
				// 	while($rows = $results->fetch_array(MYSQLI_ASSOC)){
				// 		if($rows['duration'] == 1 && $rows['status'] == 0 && $rows['countresets'] == 0){
				// 			$moneyz = $moneyz + (500 * $rows['player_type']);
				// 		}else if($rows['duration'] == 0 && $rows['status'] == 0 && $rows['countresets'] == 0){
				// 			$moneyz = $moneyz + (250 * $rows['player_type']);
				// 		}
				// 	}
				// 	$finalmoney = $row['amount'] - $moneyz;
				// 	if($finalmoney < $price){
				// 		$flag = false;
				// 	}
				// }
				// if($flag){
					try{
						$add_order = $this->db->prepare("INSERT INTO tbl_drink_orders (card_id, bar_item_id, order_date, drinks_no, amount) VALUES (:x, :y, :z, :a, :b) ");
						$add_order->bindparam(':x', $cardid);
						$add_order->bindparam(':y', $drinkname);
						$add_order->bindparam(':z', $orderdate);
						$add_order->bindparam(':a', $drinknameno);
						$add_order->bindparam(':b', $price);
						$add_order->execute();
						$fetch_device = "SELECT * FROM tbl_bar_items WHERE bar_item_id = ".$drinkname;
						$result = mysqli_query($conn,$fetch_device);
						$row = $result -> fetch_array(MYSQLI_ASSOC);
						$counter = $row['bar_item_counter'] + 1;
						$play_counter = $this->db->prepare("UPDATE tbl_bar_items SET bar_item_counter = :x WHERE bar_item_id = :y ");
						$play_counter->bindparam(':x', $counter);
						$play_counter->bindparam(':y', $drinkname);
						$play_counter->execute();
						$_SESSION['messagex'] = "Order Transaction Successfully !";
					}catch(PDOException $e) {
						echo $e->getMessage();
					}
				// }else{
				// 	$_SESSION['messagey'] = "Insufficient Amount in card !";
				// }
			}else{
				$_SESSION['messagey'] = "Card id is invalid !";
			}
		} else {
			try{
				$add_order = $this->db->prepare("INSERT INTO tbl_drink_orders ( bar_item_id, order_date, drinks_no, amount) VALUES ( :y, :z, :a, :b) ");
				$add_order->bindparam(':y', $drinkname);
				$add_order->bindparam(':z', $orderdate);
				$add_order->bindparam(':a', $drinknameno);
				$add_order->bindparam(':b', $price);
				$add_order->execute();
				$fetch_device = "SELECT * FROM tbl_bar_items WHERE bar_item_id = ".$drinkname;
				$result = mysqli_query($conn,$fetch_device);
				$row = $result -> fetch_array(MYSQLI_ASSOC);
				$counter = $row['bar_item_counter'] + 1;
				$play_counter = $this->db->prepare("UPDATE tbl_bar_items SET bar_item_counter = :x WHERE bar_item_id = :y ");
				$play_counter->bindparam(':x', $counter);
				$play_counter->bindparam(':y', $drinkname);
				$play_counter->execute();
				$_SESSION['messagex'] = "Order Transaction Successfully !";
			}catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
	}
	
	/*-------------------------------- card id generator ---------------------------------*/

	public function generate_cards($data)
	{
		$lastcardid = $this->test_form_input_data($data["lastcardid"]);
		$cardnumber = $this->test_form_input_data($data["cards_counter"]);
		for($i=$lastcardid+1;$i<=($lastcardid+$cardnumber);$i++){
		    if($i<10){
		        $v = "00".$i;
		    }else if($i<100){
		        $v = "0".$i;
		    }else{
		        $v = "".$i;
		    }
		    $add_cards = $this->db->prepare("INSERT INTO tbl_cards (card_id, card_type, is_assigned, amount) VALUES (:x, 'NA', 0, 0) ");
			$add_cards->bindparam(':x', $v);
			$add_cards->execute();
		}
	}

	/*---------------------------------- add_new_device ----------------------------------*/

	public function add_new_device($data)
	{
		$device_id  = $this->test_form_input_data($data['txtdeviceid']);
		$device_name = $this->test_form_input_data($data['txtname']);
		$device_fb_id = $this->test_form_input_data($data['txtfb']);
		$device_pin = $this->test_form_input_data($data['txtpin']);
		$device_arena = $this->test_form_input_data($data['txtarena']);
		try{
			$add_device = $this->db->prepare("INSERT INTO tbl_device (deviceid, devicename, devicefbid,  devicepin, devicearena, inuse) VALUES (:x, :y, :z, :a, :b, 0) ");
			$add_device->bindparam(':x', $device_id);
			$add_device->bindparam(':y', $device_name);
			$add_device->bindparam(':z', $device_fb_id);
			$add_device->bindparam(':a', $device_pin);
			$add_device->bindparam(':b', $device_arena);
			$add_device->execute();
		}catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	/*--------------------------------- update_device_data --------------------------------*/

	public function update_device_data($data, $id)
	{
		$device_id  = $this->test_form_input_data($data['txtdeviceid']);
		$device_name = $this->test_form_input_data($data['txtname']);
		$device_fb_id = $this->test_form_input_data($data['txtfb']);
		$device_pin = $this->test_form_input_data($data['txtpin']);
		$device_arena = $this->test_form_input_data($data['txtarena']);
		try{
			$update_device = $this->db->prepare("UPDATE tbl_device SET deviceid = :x, devicename = :y, devicefbid = :z, devicepin = :a, devicearena = :b WHERE id = :id ");
			$update_device->bindparam(':x', $device_id);
			$update_device->bindparam(':y', $device_name);
			$update_device->bindparam(':z', $device_fb_id);
			$update_device->bindparam(':a', $device_pin);
			$update_device->bindparam(':b', $device_arena);
			$update_device->bindparam(':id', $id);
			$update_device->execute();
			$_SESSION['update_device'] = 'update_device';
			header('Location: admin-manage-user.php');
		}catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	/*----------------------------------- update_user_data --------------------------------- */

	public function update_admin_data($data, $id)
	{
		$user_username = $this->test_form_input_data($data['txtname']);
		$user_email = $this->test_form_input_data($data['txtemail']);
		$user_phone = $this->test_form_input_data($data['txtnumber']);
		$user_role = $this->test_form_input_data($data['user_role']);
		try{
			$update_user = $this->db->prepare("UPDATE tbl_admin SET username = :y, email = :z, phone = :a, user_role = :c WHERE admin_id = :id ");
			$update_user->bindparam(':y', $user_username);
			$update_user->bindparam(':z', $user_email);
			$update_user->bindparam(':a', $user_phone);
			$update_user->bindparam(':c', $user_role);
			$update_user->bindparam(':id', $id);
			$update_user->execute();
			header('Location: manage-admin.php');
		}catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
	
	public function update_user_data($data, $id)
	{
		$user_cardid  = $this->test_form_input_data($data['txtcardid']);
		$user_username = $this->test_form_input_data($data['txtname']);
		$user_email = $this->test_form_input_data($data['txtemail']);
		$user_phone = $this->test_form_input_data($data['txtnumber']);
		$user_dob = $this->test_form_input_data($data['txtdob']);
		$user_gender = $this->test_form_input_data($data['gender']);
		try{
			$update_user = $this->db->prepare("UPDATE tbl_clients SET card_id = :x, username = :y, email = :z, phone = :a, dob = :b, gender = :c WHERE user_id = :id ");
			$update_user->bindparam(':x', $user_cardid);
			$update_user->bindparam(':y', $user_username);
			$update_user->bindparam(':z', $user_email);
			$update_user->bindparam(':a', $user_phone);
			$update_user->bindparam(':b', $user_dob);
			$update_user->bindparam(':c', $user_gender);
			$update_user->bindparam(':id', $id);
			$update_user->execute();
			header('Location: manage-clients.php');
		}catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	/*----------------------------- update_user_password ---------------------------------*/
	
	public function update_user_password($data, $id)
	{
		$employee_password  = $this->test_form_input_data($data['employee_password']);
		try{
			$update_user_password = $this->db->prepare("UPDATE tbl_admin SET password = :x WHERE admin_id = :id ");
			$update_user_password->bindparam(':x', $employee_password);
			$update_user_password->bindparam(':id', $id);
			$update_user_password->execute();
			$_SESSION['update_user_pass'] = 'update_user_pass';
			header('Location: admin-manage-user.php');
		}catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	/*------------------------------- admin_password_change ------------------------------*/

	public function admin_password_change($data, $id)
	{
		$admin_old_password  = $this->test_form_input_data($data['admin_old_password']);
		$admin_new_password  = $this->test_form_input_data($data['admin_new_password']);
		$admin_cnew_password  = $this->test_form_input_data($data['admin_cnew_password']);
		$admin_raw_password = $this->test_form_input_data($data['admin_new_password']);
		try{
			$sql = "SELECT * FROM tbl_admin WHERE admin_id = '$id' AND password = '$admin_old_password' ";
			$query_result = $this->manage_all_info($sql);
			$total_row = $query_result->rowCount();
			$all_error = '';
			if($total_row == 0){
				$all_error = "Invalid old password";
			}
			if($admin_new_password != $admin_cnew_password ){
				$all_error .= '<br>'."New and Confirm New password do not match";
			}
			$password_length = strlen($admin_raw_password);
			if($password_length < 6){
				$all_error .= '<br>'."Password length must be more then 6 character";
			}
			if(empty($all_error)){
				$update_admin_password = $this->db->prepare("UPDATE tbl_admin SET password = :x WHERE admin_id = :id ");
				$update_admin_password->bindparam(':x', $admin_new_password);
				$update_admin_password->bindparam(':id', $id);
				$update_admin_password->execute();
				$_SESSION['update_user_pass'] = 'update_user_pass';
				header('Location: admin-manage-user.php');
			}else{
				return $all_error;
			}
		}catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	/* ===================================Task Related================================= */

	public function add_new_task($data)
	{
		date_default_timezone_set("Asia/Calcutta");
	    include('config.php');
		$task_cardid = $this->test_form_input_data($data['txtcardid']);
		$gtype = $this->test_form_input_data($data['txtgtype']);
		$type = $this->test_form_input_data($data['txttype']);
		$duration = $this->test_form_input_data($data['txtduration']);
		$stmt = $this->db->prepare("SELECT * FROM tbl_cards WHERE card_id=:id and is_assigned = 1 LIMIT 1");
		$stmt->execute(array(':id'=>$task_cardid));
		if($stmt->rowCount() > 0) {
			$taskdate = date("Y-m-d");
			$fetch_device = "SELECT * FROM tbl_cards WHERE card_id = ".$task_cardid;
			$result = mysqli_query($conn,$fetch_device);
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$moneyz = 0;
			$fetch_device = "SELECT * FROM task_info WHERE card_id = '".$task_cardid."' AND task_date = '".date("Y-m-d")."'";
			$results = mysqli_query($conn,$fetch_device);
			while($rows = $results->fetch_array(MYSQLI_ASSOC)){
				if($rows['duration'] == 1 && $rows['status'] == 0 && $rows['countresets'] == 0){
					$moneyz = $moneyz + (500 * $rows['player_type']);
				}else if($rows['duration'] == 0 && $rows['status'] == 0 && $rows['countresets'] == 0){
					$moneyz = $moneyz + (250 * $rows['player_type']);
				}
			}
			$finalmoney = $row['amount'] - $moneyz;
			if(($duration == 1 && $finalmoney >= (500*$type)) || ($duration == 0 && $finalmoney >= (250*$type)))
			{
				try{
					$fetch_device = "SELECT * FROM task_info WHERE task_date = '".date("Y-m-d")."'";
					$result = mysqli_query($conn,$fetch_device);
					$num_row = mysqli_num_rows($result);
					$num_row++;
					$add_task = $this->db->prepare("INSERT INTO task_info (token_no, card_id, game_id, task_date, player_type, duration) VALUES (:t, :x, :y, :w, :z, :a) ");
					$add_task->bindparam(':t', $num_row);
					$add_task->bindparam(':x', $task_cardid);
					$add_task->bindparam(':y', $gtype);
					$add_task->bindparam(':w', $taskdate);
					$add_task->bindparam(':z', $type);
					$add_task->bindparam(':a', $duration);
					$add_task->execute();
					$fetch_device = "SELECT * FROM tbl_play_items WHERE play_item_id = '".$gtype."'";
					$result = mysqli_query($conn,$fetch_device);
					$row = $result -> fetch_array(MYSQLI_ASSOC);
					$counter = $row['play_item_counter'] + 1;
					$play_counter = $this->db->prepare("UPDATE tbl_play_items SET play_item_counter = :x WHERE play_item_id = :y ");
					$play_counter->bindparam(':x', $counter);
					$play_counter->bindparam(':y', $gtype);
					$play_counter->execute();
					$_SESSION['messagex'] = 'Queue updated successfully !';
				}catch (PDOException $e) {
					echo $e->getMessage();
				}
			}else{
				$_SESSION['messagey'] = "Insufficient Amount in card !";
			}
		}else{
			$_SESSION['messagey'] = "Card id is Invalid !";
		}
	}

	public function update_task_info($data, $task_id, $user_role)
	{
		$card_id  = $this->test_form_input_data($data['card_id']);
		$device_id = $this->test_form_input_data($data['device_id']);
		$player_type = $this->test_form_input_data($data['txttype']);
		$duration = $this->test_form_input_data($data['txtduration']);
		$sql = "SELECT * FROM task_info WHERE task_id='$task_id' ";
		$info = $this->manage_all_info($sql);
		$row = $info->fetch(PDO::FETCH_ASSOC);
		try{
			$update_task = $this->db->prepare("UPDATE task_info SET card_id = :x, deviceid = :y, player_type = :z, duration = :a WHERE task_id = :id ");
			$update_task->bindparam(':x', $card_id);
			$update_task->bindparam(':y', $device_id);
			$update_task->bindparam(':z', $player_type);
			$update_task->bindparam(':a', $duration);
			$update_task->bindparam(':id', $task_id);
			$update_task->execute();
			$_SESSION['Task_msg'] = 'Task Update Successfully';
			header('Location: task-info.php');
		}catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function update_task_device($task_id, $deviceid)
	{
		try{
			$update_task = $this->db->prepare("UPDATE task_info SET deviceid = :y WHERE task_id = :id ");
			$update_task->bindparam(':y', $deviceid);
			$update_task->bindparam(':id', $task_id);
			$using = 1;
			$update_device = $this->db->prepare("UPDATE tbl_device SET inuse = :x WHERE deviceid = :id ");
			$update_device->bindparam(':x', $using);
			$update_device->bindparam(':id', $deviceid);
			$update_task->execute();
			$update_device->execute();
			$_SESSION['Task_msg'] = 'Task Updated Successfully';
		}catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	/* ===============================Payment Related=============================== */

	public function add_new_payment($data)
	{
		$payment_cardid  = $this->test_form_input_data($data['txtcardid']);
		$payment_amount = $this->test_form_input_data($data['txtamount']);
		$payment_date = date("Y-m-d");
		$payment_type = $this->test_form_input_data($data['pay_mode']);
		$given_money = $this->test_form_input_data($data['txtamountgiven']);
		$change_given = $this->test_form_input_data($data['txtamountchange']);
		$stmt = $this->db->prepare("SELECT * FROM tbl_cards WHERE card_id=:id and is_assigned = 1 LIMIT 1");
		$stmt->execute(array(':id'=>$payment_cardid));
		if($stmt->rowCount() > 0) {
			if($given_money == ""){
				$given_money = 0;
			}
			if($change_given == ""){
				$change_given = 0;
			}
			if(($payment_type == "Online" && $given_money == 0) || ($payment_type == "Cash" && $given_money > $change_given && $given_money == ($payment_amount + $change_given)))
			{
				$sql = "SELECT * FROM tbl_cards WHERE card_id=".$payment_cardid;
				$info = $this->manage_all_info($sql);
				$row = $info->fetch(PDO::FETCH_ASSOC);
				if($row['is_assigned'] == 1){
					try{
						$add_pay = $this->db->prepare("INSERT INTO tbl_payment (card_id, pdate, payment_type, amount, given_money, change_given) VALUES (:x, :y, :z, :a, :b, :c) ");
						$add_pay->bindparam(':x', $payment_cardid);
						$add_pay->bindparam(':y', $payment_date);
						$add_pay->bindparam(':z', $payment_type);
						$add_pay->bindparam(':a', $payment_amount);
						$add_pay->bindparam(':b', $given_money);
						$add_pay->bindparam(':c', $change_given);
						$add_pay->execute();
						if($payment_amount > 500){
							$pay_amount = $payment_amount + 20;
						}else if($payment_amount > 250){
							$pay_amount = $payment_amount + 10;
						}else{
							$pay_amount = $payment_amount;
						}
						$sql = "SELECT * FROM tbl_cards WHERE card_id=".$payment_cardid;
						$info = $this->manage_all_info($sql);
						$row = $info->fetch(PDO::FETCH_ASSOC);
						$pay_amount = $pay_amount + $row['amount'];
						$update_card = $this->db->prepare("UPDATE tbl_cards SET amount = :y WHERE card_id = :x ");
						$update_card->bindparam(':x', $payment_cardid);
						$update_card->bindparam(':y', $pay_amount);
						$update_card->execute();
						$_SESSION['messagex'] = 'Payment Accepted';
					}catch (PDOException $e) {
						echo $e->getMessage();
					}
				}else{
					$_SESSION['messagey'] = 'Enter Correct card id !';
				}
			}else{
				$_SESSION['messagey'] = 'Please input correct amount !';
			}
		}else{
			$_SESSION['messagey'] = 'Card id is invalid !';
		}
	}

	public function update_payment_info($data, $task_id, $user_role)
	{
		$card_id  = $this->test_form_input_data($data['card_id']);
		$device_id = $this->test_form_input_data($data['device_id']);
		$player_type = $this->test_form_input_data($data['txttype']);
		$duration = $this->test_form_input_data($data['txtduration']);
		$sql = "SELECT * FROM task_info WHERE task_id='$task_id' ";
		$info = $this->manage_all_info($sql);
		$row = $info->fetch(PDO::FETCH_ASSOC);
		try{
			$update_task = $this->db->prepare("UPDATE task_info SET card_id = :x, deviceid = :y, player_type = :z, duration = :a WHERE task_id = :id ");
			$update_task->bindparam(':x', $card_id);
			$update_task->bindparam(':y', $device_id);
			$update_task->bindparam(':z', $player_type);
			$update_task->bindparam(':a', $duration);
			$update_task->bindparam(':id', $task_id);
			$update_task->execute();
			$_SESSION['Task_msg'] = 'Task Update Successfully';
			header('Location: task-info.php');
		}catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	/* ==============================Attendance Related================================ */
	
	public function add_punch_in($data)
	{
		$date = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
		$user_id  = $this->test_form_input_data($data['user_id']);
		$punch_in_time = $date->format('d-m-Y H:i:s');
		try{
			$add_attendance = $this->db->prepare("INSERT INTO attendance_info (atn_user_id, in_time) VALUES ('$user_id', '$punch_in_time') ");
			$add_attendance->execute();
			header('Location: attendance-info.php');
		}catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function add_punch_out($data)
	{
		$date = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
		$punch_out_time = $date->format('d-m-Y H:i:s');
		$punch_in_time  = $this->test_form_input_data($data['punch_in_time']);
		$dteStart = new DateTime($punch_in_time);
        $dteEnd   = new DateTime($punch_out_time);
        $dteDiff  = $dteStart->diff($dteEnd);
        $total_duration = $dteDiff->format("%H:%I:%S");
		$attendance_id  = $this->test_form_input_data($data['aten_id']);
		try{
			$update_user = $this->db->prepare("UPDATE attendance_info SET out_time = :x, total_duration = :y WHERE aten_id = :id ");
			$update_user->bindparam(':x', $punch_out_time);
			$update_user->bindparam(':y', $total_duration);
			$update_user->bindparam(':id', $attendance_id);
			$update_user->execute();
			header('Location: attendance-info.php');
		}catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	/* ------------------------------delete_data_by_this_method----------------------------*/

	public function delete_data_by_this_method($sql,$action_id,$sent_po)
	{
		try{
			$delete_data = $this->db->prepare($sql);
			$delete_data->bindparam(':id', $action_id);
			$delete_data->execute();
			header('Location: '.$sent_po);
		}catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	/* ----------------------manage_all_info--------------------- */

	public function manage_all_info($sql)
	{
		try{
			$info = $this->db->prepare($sql);
			$info->execute();
			return $info;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
}
?>