<?php
$conn = mysqli_connect( 'localhost', 'ciuser', 'cipass');
mysqli_select_db($conn, 'opentutorials');
$result = mysqli_query($conn, 'SELECT * FROM `topic`');
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MySQL 실습</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body id="target">
    <header>
         <img src="https://s3.ap-northeast-2.amazonaws.com/opentutorials-user-file/course/94.png" alt="생활코딩"/>
        <h1><a href="/index.php">JavaScript</a></h1>
    </header>
    <nav>
        <ol>
    <?php
        while($row = mysqli_fetch_assoc($result)) {
            echo '<li><a href="/index.php?id='.$row['id'].'">'.$row['title'].'</a></li>'."\n";
        }
    ?>
        </ol>
    </nav>
    <div id="control">
        <input type="button" value="white" onclick="document.getElementById('target').className='white'"/>
        <input type="button" value="black" onclick="document.getElementById('target').className='black'"/>
        <a href="/write.php">쓰기</a>
    </div>
    <article>
    <?php
    if(empty($_GET['id']) === false) {
        $sql = "SELECT topic.id, title, user.name as author, description "
            . "FROM topic LEFT Join user ON topic.author = user.id "
            . "WHERE topic.id =".$_GET['id'];
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        echo '<h2>'.$row['title'].'</h2>'."\n";
        echo '<p>'.$row['author'].'</p>'."\n";
        echo $row['description'];
    }
    ?>
    </article>
</body>
</html>
