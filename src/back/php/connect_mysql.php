<?php
    $host = '192.168.80.130';
    $user = 'adminjonghyun';
    $pw = 'tjwhdgus';
    $dbname = 'robo_db';
    $conn = mysqli_connect($host, $user, $pw, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>