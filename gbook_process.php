<?php
require('config/config.php');
require('lib/db.php');
$conn = db_init($config['host'], $config['dbuser'], $config['dbpass'], $config['dbname']);

if(!empty($_GET['cmd'])) {
    $cmd = strtolower($_GET['cmd']);
    switch ($cmd) {
        case 'insert': // 저장하기
            $author = escape_string($conn, $_POST['name']);
            $password = escape_string($conn, $_POST['password']);
            $content = escape_string($conn, $_POST['content']);
            $sql = "INSERT INTO guestbook (author, password, content) ";
            $sql .= "VALUES ('$author', '$password', '$content')";
            //echo $sql;
            $result = mysqli_query($conn, $sql);
?>
    <script type="text/javascript">
        alert("글이 등록되었습니다.");
        location.href="gbook_list.php";
    </script>
<?php
            break;
        case 'update': // 수정하기
            # code...
            break;
        case 'delete': // 삭제하기
            if(empty($_POST['id']) || empty($_POST['password'])) {
?>
    <script type="text/javascript">
        alert("잘못된 접근입니다.");
        location.href="gbook_list.php";
    </script>
<?php
            }
            $id = escape_string($conn, $_POST['id']);
            $password = escape_string($conn, $_POST['password']);
            // echo "ID: ", $id, ", PASS: ", $password;
            $sql = 'SELECT password FROM guestbook WHERE id='.$id;
            //echo $sql;
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            if($row['password'] == $password) {
                $sql = "DELETE FROM guestbook WHERE id=$id";
                $result = mysqli_query($conn, $sql);
?>
    <script type="text/javascript">
        alert("글이 삭제되었습니다.");
        location.href="gbook_list.php";
    </script>
<?php
            }
            else {
?>
    <script type="text/javascript">
        alert("비밀번호가 맞지 않습니다.");
        location.href="gbook_list.php";
    </script>
<?php
            }
            break;
        default:
            # code...
            break;
    }
}
else {
    echo "Command is Not Found";
}
