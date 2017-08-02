<?php
require('config/config.php');
require('lib/db.php');
$conn = db_init($config['host'], $config['dbuser'], $config['dbpass'], $config['dbname']);

if(!empty($_GET['cmd'])) {
    $cmd = strtolower($_GET['cmd']);
    switch ($cmd) {
        case 'insert': // 저장하기
            // 입력값 검증
            if(empty($_POST['name'])) ErrorMessage('이름을 입력하세요.');
            if(empty($_POST['password'])) ErrorMessage('비밀번호를 입력하세요.');
            if(empty($_POST['title'])) ErrorMessage('제목을 입력하세요.');
            if(empty($_POST['content'])) ErrorMessage('내용을 입력하세요.');

            $name = $email = $password = $title = $content  = '';
            $REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $name = sanitize($_POST['name']);
                $email = sanitize($_POST['email']);
                $password = sanitize($_POST['password']);
                $title = sanitize($_POST['title']);
                $content  = sanitize($_POST['content']);
                //var_dump($_POST);
                // 현재 글 중에서 가장 큰 값을 가져온다.
                $min_thread_result = mysqli_query($conn, "SELECT min(thread) FROM $board");
                $min_thread_fetch = mysqli_fetch_row($min_thread_result);
                // 새 글의 thread 값을 계산한다.
                $min_thread = floor($min_thread_fetch[0] / 1000) * 1000 - 1000;
                $sql  = "INSERT INTO $board (`thread`,`depth`,`name`,`email`,`password`,`title`,`content`,`created_at`,`ip`,`hits`) ";
                $sql .= "VALUES ($min_thread, 0, '$name', '$email', '$password', '$title', '$content', UNIX_TIMESTAMP(), '$REMOTE_ADDR', 0)";
                //echo $sql;
                if(mysqli_query($conn, $sql) === TRUE) {
                    $inserted_id = mysqli_insert_id($conn);
                    alert_to_location("글이 저장되었습니다.","/board_list.php");
                }
                else {
                    alert_to_back("글 저장이 실패하였습니다.\n다시입력바랍니다.");
                }
            }
            else {
                alert_to_location("잘못된 접근입니다.","/board_list.php");
            }
            break;
        case 'update': // 수정하기
            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                alert_to_location("잘못된 접근입니다.","/board_list.php");
                break;
            }
            // 입력값 검증
            if(empty($_POST['name'])) ErrorMessage('이름을 입력하세요.');
            if(empty($_POST['password'])) ErrorMessage('비밀번호를 입력하세요.');
            if(empty($_POST['title'])) ErrorMessage('제목을 입력하세요.');
            if(empty($_POST['content'])) ErrorMessage('내용을 입력하세요.');

            $id = sanitize($_POST['id']);
            $password = sanitize($_POST['password']);
            $result = mysqli_query($conn, "SELECT password FROM $board WHERE id=$id");
            $row = mysqli_fetch_assoc($result);
            if ($password == $row['password']) { // 비밀번호가 일치하는 경우
                $name = sanitize($_POST['name']);
                $email = sanitize($_POST['email']);
                $title = sanitize($_POST['title']);
                $content  = sanitize($_POST['content']);
                $sql = "UPDATE board SET name='$name', email='$email', title='$title', content='$content' WHERE id=$id";
                if($result = mysqli_query($conn, $sql)) {
                    alert_to_location("글이 수정되었습니다.","board_read.php?id=$id");
                }
                else { // 글 저장이 실패
                    alert_to_back("글 수정이 실패하였습니다.\n다시입력바랍니다.");
                }
            }
            else { // 비밀번호가 일치하지 않는 경우
                alert_to_back("비밀번호가 틀립니다.\n다시입력바랍니다.");
            }
            break;
        case 'delete': // 삭제하기
            if(empty($_POST['id']) || empty($_POST['password'])) {
                alert_to_location("잘못된 접근입니다.","/board_list.php");
            }
            $id = escape_string($conn, $_POST['id']);
            $password = escape_string($conn, $_POST['password']);

            $sql = "SELECT password FROM $board WHERE id=$id";
            //echo $sql;
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            if($row['password'] == $password) {
                $sql = "DELETE FROM $board WHERE id=$id";
                $result = mysqli_query($conn, $sql);
                alert_to_location("글이 삭제되었습니다.","/board_list.php");
            }
            else {
                alert_to_back("비밀번호가 맞지 않습니다.");
            }
            break;
        case 'insert_reply' : // 답변글 저장
            // 입력값 검증
            if(empty($_POST['name'])) ErrorMessage('이름을 입력하세요.');
            if(empty($_POST['password'])) ErrorMessage('비밀번호를 입력하세요.');
            if(empty($_POST['title'])) ErrorMessage('제목을 입력하세요.');
            if(empty($_POST['content'])) ErrorMessage('내용을 입력하세요.');

            $name = $email = $password = $title = $content  = '';
            $REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $name = sanitize($_POST['name']);
                $email = sanitize($_POST['email']);
                $password = sanitize($_POST['password']);
                $title = sanitize($_POST['title']);
                $content  = sanitize($_POST['content']);
                $parent_thread = intval($_POST['parent_thread']);
                $parent_depth = intval($_POST['parent_depth']);

                $prev_parent_thread = floor($_POST['parent_thread'] / 1000) * 1000 + 1000;
                $sql = "UPDATE $board SET thread=thread+1 WHERE thread < $prev_parent_thread and thread > $parent_thread";
                $sql .= " ORDER BY thread DESC";
                $update_thread = mysqli_query($conn, $sql);
                $sql = "INSERT INTO $board (thread, depth, name, password, email, title, content, created_at,ip, hits) ";
                $sql .= "VALUES (".($parent_thread + 1).", ".($parent_depth + 1).", '$name', '$password', '$email','$title','$content', UNIX_TIMESTAMP(), '$REMOTE_ADDR', 0)";
                if($result = mysqli_query($conn, $sql)) {
                    alert_to_location('정상적으로 저장되었습니다.', '/board_list.php');
                } else {
                    alert_to_back('글 저장이 실패하였습니다.');
                }
            }
            else {
                alert_to_location('잘못된 접근입니다.', '/board_list.php');
            }
            break;
        default:
            alert_to_location('잘못된 접근입니다.', '/board_list.php');
            break;
    }
}
else {
    alert_to_location('잘못된 접근입니다.', '/board_list.php');
}
?>
