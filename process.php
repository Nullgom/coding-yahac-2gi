<?php
require('config/config.php');
require('lib/db.php');
$conn = db_init($config['host'], $config['dbuser'], $config['dbpass'],
$title = mysqli_real_escape_string($conn, $_POST['title']);
$author = mysqli_real_escape_string($conn, $_POST['author']);
$description = mysqli_real_escape_string($conn, $_POST['description']);

$sql = "SELECT * FROM user WHERE name='".$author."'";

$result = mysqli_query($conn, $sql);
if($result->num_rows > 0) {
    $row = mysqli_fetch_assoc($result);
    $user_id = $row['id'];
} else {
    $sql = "INSERT INTO user (name, password) VALUES('".$author."', '123456')";
    mysqli_query($conn, $sql);
    $user_id = mysqli_insert_id($conn);
}
// echo $user_id;
// exit;
$sql = "INSERT INTO topic (title, description, author, created_at) VALUES('"
     . $title . "','" . $description. "'," .$user_id. ", now())";
// echo $sql;
$result = mysqli_query($conn, $sql);
header('Location: http://'.$_SERVER['HTTP_HOST'].'/index.php');
?>
