<?php
    $ccc = "1번페이지입니다.";
    $home = "홈으로 돌아가기";
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>1번타이틀</title>
</head>
<body>
    <h1>
        <div><?=$ccc?></div>
        <div><a href="http://192.168.80.130/practice.php"><?=$home?></a></div>
    </h1>

    <form action="practice.php" name = "로그인" method = "get">
        아이디 <input type="text" name = "login_id"><br>
        비밀번호 <input type="password" name="login_password">
        <input type="submit" value = "로그인">
    </form>

    <ol>
        <li><a href="1.php">1번으로 이동하기</a></li>
        <li><a href="2.php">2번으로 이동하기</a></li>
        <li><a href="3.php">3번으로 이동하기</a></li>
    </ol>
</body>
</html>