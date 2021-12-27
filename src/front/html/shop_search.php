<?php
    include "../../back/php/session.php";
    include "../../back/php/connect_mysql.php";

    if ($is_login == TRUE){
        $login_user_id = $_SESSION['user_id'];
    } else {
        $login_user_id = "";
    }

    $search = $_GET['user_search'];

    if(isset($_GET["page"])){
        $page = $_GET["page"]; // 하단에서 다른 페이지 클릭하면 해당 페이지 값 가져와서 보여줌
    } else {
        $page = 1; // 게시판 처음 들어가면 1페이지로 시작
    }

    $sql = "SELECT * FROM pd_info_table I 
    INNER JOIN pd_category_table C ON I.cg_id = C.cg_id 
    WHERE I.pd_name like '%$search%'
    ORDER BY I.pd_id DESC";
    $result = mysqli_query($conn,$sql);
    $exist_num = mysqli_num_rows($result);


?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>robo_search</title>

    <link rel="stylesheet" type="text/css" href="../css/shop_rb_list.css">
    <link rel="stylesheet" type="text/css" href="../css/header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    <div class="wrap">
        <?php
            include "../../front/html/header.php";
        ?>
        <div class="main_top">
            <p class="title">검색결과</p>
            <p class="subtitle"><?=$search."으로 검색한 결과입니다."?></p>
        </div>
    </div>
    <div class="product_list_wrap">
        <ul class="product_list">
            <?php

                $list = 3; //보여줄 게시물 개수
                $block_cnt = 3; //블록페이지 개수
                $block_num = ceil($page/$block_cnt);
                $block_start = (($block_num-1)*$block_cnt)+1;
                $block_end = $block_start + $block_cnt - 1;

                $current = ($page-1) * $list;

                $total_page = ceil($exist_num/$list);
                //자료수가 적으면 페이지 블록 갯수 조절
                if($block_end > $total_page){
                    $block_end = $total_page;
                }
                $total_block = ceil($total_page/$block_cnt);
                $page_start = ($page-1)*$list;

                $sql_pageRecord = "SELECT * FROM pd_info_table
                WHERE pd_name like '%$search%'
                ORDER BY pd_id DESC
                LIMIT $page_start,$list";

                $result_pageRecord = mysqli_query($conn,$sql_pageRecord);

                if (mysqli_num_rows($result_pageRecord) < $list){
                    $list = mysqli_num_rows($result_pageRecord);
                }


                for ($i=0; $i<$list; $i=$i+1){
                    $row= mysqli_fetch_array($result_pageRecord);

                    $pd_id = $row['pd_id']; //상품고유번호
                    $pd_name = $row['pd_name']; //상품이름 1
                    $pd_price = $row['pd_price']; //상품가격 1
                    $pd_imgpath = $row['pd_imgpath']; //상품이미지 1
                    // $cg_name = $row['cg_name']; //카테고리 이름
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
            </li>
            <?php
                }
            ?>
        </ul>
        <div class="paging">
            <?php
                //처음 만들기
                if($page <= 1){
                    //빈거
                } else{
                    echo "<a href='shop_search.php?page=1&user_search=$search'>처음</a>";
                }
                //이전 만들기
                if($page <= 1){
                    //빈거
                } else {
                    $pre = $page - 1;
                    echo "<a href='shop_search.php?page=$pre&user_search=$search'>이전</a>";
                }

                for ($i = $block_start; $i <= $block_end; $i++){
                    if($page == $i){
                        echo "<a class='num on'>$i</a>";
                    } else {
                        echo "<a href='shop_search.php?page=$i&user_search=$search' class='num'>$i</a>";
                    }
                }

                if($page >= $total_page){
                    //빈거
                } else {
                    $next = $page + 1;
                    echo "<a href='shop_search.php?page=$next&user_search=$search'>다음</a>";
                }

                if($page >= $total_page) {
                    //빈거
                } else {
                    echo "<a href='shop_search.php?page=$total_page&user_search=$search'>마지막</a>";
                }
            ?>
        </div>
    </div>
</body>
</html>