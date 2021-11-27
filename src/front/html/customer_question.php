<?php
    // include "session.php";
    session_start();
    $is_login = FALSE;
    if(isset( $_SESSION['user_id']) ) {
      $is_login = TRUE;
    }
?>

<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" type="text/css" href="../css/customer_question.css">
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
                    <img src="../../img/쇼핑몰다람쥐.jpg" width="150px" height="64px">
                </a>
            </div>
            <ul class="nav">
                <li><a href="#">로봇 키트</a></li>
                <li><a href="#">로봇 모터</a></li>
                <li><a href="#">기타용품</a></li>
                <li><a href="customer_question.php">고객센터</a></li>
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
            <p class="title">고객센터</p>
            <p class="subtitle">상품에 관련된 문의를 자유롭게 해주세요. </p>
        </div>
        <div class="main_wrap">
                <table>
                    <thead>
                        <tr>
                            <th scope="col1">번호</th>
                            <th scope="col2">제목</th>
                            <th scope="col3">글쓴이</th>
                            <th scope="col4">등록일</th>
                            <th scope="col5">조회수</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="td_num"></td>
                            <td class="td_title"></td>
                            <td class="td_writer"></td>
                            <td class="td_date"></td>
                            <td class="td_visit"></td>
                        </tr>
                    </tbody>
                </table>
        </div>
        
        

    </div>
    
    
</body>
</html>