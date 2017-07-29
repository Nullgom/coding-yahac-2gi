<!DOCTYPE html>
<html>
<head>
     <meta charset="utf-8">
     <title>로그인 기능 만들기</title>
</head>
<body>
  <?php
    // $password = $_GET["password"];
    $password = $_POST["password"];  // 패스워드를 넘겨 받을때에는 POST 방식을 사용한다.
    if($password == "1111"){
        echo "주인님 환영합니다";
    } else {
        echo "뉘신지?";
    }
   ?>
</body>
</html>
