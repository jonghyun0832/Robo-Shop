
<div class = intro_top>
    <?php
        if ($is_login == FALSE){ //로그인 아직 안했음
    ?>
    <ul class="top_item">
        <li><a href="shop_login.html">로그인</a></li>
        <li><a href="shop_create_account.html">회원가입</a></li>
        <li><a href="shop_basket.php">장바구니</a></li>
    </ul>
    <?php
        }else { //로그인 완료
    ?>
    <ul class="top_item">
        <li><?php echo $_SESSION['user_name']?>님 안녕하세요</li>
        <li><a href="../../back/php/shop_logout.php">로그아웃</a></li>
        <?php
            if($_SESSION['user_id'] == 'admin123'){
        ?>   
        <li><a href="shop_order_check.php">주문확인</a></li>
        <?php
            } else {
        ?>
        <li><a href="shop_basket.php">장바구니</a></li>
        <?php
            }
        ?>
    </ul>
    <?php
        }
    ?>
</div>
<div class="header">
    <div class="main_logo">
        <a href="../html/shop.php">    
            <img src="../../img/ROBO.png" width="150px" height="64px">
        </a>
    </div>
    <ul class="nav">
        <li><a href="shop_rb_list.php">로봇키트</a></li>
        <li><a href="shop_eq_list.php">기타용품</a></li>
        <li><a href="shop_customer_question.php">공지사항</a></li>
    </ul>
    <div class="searchArea">
        <!-- 서치.php만들어줘야함 -->
        <form action="../../front/html/shop_search.php" name = "검색" method = "get">
            <input type="search" name = "user_search" id = 'user_search' placeholder="Search">
            <span><img src="../../img/search.png" height="25px" onclick="sendSearch()"></span>
        </form>
    </div>
</div>


