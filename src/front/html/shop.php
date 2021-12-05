<?php

    include "../../back/php/session.php";
    include "../../back/php/connect_mysql.php";

    if ($is_login == TRUE){
        $login_user_id = $_SESSION['user_id'];
    } else {
        $login_user_id = "";
    }
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    <div class="wrap">
        <?php
            include "../../front/html/header.php";
        ?>
        <div class="main">
            <div class="content_advertise">
                상품광고
            </div>
            <div class="content_item_new" >
                <div class = "card_item1">
                    신제품
                </div>
            </div>
            <div class="content_item_recommand">
                <div class = "card_item2">
                    추천상품
                </div>
            </div>
            <div class="content_item_best">
                <div class="card_item3">
                    베스트상품
                </div>
            </div>
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
    </script>
</body>
</html>