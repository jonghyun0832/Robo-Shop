<?php
    include "../../back/php/session.php";
    include "../../back/php/connect_mysql.php";

    $sql_order = "SELECT * FROM order_table
    ORDER BY od_boolean, od_id DESC";

    $result_order = mysqli_query($conn,$sql_order);
    //$exist = mysqli_num_rows($result_order);

?>


<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>주문확인</title>

    <link rel="stylesheet" type="text/css" href="../css/shop_order_check.css">
    <link rel="stylesheet" type="text/css" href="../css/header.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@500&display=swap" rel="stylesheet">

</head>
<body>
    <div class="wrap">
        <?php
            include "../../front/html/header.php";
        ?>
        <div class="main_top">
            <p class="title">주문확인</p>
        </div>
        <div class="basket_list_wrap">
            <table class="basket_list">
                <caption>장바구니 목록</caption>
                <thead>
                    <tr>
                        <th class="first">주문날짜</th>
                        <th class="third">상품명</th>
                        <th class="fourth">가격</th>
                        <th class="fifth">구매자 정보</th>
                        <th class="sixth">처리상태</th>
                    </tr>
                </thead>
                <tbody class = "infinite" id = "infinite">
                    <?php
                    for ($j=0; $j<5; $j=$j+1){
                        $row= mysqli_fetch_array($result_order);
                        
                        //주문 테이블에서 데이터 가져오기
                        $od_id = $row['od_id']; //주문 id
                        $pd_id_str = $row['pd_id_str'];
                        $pd_count_str = $row['pd_count_str'];
                        $user_id = $row['user_id'];
                        $od_cdate = $row['od_cdate']; //생성일
                        $od_boolean = $row['od_boolean']; //처리여부

                        //데이터 쪼개서 배열로만들기
                        $pd_id_arr = explode(",",$pd_id_str); //상품id 리스트
                        $pd_count_arr = explode(",",$pd_count_str); //상품별 갯수
                        //유저 테이블에서 데이터 가져오기
                        $sql_person = "SELECT * FROM user_table
                        WHERE user_id ='".$user_id."'";

                        $result = mysqli_query($conn,$sql_person);
                        $row= mysqli_fetch_array($result);

                        $user_name = $row['user_name']; //소비자 이름
                        $user_email = $row['user_email']; //소비자 이메일
                        $user_phone_number = $row['user_phone_number']; //소비자 번호
                        $user_address_post = $row['user_address_post']; //소비자 우편번호
                        $user_address = $row['user_address']; //소비자 주소
                        $user_address_detail = $row['user_address_detail']; //소비자 상세주소

                        //상품 테이블에서 데이터 가져오기
                        $pd_name_arr = [];
                        $pd_total_price = 0;
                        for ($i=0; $i<count($pd_id_arr); $i=$i+1){
                            $sql_product = "SELECT pd_name,pd_price FROM pd_info_table
                            WHERE pd_id = '".$pd_id_arr[$i]."'";

                            $result = mysqli_query($conn,$sql_product);
                            $row= mysqli_fetch_array($result);

                            $product_name = $row['pd_name'];
                            $product_price = $row['pd_price'];

                            array_push($pd_name_arr, $product_name." : ".$pd_count_arr[$i]);
                            $pd_total_price = $pd_total_price + (int)$product_price*(int)$pd_count_arr[$i];
                        }

                        $pd_name_str = $pd_name_arr[0];
                        if (count($pd_name_arr) > 1){
                            for ($i=1; $i<count($pd_name_arr); $i=$i+1){
                                $pd_name_str = $pd_name_str.",<br>".$pd_name_arr[$i];
                            }
                        }
                    ?>
                    <tr class="list">
                        <td class="date"><?=$od_cdate?></td>
                        <td class="tit">
                            <?=$pd_name_str?>
                        </td>
                        <td class="price"><?=number_format($pd_total_price)."원"?></td>
                        <td class="consumer">
                            <div><?=$user_name?></div>
                            <div><?=$user_email?></div>
                            <div><?=$user_phone_number?></div>
                            <div><?=$user_address_post?></div>
                            <div><?=$user_address." ".$user_address_detail?></div>
                        </td>
                        <td class="done">
                        
                            <?php
                                if($od_boolean == FALSE){
                            ?>
                            <span class="process" id="od_complete<?=$od_id?>" onclick="order_complete(<?=$od_id?>)">
                                미처리
                            </span>
                            <?php
                                } else {
                            ?>
                            <span class="finish" id="od_complete<?=$od_id?>">처리완료</span>
                            <?php
                                }
                            ?>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                    <tr class="empty"></tr>
                </tbody>
            </table>
        </div>
    </div>
    <script type="text/javascript" src="../js/order_check.js"></script>


</body>
</html>