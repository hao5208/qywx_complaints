<?php
$access_token =  $_GET['token'] ?? '';
$tsurl =  $_GET['tsurl'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>更新信息 - 企业微信</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container { max-width: 600px; margin-top: 30px; }
        .token-box { 
            background: #f8f9fa; 
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card p-4">
        <h4 class="mb-4">🔄 设置全部投诉信息</h4>
        
        <!-- 显示当前Token -->
        <div class="token-box">
            <small class="text-muted">当前Token：</small>
            <code><?= htmlspecialchars(substr($access_token, 0, 20)) ?>...</code>
        </div>

        <?= $result ?? '' ?>
        
        <form method="post" action="updateall.php">
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">token</label>
                    <input type="text" name="token" class="form-control" required value="<?= htmlspecialchars($access_token) ?>" readonly="readonly">
                </div>
                <div class="col-md-6">
                    <label class="form-label">链接名称(需要与文档第6步设置的内容一致)</label>
                    <input type="text" name="name" class="form-control" required value="服务">
                </div>
                <div class="col-12">
                    <label class="form-label">URL地址</label>
                    <input type="url" name="url" class="form-control" required value="<?= htmlspecialchars($tsurl) ?>">
                </div>
                <div class="col-12">
                    <label class="form-label">链接标题</label>
                    <input type="text" name="title" class="form-control" required value="投诉">
                </div>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-success w-100">更新全部成员信息</button>
                <a href="getaccesstoken.php" class="btn btn-link w-100 mt-2">重新获取Token</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
