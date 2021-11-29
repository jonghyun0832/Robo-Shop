<?php

    $source = $_FILES['find_img']['tmp_name']; 
    // /home/jonghyun/바탕화면/practie/src/img/
    if (basename($_FILES['find_img']['name']) != ""){
        $dest = "../../img/".date("YmdHis").basename($_FILES['find_img']['name']);
        move_uploaded_file($source,$dest);
    } else {
        $dest = null;
    }
    include "connect_mysql.php";
    include "session.php";
    //세션에서 아이디 뽑아오기
    //글쓰기 쪽에서 이미 세션 확인했으니까 여기선 그냥 로그인
    //되어있다고 생각하고 바로 받아온다
    $user_id = $_SESSION['user_id'];
    $isnew = $_POST['isnew'];
    $cm_title = $_POST['title'];
    $cm_id = $_POST['cm_id'];
    $cm_content = $_POST['content'];


    if($isnew == TRUE){
        $sql = "INSERT INTO community_table 
        (user_id,cm_title,cm_content,cm_imagepath)
        VALUE
        ('$user_id','$cm_title','$cm_content','$dest')";

        if (!mysqli_query($conn,$sql)){
            die('Error: ' . mysqli_error($conn));
        }
        mysqli_close($conn);
        echo "<script>alert('글 작성 완료');
        location.href='http://192.168.80.130//front/html/shop_customer_question.php'
        </script>";
    }
    else {
        $sql = "UPDATE community_table SET 
        cm_title = '$cm_title', cm_content = '$cm_content'
        WHERE cm_id = '".$cm_id."'";

        if (!mysqli_query($conn,$sql)){
            die('Error: ' . mysqli_error($conn));
        }
        mysqli_close($conn);
        echo "<script>alert('글 수정 완료');
        location.href='http://192.168.80.130//front/html/shop_customer_question.php'
        </script>";

    }





?>