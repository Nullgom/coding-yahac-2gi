<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP 실습</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body id="target">
    <header>
        <h1><a href="/index.php">JavaScript</a></h1>
    </header>
    <nav>
        <ol>
    <?php
        echo file_get_contents("list.txt");
    ?>
        </ol>
    </nav>
    <div id="control">
        <input type="button" value="white" onclick="document.getElementById('target').className='white'"/>
        <input type="button" value="black" onclick="document.getElementById('target').className='black'"/>
    </div>
    <article>
    <?php
        if(empty($_GET['id']) == false) {
            echo file_get_contents($_GET['id'].'.txt');
        }
        else {
            echo '<h1>환영합니다.</h1>';
        }
    ?>
    </article>
</body>
</html>
