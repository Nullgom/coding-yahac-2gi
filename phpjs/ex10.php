<!DOCTYPE html>
<html>
<head>
     <meta charset="utf-8">
     <title>배열</title>
</head>
<body>
  <h1>JavaScript</h1>
  <script>
    list = new Array("one", "two", "three");
    document.write(list[2]);
    document.write(list.length);
  </script>

  <h1>php</h1>
  <?php
    $list = array("one", "two", "three");
    // $list = ["one", "two", "three"]; // PHP 5.4이후 부터..
    echo $list[2];
    echo count($list);
  ?>
</body>
</html>
