<?php
session_start();

$row = $_GET['row'];

$user_id = $_SESSION['user_id'];

$product_amount = 1;

if(!isset($_COOKIE[$user_id])) { // 해당 쿠키가 존재하지 않을 때
    //echo "{$user_id}라는 이름의 쿠키는 아직 생성되지 않았습니다.";
    setcookie($user_id,$add_info, time()+60*60,"/");
} else {                            // 해당 쿠키가 존재할 때
    //echo "{$user_id}라는 이름의 쿠키가 생성되었으며, 생성된 값은 '".$_COOKIE[$user_id]."'입니다.";
    $cookies2 = explode("//",$_COOKIE[$user_id]);
    $cookies = array_reverse($cookies2);
    //row 번째를 찾아서 지운다 (배열에서 특정 인덱스 지우는 방법 써보기)
    setcookie($user_id,$info."//".$add_info, time()+60*60,"/");
}   

?>