<?php
    include "../../back/php/session.php";
    include "../../back/php/connect_mysql.php";

    if ($is_login == FALSE){ //로그인 안되어있으면 로그인창으로 보냄
        echo "<script>alert('로그인 후 이용해주세요.');
        location.href='http://192.168.80.130//front/html/shop_login.html'
        </script>";
    }
    $user_id = $_SESSION['user_id'];

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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    <div class="wrap">
        <div class = intro_top>
            <?php
                if ($is_login == FALSE){ //로그인 아직 안했음
            ?>
            <ul class="top_item">
                <li><a href="shop_login.html">로그인</a></li>
                <li><a href="shop_create_account.html">회원가입</a></li>
                <li><a href="">장바구니</a></li>
            </ul>
            <?php
                }else { //로그인 완료
            ?>
            <ul class="top_item">
                <li><?php echo $_SESSION['user_id']?>님 안녕하세요</li>
                <li><a href="../../back/php/shop_logout.php">로그아웃</a></li>
                <li><a href="">장바구니</a></li>
            </ul>
            <?php
                }
            ?>
        </div>
        <div class="header">
            <div class="main_logo">
                <a href="../html/shop.php">    
                    <img src="../../img/mainLogo.png" width="150px" height="64px">
                </a>
            </div>
            <ul class="nav">
                <li><a href="shop_rb_list.php">로봇키트</a></li>
                <li><a href="shop_eq_list.php">기타용품</a></li>
                <li><a href="shop_customer_question.php">고객센터</a></li>
            </ul>
            <div class="searchArea">
                <!-- 서치.php만들어줘야함 -->
                <form action="../../back/php/shop_search.php" name = "검색" method = "get">
                    <input type="search" name = "user_search" id = 'user_search' placeholder="Search">
                    <span><img src="../../img/search.png" height="25px" onclick="sendSearch()"></span>
                </form>
            </div>
        </div>
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
                            $total = $total + $pd_price;
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

            tp_value = parseInt(tp_value.replace(/,/g,''));
            //string에서 g써서 replaceall같은 느낌으로 제거

            
            if(number == 1){    //상품갯수 0 아래로 못가게 만들기
                if(type === 'plus') {
                    number = number + 1;
                    tp_value = tp_value + parseInt(price);
                }else if(type === 'minus')  {
                    number = number;
                    tp_value = tp_value;
                }
            } else {    // 더하기/빼기
                if(type === 'plus') {
                    number = number + 1;
                    tp_value = tp_value + parseInt(price);
                }else if(type === 'minus')  {
                    number = number - 1;
                    tp_value = tp_value - parseInt(price);
                }
            }
            
            // 결과 출력
            resultElement.value = number;
            tp.value = tp_value.toLocaleString('ko-KR');
        }
        
        function delete_item(i) {
            //눌렀을때 해당 아이템 삭제 (쿠키에서)
            console.log("쿠키에서 삭제하기")
            fetch('http://192.168.80.130/back/php/delete_cookie.php?row='+i)
            .then((res) => res.text())
            .then((data) => {
                console.log(data);
                alert("아이템삭제")
                location.href='http://192.168.80.130/front/html/shop_basket.php';
            });
        }

        function buy_product() {
            console.log("결제하기")
            //결제하기 눌렀을떄 결제하기로 이동
        }
    </script>
    
</body>
</html>