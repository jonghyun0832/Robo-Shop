<?php

    include "../../back/php/session.php";
    include "../../back/php/connect_mysql.php";

    if ($is_login == TRUE){
        $login_user_id = $_SESSION['user_id'];
    } else {
        $login_user_id = "";
    }

    $sql_new = "SELECT pd_id,pd_name,pd_price,pd_imgpath FROM pd_info_table
    ORDER BY pd_cdate DESC;";

    $result_new = mysqli_query($conn,$sql_new);


?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>쇼핑몰</title>

    <link rel="stylesheet" type="text/css" href="../css/shop.css">
    <link rel="stylesheet" type="text/css" href="../css/header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@500&display=swap" rel="stylesheet">
</head>
<script src="http://code.jquery.com/jquery-latest.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
<body>
    <div class="wrap">
        <?php
            include "../../front/html/header.php";
        ?>
        <div class="main">
            <div class="content_advertise">
                <div class="post-slider">
                    <h1 class="sider-title">Product List</h1>
                    <div class="post-wrapper">
                        <div class="post">
                            <a href="http://192.168.80.130//front/html/shop_product_show.php?pd_id=30"><img src="../../img/capture1.png"></a>
                        </div>
                        <div class="post">
                            <a href="http://192.168.80.130//front/html/shop_product_show.php?pd_id=21"><img src="../../img/capture2.png"></a>
                        </div>
                        <div class="post">
                            <a href="http://192.168.80.130//front/html/shop_product_show.php?pd_id=31"><img src="../../img/capture0.jpg"></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content_item_new" >
                <div class = "card_item1">
                    신상품
                    <div class="new_item_wrap">
                        <ul class = "new_item_list_wrap">
                            <?php
                                for ($i=0; $i<4; $i=$i+1){
                                    $row= mysqli_fetch_array($result_new);

                                    $pd_id = $row['pd_id'];
                                    $pd_name = $row['pd_name'];
                                    $pd_price = $row['pd_price'];
                                    $pd_imgpath = $row['pd_imgpath'];
                                    $pd_get = "http://192.168.80.130//front/html/shop_product_show.php?pd_id=".$pd_id;
                            ?>
                            <li class ="new_item_list">
                                <div class ="new_item_img">
                                    <a href="<?=$pd_get?>">
                                        <img src="<?=$pd_imgpath?>" style="width: 230px; height: 180px;">
                                    </a>
                                </div>
                                <div class ="new_item_name">
                                    <a href="<?=$pd_get?>">
                                        <?=$pd_name?>
                                    </a>
                                </div>
                                <div class ="new_item_price"><?=number_format($pd_price)."원"?></div>
                            </li>
                            <?php
                                }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- <div class="content_item_recommand">
                <div class = "card_item2">
                    추천상품
                    <div class="new_item_wrap">
                        <ul class = "new_item_list_wrap">
                            <li class ="new_item_list">
                                <div class ="new_item_img">
                                <img src="../../pd_img/20211201084311_equipment.png" style="width: 230px; height: 180px;">
                                </div>
                                <div class ="new_item_name">이름</div>
                                <div class ="new_item_price">가격</div>
                            </li>
                            <li class ="new_item_list">
                                <div class ="new_item_img">
                                <img src="../../pd_img/20211201084311_equipment.png" style="width: 230px; height: 180px;">
                                </div>
                                <div class ="new_item_name">이름</div>
                                <div class ="new_item_price">가격</div>
                            </li>
                            <li class ="new_item_list">
                                <div class ="new_item_img">
                                <img src="../../pd_img/20211201084311_equipment.png" style="width: 230px; height: 180px;">
                                </div>
                                <div class ="new_item_name">이름</div>
                                <div class ="new_item_price">가격</div>
                            </li>
                            <li class ="new_item_list">
                                <div class ="new_item_img">
                                <img src="../../pd_img/20211201084311_equipment.png" style="width: 230px; height: 180px;">
                                </div>
                                <div class ="new_item_name">이름</div>
                                <div class ="new_item_price">가격</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
    <script>
        function sendSearch(){
            var newForm = document.createElement('form');
            newForm.name = 'newForm';
            newForm.method = 'get';
            newForm.action = 'http://192.168.80.130/back/php/shop_search.php';
            
            var input_data = document.createElement('input');

            input_data.setAttribute("type", "search");
            input_data.setAttribute("name", "user_search");
            input_data.setAttribute("value", document.getElementById('user_search').value);

            newForm.appendChild(input_data);
            
            document.body.appendChild(newForm);

            newForm.submit();
        }
        $('.post-wrapper').slick({
            infinite : true,
            autoplay: true,
            autoplaySpeed: 2000,
            arrow : true,
            dots : true,
            pauseOnHover : true
        });
    </script>
</body>
</html>