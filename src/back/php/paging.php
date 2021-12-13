<?php

    //include "connect_mysql.php";
    $sql_totalPage = "SELECT count(*) FROM community_table";
    $result_totalPage = mysqli_query($conn,$sql_totalPage);
    $row= mysqli_fetch_array($result_totalPage);
    $total_count = $row['count(*)'];

?>