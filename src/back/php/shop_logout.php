<?php
    //include "session.php";
    session_start();
    session_destroy();
    
    echo "<script>alert('로그아웃');
    location.href='http://192.168.80.130//front/html/shop.php'
    </script>";
?>