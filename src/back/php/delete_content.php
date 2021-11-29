<?php
    include "../../back/php/connect_mysql.php";

    $get_id = $_GET['cm_id'];
    $get_img_path = $_GET['img_path'];

    $sql = "DELETE FROM community_table WHERE cm_id = '".$get_id."'";
    mysqli_query($conn,$sql);

    mysqli_close($conn);

    unlink($get_img_path);

?>