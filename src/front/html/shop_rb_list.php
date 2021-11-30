<?php
    include "../../back/php/session.php";
    include "../../back/php/connect_mysql.php";

    if ($is_login == TRUE){
        $login_user_id = $_SESSION['user_id'];
    } else {
        $login_user_id = "";
    }
    //로그인 세션으로 관리자면 버튼보이게 해줘야함

    $sql = "SELECT * FROM pd_info_table I 
    INNER JOIN pd_category_table C ON I.cg_id = C.cg_id 
    WHERE I.cg_id = 1
    ORDER BY I.pd_id DESC;";
    $result = mysqli_query($conn,$sql);
    $exist_num = mysqli_num_rows($result);

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로봇 키트</title>

    <link rel="stylesheet" type="text/css" href="../css/shop_rb_list.css">
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
                    <img src="../../img/쇼핑몰다람쥐.jpg" width="150px" height="64px">
                </a>
            </div>
            <ul class="nav">
                <li><a href="shop_rb_list.php">로봇 키트</a></li>
                <li><a href="shop_eq_list.html">기타용품</a></li>
                <li><a href="shop_customer_question.php">고객센터</a></li>
            </ul>
            <div class="searchArea">
                <!-- 서치.php만들어줘야함 -->
                <form action="../../back/php/shop_search.php" name = "검색" method = "get">
                    <input type="search" name = "user_search" id = 'user_search' placeholder="Search">
                    <span><img src="../../img/검색.png" height="25px" onclick="sendSearch()"></span>
                </form>
            </div>
        </div>
        <div class="main_top">
            <p class="title">로봇 키트</p>
            <p class="subtitle">로봇 제작용 재료들입니다. </p>
        </div>
        <div class="product_list_wrap">
            <ul class="product_list">
                <?php
                    for ($i=0; $i<$exist_num; $i=$i+1){
                        $row= mysqli_fetch_array($result);

                        $pd_id = $row['pd_id']; //상품고유번호
                        $pd_name = $row['pd_name']; //상품이름 1
                        $pd_price = $row['pd_price']; //상품가격 1
                        $pd_imgpath = $row['pd_imgpath']; //상품이미지 1
                        $pd_content = $row['pd_content']; //상품설명
                        $cg_name = $row['cg_name']; //카테고리 이름
                        $pd_get = "http://192.168.80.130//front/html/#.php"."?pd_id=".$pd_id;
                ?>
                <li class="product_wrap">
                    <div>
                        <img src="<?=$pd_imgpath?>" name="pd_img" id="pd_img" alt="상품" style="width: 250px; height: 250px;" onclick="view_product()">
                    </div>
                    <div class="pd_title" onclick="view_product()"><?=$pd_name?></div>
                    <div class="pd_price"><?=number_format($pd_price)."원"?></div>
                    <div class="pd_choice">
                        <?php
                            if($login_user_id != "admin123"){ //관리자아니면
                        ?>
                        <span>장바구니</span>
                        <span>즉시구매</span>
                        <?php
                            } else { //관리자면 변경 삭제 표시
                        ?>
                        <span onclick = "update_product()">변경하기</span>
                        <span onclick = "delete_product()">삭제하기</span>
                        <?php
                            } 
                        ?>
                    </div>
                </li>
                <?php
                    }
                ?>
            </ul>
            <?php
                if($login_user_id == "admin123"){
            ?>
            <div class="add_product">
                <span onclick = "add_product()">상품 추가하기</span>
            </div>
            <?php
                }
            ?>
            <div class="paging">
                <a href="#" class="btn">처음</a>
                <a href="#" class="btn">이전</a>
                <a href="#" class="num">1</a>
                <a href="#" class="num">2</a>
                <a href="#" class="num">3</a>
                <a href="#" class="btn">다음</a>
                <a href="#" class="btn">마지막</a>
            </div>
        </div>
    
    </div>

    <script>
        function view_product(){
            console.log("상품클릭");
            location.href='http://192.168.80.130/front/html/shop_product_show.html?pd_id='+'뭐시기';
        }

        function add_product(){
            console.log("상품생성");
        }

        function update_product(){
            console.log("상품업데이트");
        }

        function delete_product(){
            console.log("상품삭제");
        }
    </script>
    
</body>
</html>