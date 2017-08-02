<?php
require('config/config.php');
require('lib/db.php');
$conn = db_init($config['host'], $config['dbuser'], $config['dbpass'], $config['dbname']);
$id = intval($_GET['id']);
$no = empty($_GET['no']) ? 0 : intval($_GET['no']);
// 먼저 쓴 글의 정보를 가져온다.
$sql = "SELECT * FROM $board WHERE id=$id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판 글 내용 보기</title>
    <link href="https://bootswatch.com/paper/bootstrap.min.css" rel="stylesheet" />
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
        <h1>게시판 <small>글 내용 보기</small></h1>
        <hr>
        <div class="view">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="post-title"><?=strip_tags($row['title'])?></h4>
              </div>
              <div class="panel-body">
                <div class="post-info">
                    <ul>
                        <li><span class="glyphicon glyphicon-user"></span>&nbsp;
                            <a href="mailto:<?=$row['email']?>"><?=$row['name']?></a></li>
                        <li><span class="glyphicon glyphicon-calendar"></span>&nbsp;
                            <?=date("Y-m-d", $row['created_at'])?></li>
                        <li><span class="glyphicon glyphicon-eye-open"></span>&nbsp;
                            <?=$row['hits']?></li>
                    </ul>
                </div>
                <div class="post-body">
                    <?=nl2br(strip_tags($row['content']))?>
                </div>
              </div>
            </div>
            <div class="control text-right">
                <a href="/board_reply.php?id=<?=$row['id']?>" class="btn btn-success">
                    <span class="glyphicon glyphicon-pencil"></span>&nbsp; 답변 달기</a>
                &nbsp;&nbsp;&nbsp;
                <a href="/board_edit.php?id=<?=$row['id']?>" class="btn btn-primary">
                    <span class="glyphicon glyphicon-pencil"></span>&nbsp; 글 수정</a>
                &nbsp;&nbsp;&nbsp;
                <a href="#" class="btn btn-danger" data-toggle="modal" data-target=".modal-delete" data-index="<?=$row['id']?>">
                    <span class="glyphicon glyphicon-trash"></span>&nbsp; 글 삭제</a>
                &nbsp;&nbsp;&nbsp;
                <a href="/board_list.php" class="btn btn-warning">
                    <span class="glyphicon glyphicon-list"></span>&nbsp; 글 목록</a>
            </div>
            <nav>
              <ul class="pager">
<?php
    // 현재 글보다 id값이 큰 글 중 가작 작은 것을 가져온다. 즉 바로 이전 글
    $query = mysqli_query($conn, "SELECT id FROM $board WHERE thread > {$row['thread']} and depth = 0 LIMIT 1");
    $prev_id = mysqli_fetch_assoc($query);
    if($prev_id['id']) { // 이전 글이 있는 경우
        echo '<li class="previous"><a href="/board_read.php?id='.$prev_id['id'].'">';
        echo '<span aria-hidden="true">&larr;</span> 이전 글</a></li>'."\n";
    } else {
        echo '<li class="previous disabled"><a href="#"><span aria-hidden="true">&larr;</span> 이전 글</a></li>'."\n";
    }
    $query = mysqli_query($conn, "SELECT id FROM $board WHERE thread < {$row['thread']} and depth = 0 ORDER BY thread DESC LIMIT 1");
    $next_id = mysqli_fetch_assoc($query);
    if($next_id['id']) {
        echo '<li class="next"><a href="/board_read.php?id='.$next_id['id'].'">';
        echo '다음 글 <span aria-hidden="true">&rarr;</span></a></li>'."\n";
    } else {
        echo '<li class="next disabled"><a href="#">다음 글 <span aria-hidden="true">&rarr;</span></a></li>'."\n";
    }
?>
              </ul>
            </nav>

<?php
    // 리스트를 출력을 위해 thread를 계산한다.
    $thread_start = (ceil($row['thread'] / 1000) -1) * 1000;
    $thread_end = $thread_start + 1000;
    //echo $thread_start, $thread_end;
    $sql = "SELECT * FROM $board WHERE thread <= $thread_end AND thread > $thread_start ORDER BY thread DESC";
    $result = mysqli_query($conn, $sql);
    //var_dump($result);
    if($result->num_rows > 0) {
?>
            <table class="table table-striped">
            <thead>
                <tr class="info">
                    <th>번호</th>
                    <th>제목</th>
                    <th>글쓴이</th>
                    <th>작성일</th>
                    <th>조회수</th>
                </tr>
            </thead>
            <tbody>
<?php
        while($row = mysqli_fetch_assoc($result)) {
?>
                <tr>
                    <td><?=$row['id']?></td>
                    <td><?php if($row['depth'] > 0) echo '<img src="/img/depth.gif" width="'.($row['depth']*7).'" alt="gap">└'; ?>
                        <a href="/board_read.php?id=<?=$row['id']?>&no=<?=$no?>"><?=strip_tags($row['title'])?></a>
                    </td>
                    <td><a href="mailto:<?=$row['email']?>"><?=$row['name']?></a></td>
                    <td><?=date("Y-m-d", $row['created_at'])?></td>
                    <td><?=$row['hits']?></td>
                </tr>
<?php
        }
?>
            </tbody>
            </table>
<?php
    }
?>
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="container">
            <p>Coding Yahac II 2017 Web Developments <span class="text-muted">by Whoisy</span></p>
        </div>
    </footer>
    <div class="modal fade modal-delete" tabindex="-1" role="dialog"
        aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">글 삭제하기</h4>
              </div>
            <div class="modal-body">
                <p>삭제하려면 비밀번호를 입력하세요.</p>
                <form class="form" action="board_process.php?cmd=delete" method="post">
                        <input type="hidden" name="id" id="inputId"/>
                    <div class="input-group">
                          <input type="password" class="form-control" name="password" placeholder="비밀번호 입력" required/>
                          <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit">확인</button>
                          </span>
                    </div>
                  </form>
            </div>
        </div>
      </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="bootstrap-3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(function(){
            $('.modal-delete').on('show.bs.modal', function(event){
                var button = $(event.relatedTarget);
                var index = button.data('index');
                var modal = $(this)
                $('#inputId').val(index);
            });
        });
    </script>
</body>
</html>
<?php
// 조회수 업데이트
$result = mysqli_query($conn, "UPDATE $board SET hits=hits+1 WHERE id=$id");
mysqli_close($conn);
?>
