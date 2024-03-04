<?php
// เชื่อมต่อกับฐานข้อมูล
$servername = "localhost";
$username = "username";
$password = "password";
$database = "database_name";

$conn = new mysqli($servername, $username, $password, $database);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ทำการรีเซ็ตข้อมูล
$sql = "UPDATE table_name SET column1 = default_value1, column2 = default_value2, ...";
if ($conn->query($sql) === TRUE) {
    echo "รีเซ็ตข้อมูลเรียบร้อยแล้ว";
} else {
    echo "เกิดข้อผิดพลาดในการรีเซ็ตข้อมูล: " . $conn->error;
}

$conn->close();
?>
