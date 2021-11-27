<?php
    $post_data = json_decode(file_get_contents('php://input'));

    if ($post_data->id == '') die('false');

    include "connect_mysql.php";

    $result = null;

    $sql = "SELECT user_id FROM user_table where user_id ='".$post_data->id."'";
    $result = mysqli_query($conn,$sql);
    $exist = mysqli_num_rows($result);
    // try {
    //     //여기서 데이터 베이스 훑어보기
    //     $result = DB::query('SELECT * FROM user_table WHERE user_id=:id', array(':id' => $post_data->id));
    // } catch (Exception $e) {
    //     // 쿼리에서 에러 발생 시 false로 처리
    //     die('false');
    // }

    //데이터 베이스에서 중복되는걸 찾으면 result값이 0보다커짐
    //count($result) > 0
    if ($exist > 0) {
        //중복
        echo 'false';
    } else {
        //중복안됨
        echo 'true';
    }

?>
