<?php
    include "../../back/php/session.php";
    include "../../back/php/connect_mysql.php";

    if ($is_login == TRUE){
        $login_user_id = $_SESSION['user_id'];
    } else {
        $login_user_id = "";
    }
    //로그인 세션으로 관리자면 버튼보이게 해줘야함

    //상품테이블 카테고리2 가져오기
    $sql = "SELECT * FROM pd_info_table I 
    INNER JOIN pd_category_table C ON I.cg_id = C.cg_id 
    WHERE I.cg_id = 2
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
    <title>기타 용품</title>

    <link rel="stylesheet" type="text/css" href="../css/shop_rb_list.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    <div class="wrap">
        <!-- 여기부터 -->
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
        <!-- 여기까지 헤더 부분임 -->
        <div class="main_top">
            <p class="title">기타 용품</p>
            <p class="subtitle">제작용 기타 용품입니다. </p>
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
                        $pd_get = "http://192.168.80.130//front/html/shop_product_show.php?pd_id=".$pd_id;
    
                ?>
                <li class="product_wrap">
                    <div>
                        <a href=<?=$pd_get?>>
                            <img src="<?=$pd_imgpath?>" name="pd_img" id="pd_img" alt="상품" style="width: 250px; height: 250px;">
                        </a>
                    </div>
                    <div class="pd_title" >
                        <a href=<?=$pd_get?>><?=$pd_name?></a>
                    </div>
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
                        <!-- <span onclick = "update_product()">변경하기</span> -->

                        <span onclick = "delete_product('<?=$pd_id?>','<?=$pd_imgpath?>')">삭제하기</span> 

                        <!-- 얘네도 자바메소드 지우고 눌렀을떄 php에서 pd_id전달해줘야함 -->
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
        function add_product(){
            console.log("상품생성");

            let newForm = document.createElement('form');
            newForm.name = 'newForm';
            newForm.method = 'post';
            newForm.action = 'http://192.168.80.130/front/html/shop_product_add.php';

            let input_data = document.createElement('input');

            input_data.setAttribute("type", "text");
            input_data.setAttribute("name",'cg_id');
            input_data.setAttribute("value","2");

            newForm.appendChild(input_data);
            document.body.appendChild(newForm);
            newForm.submit();
            
        }

        function update_product(){
            console.log("상품업데이트");
        }

        function delete_product(delete_id, img_path){
            console.log("상품삭제");
            if (confirm("정말 삭제하시겠습니까?") == true){
                //삭제
                fetch('http://192.168.80.130/back/php/shop_delete_product.php?pd_id='+delete_id+'&img_path='+img_path)
                .then((res) => res.text())
                .then((data) => {
                    console.log(data);
                    alert("삭제가 완료되었습니다.")
                    location.href='http://192.168.80.130/front/html/shop_eq_list.php';
                    //카테고리 분기점-이건그냥 자기한테 와야함
                });
            } else{
                return;
            }
        }
    </script>
</body>
</html>