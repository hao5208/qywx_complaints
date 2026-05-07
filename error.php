<?php
// 设置PHP版本为7.4（通常需要在服务器环境配置）
// 此注释仅用于说明，实际需在服务器环境中配置PHP版本

// 处理GET参数
$type = $_GET['type'] ?? null;
$message = '';
$alert_type = '';

if ($type !== null) {
    switch ($type) {
        case 'a':
            $message = '链接找不到';
            $alert_type = 'danger';
            break;
        case 'b':
            $message = '系统已过期请及时续费';
            $alert_type = 'warning';
            break;
        case 'c':
            $message = '参数不能为空';
            $alert_type = 'info';
            break;
        case 'd':
            $message = '域名与企业不一致';
            $alert_type = 'warning';
            break;
        default:
            $message = '未知类型';
            $alert_type = 'secondary';
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>状态提示</title>
    <!-- Bootstrap CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <?php if ($type !== null) : ?>
            <div class="alert alert-<?= htmlspecialchars($alert_type) ?>">
                <?= htmlspecialchars($message) ?>
                <?php if ($type === 'b') : ?>
                    <a href="kmupdate.php" class="alert-link">立即续费</a>
                <?php endif; ?>
            </div>
        <?php else : ?>
            <div class="alert alert-light">
                请通过URL参数type指定类型（a/b/c）
            </div>
        <?php endif; ?>
        
        
    </div>

    <!-- Bootstrap JS 及其依赖 -->
    <script src="/js/jquery.min.js"></script>
    <script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
</body>
</html>
