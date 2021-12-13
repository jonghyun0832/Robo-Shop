<?php
    include "../../back/php/session.php";
    include "../../back/php/connect_mysql.php";

    if ($is_login == FALSE){ //로그인 안되어있으면 로그인창으로 보냄
        echo "<script>alert('로그인 후 이용해주세요.');
        location.href='http://192.168.80.130//front/html/shop_login.html'
        </script>";
    }
    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];

    $iscookie = false;

    if(!isset($_COOKIE[$user_id])) { // 해당 쿠키가 존재하지 않을 때

    } else { // 해당 쿠키가 존재할 때
        $cookies2 = explode("//",$_COOKIE[$user_id]);
        $cookies = array_reverse($cookies2);
        $iscookie = true;

        
    }   

    $total = 0;

?>


<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>장바구니</title>

    <link rel="stylesheet" type="text/css" href="../css/shop_basket.css">
    <link rel="stylesheet" type="text/css" href="../css/header.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@500&display=swap" rel="stylesheet">
</head>
<script src="http://code.jquery.com/jquery-latest.js"></script> 
<body>
    <div class="wrap">
        <?php
            include "../../front/html/header.php";
        ?>
        <div class="main_top">
            <p class="title">장바구니</p>
        </div>
        <div class="basket_list_wrap">
            <table class="basket_list">
                <caption>장바구니 목록</caption>
                <thead>
                    <tr>
                        <th class="first"></th>
                        <th class="second">상품정보</th>
                        <th class="third">상품가격</th>
                        <th class="fourth">개수</th>
                        <th class="fifth"></th>
                    </tr>
                </thead>
                <tbody>
                    <!-- 여기부터 -->
                    <?php
                        if($iscookie) { //쿠키가 있을때
                            for ($i=0; $i<count($cookies); $i=$i+1){
                                $product_info2 = explode(",",$cookies[$i]);
                                $product_info = array_reverse($product_info2);
                                
                                $sql = "SELECT * FROM pd_info_table
                                WHERE pd_id ='".$product_info[1]."'";
                                $result = mysqli_query($conn,$sql);
                                $row= mysqli_fetch_array($result);

                                $pd_id = $row['pd_id']; //상품고유번호 
                                $pd_name = $row['pd_name']; //상품이름  
                                $pd_price = $row['pd_price']; //상품가격  
                                $pd_imgpath = $row['pd_imgpath']; //상품이미지
                                $pd_get = "http://192.168.80.130//front/html/shop_product_show.php?pd_id=".$pd_id; 
                    ?>
                    <tr>
                        <td>
                            <a href="<?=$pd_get?>">
                                <img src="<?=$pd_imgpath?>" style="width: 200px; height: 150px;" >
                            </a>
                        </td>
                        <td class="tit">
                            <a href="<?=$pd_get?>"><?=$pd_name?></a>
                        </td>
                        <td class="price"><?=number_format($pd_price)."원"?></td>
                        <td class="count">
                            <span class="item_count">
                                <input class="minus" type='button'
                                onclick='count("minus",<?=$i?>,<?=$pd_price?>)'
                                value='-'/>
                                <input type="text" name="item_final_count" id="item_final_count<?=$i?>"
                                value = <?=$product_info[0]?> readonly>
                                <input class="plus" type='button'
                                onclick='count("plus",<?=$i?>,<?=$pd_price?>)'
                                value='+'/>
                            </span>
                        </td>
                        <td class="cancel">
                            <input class="minus" type='button'
                            onclick='delete_item(<?=$i?>)'
                            value='x'/>
                        </td>
                    </tr>
                    <?php
                            $total = $total + $pd_price * $product_info[0];
                            }
                        } else { //쿠키가 없을떄
                    ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <?php
                        }
                    ?>
                    <!-- 여기까지 -->
                    <tr class="empty"></tr>
                    <tr class="total_order">
                        <td>총 가격</td>
                        <td></td>
                        <td></td>
                        <td colspan="2" class="total_price">
                            <input type="text" name="total_price" id="total_price"
                            value = <?=number_format($total)?> readonly>원
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php
            if($iscookie == true){
        ?>
        <div class="border_bottom">
            <span id="buy" onclick="buy_product()">결제하기</span>
        </div>
        <?php
            }
        ?>
    </div>
    <script type="text/javascript" src="https://cdn.iamport.kr/js/iamport.payment-1.1.5.js"></script>
    <script>
        function count(type,i,price)  {
            // 결과를 표시할 element
            console.log(type);
            console.log(i);
            console.log('item_final_count'+i)
            const resultElement = document.getElementById('item_final_count'+i);
            const tp= document.getElementById('total_price');

            // 현재 화면에 표시된 값
            let number = parseInt(resultElement.value);
            let tp_value = tp.value;
            //string에서 g써서 replaceall같은 느낌으로 제거 
            tp_value = parseInt(tp_value.replace(/,/g,''));

            
            //php에서 쓰던 쿠키설정을 스크립트에서
            let cookie = document.cookie.match('(^|;) ?' + '<?=$user_id?>' + '=([^;]*)(;|$)');
            let value = cookie[2];
            let cookie_arr = new Array();
            cookie_arr = value.split("%2F%2F");
            cookie_arr = cookie_arr.reverse();
            console.log(cookie_arr);
            cookie_tmp = cookie_arr[i].split("%2C");

            if(number == 1){    //상품갯수 0 아래로 못가게 만들기
                if(type === 'plus') {
                    number = number + 1;
                    tp_value = tp_value + parseInt(price);
                    cookie_tmp[1] = number;
                }else if(type === 'minus')  {
                    number = 1;
                    tp_value = tp_value;
                }
            } else {    // 더하기/빼기
                if(type === 'plus') {
                    number = number + 1;
                    tp_value = tp_value + parseInt(price);
                    cookie_tmp[1] = number;
                }else if(type === 'minus')  {
                    number = number - 1;
                    tp_value = tp_value - parseInt(price);
                    cookie_tmp[1] = number;
                }
            }
            console.log(cookie_tmp);
            //쿠키 재설정
            cookie_tmp = cookie_tmp[0]+"%2C"+cookie_tmp[1];
            cookie_arr[i] = cookie_tmp;
            cookie_arr = cookie_arr.reverse();
            cookie_info = cookie_arr[0];
            if (cookie_arr.length > 1){
                for (i=1; i<cookie_arr.length; i=i+1){
                    cookie_info = cookie_info+"%2F%2F"+cookie_arr[i];
                }
            }
            let date = new Date();
            date.setTime(date.getTime() + 1*60*60*1000);
            document.cookie = '<?=$user_id?>' + '=' + cookie_info + ';expires=' + date.toUTCString() + ';path=/';
            
            // 결과 출력
            resultElement.value = number;
            tp.value = tp_value.toLocaleString('ko-KR');
            //페이지 리로드 - 쿠키갱신용
            window.location.reload();
        }
        
        function delete_item(i) {
            //눌렀을때 해당 아이템 삭제 (쿠키에서)
            if (confirm("장바구니에서 삭제하시겠습니까?") == true){
                console.log("쿠키에서 삭제하기")
                fetch('http://192.168.80.130/back/php/delete_cookie.php?row='+i)
                .then((res) => res.text())
                .then((data) => {
                    console.log(data);
                    alert("아이템삭제")
                    location.href='http://192.168.80.130/front/html/shop_basket.php';
                });
            } else {
                return;
            }
        }   

        function buy_product() {
            //총 주문금액 가져오기
            const tp= document.getElementById('total_price');
            let tp_value = tp.value;
            tp_value = parseInt(tp_value.replace(/,/g,''));

            //총 가격을 php에 넘기기 위해 쿠키로 만들기
           
        

            //상품명 갯수
            let cookie = document.cookie.match('(^|;) ?' + '<?=$user_id?>' + '=([^;]*)(;|$)');
            let value = cookie[2];
            let cookie_arr = new Array();
            cookie_arr = value.split("%2F%2F");
            let pd_length = cookie_arr.length;
            
            

            <?php

                //상품 id들만 골라서 str으로 만들기
                
                $pd_id_arr = [];
                $pd_count_arr = [];
                $cookies2 = explode("//",$_COOKIE[$user_id]);
                $cookies = array_reverse($cookies2);
                for ($i=0; $i<count($cookies); $i=$i+1){
                    $product_info = explode(",",$cookies[$i]);
                    array_push($pd_id_arr,$product_info[0]);
                    array_push($pd_count_arr,$product_info[1]);
                }
                $pd_id_str = implode(",",$pd_id_arr);
                $pd_count_str = implode(",",$pd_count_arr);
                
            
                // 주문자 정보 가져오기
                $sql = "SELECT * FROM user_table
                WHERE user_id ='".$user_id."'";
                $result = mysqli_query($conn,$sql);
                $row= mysqli_fetch_array($result);

                $user_name = $row['user_name']; //고객이름 
                $user_email = $row['user_email']; //고객
                $user_phone_number = $row['user_phone_number']; //고객전화번호  
                $user_address_post = $row['user_address_post']; //고객우편번호
                $user_address = $row['user_address']; //고객주소
                $user_address_detail = $row['user_address_detail']; //고객상세주소

                mysqli_close($conn);
            ?>


            console.log("결제하기")
            //결제 영수증 내역
            let rp_name;
            if (pd_length == 1){
                rp_name = "<?=$pd_name?>";
            } else {
                rp_name = "<?=$pd_name?>"+" 외 "+(pd_length-1)+"개 상품";
            }
            //결제하기 눌렀을떄 결제하기로 이동
            //pg : "html5_inicis",  : KG이니시스 웹기본
            //pg : "kakaopay",  : 카카오페이 결제
            var IMP = window.IMP; 
            IMP.init('imp22891383'); 
            IMP.request_pay({
                pg : "kakaopay", 
                pay_method : 'card',
                merchant_uid : 'merchant_' + new Date().getTime(),
                name : rp_name,
                amount : tp_value,
                buyer_email : '<?=$user_email?>',
                buyer_name : '<?=$user_name?>',
                buyer_tel : '<?=$user_phone_number?>',
                buyer_addr : '<?=$user_address." ".$user_address_detail?>',
                buyer_postcode : '<?=$user_address_post?>'
            }, function(rsp) {
                if ( rsp.success ) {

                    //form객체 만들어서 post로 데이터전달
                    //데이터는 상품id, 유저id, 상품갯수
                    var userData = {
                        'user_id' : '<?=$user_id?>',
                        'pd_id_str' : '<?=$pd_id_str?>',
                        'pd_count_str' : '<?=$pd_count_str?>'
                    };

                    var newForm = document.createElement('form');
                    newForm.name = 'newForm';
                    newForm.method = 'post';
                    newForm.action = 'http://192.168.80.130/back/php/make_order.php';
                    
                    for (var key in userData){
                    var input_data = document.createElement('input');
                    
                    input_data.setAttribute("type", "text");
                    input_data.setAttribute("name",key);
                    input_data.setAttribute("value",userData[key]);

                    newForm.appendChild(input_data);
                    }
                    document.body.appendChild(newForm);

                    newForm.submit();

                } else {
                    var msg = '다시 시도해주세요.';
                    alert(msg);
                    rsp.error_msg;
                }
                
            });
        }
    </script>
    
</body>
</html>