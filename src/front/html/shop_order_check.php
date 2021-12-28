<?php
    include "../../back/php/session.php";
    include "../../back/php/connect_mysql.php";

    $sql_order = "SELECT * FROM order_table
    ORDER BY od_boolean, od_id DESC";

    $result_order = mysqli_query($conn,$sql_order);
    $exist = mysqli_num_rows($result_order);

?>


<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>주문확인</title>

    <link rel="stylesheet" type="text/css" href="../css/shop_order_check.css">
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
        <div class="main_top">
            <p class="title">주문확인</p>
        </div>
        <div class="basket_list_wrap">
            <table class="basket_list">
                <caption>장바구니 목록</caption>
                <thead>
                    <tr>
                        <th class="first">주문날짜</th>
                        <th class="third">상품명</th>
                        <th class="fourth">가격</th>
                        <th class="fifth">구매자 정보</th>
                        <th class="sixth">처리상태</th>
                    </tr>
                </thead>
                <tbody class = "infinite" id = "infinite">
                    <?php
                    for ($j=0; $j<$exist; $j=$j+1){
                        $row= mysqli_fetch_array($result_order);
                        
                        //주문 테이블에서 데이터 가져오기
                        $od_id = $row['od_id']; //주문 id
                        $pd_id_str = $row['pd_id_str'];
                        $pd_count_str = $row['pd_count_str'];
                        $user_id = $row['user_id'];
                        $od_cdate = $row['od_cdate']; //생성일
                        $od_boolean = $row['od_boolean']; //처리여부

                        //데이터 쪼개서 배열로만들기
                        $pd_id_arr = explode(",",$pd_id_str); //상품id 리스트
                        $pd_count_arr = explode(",",$pd_count_str); //상품별 갯수
                        //유저 테이블에서 데이터 가져오기
                        $sql_person = "SELECT * FROM user_table
                        WHERE user_id ='".$user_id."'";

                        $result = mysqli_query($conn,$sql_person);
                        $row= mysqli_fetch_array($result);

                        $user_name = $row['user_name']; //소비자 이름
                        $user_email = $row['user_email']; //소비자 이메일
                        $user_phone_number = $row['user_phone_number']; //소비자 번호
                        $user_address_post = $row['user_address_post']; //소비자 우편번호
                        $user_address = $row['user_address']; //소비자 주소
                        $user_address_detail = $row['user_address_detail']; //소비자 상세주소

                        //상품 테이블에서 데이터 가져오기
                        $pd_name_arr = [];
                        $pd_total_price = 0;
                        for ($i=0; $i<count($pd_id_arr); $i=$i+1){
                            $sql_product = "SELECT pd_name,pd_price FROM pd_info_table
                            WHERE pd_id = '".$pd_id_arr[$i]."'";

                            $result = mysqli_query($conn,$sql_product);
                            $row= mysqli_fetch_array($result);

                            $product_name = $row['pd_name'];
                            $product_price = $row['pd_price'];

                            array_push($pd_name_arr, $product_name." : ".$pd_count_arr[$i]);
                            $pd_total_price = $pd_total_price + (int)$product_price*(int)$pd_count_arr[$i];
                        }

                        $pd_name_str = $pd_name_arr[0];
                        if (count($pd_name_arr) > 1){
                            for ($i=1; $i<count($pd_name_arr); $i=$i+1){
                                $pd_name_str = $pd_name_str.",<br>".$pd_name_arr[$i];
                            }
                        }
                    ?>
                    <tr class="list">
                        <td class="date"><?=$od_cdate?></td>
                        <td class="tit">
                            <?=$pd_name_str?>
                        </td>
                        <td class="price"><?=number_format($pd_total_price)."원"?></td>
                        <td class="consumer">
                            <div><?=$user_name?></div>
                            <div><?=$user_email?></div>
                            <div><?=$user_phone_number?></div>
                            <div><?=$user_address_post?></div>
                            <div><?=$user_address." ".$user_address_detail?></div>
                        </td>
                        <td class="done">
                        
                            <?php
                                if($od_boolean == FALSE){
                            ?>
                            <span class="process" id="od_complete<?=$j?>" onclick="order_complete(<?=$j?>,<?=$od_id?>)">
                                미처리
                            </span>
                            <?php
                                } else {
                            ?>
                            <span class="finish" id="od_complete<?=$j?>">처리완료</span>
                            <?php
                                }
                            ?>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                    <tr class="empty"></tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- <script type="text/javascript" src="../js/order_check.js"></script> -->
    <script>
        function order_complete(j,od_id){
            console.log("처리처리");
            if (confirm("주문을 완료 처리 하시겠습니까?") == true){
                fetch('http://192.168.80.130/back/php/order_finish.php?od_id='+od_id)
                .then((res) => res.text())
                .then((data) => {
                    console.log(data);
                    // alert("처리완료")
                    // location.href='http://192.168.80.130/front/html/shop_order_check.php';
                    const btn_done = document.getElementById('od_complete'+j);
                    btn_done.innerText = "처리완료";
                    btn_done.style.color = "white";
                    btn_done.style.border = "none";
                    btn_done.style.backgroundColor = "green";
                    window.location.reload();
                });
            } else {
                return;
            }
        }

        

        function load_data(page,bool) {
            if (bool == 0){ //데이터 끝나면 스크롤을 멈춘다.
                fetch('http://192.168.80.130/back/php/load_data.php?page='+now_page+'&end='+bool)
                .then((res) => res.text())
                .then((data) => {
                    switch(data){
                        case 'false':{ //불러올게 없을떄
                            console.log(data);
                            console.log(now_page);
                            io.disconnect();
                        }
                        default:{ //데이터 불러올떄
                            data1 = JSON.parse(data);
                            console.log(data1);
                            console.log(now_page);
                            now_page = now_page + 1;
                            end = data1[0][0];

                            data_len = data1.length;

                            let tbody = document.getElementById('infinite');

                            for (var i = 0; i < data_len; i++) {
                                
                                let tr = document.createElement('tr');
                                // let tr = document.createElement('tr');
                                let td2 = document.createElement('td');
                                td2.setAttribute('class','date');

                                let td3 = document.createElement('td');
                                td3.setAttribute('class','tit');

                                let td4 = document.createElement('td');
                                td4.setAttribute('class','price');

                                let td5 = document.createElement('td');
                                td5.setAttribute('class','consumer');
                                
                                let div_name = document.createElement('div');
                                let div_email = document.createElement('div');
                                let div_phone_number = document.createElement('div');
                                let div_address_post = document.createElement('div');
                                let div_address_detail = document.createElement('div');
                                
                                div_name.innerHTML = data1[i][4];
                                div_email.innerHTML = data1[i][5];
                                div_phone_number.innerHTML = data1[i][6];
                                div_address_post.innerHTML = data1[i][7];
                                div_address_detail.innerHTML = data1[i][8] +" "+ data1[i][9];

                                td5.appendChild(div_name);
                                td5.appendChild(div_email);
                                td5.appendChild(div_phone_number);
                                td5.appendChild(div_address_post);
                                td5.appendChild(div_address_detail);


                                let td6 = document.createElement('td');
                                td6.setAttribute('class','done');

                                // <span class="process" id="od_complete<?=$j?>" onclick="order_complete(<?=$j?>,<?=$od_id?>)">

                                let span = document.createElement('span');

                                td2.innerHTML = data1[i][1];
                                td3.innerHTML = data1[i][2];
                                td4.innerHTML = data1[i][3].toLocaleString('ko-KR')+"원";
                                //td5.innerHTML = "구매자정보";
                                td6.innerHTML = data1[i][10];

                                
                                tr.appendChild(td2);
                                tr.appendChild(td3);
                                tr.appendChild(td4);
                                tr.appendChild(td5);
                                tr.appendChild(td6);

                                tbody.appendChild(tr);

                            }
                            let tr_empty = document.createElement('tr');
                            tr_empty.setAttribute('class','empty');
                            tr_empty.setAttribute('id','empty'+now_page);

                            tbody.appendChild(tr_empty);

                            changeTarget(now_page);
                        }
                    }
                });



            }
            
        }

        // const options = {
        // root: null, // 또는 scrollable 한 element root: document.querySelector('#scrollArea'),
        // rootMargin: '10px', // 기본값 0px 상우하좌
        // threshold: 0.5 // 0.0 ~ 1.0 사이의 숫자. 배열도 가능
        // }

        let now_page = 0;
        let end = 0;

        const io = new IntersectionObserver((entries,observer) => {
            entries.forEach(entry => {
                //   console.log('entry:',entry);
                //   console.log('observer:',observer);
                // 관찰 대상이 viewport 안에 들어온 경우 'tada' 클래스를 추가
                if (entry.intersectionRatio > 0) {
                    // entry.target.classList.add('tada');
                    console.log("들어왔음");
                    load_data(now_page,end);
                }
                // 그 외의 경우 'tada' 클래스 제거
                else {
                    // entry.target.classList.remove('tada');
                    console.log("그외는 삭제");
                }
            })
        });

        // 관찰할 대상을 선언하고, 해당 속성을 관찰시킨다.
        const boxElList = document.querySelectorAll('.empty');
        boxElList.forEach((el) => {
            console.log("io.observe실행");
            io.observe(el);
        })

        function changeTarget(npage) {
            io.disconnect();
            console.log("타겟들어옴");
            nid = "empty" + npage;
            io.observe(document.getElementById(nid));
        }

    </script>

</body>
</html>