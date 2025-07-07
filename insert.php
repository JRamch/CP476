<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
$conn = new mysqli("localhost", "root", "Admin", "cp476");
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
} catch(Exception $e) {
error_log($e->getMessage());
exit('Error connecting to database');
}
$conn->close();
echo "success!";
?>