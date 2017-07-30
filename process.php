<?php
$conn = mysqli_connect('localhost', 'ciuser','cipass');
mysqli_select_db($conn, 'opentutorials');

$sql = "INSERT INTO topic (title, description, author) VALUES('"
     . $_POST['title'] . "','" . $_POST['description']. "','" .$_POST['author']. "')";
// echo $sql;
$result = mysqli_query($conn, $sql);
header('Location: http://'.$_SERVER['HTTP_HOST'].'/index.php');
?>
