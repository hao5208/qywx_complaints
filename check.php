<?php
require 'db.php';

header('Content-Type: application/json');

if (!isset($_GET['km'])) {
    echo json_encode(['status' => 0, 'msg' => '缺少参数', 'time' => 0]);
    exit;
}

$kami = $conn->real_escape_string($_GET['km']);

// 查询卡密信息
$stmt = $conn->prepare("SELECT * FROM kamiusage WHERE kami = ?");
$stmt->bind_param("s", $kami);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['status' => 0, 'msg' => '卡密无效', 'time' => 0]);
    exit;
}

$row = $result->fetch_assoc();

// 处理首次使用时间
if (!$row['first_used']) {
    $update_stmt = $conn->prepare("UPDATE kamiusage SET first_used = NOW() WHERE id = ?");
    $update_stmt->bind_param("i", $row['id']);
    $update_stmt->execute();
    $first_used = time();
} else {
    $first_used = strtotime($row['first_used']);
}

// 计算过期时间
$expire_timestamp = $first_used + ($row['days'] * 86400);
$current_timestamp = time();

if ($current_timestamp > $expire_timestamp) {
    echo json_encode(['status' => 0, 'msg' => '卡密已过期', 'time' => 0]);
} else {
    echo json_encode(['status' => 200, 'time' => $expire_timestamp]);
}

$stmt->close();
$conn->close();
?>
