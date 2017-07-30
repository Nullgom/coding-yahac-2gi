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
    <title>업로드 케어 추가하기</title>
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
                <textarea name="description" id="inputDesc" rows="7" cols="80"></textarea>
            </p>
            <p>
                <input type="hidden" role="uploadcare-uploader" />
                <input type="submit" class="btn btn-primary" value="전송" />
            </p>
        </form>
    </article>
    <script>
      UPLOADCARE_LOCALE = "ko";
      UPLOADCARE_TABS = "file url facebook gdrive gphotos dropbox instagram evernote flickr skydrive";
      UPLOADCARE_PUBLIC_KEY = "PUBLIC_KEY 입력";
    </script>
    <script charset="utf-8" src="//ucarecdn.com/libs/widget/3.1.1/uploadcare.full.min.js"></script>
    <script type="text/javascript">
        // role의 값이 uploadcare-uploader인 태그를 업로드 위젯으로 만들어라.
        var singleWidget = uploadcare.SingleWidget('[role=uploadcare-uploader]');
        // 그 위젯을 통해서 업로드가 끝났을 때
        singleWidget.onUploadComplete(function(info){
            // id 값이 description인 태크의 값 뒤에 업로드한 이미지 파일의 주소를 이미지 태그와 함께 첨부하라.
            var description = document.getElementById('inputDesc');
            description.value = description.value + '<img src="' + info.cdnUrl +'"/>';
        });

    </script>
</body>
</html>
