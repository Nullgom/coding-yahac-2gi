<?php
require('config/config.php');
require('lib/db.php');
$conn = db_init($config['host'], $config['dbuser'], $config['dbpass'], $config['dbname']);

if(!empty($_GET['cmd'])) {
    $cmd = strtolower($_GET['cmd']);
    switch ($cmd) {
        case 'insert': // 저장하기
            $name = $email = $password = $title = $content  = '';
            $REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $name = sanitize($_POST['name']);
                $email = sanitize($_POST['email']);
                $password = sanitize($_POST['password']);
                $title = sanitize($_POST['title']);
                $content  = sanitize($_POST['content']);
                //var_dump($_POST);
                $sql  = "INSERT INTO `board` (`name`, `email`, `password`, `title`, `content`, `created_at`, `ip`, `hits`) ";
                $sql .= "VALUES ('$name', '$email', '$password', '$title', '$content', now(), '$REMOTE_ADDR', 0)";
                //echo $sql;
                if(mysqli_query($conn, $sql) === TRUE) {
                    $inserted_id = mysqli_insert_id($conn);
?>
    <script type="text/javascript"> alert("글이 저장되었습니다."); location.href="board_list.php"; </script>
<?php
                }
                else {
?>
    <script type="text/javascript"> alert("글 저장이 실패하였습니다.\n다시입력바랍니다."); history.back(); </script>
<?php
                }
            }
            else {
?>
    <script type="text/javascript"> alert("잘못된 접근입니다."); location.href="board_list.php"; </script>
<?php
            }
            break;
        case 'update': // 수정하기
            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
?>
    <script type="text/javascript"> alert("잘못된 접근입니다."); location.href="board_list.php"; </script>
<?php
                die();
            }
            $id = sanitize($_POST['id']);
            $password = sanitize($_POST['password']);
            $result = mysqli_query($conn, "SELECT password FROM board WHERE id=$id");
            $row = mysqli_fetch_assoc($result);
            if ($password == $row['password']) { // 비밀번호가 일치하는 경우
                $name = sanitize($_POST['name']);
                $email = sanitize($_POST['email']);
                $title = sanitize($_POST['title']);
                $content  = sanitize($_POST['content']);
                $sql = "UPDATE board SET name='$name', email='$email', title='$title', content='$content' WHERE id=$id";
                if($result = mysqli_query($conn, $sql)) {
?>
    <script type="text/javascript"> alert("글이 수정되었습니다."); location.href="board_read.php?id=<?=$id?>"; </script>
<?php
                }
                else { // 글 저장이 실패
?>
    <script type="text/javascript"> alert("글 수정이 실패하였습니다.\n다시입력바랍니다."); history.back(); </script>
<?php
                }
            }
            else { // 비밀번호가 일치하지 않는 경우
?>
    <script type="text/javascript"> alert("비밀번호가 틀립니다.\n다시입력바랍니다."); history.back(); </script>
<?php
            }
            break;
        case 'delete': // 삭제하기
            if(empty($_POST['id']) || empty($_POST['password'])) {
?>
    <script type="text/javascript"> alert("잘못된 접근입니다."); location.href="board_list.php"; </script>
<?php
            }
            $id = escape_string($conn, $_POST['id']);
            $password = escape_string($conn, $_POST['password']);

            $sql = 'SELECT password FROM board WHERE id='.$id;
            //echo $sql;
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            if($row['password'] == $password) {
                $sql = "DELETE FROM board WHERE id=$id";
                $result = mysqli_query($conn, $sql);
?>
    <script type="text/javascript"> alert("글이 삭제되었습니다."); location.href="board_list.php"; </script>
<?php
            }
            else {
?>
    <script type="text/javascript"> alert("비밀번호가 맞지 않습니다."); history.back();</script>
<?php
            }
            break;
        default:
?>
    <script type="text/javascript"> alert("잘못된 접근입니다."); location.href="board_list.php"; </script>
<?php
            break;
    }
}
else {
?>
    <script type="text/javascript"> alert("잘못된 접근입니다."); location.href="/index.php"; </script>
<?php
}
?>
