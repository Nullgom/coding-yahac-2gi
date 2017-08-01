<?php
require('config/config.php');
require('lib/db.php');
$conn = db_init($config['host'], $config['dbuser'], $config['dbpass'], $config['dbname']);
$result = mysqli_query($conn, 'SELECT * FROM `topic`');
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>글 작성 화면 : Bootstrap3 적용</title>
    <link href="bootstrap-3.3.7/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css">
</head>
<body id="target">
    <div class="container">
        <header class="jumbotron text-center">
             <img src="https://s3.ap-northeast-2.amazonaws.com/opentutorials-user-file/course/94.png" alt="생활코딩" class="img-circle" id="logo"/>
            <h1><a href="/index.php">JavaScript</a></h1>
        </header>

        <div class="row">
            <nav class="col-md-3">
                <ol class="nav nav-pills nav-stacked">
            <?php
                while($row = mysqli_fetch_assoc($result)) {
                    if(isset($_GET['id']) && $_GET['id'] == $row['id']) {
                        echo '<li class="active"><a href="/index.php?id='.$row['id'].'">'.htmlspecialchars($row['title']).'</a></li>'."\n";
                    }
                    else {
                        echo '<li><a href="/index.php?id='.$row['id'].'">'.htmlspecialchars($row['title']).'</a></li>'."\n";
                    }

                }
            ?>
                </ol>
            </nav>
            <div class="col-md-9">
                <article>
                    <form class="form" action="process.php" method="post">
                        <div class="form-group">
                            <label for="inputTitle">제목 : </label>
                            <input type="text" name="title" class="form-control" id="inputTitle" placeholder="제목을 입력하세요.">
                        </div>
                        <div class="form-group">
                            <label for="inputAuthor">작성자 : </label>
                            <input type="text" name="author" class="form-control" id="inputAuthor" placeholder="작성자를 입력하세요.">
                        </div>
                        <div class="form-group">
                            <label for="inputDesc">본문 : </label>
                            <textarea name="description" class="form-control" id="inputDesc" rows="10" placeholder="본문 내용을 입력하세요."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" >
                            <span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;&nbsp;저장</button>
                    </form>
                </article>
                <hr />
                <div id="control" class="text-right">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <input type="button" value="White" onclick="document.getElementById('target').className='white'" class="btn btn-default btn-lg"/>
                        <input type="button" value="Black" onclick="document.getElementById('target').className='black'" class="btn btn-default btn-lg"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="bootstrap-3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
