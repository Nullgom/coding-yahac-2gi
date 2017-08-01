<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>방명록 쓰기</title>
    <link href="bootstrap-3.3.7/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container">
        <div class="row">
            <section class="col-md-8 col-md-offset-2">
                <h1>방명록</h1>
                <hr>
                <form class="form" action="/gbook_process.php?cmd=insert" method="post">
                    <div class="form-group">
                        <label for="name">이름 :</label>
                        <input type="text" class="form-control" name="name" id="name"  placeholder="작성자 이름 입력"/>
                    </div>
                    <div class="form-group">
                        <label for="password">비밀번호 :</label>
                        <input type="password" class="form-control" name="password" id="password"  placeholder="비밀번호 입력"/>
                    </div>
                    <div class="form-group">
                        <label for="content">글내용 :</label>
                        <textarea class="form-control" name="content" id="content" rows="10"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">제출</button>
                </form>
            </section>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="bootstrap-3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
