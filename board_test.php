<?php
set_time_limit(0);

// 데이터 베이스 연결하기
require('config/config.php');
require('lib/db.php');
$conn = db_init($config['host'], $config['dbuser'], $config['dbpass'], $config['dbname']);

// 글 등록에 대한 기본적인 정보
$name = "부라운";
$password = "123456";
$email = "happybrown@naver.com";
$success = 0;
$failure = 0;

if (ob_get_level() == 0) ob_start();

for($i = 1; $i <= 1000000; $i++) {
    $title = "$i 번째 테스트 게시물";
    $content = "$i 번째 테스트 게시물 내용 입니다.";

    // 답글을 위해 thread 값은 index 값의 1000배
    $max_thread = $i * 1000;

    $query = "INSERT INTO $board (thread, depth, name, password, email, title, hits, created_at, ip, content) ";
    $query .= "VALUES ($max_thread, 0, '$name', '$password', '$email', '$title', 0, UNIX_TIMESTAMP(),'127.0.0.1','$content')";
    //echo $query;
    //die();
    $result = mysqli_query($conn, $query);
    if($result) {
        $success ++;
        print("$1 INSERT 성공<br/>\r\n");
    } else {
        $failure ++;
        print("$1 INSERT <b>실패</b><br/>\r\n");
    }

    // 이프로그램이 시스템 자원을 많이 할당받는 것을 막기 위해
    // 10000번당 1초식 쉽니다.
    if(($i % 10000) == 0) sleep(1);
}

// 데이터베이스 연결 종료
mysqli_close($conn);
?>
