<?php
    $ccc = "오늘의명언";
    $host = '192.168.80.130';
    $user = 'winjonghyun';
    $pw = '1401';
    $dbname = 'practice';
    $conn = mysqli_connect($host, $user, $pw, $dbname);
 
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    

    $sql = "SELECT sno, name, tel FROM student_tb";
    $result = $conn->query($sql);


    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "인덱스 : " . $row["sno"]. " 이름 : " . $row["name"]. " 전화번호 :  " . $row["tel"]. "<br>";
        }
    } else {
       echo "0 results";
    }
    $conn->close();

    //데이터 받아오기
    $id_get=$_GET["login_id"];
    $pw_get=$_GET["login_password"];
    $id_post=$_POST["login_id"];
    $pw_post=$_POST["login_password"];
?>

<style>
    *{
        text-decoration: none; /*아래밑줄 제거*/
        color: black; /*글자색 검은색 고정*/
    }
    
</style>

<!DOCTYPE html>
<html>
    <head>
        <title>
            내가만든연습페이지
        </title>
        <meta charset = "utf-8">
    </head>
    <body>
        <h1>
            <div> <?=$ccc?> </div>
            <span>
                <a href = "https://www.naver.com/">네이버로 바로가기</a>
            </span>
            옆에써지려나?
            <div>
                <a target = "_blank" href = "https://www.naver.com/">네이버 새페이지에 띄우기</a>
            </div>
        </h1>
        <ol>
            <li><a href="1.php">로그인(get)</a></li>
            <li><a href="2.php">로그인(post)</a></li>
            <li><a href="3.php">3번으로 이동하기</a></li>
        </ol>
        <div><h2>아이디(get) : <?=$id_get?></h2></div>
        <div><h2>비밀번호(get)) : <?=$pw_get?></h2></div>
        <div><h2>아이디(post) : <?=$id_post?></h2></div>
        <div><h2>비밀번호(post) : <?=$pw_post?></h2></div>


    </body>


</html>
