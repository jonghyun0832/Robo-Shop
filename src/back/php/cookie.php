<?php
session_start();
$pd_id = $_GET['pd_id'];

$user_id = $_SESSION['user_id'];

$product_amount = $_GET['pd_cnt'];

$add_info = $pd_id.",".$product_amount;

if(!isset($_COOKIE[$user_id])) { // 해당 쿠키가 존재하지 않을 때
    //echo "{$user_id}라는 이름의 쿠키는 아직 생성되지 않았습니다.";
    setcookie($user_id,$add_info, time()+60*60,"/");
} else {                            // 해당 쿠키가 존재할 때
    //echo "{$user_id}라는 이름의 쿠키가 생성되었으며, 생성된 값은 '".$_COOKIE[$user_id]."'입니다.";
    $info = $_COOKIE[$user_id];
    if (strpos($info,"$pd_id") !==false){ //장바구니에 중복으로 담기면 return;
        echo 'false';
    } else { //중복이지 않으면 그냥 추가
        setcookie($user_id,$info."//".$add_info, time()+60*60,"/");
    }
}   

?>
