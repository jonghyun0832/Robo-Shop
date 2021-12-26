<?php
    include "../../back/php/connect_mysql.php";

    $cm_id = $_GET['cm_id'];
    $cm_view = $_GET['cm_view'];
    $change_view = (int)$cm_view + 1;

    $sql = "UPDATE community_table
    SET cm_view = '$change_view'
    WHERE cm_id = '".$cm_id."'";

    if (!mysqli_query($conn,$sql)){
        die('Error: ' . mysqli_error($conn));
    }
    mysqli_close($conn);


?>