<?php
$conn = mysqli_connect('localhost', 'ciuser','cipass');
mysqli_select_db($conn, 'opentutorials');
$sql = "SELECT * FROM user WHERE name='".$_POST['author']."'";
$result = mysqli_query($conn, $sql);
if($result->num_rows > 0) {
    $row = mysqli_fetch_assoc($result);
    $user_id = $row['id'];
} else {
    $sql = "INSERT INTO user (name, password) VALUES('".$_POST['author'] ."', '123456')";
    mysqli_query($conn, $sql);
    $user_id = mysqli_insert_id($conn);
}
// echo $user_id;
// exit;
$sql = "INSERT INTO topic (title, description, author, created_at) VALUES('"
     . $_POST['title'] . "','" . $_POST['description']. "'," .$user_id. ", now())";
// echo $sql;
$result = mysqli_query($conn, $sql);
$insert_id = mysqli_insert_id($conn);
header('Location: http://'.$_SERVER['HTTP_HOST'].'/index.php?id='.$insert_id);
?>
