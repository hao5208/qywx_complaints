<?php
// 引入数据库连接文件
require_once 'db.php';

// 获取随机字符串
$random_string = $_GET['ss'];

// 使用预处理语句查询对应的密钥、卡密和过期日期
$stmt = $conn->prepare("SELECT secret_key, km, domainname,expiry_date FROM keys_table WHERE random_string = ?");
$stmt->bind_param("s", $random_string);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($secret_key, $kami,$domainname, $expiry_date);
    $stmt->fetch();

    // 检查密钥是否过期
    $current_time = date("Y-m-d H:i:s");
    if ($current_time > $expiry_date) {
        $result_url = "卡密已过期，无法使用。";
    } else {
        $result_url = "http://".$domainname."/kesu/?spt=" . $random_string . "&random=";
    }
} else {
    $result_url = "未找到对应的数据";
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>查询结果</title>
    <!-- 引入 Bootstrap CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
        <div class="alert alert-warning text-center mb-0" role="alert">
        <strong>公告：</strong>请将此页面收藏，只会显示一次，如有问题请联系管理员。
    </div>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">查询结果</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($result_url !== "未找到") : ?>
                            <div class="alert alert-success" role="alert">
                                
                                <br>
                                <a href="<?php echo $result_url; ?>" target="_blank" class="btn btn-link"><?php echo $result_url; ?></a>
                            </div>
                        <?php else : ?>
                            <div class="alert alert-danger" role="alert">
                                未找到对应的密钥，请检查输入是否正确。
                            </div>
                        <?php endif; ?>
                        
                        <div class="text-center mt-3">
                            <a href="getaccesstoken.php?tsurl=<?php echo $result_url; ?>" class="btn btn-primary">下一步</a>
                        </div>
                        <div class="text-center mt-3">
                            <a href="stats.php?spt=<?php echo $random_string; ?>" class="btn btn-primary">查看所有投诉</a>
                        </div>
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
