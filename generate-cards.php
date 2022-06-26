<?php

// admin authentication check 
require 'authentication.php';
include('config.php');

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
  header('Location: task-info.php');
}

if(isset($_GET['delete_task'])){
  $action_id = $_GET['task_id'];
  $sql = "DELETE FROM task_info WHERE task_id = :id";
  $sent_po = "generate-cards.php";
  $obj_admin->delete_data_by_this_method($sql,$action_id,$sent_po);
}

if(isset($_POST['generate_card_id'])){
  $obj_admin->generate_cards($_POST);
}

$fetch_device = "Select * from tbl_cards";
$result = mysqli_query($conn,$fetch_device);
$page_name="Cards";
include("include/sidebar.php");

// include('ems_header.php');
$lastcard = 0;
$sql = "SELECT * FROM tbl_cards order by ids asc";
$info = $obj_admin->manage_all_info($sql);
while( $row = $info->fetch(PDO::FETCH_ASSOC) ){
  $lastcard = $row['card_id'];
}

?>
  <div class="row">
    <div class="col-md-12">
      <div class="panel shown p-4">
        <div class="row" style="padding-top:20px;">
          <!-- <div class="col-md-3">
            <div class="d-flex flex-row-reverse bd-highlight mb-3">
                <form action="index.php" method="post">
                    <select name="records-limit" id="records-limit" class="custom-select">
                        <option disabled selected>Records Limit</option>
                        <?php foreach([5,7,10,12] as $limit) : ?>
                        <option
                            <?php if(isset($_SESSION['records-limit']) && $_SESSION['records-limit'] == $limit) echo 'selected'; ?>
                            value="<?= $limit; ?>">
                            <?= $limit; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>
          </div> -->
          <div class="btn-group pull-right m-3">
            <div class="btn-group">
              <form action="" method="post">
                <table>
                  <tr>
                    <td>
                      <input type="hidden" name="lastcardid" id="lastcardid" value="<?php echo $lastcard; ?>">
                    </td>
                    <td class="input">
                      <input type="number" class="form-control input-custom" name="cards_counter" id="cards_counter" placeholder="Number of cards !" required/>
                    </td>
            		    <td>
                      <button type="submit" class="button btn-menu" name="generate_card_id">Generate Card ID</button>
                    </td>
                  </tr>
                </table>
							</form>
            </div>
          </div>
        </div>
        <div id="content">
          <div class="table-responsive">
            <h1 class="heading text-center" style="padding:20px;border:1px solid;">Cards Chart</h1>
            <table class="table table-codensed table-custom text-center">
              <thead>
                <tr>
                  <th>Serial No.</th>
                  <th>Card ID</th>
                  <th>Card Type</th>
                  <th>Assigned</th>
                  <th>Amount</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $limit = 20;
                  $sql = "SELECT * FROM tbl_cards order by ids asc";
                  $result = $obj_admin->manage_all_info($sql);
                  $total_rows = $result->rowCount();
                  $total_pages = ceil ($total_rows / $limit);
                  if (!isset ($_GET['page']) ) {
                    $page_number = 1;
                  } else {
                    $page_number = $_GET['page'];
                  }
                  $initial_page = ($page_number-1) * $limit;
                  $getQuery = "SELECT *FROM tbl_cards order by ids asc LIMIT " . $initial_page . ',' . $limit;
                  $result = $obj_admin->manage_all_info($getQuery);
                  $serial = 0 + ($page_number - 1) * $limit;
                  while( $row = $result->fetch(PDO::FETCH_ASSOC) ){
                ?>
                <tr>
                  <td><?php echo ++$serial; ?></td>
                  <td><?php echo $row['card_id']; ?></td>
                  <td><?php echo $row['card_type']; ?></td>
                  <?php if($row['is_assigned'] != 0){ echo '<td><span class="success">Assigned </span><i class="ri-check-line"></i></td>'; }else{ echo '<td class="alert">Not Assigned</td>'; } ?>
                  <td><?php echo $row['amount']; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
            <nav aria-label="Page navigation example mt-5">
              <ul class="pagination m-0">
                <li class="page-item <?php if(!isset($_GET['page']) || $_GET['page'] == 1){ echo 'hidden'; } ?>">
                  <a class="page-link" href="<?php echo "generate-cards.php?page=" . $_GET['page'] - 1;?>">Previous</a>
                </li>
                <?php for($page_number = (isset($_GET['page'])?$_GET['page']:1); $page_number <= $_GET['page']+5; $page_number++): ?>
                <li class="page-item <?php if($_GET['page'] == $page_number) {echo 'active'; } ?>">
                  <a class="page-link" href="generate-cards.php?page=<?= $page_number; ?>"> <?= $page_number; ?> </a>
                </li>
                <?php endfor; ?>
                <li class="page-item <?php if((isset($_GET['page'])?$_GET['page']:1)+5 >= $total_Pages) { echo 'hidden'; } ?>">
                  <a class="page-link" href="<?php if($_GET['page'] >= $total_Pages){ echo '#'; } else {echo "?page=". $next; } ?>">Next</a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    $(document).ready(function () {
        $('#records-limit').change(function () {
            $('form').submit();
        })
    });
    function demoFromHTML() {
        var pdf = new jsPDF('p', 'pt', 'letter');
        // source can be HTML-formatted string, or a reference
        // to an actual DOM element from which the text will be scraped.
        source = $('#content')[0];

        // we support special element handlers. Register them with jQuery-style 
        // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
        // There is no support for any other type of selectors 
        // (class, of compound) at this time.
        specialElementHandlers = {
            // element with id of "bypass" - jQuery style selector
            '#bypassme': function (element, renderer) {
                // true = "handled elsewhere, bypass text extraction"
                return true
            }
        };
        margins = {
            top: 80,
            bottom: 60,
            left: 40,
            width: 522
        };
        // all coords and widths are in jsPDF instance's declared units
        // 'inches' in this case
        pdf.fromHTML(
            source, // HTML string or DOM elem ref.
            margins.left, // x coord
            margins.top, { // y coord
                'width': margins.width, // max width of content on PDF
                'elementHandlers': specialElementHandlers
            },

            function (dispose) {
                // dispose: object with X, Y of the last line add to the PDF 
                //          this allow the insertion of new lines after html
                pdf.save('Test.pdf');
            }, margins
        );
    }
</script>
<?php include("include/footer.php"); ?>