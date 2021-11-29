<?php
    include "../../back/php/session.php";
    include "../../back/php/connect_mysql.php";

    $content_id = $_GET['cm_id'];
    if ($is_login == TRUE){
        $login_user_id = $_SESSION['user_id'];
    } else {
        $login_user_id = "";
    }

    $sql = "SELECT * FROM community_table WHERE cm_id = '".$content_id."'";
    $result = mysqli_query($conn,$sql);
    $row= mysqli_fetch_array($result);
    $user_id = $row['user_id'];
    $cm_title = $row['cm_title'];
    $cm_cdate = $row['cm_cdate'];
    $cm_view = $row['cm_view'];
    $cm_content = $row['cm_content'];
    $cm_imgpath = $row['cm_imagepath'];

    $cm_content_convert = str_replace("\r\n", "<br>",$cm_content);


?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>제목가져와서 붙이기</title>

    <link rel="stylesheet" type="text/css" href="../css/shop_customer_question_read.css">
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
                <li><a href="shop_customer_question.php">고객센터</a></li>
            </ul>
            <div class="searchArea">
                <!-- 서치.php만들어줘야함 온클릭 메소드도 만들어줘야함-->
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
        <div class="content_wrap">
            <div class="content_header">
                <span><?=$user_id?></span>
                <span><?=$cm_cdate?></span>
                <span>조회수 : <?=$cm_view?></span>
            </div>
            <div class="content_title">
                <?=$cm_title?>
            </div>
            <div class="content_body">
                <?php
                    //이미지 경로가 존재하면 이미지 띄워주기
                    if ($cm_imgpath != ""){
                ?>
                <div class="img_area"><img src="<?=$cm_imgpath?>" alt="컨텐츠사진"></div>
                <?php
                    }
                ?>
                <div class="text_area"><?=$cm_content_convert?></div>
            </div>
            <?php
                if ($login_user_id == $user_id){
            ?>
            <div class = "content_tail">
                    <span onclick = "update_content()">수정</span>
                    <span onclick="delete_content()">삭제</span>
            </div>
            <?php
                }
            ?>
        </div>
    </div>
    <script>
        function update_content() {

            let newForm = document.createElement('form');
            newForm.name = 'newForm';
            newForm.method = 'post';
            newForm.action = 'http://192.168.80.130/front/html/shop_customer_question_write.php';

            let input_data = document.createElement('input');

            input_data.setAttribute("type", "text");
            input_data.setAttribute("name",'cm_id');
            input_data.setAttribute("value",<?=$content_id?>);

            newForm.appendChild(input_data);
            document.body.appendChild(newForm);
            newForm.submit();
            
        }
        function delete_content() {
            if (confirm("정말 삭제하시겠습니까?") == true){
                //삭제
                fetch('http://192.168.80.130/back/php/delete_content.php?cm_id='+'<?=$content_id?>'+'&img_path='+'<?=$cm_imgpath?>')
                .then((res) => res.text())
                .then((data) => {
                    console.log(data);
                    alert("삭제가 완료되었습니다.")
                    location.href='http://192.168.80.130/front/html/shop_customer_question.php';
                });
            } else{
                return;
            }
        }
    </script>
</body>
</html>