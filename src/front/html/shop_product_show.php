<?php
    include "../../back/php/session.php";
    include "../../back/php/connect_mysql.php";

    if ($is_login == TRUE){
        $login_user_id = $_SESSION['user_id'];
    } else {
        $login_user_id = "";
    }
    //혹시 세션으로 장바구니 쓸거면 여기서작업
    $pd_id = $_GET['pd_id']; //받아온 상품 고유 번호 1  

    $sql = "SELECT * FROM pd_info_table I 
    INNER JOIN pd_category_table C ON I.cg_id = C.cg_id 
    WHERE I.pd_id = '".$pd_id."'";
    $result = mysqli_query($conn,$sql);
    $row= mysqli_fetch_array($result);

    $pd_name = $row['pd_name']; //상품이름 1
    $pd_price = $row['pd_price']; //상품가격 1
    $pd_imgpath = $row['pd_imgpath']; //상품이미지 1
    $pd_content = $row['pd_content']; //상품설명 1
    $cg_name = $row['cg_name']; //카테고리 이름 1

    $pd_content_convert = str_replace("\r\n", "<br>",$pd_content);

?>


<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$cg_name." > ".$pd_name?></title>

    <link rel="stylesheet" type="text/css" href="../css/shop_product_show.css">
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
        <div class="main_header"> 
            <?=$cg_name?>
            <!-- 카테고리 -> 아이템이름 -->
        </div>
        <div class="main_wrap">
            <div class="main_img">
                <img src="<?=$pd_imgpath?>" style="max-width: 400px; height: auto;">
            </div>
            <div class="main_content_wrap">
                <div class="title">
                    <?=$pd_name?>
                    <!-- 상품 이름 -->
                </div>
                <div class="price">
                    <?=number_format($pd_price)."원"?>
                    <!-- 상품 가격 -->
                </div>
                <div class="count">
                    <span>수량</span>
                    <span class="item_count">
                    <input class="minus" type='button'
                        onclick='count("minus")'
                        value='-'/>
                        <input type="text" name="item_final_count" id="item_final_count"
                        value = 1>
                        <input class="plus" type='button'
                        onclick='count("plus")'
                        value='+'/>
                    </span>
                </div>
                <div class="select_wrap">
                    <span onclick ="buy()">바로 구매</span>
                    <span onclick ="basket('<?=$is_login?>','<?=$pd_id?>')">장바구니 담기</span>
                </div>
            </div>
        </div>
        <div class="tail_wrap">
            <div class="tail">
                <div class="tail_head">
                    상품정보
                </div>
                <div class="tail_content">
                    <!-- 상품정보받아서 입력 -->
                    <?=$pd_content_convert?>
                </div>
            </div>
        </div>

    </div>
    
    <script>
        //스크립트 분리필요
        function count(type)  {
            // 결과를 표시할 element
            console.log(type)
            const resultElement = document.getElementById('item_final_count');
            
            // 현재 화면에 표시된 값
            let number = parseInt(resultElement.value);
            
            // 더하기/빼기

            if(number == 1){    //상품갯수 0 아래로 못가게 만들기
                if(type === 'plus') {
                    number = number + 1;
                }else if(type === 'minus')  {
                    number = number;
                }
            } else {    // 더하기/빼기
                if(type === 'plus') {
                    number = number + 1;
                }else if(type === 'minus')  {
                    number = number - 1;
                }
            }
            
            // 결과 출력
            resultElement.value = number;
        }

        function buy() {
            console.log("바로 구매")
        }

        function basket(is_login,pd_id) {
            console.log("장바구니 담기")
            let pd_cnt = parseInt(document.getElementById('item_final_count').value);
            if (is_login == false){
                alert("로그인이 필요합니다.")
                location.href='http://192.168.80.130/front/html/shop_login.html';
            } else{
                fetch('http://192.168.80.130/back/php/cookie.php?pd_id='+pd_id+'&pd_cnt='+pd_cnt)
                .then((res) => res.text())
                .then((data) => {
                    console.log(data);
                    alert("상품을 장바구니에 담았습니다.")
                });
            }
        }
    </script>
    
</body>
</html>