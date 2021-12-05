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
    <title>로봇키트</title>

    <link rel="stylesheet" type="text/css" href="../css/shop_rb_list.css">
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
            <p class="title">로봇키트</p>
            <p class="subtitle">로봇 제작용 재료들입니다.</p>
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
                        <span onclick="add_basket('<?=$is_login?>','<?=$pd_id?>')">장바구니 담기</span>
                        <span onclick="buy_now('<?=$is_login?>','<?=$pd_id?>','<?=$pd_name?>','<?=$pd_price?>')">즉시구매</span>
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
    <script type="text/javascript" src="https://cdn.iamport.kr/js/iamport.payment-1.1.5.js"></script>
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
            input_data.setAttribute("value","1");

            newForm.appendChild(input_data);
            document.body.appendChild(newForm);
            newForm.submit();
            
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
                    location.href='http://192.168.80.130/front/html/shop_rb_list.php';
                    //카테고리 분기점-이건그냥 자기한테 와야함
                });
            } else{
                return;
            }
        }

        function add_basket(is_login, pd_id) {
            console.log("장바구니 담기")
            if (is_login == false){
                alert("로그인이 필요합니다.")
                location.href='http://192.168.80.130/front/html/shop_login.html';
            } else{ //쿠키 설정 파일로 상품번호와 상품갯수 1개(고정)해서 보내기
                //location.href='http://192.168.80.130/back/php/cookie.php?pd_id='+pd_id;
                fetch('http://192.168.80.130/back/php/cookie.php?pd_id='+pd_id+'&pd_cnt='+1)
                .then((res) => res.text())
                .then((data) => {
                    console.log(data);
                    switch(data){
                        case 'false' : //중복일떄
                            alert("이미 장바구니에 담겨있습니다.");
                            break;
                        default:
                            alert("상품을 장바구니에 담았습니다.");
                    }
                });
            }
        }

        function buy_now(is_login, pd_id, pd_name, pd_price) {
            if (is_login == false){
                alert("로그인이 필요합니다.")
                location.href='http://192.168.80.130/front/html/shop_login.html';
            } else { //바로 결제 프로세스
                var IMP = window.IMP; 
                IMP.init('imp22891383'); 
                IMP.request_pay({
                    pg : "kakaopay", 
                    pay_method : 'card',
                    merchant_uid : 'merchant_' + new Date().getTime(),
                    name : pd_name,
                    amount : pd_price,
                    buyer_email : 'sjh_0832@naver.com',
                    buyer_name : '서종현',
                    buyer_tel : '01079160052',
                    buyer_addr : '경기도 군포시 수리산로40',
                    buyer_postcode : '15823',
                    m_redirect_url : 'redirect url'
                }, function(rsp) {
                    if ( rsp.success ) {
                        var msg = '결제가 완료되었습니다.';
                        alert(msg);
                        location.href='http://192.168.80.130/front/html/shop.php';
                    } else {
                        var msg = '결제에 실패하였습니다.';
                        alert(msg);
                        rsp.error_msg;
                    }
                    
                });
            }
        }
    </script>
    
</body>
</html>