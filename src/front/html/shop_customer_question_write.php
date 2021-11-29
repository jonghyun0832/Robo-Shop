<?php
    include "../../back/php/session.php";
    include "../../back/php/connect_mysql.php";

    // 로그인 했을때만 글 작성 화면으로 넘아간다.
    if ($is_login == FALSE){
        echo "<script>alert('로그인 후 이용해주세요.');
        location.href='http://192.168.80.130//front/html/shop_login.html'
        </script>";
    }
    $content_id = $_POST['cm_id'];
    $cm_img_name = "";
    $cm_imgpath = "";

    $isnew = true;

    if (empty($content_id)){
        echo "새글임";
        //새로 작성하는 글임
    } else {
        //업데이트 하는 글임
        echo "업데이트임";
        $isnew = false;
        $sql = "SELECT * FROM community_table WHERE cm_id = '".$content_id."'";
        $result = mysqli_query($conn,$sql);
        $row= mysqli_fetch_array($result);
        $cm_title = $row['cm_title'];
        $cm_cdate = $row['cm_cdate'];
        $cm_view = $row['cm_view'];
        $cm_content = $row['cm_content'];
        $cm_imgpath = $row['cm_imagepath'];
        $tmp_arr = explode("_",$cm_imgpath);
        $cm_img_name = $tmp_arr[1];
    }

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>고객센터-글쓰기</title>

    <link rel="stylesheet" type="text/css" href="../css/shop_customer_question_write.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    <div class="wrap">
        <div class="header">
            <span class="write_data" onclick="writedata()">등록하기</span>
            <!-- <input type="button" value="등록하기" onclick=""> -->
        </div>
        <div class="main_top">
            <p class="title">고객센터</p>
            <p class="subtitle">상품에 관련된 문의를 자유롭게 해주세요. </p>
        </div>
        <form action="../../back/php/shop_save_content.php" method="post" enctype="multipart/form-data" id="sendform">
            <div class="board_write_list_wrap">
                <table class="board_write_list">
                    <caption>글쓰기 형식</caption>
                    <thead>
                        <tr>
                            <th>문의 내용을 적어주세요</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                                if ($isnew == true){ //새글일떄
                            ?>
                            <tr class="ct_title">
                                <td><input type="text" name="title" id="title" placeholder="제목을 입력해주세요."></td>
                            </tr>
                            <tr class="ct_content">
                                <td><textarea name="content" id="content" cols="50" rows="10" placeholder="내용을 입력해주세요." wrap="hard"></textarea></td>
                                
                            </tr>
                            <tr class="ct_img">
                                <td>
                                    <input type="file" name="find_img" id="find_img" accept="image/*">
                                    <label for="find_img" class="btn_file">파일선택</label>
                                    <span id="fileName">선택된 파일 없음</span>
                                </td>
                            </tr>
                            <?php
                                }
                                else { //업데이트일때
                            ?>
                            <tr class="ct_title">
                                <td><input type="text" name="title" id="title" placeholder="제목을 입력해주세요." value=<?=$cm_title?>></td>
                            </tr>
                            <tr class="ct_content">
                                <td>
                                    <textarea name="content" id="content" cols="50" rows="10" placeholder="내용을 입력해주세요." wrap="hard"><?=$cm_content?></textarea>
                                </td>
                            </tr>
                            <!-- 이미지도해야함 -->
                            <tr class="ct_img">
                                <td>
                                <input type="file" name="find_img" id="find_img" accept="image/*">
                                <label for="find_img" class="btn_file">파일선택</label>
                                <span id="fileName"><?=$cm_img_name?></span>
                            </td>
                            </tr>
                            <?php
                                }
                            ?>
                            
                    </tbody>
                </table>
            </div>
        </form>
    </div>
    <script>
        function writedata() {
            console.log("dsdsdsd")
            let cm_title = document.getElementById('title');
            let cm_content = document.getElementById('content');
            if(cm_title.value == ""){
                alert("제목을 입력해주세요.");
            } else {
                if (cm_content.value == ""){
                    alert("내용을 입력해주세요.");
                } else {
                    let sendform = document.getElementById('sendform');

                    let input_data = document.createElement('input');

                    input_data.setAttribute("type", "text");
                    input_data.setAttribute("name",'isnew');
                    input_data.setAttribute("value",'<?=$isnew?>');

                    sendform.appendChild(input_data);

                    let input_data2 = document.createElement('input');

                    input_data2.setAttribute("type", "text");
                    input_data2.setAttribute("name",'cm_id');
                    input_data2.setAttribute("value",'<?=$content_id?>');

                    sendform.appendChild(input_data2);

                    let input_data3 = document.createElement('input');

                    input_data3.setAttribute("type", "text");
                    input_data3.setAttribute("name",'prev_img');
                    input_data3.setAttribute("value",'<?=$cm_img_name?>');

                    sendform.appendChild(input_data3);

                    let input_data4 = document.createElement('input');

                    input_data4.setAttribute("type", "text");
                    input_data4.setAttribute("name",'prev_img_path');
                    input_data4.setAttribute("value",'<?=$cm_imgpath?>');

                    sendform.appendChild(input_data4);


                    document.body.appendChild(sendform);
                    sendform.submit();
                }
            }
        }

        document.getElementById('find_img').addEventListener('change', function(){
        var filename = document.getElementById('fileName');
        if(this.files[0] == undefined){
            filename.innerText = '선택된 파일없음';
            return;
        }
        filename.innerText = this.files[0].name;
        });

    </script>
    <!-- <script>
        function submit_content() {
            //제목있나확인
            //글있나 확인
            
            //다되었을때 보내기
            var userData = {
                'cm_title' : document.getElementById('title').value,
                'cm_content' : document.getElementById('content').value
            };

        var newForm = document.createElement('form');
        newForm.name = 'newForm';
        newForm.method = 'post';
        newForm.enctype = 'multipart/form-data';
        newForm.action = 'http://192.168.80.130/back/php/shop_save_content.php';
        // newForm.target = '_blank';
        for (var key in userData){
        var input_data = document.createElement('input');

        input_data.setAttribute("type", "text");
        input_data.setAttribute("name",key);
        input_data.setAttribute("value",userData[key]);

        newForm.appendChild(input_data);
        }
        document.body.appendChild(newForm);

        newForm.submit();
        

        // // newForm.appendChild(input_data);

        // document.body.appendChild(newForm);
        // }
        }
    </script> -->
</body>
</html>