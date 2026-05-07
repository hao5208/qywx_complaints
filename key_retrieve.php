<?php
require 'db.php';

$error = '';
$result = null;

// 处理表单提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $secret_key = trim($_POST['secret_key'] ?? '');
    
    if (empty($secret_key)) {
        $error = '请输入密钥信息';
    } else {
        // 使用预处理语句防止SQL注入
        $stmt = $conn->prepare("SELECT random_string, expiry_date FROM keys_table WHERE secret_key = ?");
        $stmt->bind_param("s", $secret_key);
        
        if ($stmt->execute()) {
            $query = $stmt->get_result();
            if ($query->num_rows > 0) {
                $result = $query->fetch_assoc();
                // 验证有效期
                if (strtotime($result['expiry_date']) < time()) {
                    $error = '该密钥已过期';
                    $result = null;
                }
            } else {
                $error = '未找到匹配的密钥信息';
            }
        } else {
            $error = '数据库查询失败，请稍后再试';
        }
        $stmt->close();
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>入口找回</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .retrieve-box { max-width: 600px; margin: 50px auto; }
        .result-card { background: #f8f9fa; border-left: 4px solid #0d6efd; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-shield-lock"></i> 入口找回
            </a>
        </div>
    </nav>

    <div class="container">
        <div class="retrieve-box">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h3 class="mb-4 text-center"><i class="bi bi-key"></i> 找回随机码</h3>
                    
                    <?php if ($error): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>

                    <form method="post">
                        <div class="mb-3">
                            <label class="form-label">请输入企业微信机器人token</label>
                            <input type="text" name="secret_key" 
                                   class="form-control form-control-lg"
                                   placeholder="输入机器人token" required
                                   value="<?= htmlspecialchars($_POST['secret_key'] ?? '') ?>">
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-search"></i> 立即查询
                        </button>
                    </form>

                    <?php if ($result): ?>
                    <div class="card result-card mt-4">
                        <div class="card-body">
                            <h5 class="card-title">查询结果</h5>
                            <dl class="row">
                                <dt class="col-sm-3">随机码</dt>
                                <dd class="col-sm-9">
                                    <span class="fs-4 text-primary"><?= $result['random_string'] ?></span>
                                    <a href="urlsel.php?ss=<?= $result['random_string'] ?>" class="btn btn-primary">下一步</a>
                                </dd>
                                
                                <dt class="col-sm-3">有效期至</dt>
                                <dd class="col-sm-9">
                                    <?= date('Y-m-d H:i', strtotime($result['expiry_date'])) ?>
                                </dd>
                            </dl>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>
