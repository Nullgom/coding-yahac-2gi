<?php
require('config/config.php');
require('lib/db.php');
$conn = db_init($config['host'], $config['dbuser'], $config['dbpass'], $config['dbname']);

$page_size = 10;       // 한페이지에 보여질 게시물 수
$page_list_size = 10; // 페이지 나누기에 표시될 페이지수
// $no 값이 안 넘어 오거나 잘못된(음수) 값이 넘어오는 경우 0으로 처리
$no = empty($_GET['no']) ? 0 : intval($_GET['no']);
if(!$no || $no < 0) $no = 0;


$st = explode(" ", microtime());
// 데이터베이스에서 페이지의 첫 번째  글($no)부터 $page_size만큼의 글을 가져 온다.
// $sql = "SELECT * FROM $board ORDER BY thread LIMIT $no,$page_size";
// 1. 글 목록의 첫번째 글 찾기
$sql = "SELECT thread FROM $board ORDER BY thread LIMIT $no,1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_row($result);
$start_thread = $row[0];
//2. 찾은 thread 값으로 10개의 글을 가져옴
$sql = "SELECT * FROM $board WHERE thread >= '$start_thread' ORDER BY thread LIMIT $page_size";

//$sql = "SELECT * FROM $board WHERE thread >= (SELECT thread FROM $board ORDER BY thread LIMIT $no, 1) ORDER BY thread";
$result = mysqli_query($conn, $sql);

$et = explode(" ", microtime());
echo ($et[1] - $st[1] + $et[0]-$st[0]);
// 총 게시물 수를 구한다.
$result_count = mysqli_query($conn, "SELECT count(*) FROM $board");
$result_row = mysqli_fetch_row($result_count);
$total_row = $result_row[0]; // 첫 번째 열이 count(*) 의 결과다
// 총 페이지 계산
if($total_row <= 0) $total_row = 0; // 총 게시물의 값이 0 이나 비정상이라면 0으로 설정
$total_page = ceil($total_row / $page_size);
// 현재 페이지 계산
$current_page = ceil(($no + 1) / $page_size);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판 목록 보기</title>
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
        <h1>게시판 <small>글 쓰기</small></h1>
        <hr>
        <table class="table table-striped">
        <thead>
            <tr class="success">
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
                <td><?php if($row['depth'] > 0) echo '<img src="/img/depth.gif" width="'.($row['depth'] * 7).'"/>└'; ?>
                    <a href="/board_read.php?id=<?=$row['id']?>&no=<?=$no?>"><?=strip_tags($row['title'])?></a>
                </td>
                <td><a href="mailto:<?=$row['email']?>"><?=$row['name']?></a></td>
                <td><?=date("Y-m-d", $row['created_at'])?></td>
                <td><?=$row['hits']?></td>
            </tr>
<?php
    } // end While
?>
        </tbody>
        </table>
        <div class="text-center">
            <ul class="pagination">
<?php
// 시작 페이지 계산
$start_page = floor(($current_page - 1) / $page_list_size) * $page_list_size + 1;
// 페이지 리스트의 마지막 페이지가 몇 번째 페이지인지 구하는 부분
$end_page = $start_page + $page_list_size - 1;
if($total_page <  $end_page) $end_page = $total_page;
if($start_page >= $page_list_size) {
    // 이전 페이지 리스트 값은 젓 번째 페이지에서 한 페이지 감소하면 된다.
    // $page_size를 곱해주는 이유는 글 번호로 표시하기 위해서이다.
    $prev_list = ($start_page - 2) * $page_size;
    echo '<li><a href="'.$_SERVER['PHP_SELF'].'?no='.$prev_list.'">&laquo;</a></li>'."\n";
} else {
    echo '<li class="disabled"><a href="#">&laquo;</a></li>'."\n";
}
// 페이지 리스트를 출력
for($i = $start_page; $i <= $end_page; $i++) {
    $page = ($i - 1) * $page_size; // 페이지값을 no 값으로 변환
    if($no != $page) { // 현재 페이지가 아닐 경우만 링크 표시
        echo '<li><a href="'.$_SERVER['PHP_SELF'].'?no='.$page.'">'.$i.'</a></li>'."\n";
    }
    else {
        echo '<li class="active"><a href="#">'.$i.'</a></li>'."\n";
    }
}
// 다음 페이지 리스트가 필요할때는 총 페이지가 마지막 리스트보다 클때이다.
// 리스트를 다 뿌리고도 더 뿌려줄 페이지가 남았을 때 다음 버튼이 필요할 것이다.
if($total_page > $end_page) {
    $next_list = $end_page * $page_size;
    echo '<li><a href="'.$_SERVER['PHP_SELF'].'?no='.$next_list.'">&raquo;</a></li>'."\n";
} else {
    echo '<li class="disabled"><a href="#">&raquo;</a></li>'."\n";
}
?>
            </ul>
        </div>
        <div class="control text-right">
            <a href="/board_write.php" class="btn btn-primary">
                <span class="glyphicon glyphicon-pencil"></span>&nbsp; 글 쓰기</a>
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
