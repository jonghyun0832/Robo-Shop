<?php
    //include "session.php";
    session_start();
    $user_id = $_SESSION['user_id'];
    setcookie($user_id,"", time()-60*60,"/");
    session_destroy();
    
    echo "<script>alert('๋ก๊ทธ์์');
    location.href='http://192.168.80.130//front/html/shop.php'
    </script>";
?>