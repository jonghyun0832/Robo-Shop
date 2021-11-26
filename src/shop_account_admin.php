<?php

    $host = '192.168.80.130';
    $user = 'adminjonghyun';
    $pw = 'tjwhdgus';
    $dbname = 'robo_db';
    $conn = mysqli_connect($host, $user, $pw, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user_id = $_POST['usr_id'];
    $user_pw = $_POST['usr_pw'];
    $user_name = $_POST['usr_name'];
    $user_email = $_POST['usr_email'];
    $user_phone_number = $_POST['usr_phoneNum'];
    $user_address_post = $_POST['usr_addPost'];
    $user_address = $_POST['usr_addAddress'];
    $user_address_detail = $_POST['usr_addDetail'];
    $user_address_extra = $_POST['usr_addExtra'];

    //여기서 유효성 검사 한번 해주면될듯

    

    $sql = "INSERT INTO user_table (user_id,user_pw,user_name,user_email,
    user_phone_number,user_address_post,user_address,user_address_detail,user_address_extra)
    VALUE
    ('$user_id','$user_pw','$user_name','$user_email','$user_phone_number',
    '$user_address_post','$user_address','$user_address_detail','$user_address_extra')";

    // $sql="INSERT INTO user_table ('user_id','user_pw','user_name','user_email',
    // 'user_phone_number','user_address_post','user_address','user_address_detail','user_address_extra')
    // VALUES
    // ('$_POST['usr_id']','$_POST['usr_pw']','$_POST['usr_name']','$_POST['usr_email']',
    // '$_POST['usr_phoneNum']','$_POST['usr_addPost']','$_POST['usr_addAddress']','$_POST['usr_addDetail']','$_POST['usr_addExtra']')";


    if (!mysqli_query($conn,$sql)){
        die('Error: ' . mysqli_error($conn));
    }
    echo "1 record added";

    mysqli_close($conn);

    // echo "아이디 : ". $_POST['usr_id']
    // echo "비밀번호 : ". $_POST['usr_pw']
    // echo "이름 : ". $_POST['usr_name']
    // echo "이메일 : ". $_POST['usr_email']
    // echo "번호 : ". $_POST['usr_phoneNum']
    // echo "우편번호 : ". $_POST['usr_addPost']
    // echo "주소 : ". $_POST['usr_addAddress']
    // echo "상세주소 : ". $_POST['usr_addDetail']
    // echo "주소추가사항 : ". $_POST['usr_addExtra'];



?>