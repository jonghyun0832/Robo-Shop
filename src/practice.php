<?php
    $ccc = "오늘의명언";
    $host = '127.0.0.1';
    $user = 'root';
    $pw = 'tjwhdgus';
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
?>


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
            <li>
                <div>
                    <a target = "_blank" href = "https://www.naver.com/">네이버 새페이지에 띄우기</a>
                </div>
            </li>
        </h1>
        <ol>
            <li><a href="1.php">1번으로 이동하기</a></li>
            <li><a href="2.php">2번으로 이동하기</a></li>
            <li><a href="3.php">3번으로 이동하기</a></li>
            
        </ol>

    </body>


</html>
