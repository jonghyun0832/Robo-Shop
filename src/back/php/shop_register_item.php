<?php
    include "connect_mysql.php";
    include "session.php";

    $cg_id = $_POST['category_box'];
    $pd_name = $_POST['pd_name'];
    $pd_price = $_POST['pd_price'];
    $pd_content = $_POST['pd_content'];

    $source = $_FILES['find_img']['tmp_name']; 

    if (basename($_FILES['find_img']['name']) != ""){
        $dest = "../../pd_img/".date("YmdHis")."_".basename($_FILES['find_img']['name']);
    } else {    
        $dest = null;
    }
    move_uploaded_file($source,$dest);

    $sql = "INSERT INTO pd_info_table 
    (cg_id,pd_name,pd_price,pd_imgpath,pd_content)
    VALUE
    ('$cg_id','$pd_name','$pd_price','$dest','$pd_content')";

    if (!mysqli_query($conn,$sql)){
        die('Error: ' . mysqli_error($conn));
    }
    mysqli_close($conn);
    if ($cg_id =="1"){ //1번 카테고리 - 로봇키트로 돌아가기
        echo "<script>alert('상품 등록 완료');
        location.href='http://192.168.80.130//front/html/shop_rb_list.php'
        </script>";
    } else { //2번 카테고리 - 기타용품으로 돌아가기
        echo "<script>alert('상품 등록 완료');
        location.href='http://192.168.80.130//front/html/shop_eq_list.php'
        </script>";
    }

?>