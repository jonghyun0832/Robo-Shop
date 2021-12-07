<?php

    include "../../back/php/connect_mysql.php";

    $user_id = $_POST['user_id'];
    $pd_id_str = $_POST['pd_id_str'];
    $pd_count_str = $_POST['pd_count_str'];

    $sql = "INSERT INTO order_table
    (user_id,pd_id_str,pd_count_str)
    VALUE
    ('$user_id','$pd_id_str','$pd_count_str')";
    if (!mysqli_query($conn,$sql)){
        die('Error: ' . mysqli_error($conn));
    }
    mysqli_close($conn);

    setcookie($user_id,"", time()-60*60,"/");

    echo "<script>alert('결제가 완료되었습니다.');
    location.href='http://192.168.80.130//front/html/shop.php'
    </script>";

?>
