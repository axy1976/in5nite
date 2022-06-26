<?php
	include('config.php');
	$search = $_GET['cardid'];
	$strs = "";
	if(isset($_GET['amount'])){
	    $query = $conn->query("SELECT a.amount,b.* FROM tbl_cards a,tbl_clients b WHERE a.card_id LIKE '$search' AND a.is_assigned = 1 AND a.card_id = b.card_id order by b.user_id desc") or die(mysqli_connect_errno());
    	$rows = $query->num_rows;
    	if($rows > 0){
    		while($row = $query->fetch_assoc()){
    			$strs = $strs."<tr>
    				<td>".$row['card_id']."</td>
    				<td>".$row['username']."</td>
    				<td>".$row['email']."</td>
    				<td>".$row['phone']."</td>
    				<td>".$row['dob']."</td>
    				<td>".$row['gender']."</td>
    				<td>".$row['amount']."</td>
    		    </tr>";
    		    $serial++;
    		}
    	}else{
    	    echo "<tr>
			        <td colspan='7' class='alert'>No Data</td>
			    </tr>";
    	}
    	echo $strs;
	}else{
    	$query = $conn->query("SELECT a.amount,b.* FROM tbl_cards a,tbl_clients b WHERE a.card_id LIKE '%$search%' AND a.is_assigned = 1 AND a.card_id = b.card_id order by b.user_id desc") or die(mysqli_connect_errno());
    	$rows = $query->num_rows;
    	$serial = 1;
    	if($rows > 0){
    		while($row = $query->fetch_assoc()){
    			$strs = $strs."<tr>
    				<td>".$serial."</td>
    				<td>".$row['card_id']."</td>
    				<td>".$row['username']."</td>
    				<td>".$row['email']."</td>
    				<td>".$row['phone']."</td>
    				<td>".$row['dob']."</td>
    				<td>".$row['gender']."</td>
    				<td>
    					<a title='Update Client' href='payment-maindesk.php?card_id=".$row['card_id']."'><span class='glyphicon glyphicon-edit'></span></a>
    				</td>
    		    </tr>";
    		    $serial++;
    		}
    	}else{
    			$query = $conn->query("SELECT a.amount,b.* FROM tbl_cards a,tbl_clients b WHERE a.card_id = b.card_id order by b.user_id desc") or die(mysqli_connect_errno());
            	$rows = $query->num_rows;
            	$serial = 1;
    			$strs="";
    			if($num_row==0){
    				$strs = '<tr><td colspan="9" class="alert">No Data found</td></tr>';
    			}else{
    			    while( $row = $info->fetch_assoc() ){
    	            $strs = $strs."<tr>
        				<td>".$serial."</td>
        				<td>".$row['card_id']."</td>
        				<td>".$row['username']."</td>
        				<td>".$row['email']."</td>
        				<td>".$row['phone']."</td>
        				<td>".$row['dob']."</td>
        				<td>".$row['gender']."</td>
        				<td>
        					<a title='Update Client' href='payment-maindesk.php?card_id=".$row['card_id']."'><span class='glyphicon glyphicon-edit'></span></a>
        				</td>
    			    </tr>";
    			    $serial++;
    			}
    		}
    	}
    	echo $strs;
	}
?>