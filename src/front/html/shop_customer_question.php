<?php
    include "../../back/php/session.php";
    
    //글쓰기 눌렀을때는 로그인 했어야 글쓸수 있게 만들어주면됨

    //sql 내부 데이터 개수 파악
    include "../../back/php/connect_mysql.php";

    $sql = "SELECT * FROM community_table C INNER JOIN user_table U ON C.user_id = U.user_id ORDER BY cm_id DESC";
    $result = mysqli_query($conn,$sql);
    $exist_num = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>고객센터</title>

    <link rel="stylesheet" type="text/css" href="../css/shop_customer_question.css">
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
                <li><a href="shop_eq_list.php">기타용품</a></li>
                <li><a href="shop_customer_question.php">고객센터</a></li>
            </ul>
            <div class="searchArea">
                <!-- 서치.php만들어줘야함 / sendsearch 메소드 아직 안만들어줬음 -->
                <form action="../../back/php/shop_search.php" name = "검색" method = "get">
                    <input type="search" name = "user_search" id = 'user_search' placeholder="Search">
                    <span><img src="../../img/search.png" height="25px" onclick="sendSearch()"></span>
                </form>
            </div>
        </div>
        <div class="main_top">
            <p class="title">고객센터</p>
            <p class="subtitle">상품에 관련된 문의를 자유롭게 해주세요. </p>
        </div>
        <div class="board_list_wrap">
            <table class ="board_list">
                <caption>게시판 목록</caption>
                <thead>
                    <tr>
                        <th class='first'>번호</th>
                        <th class='second'>제목</th>
                        <th class='third'>글쓴이</th>
                        <th class='fourth'>작성일</th>
                        <th class='fifth'>조회수</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    for ($i=0; $i<$exist_num; $i=$i+1){
                        $row= mysqli_fetch_array($result);
                        
                        $cm_id = $row['cm_id'];
                        // $user_id = $row['user_id'];
                        $user_name = $row['user_name'];
                        $cm_title = $row['cm_title'];
                        $cm_cdate = $row['cm_cdate'];
                        $cm_view = $row['cm_view'];
                        $cm_get = "http://192.168.80.130//front/html/shop_customer_question_read.php"."?cm_id=".$cm_id;
                ?>
                    <tr>
                        <td><?= $cm_id ?></td>
                        <td class="tit">
                            <a href=<?=$cm_get?>><?= $cm_title ?></a>
                        </td>
                        <td><?= $user_name?></td>
                        <td><?= $cm_cdate ?></td>
                        <td><?= $cm_view ?></td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
            <div class = "between">
                <!-- <a href="shop_customer_question_write.php" onclick = "create_content()">글쓰기</a> -->
                <span onclick = "create_content()">글쓰기</span>
            </div>
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
        //스크립트 분리필요
        function create_content(){
            let newForm = document.createElement('form');
            newForm.name = 'newForm';
            newForm.method = 'post';
            newForm.action = 'http://192.168.80.130/front/html/shop_customer_question_write.php';

            let input_data = document.createElement('input');

            input_data.setAttribute("type", "text");
            input_data.setAttribute("name",'cm_id');
            input_data.setAttribute("value","");

            newForm.appendChild(input_data);
            document.body.appendChild(newForm);
            newForm.submit();
        }
    </script>
    
    
</body>
</html>