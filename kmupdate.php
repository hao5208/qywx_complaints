<?php
// 引入数据库连接文件
require_once 'db.php';

// 处理表单提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old_km = $_POST['old_km']; // 旧卡密
    $new_km = $_POST['new_km']; // 新卡密

    // 调用第三方接口验证新卡密
    $api_url = $webdemo."check.php?km=$new_km";
    $response = file_get_contents($api_url);
    $result = json_decode($response, true);

    if ($result['status'] === 200) {
        // 新卡密有效，获取到期时间戳
        $new_expiry_timestamp = $result['time'];

        // 将时间戳转换为数据库中的 DATETIME 格式
        $new_expiry_date = date("Y-m-d H:i:s", $new_expiry_timestamp);

        // 使用预处理语句更新卡密和到期时间
        $stmt = $conn->prepare("UPDATE keys_table SET km = ?, expiry_date = ? WHERE km = ?");
        if (!$stmt) {
            die("SQL 语句错误: " . $conn->error);
        }

        $stmt->bind_param("sss", $new_km, $new_expiry_date, $old_km);

        if ($stmt->execute()) {
            echo "卡密和到期时间更新成功！";
        } else {
            echo "更新失败: " . $stmt->error;
        }

        $stmt->close();
    } else {
        // 新卡密无效
        echo "错误：" . $result['msg'];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>更新卡密</title>
    <!-- 引入 Bootstrap CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">更新卡密(旧卡密未到期请勿更新，卡密时间不会叠加，更新后旧卡密作废，请使用新卡密操作)</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" action="">
                            <div class="mb-3">
                                <label for="old_km" class="form-label">旧卡密:</label>
                                <input type="text" class="form-control" id="old_km" name="old_km" required>
                            </div>
                            <div class="mb-3">
                                <label for="new_km" class="form-label">新卡密:</label>
                                <input type="text" class="form-control" id="new_km" name="new_km" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">提交</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 引入 Bootstrap JS 和依赖 -->
    <script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
</body>
</html>
