<?php
    $post_data = json_decode(file_get_contents('php://input'));

    if ($post_data->id == '') die('false');

    $host = '192.168.80.130';
    $user = 'adminjonghyun';
    $pw = 'tjwhdgus';
    $dbname = 'robo_db';
    $conn = mysqli_connect($host, $user, $pw, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $result = null;

    $sql = "SELECT user_id FROM user_table where user_id ='".$post_data->id."'";
    $result = mysqli_query($conn,$sql);
    // try {
    //     //여기서 데이터 베이스 훑어보기
    //     $result = DB::query('SELECT * FROM user_table WHERE user_id=:id', array(':id' => $post_data->id));
    // } catch (Exception $e) {
    //     // 쿼리에서 에러 발생 시 false로 처리
    //     die('false');
    // }

    //데이터 베이스에서 중복되는걸 찾으면 result값이 0보다커짐
    //count($result) > 0
    if (count($result) > 0) {
        //중복안됨
        echo 'false';
    } else {
        //중복됨
        echo 'true';
    }

?>
