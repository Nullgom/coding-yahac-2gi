<?php
function db_init($host, $dbuser, $dbpass, $dbname) {
    $conn = mysqli_connect( $host, $dbuser, $dbpass);
    mysqli_select_db($conn, $dbname);
    return $conn;
}

function escape_string($conn, $str) {
    return mysqli_real_escape_string($conn, $str);
}
?>
