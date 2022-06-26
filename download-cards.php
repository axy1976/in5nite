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

$host_name='localhost';
$user_name='iqjdhyaf_in5nite';
$password='In5nite@userdhmrs';
$db_name='iqjdhyaf_in5nite';
$con = mysqli_connect($host_name,$user_name,$password,$db_name);
$fetch_device = "Select * from tbl_cards";
$result = mysqli_query($con,$fetch_device);
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
<script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
  <div class="row">
    <div class="col-md-12">
      <div class="panel shown p-4">
        <div class="row" style="padding-top:20px;">
          <div class="col-md-3">
            <td>
              <a href="javascript:demoFromHTML()" class="button">Download PDF</a>
            </td>
          </div>
        </div>
        <div id="content">
          <div class="table-responsive">
            <h1 class="heading text-center">Cards Chart</h1>
            <table class="table table-codensed table-custom text-center">
              <thead>
                <tr>
                  <th>Card ID</th>
                  <!--<th>QR URL</th>-->
                </tr>
              </thead>
              <tbody>
                <?php
                  $val = (int)($lastcard/1000000);
                  $val = $val * 1000000;
                  $val = $lastcard - $val;
                  $sql = "SELECT * FROM tbl_cards where card_id like '%$val' order by ids asc";
                  $info = $obj_admin->manage_all_info($sql);
                  $num_row = $info->rowCount();
                  if($num_row==0){
                    echo '<tr><td colspan="1" class="alert">No Data found</td></tr>';
                  }
                  while( $row = $info->fetch(PDO::FETCH_ASSOC) ){
                ?>
                <tr>
                  <td><h2><?php echo $row['card_id']; ?><h2></td>
                  <!--<td>-->
                  <!--  <div id="qrcode"></div>-->
                  <!--  <script type="text/javascript">-->
                  <!--  var qrcode = new QRCode(document.getElementById("qrcode"), {-->
                  <!--      text: "http://vdream.co.in/in5nite/registration.php",-->
                  <!--      width: 256,-->
                  <!--      height: 256,-->
                  <!--      colorDark : "#fff",-->
                  <!--      colorLight : "#000",-->
                  <!--      correctLevel : QRCode.CorrectLevel.H,-->
                  <!--      render: 'div'-->
                  <!--  });-->
                  <!--  </script>-->
                  <!--</td>-->
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    function demoFromHTML() {
        var pdf = new jsPDF('p', 'pt', 'A4');
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
            top: 10,
            bottom: 10,
            left: 30,
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
                pdf.save('CardsList.pdf');
            }, margins
        );
    }
</script>
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js" integrity="sha512-NFUcDlm4V+a2sjPX7gREIXgCSFja9cHtKPOL1zj6QhnE0vcY695MODehqkaGYTLyL2wxe/wtr4Z49SvqXq12UQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<?php include("include/footer.php"); ?>