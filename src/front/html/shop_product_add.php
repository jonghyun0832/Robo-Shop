<?php
    include "../../back/php/session.php";
    include "../../back/php/connect_mysql.php";

    $cg_id_prev = $_POST['cg_id'];


    $sql = "SELECT * FROM pd_category_table
    ORDER BY cg_id;";
    $result = mysqli_query($conn,$sql);
    $exist_num = mysqli_num_rows($result);

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>새 상품 추가하기</title>

    <link rel="stylesheet" type="text/css" href="../css/shop_product_add.css">
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
        <form action="../../back/php/shop_register_item.php" method="post" enctype="multipart/form-data" id="sendform">
        <div class="main_category_choice">
            <span>
                <select name="category_box" id="category_box">
                    <option value="">카테고리를 선택하세요.</option>
                    <?php
                        for ($i=0; $i<$exist_num; $i=$i+1){
                            $row= mysqli_fetch_array($result);
                            $cg_name = $row['cg_name']; //카테고리이름
                            $cg_id = $row['cg_id']; //카테고리번호
                    ?>
                    <!-- value는 카테고리 번호 / 띄워주는 이름은 카테고리 이름 -->
                    <option value="<?=$cg_id?>"><?=$cg_name?></option>
                    <?php
                        }
                    ?>
                </select>
            </span>
            <span>(필수)</span>
            <!-- 여기서 데이터베이스에서 카테고리 뭐있나 보여줘야함 -->
            <!-- 카테고리 -> 아이템이름 -->
        </div>
        <div class="main_wrap">
            <div class="main_img">
                <img src="../../pd_img/no_img.png" id="img_show" style="max-width: 400px; height: auto;">
                <div class="between">
                    <input type="file" name="find_img" id="find_img" accept="image/*">
                    <label for="find_img" class="btn_file">파일선택</label>
                    <span id="fileName">선택된 파일 없음</span>
                </div>
                <!-- <img src="<?=$pd_imgpath?>" style="max-width: 400px; height: auto;"> -->
            </div>
            <div class="main_content_wrap">
                <div class="name">
                    <input type="text" name="pd_name" id="pd_name" placeholder="상품이름을 입력해주세요.">
                    <!-- <input type="text" name="title" id="title" placeholder="상품이름을 입력해주세요." value=<?=$cm_title?>> -->
                    <!-- 상품 이름 -->
                    <span>(필수)</span>
                </div>
                <div class="price">
                    <input type="text" name="pd_price" id="pd_price" placeholder="상품가격을 입력해주세요.">
                    <!-- 상품 가격 -->
                    <span>(필수)</span>
                </div>
            </div>
        </div>
        <div class="tail_wrap">
            <div class="tail">
                <div class="tail_head">
                    상품정보
                    <span>(필수)</span>
                </div>
                <div class="tail_content">
                    <!-- 상품정보받아서 입력 -->
                    <textarea name="pd_content" id="pd_content" cols="50" rows="10" placeholder="상품정보를 입력해주세요." wrap="hard"></textarea>
                    <!-- <textarea name="content" id="content" cols="50" rows="10" placeholder="내용을 입력해주세요." wrap="hard"><?=$cm_content?></textarea> -->
                </div>
                <div class="end">
                    <span onclick="register()">등록하기</span>
                    <span onclick="cancel('<?=$cg_id_prev?>')">취소</span>
                </div>
            </div>
        </div>
        </form>
    </div>

    <script>
        //이미지 바꿨을떄 표시되는것도 바꿔줌
        document.getElementById('find_img').addEventListener('change', function(){
        
            let filename = document.getElementById('fileName');
            let imgpath = document.getElementById('img_show');
            if(this.files[0] == undefined){
                filename.innerText = '선택된 파일없음';
                imgpath.src = "../../pd_img/no_img.png"
                return;
            }
            filename.innerText = this.files[0].name;
            const reader = new FileReader()

            reader.onload = e => {
                const previewImage = document.getElementById("img_show")
                previewImage.src = e.target.result
            }

            reader.readAsDataURL(this.files[0])
        });

        function register() {
            let cg_select = document.getElementById('category_box').value;
            let pd_name = document.getElementById('pd_name').value;
            let pd_price = document.getElementById('pd_price').value;
            let pd_content = document.getElementById('pd_content').value;

            if (cg_select =="" || pd_name =="" || pd_price =="" || pd_content ==""){
                alert("필수 정보를 기입해주세요.");
            } else {
                let sendform = document.getElementById('sendform');
                sendform.submit();
            }

            
        }

        function cancel(cg_id_prev) { //이전페이지가 뭐였는지 카테고리번호로 판단
            if (confirm("정말 취소하시겠습니까?\n이제까지 작성한 데이터는 사라집니다") == true){
                //상품리스트 페이지로 돌아가기
                if (cg_id_prev == "1"){ //1번 로봇키트 카테고리 페이지로
                    location.href='http://192.168.80.130/front/html/shop_rb_list.php';
                } else { //2번 기타용품 카테고리 페이지로
                    location.href='http://192.168.80.130/front/html/shop_eq_list.php';
                }
            } else{
                return;
            }
        }
    </script>
    
</body>
</html>