<?php
    include('config.php');

if (isset($_GET['term'])) {
    $query = "SELECT * FROM tbl_admin";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        while ($user = mysqli_fetch_array($result)) {
            $res[] = $user['card_id'];
        }
    } else {
        $res = array();
    }
    echo json_encode($res);
}
?>