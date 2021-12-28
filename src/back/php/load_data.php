<?php

    include "connect_mysql.php";

    $end = $_GET['end'];
    $page = $_GET['page'];
    //$page_item = $_GET['page_item'];
    $page_item = 5;

    $page_start = (int)$page * (int)$page_item;

    //전체 데이터 갯수 확인
    $sql_total = "SELECT * FROM order_table
    ORDER BY od_boolean, od_id DESC";
    $result_total = mysqli_query($conn,$sql_total);
    $exist = mysqli_num_rows($result_total);

    if ($page_start + $page_item > $exist && $end == 0){
        $page_item = $exist - $page_start;
        $end = 1;
        //echo "endpaging";
    }

        $tmp2Array = array();
    
        $sql = "SELECT * FROM order_table
        ORDER BY od_boolean, od_id DESC
        LIMIT $page_start,$page_item";

        $result = mysqli_query($conn,$sql);

        for ($j=0; $j<$page_item; $j=$j+1){

            $row= mysqli_fetch_array($result);

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

            $result_person = mysqli_query($conn,$sql_person);
            $row_person= mysqli_fetch_array($result_person);

            $user_name = $row_person['user_name']; //소비자 이름
            $user_email = $row_person['user_email']; //소비자 이메일
            $user_phone_number = $row_person['user_phone_number']; //소비자 번호
            $user_address_post = $row_person['user_address_post']; //소비자 우편번호
            $user_address = $row_person['user_address']; //소비자 주소
            $user_address_detail = $row_person['user_address_detail']; //소비자 상세주소

            //상품 테이블에서 데이터 가져오기
            $pd_name_arr = [];
            $pd_total_price = 0;
            for ($i=0; $i<count($pd_id_arr); $i=$i+1){
                $sql_product = "SELECT pd_name,pd_price FROM pd_info_table
                WHERE pd_id = '".$pd_id_arr[$i]."'";

                $result_product = mysqli_query($conn,$sql_product);
                $row_product= mysqli_fetch_array($result_product);

                $product_name = $row_product['pd_name'];
                $product_price = $row_product['pd_price'];

                array_push($pd_name_arr, $product_name." : ".$pd_count_arr[$i]);
                $pd_total_price = $pd_total_price + (int)$product_price*(int)$pd_count_arr[$i];
            }

            $pd_name_str = $pd_name_arr[0];
            if (count($pd_name_arr) > 1){
                for ($i=1; $i<count($pd_name_arr); $i=$i+1){
                    $pd_name_str = $pd_name_str.",<br>".$pd_name_arr[$i];
                }
            }

            $tmpArray = array();

            array_push($tmpArray,$end,$od_cdate,$pd_name_str,$pd_total_price,$user_name,
            $user_email,$user_phone_number,$user_address_post,$user_address,
            $user_address_detail,$od_boolean);

            //$tmp2Array = array("$j"=>$tmpArray);
            array_push($tmp2Array,$tmpArray);

            //echo $tmp2Array;

            // echo "<tr class='list'>
            // <td class='date'>$od_cdate</td>
            // <td class='tit'>
            //     $pd_name_str
            // </td>
            // <td class='price'>number_format($pd_total_price)원</td>
            // <td class='consumer'>
            //     <div>$user_name</div>
            //     <div>$user_email</div>
            //     <div>$user_phone_number</div>
            //     <div>$user_address_post</div>
            //     <div>$user_address $user_address_detail</div>
            // </td>
            // <td class='done'>처리
            // </td>
            // </tr>";
        }

        echo json_encode($tmp2Array);
    



    //echo $sql;

?>