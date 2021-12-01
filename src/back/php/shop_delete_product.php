<?php
    include "../../back/php/connect_mysql.php";

    $pd_id = $_GET['pd_id'];
    $get_img_path = $_GET['img_path'];

    $sql = "DELETE FROM pd_info_table WHERE pd_id = '".$pd_id."'";
    mysqli_query($conn,$sql);

    mysqli_close($conn);

    unlink($get_img_path);

?>