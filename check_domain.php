<?php
// api/check_domain.php
header('Content-Type: text/plain');

require_once 'db.php'; // 根据实际路径调整

if (!isset($_GET['domain'])) {
    http_response_code(400);
    echo 'error';
    exit();
}

$domain = trim($_GET['domain']);

// 使用预处理语句防止SQL注入
$stmt = $conn->prepare("SELECT domainname FROM keys_table WHERE domainname = ?");
$stmt->bind_param("s", $domain);
$stmt->execute();
$result = $stmt->get_result();

echo $result->num_rows > 0 ? 'ok' : 'no';

$stmt->close();
$conn->close();
?>
