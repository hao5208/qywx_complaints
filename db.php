<?php
//你的系统域名
$webdemo = "http://kesu.669222.xyz/";

// db.php
$servername = "localhost";
$username = "ts";
$password = "xWafdG5m33H6LCyY";
$dbname = "ts";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}
?>