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
    <title>MySQL 실습:글작성</title>
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
    </div>
    <article>
        <form class="form" action="process.php" method="post">
            <p>
                <label for="inputTitle">제목 : </label>
                <input type="text" name="title" id="inputTitle" placeholder="제목을 입력">
            </p>
            <p>
                <label for="inputAuthor">작성자 : </label>
                <input type="text" name="author" id="inputAuthor" placeholder="작성자 입력">
            </p>
            <p>
                <label for="inputDesc">본문 : </label>
                <textarea name="description" id="inputDesc" rows="8" cols="80"></textarea>
            </p>
            <p>
                <input type="submit" name="submit" value="전송" />
            </p>
        </form>
    </article>
</body>
</html>
