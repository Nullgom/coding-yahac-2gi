<?php
require('config/config.php');
require('lib/db.php');
$conn = db_init($config['host'], $config['dbuser'], $config['dbpass'], $config['dbname']);
$pagesize = 5;
$sql = "SELECT * FROM guestbook ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
$total = mysqli_affected_rows($conn);
$no = empty($_GET['no']) ? 0 : intval($_GET['no']);
// mysql_data_seek($result, 0);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>방명록 목록</title>
    <link href="bootstrap-3.3.7/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container">
        <div class="row">
            <section class="col-md-8 col-md-offset-2">
                <h1>방명록</h1>
                <hr>
                <div class="text-right">
                    <a href="/gbook_write.php" class="btn btn-success">
                        <span class="glyphicon glyphicon-pencil"></span>&nbsp; 글쓰기
                    </a>
                </div><br>
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr class="info">
                        <th>번호</th>
                        <th>이름</th>
                        <th>작성일</th>
                        <th>관리</th>
                    </tr>
                    </thead>
                    <tbody>
        <?php
            for($i = $no; $i < $no + $pagesize; $i++) {
                if($i < $total) {
                    mysqli_data_seek($result, $i);
                    $row = mysqli_fetch_array($result);
        ?>

                    <tr>
                        <td>No. <?=$row['id']?></td>
                        <td><?=$row['author']?></td>
                        <td><?=$row['created_at']?></td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target=".modal-delete" data-index="<?=$row['id']?>">삭제</button>

                    </tr>
                    <tr>
                        <td colspan="4"><?=htmlspecialchars($row['content'])?></td>
                    </tr>
        <?php
                }
            }
        ?>
                    </tbody>
                </table>
                <nav>
                    <ul class="pager">
        <?php
            $prev = $no - $pagesize;
            $next = $no + $pagesize;

            if ($prev >= 0) {
                echo '<li class="previous"><a href="'.$_SERVER['PHP_SELF'].'?no='.$prev.'"><span aria-hidden="true">&larr;</span> 이전</a></li>';
            } else {
                echo '<li class="previous disabled"><a href="#"><span aria-hidden="true">&larr;</span> 이전</a></li>';
            }

            if ($next < $total) {
                echo '<li class="next"><a href="'.$_SERVER['PHP_SELF'].'?no='.$next.'">다음 <span aria-hidden="true">&rarr;</span></a></li>';
            } else {
                echo '<li class="next disabled"><a href="#">다음 <span aria-hidden="true">&rarr;</span></a></li>';
            }
        ?>
                    </ul>
                </nav>
            </section>
        </div>
    </div>
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
                <form class="form" action="gbook_process.php?cmd=delete" method="post">
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
