<?php
    include "../../back/php/connect_mysql.php";
    
    $od_id = $_GET['od_id'];

    $sql = "UPDATE order_table
    SET od_boolean = 1
    WHERE od_id = '".$od_id."'";

    if (!mysqli_query($conn,$sql)){
        die('Error: ' . mysqli_error($conn));
    }
    mysqli_close($conn);

?>
