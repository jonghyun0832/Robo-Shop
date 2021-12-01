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
                <li><?php echo $_SESSION['user_name']?>님 안녕하세요</li>
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
                <li><a href="shop_eq_list.html">기타용품</a></li>
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
                        <input class="plus" type='button'
                        onclick='count("plus")'
                        value='+'/>
                        <input type="text" name="item_final_count" id="item_final_count"
                        value = 1>
                        <input class="minus" type='button'
                        onclick='count("minus")'
                        value='-'/>
                    </span>
                </div>
                <div class="select_wrap">
                    <span onclick ="buy()">바로 구매</span>
                    <span onclick ="basket()">장바구니 담기</span>
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
            let number = resultElement.value;
            
            // 더하기/빼기
            if(type === 'plus') {
                number = parseInt(number) + 1;
            }else if(type === 'minus')  {
                number = parseInt(number) - 1;
            }
            
            // 결과 출력
            resultElement.value = number;
        }

        function buy() {
            console.log("바로 구매")
        }

        function basket() {
            console.log("장바구니 담기")
        }
    </script>
    
</body>
</html>