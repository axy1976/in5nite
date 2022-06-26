<?php

require 'authentication.php'; // admin authentication check 
// auth check
$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];
if ($user_id == NULL || $security_key == NULL) {
    header('Location: index.php');
}

$user_role = $_SESSION['user_role'];

if(isset($_GET['delete_task'])){
  $action_id = $_GET['task_id'];
  $sql = "DELETE FROM task_info WHERE task_id = :id";
  $sent_po = "task-info.php";
  $obj_admin->delete_data_by_this_method($sql,$action_id,$sent_po);
}

if(isset($_POST['add_payment'])){
    $obj_admin->add_new_payment($_POST);
}

include('config.php');
$fetch_device = "Select * from tbl_device where inuse = 0";
$result = mysqli_query($conn,$fetch_device);
$page_name="Payment";
include("include/sidebar.php");
// include('ems_header.php');


?>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link rel="stylesheet" href="Demo%20SciUI_files/toastr.css" crossorigin="anonymous">
	<script src="Demo%20SciUI_files/jquery_002.js" crossorigin="anonymous"></script>
	<script src="Demo%20SciUI_files/toastr.js" crossorigin="anonymous"></script>
	<script src="Demo%20SciUI_files/howler.js" crossorigin="anonymous"></script>
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-circle-progress/1.2.2/circle-progress.min.js"></script> -->
	<script src="Demo%20SciUI_files/jquery.js"></script>
	<script src="Demo%20SciUI_files/progressbar.js"></script>
	<!-- <link rel="stylesheet" type="text/css" href="https://unpkg.com/augmented-ui@2/augmented-ui.min.css"> -->
	<link href="Demo%20SciUI_files/remixicon.css" rel="stylesheet">
	<script src="Demo%20SciUI_files/base.js" crossorigin="anonymous"></script>
	<link href="Demo%20SciUI_files/grid.css" rel="stylesheet" type="text/css">
	<link href="Demo%20SciUI_files/styles.css" rel="stylesheet" type="text/css">
  <style>
    .autocomplete {
      /*the container must be positioned relative:*/
      position: relative;
      display: inline-block;
      width: 100%;
    }
    .autocomplete-items {
      position: absolute;
      border: 1px solid #d4d4d4;
      border-bottom: none;
      border-top: none;
      z-index: 99;
      /*position the autocomplete items to be the same width as the container:*/
      top: 100%;
      left: 0;
      right: 0;
    }
    .autocomplete-items div {
      padding: 10px;
      cursor: pointer;
      background-color: #fff;
      border-bottom: 1px solid #d4d4d4;
    }
    .autocomplete-items div:hover {
      /*when hovering an item:*/
      background-color: #e9e9e9;
    }
    .autocomplete-active {
      /*when navigating through the items using the arrow keys:*/
      background-color: DodgerBlue !important;
      color: #ffffff;
    }
  </style>
</head>

  <!-- Modal -->
  <!--<div class="modal fade" id="myModal" role="dialog">-->
  <!--  <div class="modal-dialog add-category-modal mode-color">-->
  <!--    <div class="panel shown modal-content">-->
  <!--      <div class="modal-header">-->
		<!--	<button type="button" class="close" data-dismiss="modal" onclick="sound4.play()">&times;</button>-->
		<!--	<h2 class="modal-title text-center">Add New Payment</h2>-->
  <!--  <div id="search-result"></div>-->
  <!--      </div>-->
  <!--      <div class="modal-body">-->
  <!--        <div class="row">-->
  <!--          <div class="col-md-12">-->
  <!--            <form role="form" action="" method="post" autocomplete="off">-->
  <!--              <div class="form-horizontal">-->
  <!--                <div class="form-group row">-->
  <!--                  <div class="col-sm-12">-->
		<!--				<div class="input autocomplete">-->
		<!--					<input type="text" name="txtcardid" id="txtcardid" placeholder="Card ID Of Client" list="expense" required>-->
		<!--				</div>-->
  <!--                  </div>-->
  <!--                </div>-->
		<!--		  <div class="form-group row">-->
  <!--                  <div class="col-sm-12">-->
		<!--				<div class="input autocomplete">-->
		<!--					<input type="date" name="txtpdate" id="txtpdate" placeholder="Payment Date" list="expense" required>-->
		<!--				</div>-->
  <!--                  </div>-->
  <!--                </div>-->
  <!--                <div class="form-group row">-->
  <!--                  <div class="col-sm-12">-->
		<!--				<div class="input autocomplete">-->
		<!--					<input type="text" name="txtptype" id="txtptype" placeholder="Payment Type" list="expense" required>-->
		<!--				</div>-->
  <!--                  </div>-->
  <!--                </div>-->
  <!--                <div class="form-group row">-->
  <!--                  <div class="col-sm-12">-->
		<!--				<div class="input autocomplete">-->
		<!--					<input type="text" name="txtamount" id="txtamount" placeholder="Card ID Of Client" list="expense" required>-->
		<!--				</div>-->
  <!--                  </div>-->
  <!--                </div>-->
                 		 
  <!--                <div class="form-group">-->
  <!--                </div>-->
  <!--                <div class="form-group">-->
  <!--                  <div class="col-sm-offset-3 col-sm-3">-->
  <!--                    <button type="submit" name="add_payment" class="button success" onclick="sound0.play()">Add Payment</button>-->
  <!--                  </div>-->
  <!--                  <div class="col-sm-3">-->
  <!--                    <button type="submit" class="button error" data-dismiss="modal" onclick="sound4.play()">Cancel</button>-->
  <!--                  </div>-->
  <!--                </div>-->
  <!--              </div>-->
  <!--            </form> -->
  <!--          </div>-->
  <!--        </div>-->

  <!--      </div>-->
  <!--    </div>-->
  <!--  </div>-->
  <!--</div>-->





    <div class="row">
      <div class="col-md-12">
          <div class="panel shown p-4">
            <!--<div class="row">-->
            <!--  <div class="btn-group pull-right m-3">-->
            <!--    <?php if($user_role == 1){ ?>-->
            <!--    <div class="btn-group">-->
            <!--      <button class="button btn-menu" data-toggle="modal" data-target="#myModal" onclick="sound2.play()">Add New Payment</button>-->
            <!--    </div>-->
            <!--  <?php } ?>-->
            <!--  </div>-->
            <!--</div>-->
          <div class="header">
            <h1 class="title text-center">Payment Section</h1>
          </div>

          <div class="table-responsive">
          <table class="table table-codensed table-custom" align="center">
              <thead>
                <tr>
                  <th>Serial No.</th>
                  <th>Card ID</th>
                  <th>Amount</th>
                  <th>Date</th>
                  <!--<th>Action</th>-->
                </tr>
              </thead>
              <tbody>

              <?php
                  $sql = "Select * from tbl_payment order by payment_id desc";
                  $info = $obj_admin->manage_all_info($sql);
                  $serial  = 1;
                  $num_row = $info->rowCount();
                  if($num_row==0){
                    echo '<tr><td colspan="5" class="alert">No Data found</td></tr>';
                  }
                  while( $row = $info->fetch(PDO::FETCH_ASSOC) ){
              ?>
                <tr>
                  <td><?php echo $serial++; ?></td>
                  <td><?php echo $row['card_id']; ?></td>
                  <td><?php echo $row['amount']; ?></td>
				  <td><?php echo $row['pdate']; ?></td>    
                 <!--<td><a title="Update Payment"  href="edit-payment.php?payment_id=<?php echo $row['payment_id'];?>" onclick="sound2.play()"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;-->
                  <!--<a title="View" href="task-details.php?task_id=<?php echo $row['payment_id']; ?>" onclick="sound2.play()"><span class="glyphicon glyphicon-folder-open"></span></a>&nbsp;&nbsp;-->
                  <?php if($user_role == 1){ ?>
                  <!--<a title="Delete" href="?delete_task=delete_task&task_id=<?php echo $row['task_id']; ?>" onclick="return check_delete();"><span class="glyphicon glyphicon-trash"></span></a></td>-->
                <?php } ?>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
        </div>
    </div>
<?php include("include/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script type="text/javascript">
  flatpickr('#t_start_time', {
    enableTime: true
  });

  flatpickr('#t_end_time', {
    enableTime: true
  });

</script>
<!--- Autocomplete textbox jquery ajax --->
<script type="text/javascript">
function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
              b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
      x[i].parentNode.removeChild(x[i]);
    }
  }
}
/*execute a function when someone clicks in the document:*/
document.addEventListener("click", function (e) {
    closeAllLists(e.target);
});
} 
  $(document).ready(function(){
    var search = "search";
    if (search !== "") {
      $.ajax({
        url:"ajax-db-search.php",
        type:"GET",
        cache:false,
        data:{term:search},
        success:function(data){
          //alert(data);
          autocomplete(document.getElementById("txtcardid"), data);
        }  
      });
    }else{
      data = [];
    }
  });
</script>
