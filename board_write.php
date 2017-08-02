<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판 글 쓰기</title>
    <link href="https://bootswatch.com/paper/bootstrap.min.css" rel="stylesheet" />
    <link href="bootstrap-3.3.7\css\boostrapValidator.min.css" rel="stylesheet" />
    <link href="/css/board.css" rel="stylesheet">
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
                <li class="active"><a href="/board_list.php">게시판 <span class="sr-only">(current)</span></a></li>
                <li><a href="#">토픽</a></li>
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
        <h1>게시판 <small>글 쓰기</small></h1>
        <hr>
        <div class="well col-md-10 col-md-offset-1">
        <form id="writeForm" class="form-horizontal" action="board_process.php?cmd=insert" method="post">
            <div class="form-group">
              <label for="inputName" class="col-lg-2 control-label">이름 :</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" name="name" id="inputName" placeholder="작성자 이름 입력">
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail" class="col-lg-2 control-label">이메일 :</label>
              <div class="col-lg-10">
                <input type="email" class="form-control" name="email" id="inputEmail" placeholder="Email 입력">
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword" class="col-lg-2 control-label">비밀번호 :</label>
              <div class="col-lg-10">
                <input type="password" class="form-control" name="password" id="inputPassword" placeholder="비밀번호 입력(수정,삭제 시 반드시 필요)"/>
              </div>
            </div>
            <div class="form-group">
              <label for="inputTitle" class="col-lg-2 control-label">제목 :</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" name="title" id="inputTitle" placeholder="글 제목을 입력"/>
              </div>
            </div>
            <div class="form-group">
              <label for="textArea" class="col-lg-2 control-label">본문 :</label>
              <div class="col-lg-10">
                <textarea class="form-control" rows="10" name="content" id="textArea" placeholder="글 내용을 입력..."></textarea>
                <!-- <span class="help-block">A longer block of help text that breaks onto a new line and may extend beyond one line.</span> -->
              </div>
            </div>
            <div class="form-group">
              <div class="col-lg-10 col-lg-offset-2 text-right">
                <button type="reset" class="btn btn-default">다시 쓰기</button>
                &nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn btn-primary">글 저장하기&nbsp;
                    <span class="glyphicon glyphicon-send"></span></button>
                &nbsp;&nbsp;&nbsp;
                <button class="btn btn-warning" onclick="history.back(-1)">되돌아가기</button>
              </div>
            </div>
        </form>
        </div>
    </div>
    <footer class="footer">
        <div class="container">
            <p>Coding Yahac II 2017 Web Developments <span class="text-muted">by Whoisy</span></p>
        </div>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="bootstrap-3.3.7/js/bootstrap.min.js"></script>
    <script src="bootstrap-3.3.7/js/bootstrapValidator.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#writeForm').bootstrapValidator({
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    name: {
                        validators: {
                            stringLength: {
                                min:2, max:20,
                                message: '최소 2자 이상 20이하의 문자로 입력하세요.'
                            },
                            notEmpty: {
                                message: '이름을 입력하세요.'
                            }
                        }
                    },
                    email: {
                        validators: {
                            notEmpty: {
                                message: '이메일 주소를 입력하세요'
                            },
                            emailAddress: {
                                message: '올바른 이메일 주소 형식으로 입력하세요.'
                            }
                        }
                    },
                    password: {
                        validators: {
                            stringLength: {
                                min:4, max:15,
                                message: '비밀번호는 4~15자의 숫자,알파벳 문자로 입력하세요.'
                            },
                            regexp: {
                                regexp: /^[a-zA-Z0-9]+$/,
                                message: '숫자,알파벳 문자 4~15자의 형식으로 입력하세요.'
                            },
                            notEmpty: {
                                message: '비밀번호를 입력하세요(글 수정, 삭제시 반드시 필요).'
                            }
                        }
                    },
                    title: {
                        validators: {
                            stringLength: {
                                max:100
                            },
                            notEmpty: {
                                message: '글 제목을 입력하세요.'
                            }
                        }
                    },
                    content: {
                        validators: {
                            notEmpty: {
                                message: '글 내용을 입력하세요.'
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
