<?php
// 引入数据库连接文件
require_once 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $secret_key = $_POST['secret_key'];
    $km = $_POST['km'];
    $domainname = $_POST['domainname'];
   // echo $domainname;
   if($domainname=="kesu.669222.xyz"){
       echo "禁止用此域名";
   }else{
       
   

    // 调用第三方接口验证卡密
    $api_url = $webdemo."check.php?km=$km";
    $response = file_get_contents($api_url);
    $result = json_decode($response, true);

    if ($result['status'] === 200) {
        // 卡密有效，获取到期时间戳
        $expiry_timestamp = $result['time'];

        // 将时间戳转换为数据库中的 DATETIME 格式
        $expiry_date = date("Y-m-d H:i:s", $expiry_timestamp);

        // 生成随机5位字符串
        $random_string = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);

        // 使用预处理语句插入数据
        $stmt = $conn->prepare("INSERT INTO keys_table (random_string, secret_key, km, domainname,expiry_date) VALUES (?, ?, ?, ?,?)");
        $stmt->bind_param("sssss", $random_string, $secret_key, $km,$domainname, $expiry_date);

        if ($stmt->execute()) {
            // 重定向到b.php并传递随机字符串
            header("Location: urlsel.php?ss=$random_string");
            exit();
        } else {
            // 捕获唯一约束错误
            if ($conn->errno === 1062) { // 1062 是 MySQL 中唯一约束错误的错误码
                echo "错误：机器人token已存在或卡密已使用";
            } else {
                echo "错误: " . $stmt->error;
            }
        }

        $stmt->close();
    } else {
        // 卡密无效
        echo "错误：" . $result['msg'];
    }
    
}}

$conn->close();
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>输入密钥</title>
    <!-- 引入 Bootstrap CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
        <div class="alert alert-warning text-center mb-0" role="alert">
        <strong>警告：</strong> 禁止用于以下业务及服务： 色情、博彩、诈骗、钓鱼、黑客、爆破、病毒、外挂 以上业务及服务一经发现，立即封禁卡密，概不退款。
    </div>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">生成链接</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" action="">
                            <div class="mb-3">
                                <label for="km" class="form-label">卡密:</label>
                                <input type="text" class="form-control" id="km" name="km" required>
                            </div>
                            <div class="mb-3">
                                <label for="secret_key" class="form-label">企业微信机器人token:</label>
                                <input type="text" class="form-control" id="secret_key" name="secret_key" required>
                            </div>
                               <div class="mb-3">
                                <label for="domainname" class="form-label">域名(教程第6步解析的域名，如有字母要小写):</label>
                                <input type="text" class="form-control" id="domainname" name="domainname" required>
                            </div>
                            <button type="submit" class="btn btn-primary">创建链接</button>
                            <a href="kmupdate.php" class="btn btn-primary">卡密续费</a>
                            <a href="key_retrieve.php" class="btn btn-primary">忘记链接</a>
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
