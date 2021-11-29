<?php

    $prev_img = $_POST['prev_img'];
    $prev_img_path = $_POST['prev_img_path'];
    $source = $_FILES['find_img']['tmp_name']; 
    // /home/jonghyun/바탕화면/practie/src/img/

    $is_change = true;

    if ($prev_img != basename($_FILES['find_img']['name'])){
        if (basename($_FILES['find_img']['name']) != ""){
            $dest = "../../img/".date("YmdHis")."_".basename($_FILES['find_img']['name']);
            move_uploaded_file($source,$dest);
        } else {
            $dest = null;
        }
        if ($prev_img_path != ""){ //이전에 사진있을때만 삭제
            unlink($prev_img_path);
        }
    } else { //이전이랑 같으면 이미지는 저장해줄 필요가없음
        $is_change = false;
    }

    // if (basename($_FILES['find_img']['name']) != ""){
    //     $dest = "../../img/".date("YmdHis")."_".basename($_FILES['find_img']['name']);
    //     move_uploaded_file($source,$dest);
    // } else {
    //     $dest = null;
    // }
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
    else { //사진이 안바뀌었으면 사진경로 안바꿔줘도됨
        if ($is_change == false){
            $sql = "UPDATE community_table SET 
            cm_title = '$cm_title', cm_content = '$cm_content'
            WHERE cm_id = '".$cm_id."'";
        } else { //사진이 바뀌었을떄 사진경로도 바꿔줌
            $sql = "UPDATE community_table SET 
            cm_title = '$cm_title', cm_content = '$cm_content', cm_imagepath = '$dest'
            WHERE cm_id = '".$cm_id."'";
        }
        if (!mysqli_query($conn,$sql)){
            die('Error: ' . mysqli_error($conn));
        }
        mysqli_close($conn);
        echo "<script>alert('글 수정 완료');
        location.href='http://192.168.80.130//front/html/shop_customer_question.php'
        </script>";

    }





?>