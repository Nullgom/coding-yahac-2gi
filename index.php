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
    <link href="https://bootswatch.com/paper/bootstrap.min.css" rel="stylesheet" />
    <link href="/css/style.css" rel="stylesheet">
</head>
<body id="target">
    <header class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false">
                    <span class="sr-only">토글 네비게이션</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
                    <span class="glyphicon glyphicon-lamp"></span>&nbsp;코딩야학
                </a>
            </div>

            <div class="navbar-collapse collapse" id="bs-example-navbar-collapse-2" aria-expanded="false" style="height: 1px;">
              <ul class="nav navbar-nav">
                <li><a href="#">게시판</a></li>
                <li class="active"><a href="#">토픽</a><span class="sr-only">(current)</span></li>
                <li><a href="#">방명록</a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="glyphicon glyphicon-cog"></i>&nbsp;관리자<span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                    <li class="divider"></li>
                    <li><a href="#">One more separated link</a></li>
                  </ul>
                </li>
              </ul>
              <!-- <form class="navbar-form navbar-left" role="search">
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default">
                    <span class="glyphicon glyphicon-search"></span>&nbsp;검색</button>
              </form> -->
              <ul class="nav navbar-nav navbar-right">
                <li><a href="/"><span class="glyphicon glyphicon-home"></span>&nbsp;홈</a></li>
                <!-- <li><a href="/"><span class="glyphicon glyphicon-user"></span>&nbsp;홍길동</a></li>
                <li><a href="/"><span class="glyphicon glyphicon-log-out"></span>&nbsp;로그아웃</a></li> -->
                <li><a href="/"><span class="glyphicon glyphicon-log-in"></span>&nbsp;로그인</a></li>
                <li><a href="/"><span class="glyphicon glyphicon-user"></span>&nbsp;회원가입</a></li>
              </ul>
            </div>
          </div>
    </header>
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
    <footer class="footer">
        <div class="container">
            <p>Coding Yahac II 2017 Web Developments <span class="text-muted">by Whoisy</span></p>
        </div>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="bootstrap-3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
