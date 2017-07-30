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
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap3 적용</title>
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
                    if($_GET['id'] && $_GET['id'] == $row['id']) {
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
                    <?php
                    if(empty($_GET['id']) === false) {
                        $sql = "SELECT topic.id, title, user.name as author, description "
                        . "FROM topic LEFT Join user ON topic.author = user.id "
                        . "WHERE topic.id =".$_GET['id'];
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        echo '<h2>'.htmlspecialchars($row['title']).'</h2>'."\n";
                        echo '<p>'.htmlspecialchars($row['author']).'</p>'."\n";
                        echo strip_tags($row['description'], '<a><h1><h2><h3><h4><h5><ul><ol><li><p><div><img>');
                    }
                    ?>
                </article>
                <hr />
                <div id="control" class="text-right">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <input type="button" value="White" onclick="document.getElementById('target').className='white'" class="btn btn-default btn-lg"/>
                        <input type="button" value="Black" onclick="document.getElementById('target').className='black'" class="btn btn-default btn-lg"/>
                    </div>
                    &nbsp;
                    <a href="/write.php" class="btn btn-success btn-lg">
                        <i class="glyphicon glyphicon-pencil"></i>&nbsp; 쓰기</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="bootstrap-3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
