<?php


    // $source = $_FILES['cm_imagepath']['tmp_name'];
    // $dest = "./".basename($_FILES['cm_imagepath']['name']);
    // move_uploaded_file($source,$dest);

    include "connect_mysql.php";
    include "session.php";
    //세션에서 아이디 뽑아오기

    //글쓰기 쪽에서 이미 세션 확인했으니까 여기선 그냥 로그인
    //되어있다고 생각하고 바로 받아온다
    $user_id = $_SESSION['user_id'];

    $cm_title = $_POST['cm_title'];
    $cm_content = $_POST['cm_content'];
    // $cm_imagepath = $_POST['cm_imagepath'];


    echo $user_id;
    echo $cm_title;
    echo $cm_content;
    // echo $_FILES['cm_imagepath']['name'];

    // $sql = "INSERT INTO community_table 
    // (user_id,cm_title,cm_content,cm_imagepath)
    // VALUE
    // ('$user_id','$cm_title','$cm_content','$cm_imagepath')"





?>