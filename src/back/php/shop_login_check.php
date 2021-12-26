<?php  
    session_start();

    $id_val = $_POST["id_val"];
    $pw_val = $_POST["pw_val"];

    include "connect_mysql.php";

    $sql = "SELECT user_id, user_pw, user_name, is_admin FROM user_table where user_id='".$id_val."'";
    $result = mysqli_query($conn,$sql);
    $exist = mysqli_num_rows($result);

    if ($exist >0) { //아이디가 존재한다
        $row = mysqli_fetch_row($result);
        if ($row[1] == $pw_val){  //비밀번호가 맞다
            $_SESSION['is_login'] = TRUE;
            $_SESSION['user_id'] = $row[0];
            $_SESSION['user_name'] = $row[2];
            $_SESSION['is_admin']=$row[3];
            echo "<script>alert('비밀번호맞음');
            location.href='http://192.168.80.130//front/html/shop.php'
            </script>";

            //echo "비밀번호 : " ."true";
        }else { //비밀번호가 틀리다
            echo "<script>alert('비밀번호틀림');
            location.href='http://192.168.80.130//front/html/shop_login.html'
            </script>";
            //echo "비밀번호 : " ."false";
        }
    }
    //아이디가 존재하지 않는다 
    else {
        echo "<script>alert('아이디가다름');
        location.href='http://192.168.80.130//front/html/shop_login.html'
        </script>";
        //echo "아이디 : " ."false";
    }

?>