<?php
function db_init($host, $dbuser, $dbpass, $dbname) {
    $conn = mysqli_connect( $host, $dbuser, $dbpass);
    mysqli_select_db($conn, $dbname);
    return $conn;
}

function escape_string($conn, $str) {
    return mysqli_real_escape_string($conn, $str);
}

function sanitize($data) {
    return addslashes(htmlspecialchars(strip_tags(trim($data))));
}
function alert_to_location($message, $href) {
    echo '<script type="text/javascript"> alert("'.$message.'"); location.href="'.$href.'"; </script>';
}
function alert_to_back($message) {
    echo '<script type="text/javascript"> alert("'.$message.'"); history.back();</script>';
}
function ErrorMessage($message, $type = 'on') {
    echo "<script>alert('$message'); ";
    if($type == 'on') echo " history.back(); ";
    echo "</script>\n";
    exit;
}
?>
