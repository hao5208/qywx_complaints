<?php
// 程序安装文件
error_reporting(0);
date_default_timezone_set("PRC");
$configFile = '../db.php'; // 配置文件路径

@header('Content-Type: text/html; charset=UTF-8');
$step = isset($_GET['step']) ? $_GET['step'] : 1;
if (file_exists('install.lock')) {
    exit('你已经成功安装，如需重新安装，请手动删除install目录下install.lock文件！');
}

function check_db($host, $user, $pwd, $dbname) {
    $conn = new mysqli($host, $user, $pwd, $dbname);
    if ($conn->connect_error) {
        return $conn->connect_error;
    }
    $conn->close();
    return true;
}

if ($step == 2) {
    $webdemo = isset($_POST['webdemo']) ? rtrim($_POST['webdemo'], '/').'/' : '';
    $servername = isset($_POST['servername']) ? $_POST['servername'] : 'localhost';
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $dbname = isset($_POST['dbname']) ? $_POST['dbname'] : '';

    if (empty($webdemo) || empty($servername) || empty($username) || empty($dbname)) {
        $errorMsg = '请填写完整所有必填项！';
    } else {
        $check_result = check_db($servername, $username, $password, $dbname);
        if ($check_result !== true) {
            $errorMsg = '数据库连接失败：'.$check_result;
        } else {
            $configContent = "<?php
//你的系统域名
\$webdemo = \"{$webdemo}\";

// db.php
\$servername = \"{$servername}\";
\$username = \"{$username}\";
\$password = \"{$password}\";
\$dbname = \"{$dbname}\";

// 创建连接
\$conn = new mysqli(\$servername, \$username, \$password, \$dbname);

// 检查连接
if (\$conn->connect_error) {
    die(\"连接失败: \" . \$conn->connect_error);
}
?>";

            if (file_put_contents($configFile, $configContent)) {
                header("Location: ?step=3");
                exit();
            } else {
                $errorMsg = '配置文件保存失败，请检查目录权限！';
            }
        }
    }
} elseif ($step == 3) {
    require_once $configFile;
    
    // 执行SQL文件
    $sql = file_get_contents('install.sql');
    $queries = explode(';', $sql);
    
    $success = 0;
    $errors = [];
    foreach ($queries as $query) {
        $query = trim($query);
        if (!empty($query)) {
            if ($conn->query($query) === TRUE) {
                $success++;
            } else {
                $errors[] = $conn->error;
            }
        }
    }
    
    if (empty($errors)) {
        // 创建安装锁
        file_put_contents('install.lock', '安装时间：'.date('Y-m-d H:i:s'));
    } else {
        $errorMsg = 'SQL执行错误：'.implode('<br>', $errors);
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>系统安装向导</title>
    <link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container { max-width: 800px; margin-top: 50px; }
        .card-header { font-weight: bold; }
        .form-label { font-weight: 500; }
    </style>
</head>
<body>
<div class="container">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            系统安装向导（当前步骤：<?php echo $step ?>）
        </div>
        
        <?php if ($step == 1): ?>
        <div class="card-body">
            <h4 class="mb-4">环境检查</h4>
            <ul class="list-group mb-4">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    PHP版本 ≥ 7.4
                    <span class="badge bg-<?= version_compare(PHP_VERSION, '7.4.0', '>=') ? 'success' : 'danger' ?>">
                        <?= PHP_VERSION ?>
                    </span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    MySQLi扩展支持
                    <span class="badge bg-<?= extension_loaded('mysqli') ? 'success' : 'danger' ?>">
                        <?= extension_loaded('mysqli') ? '支持' : '不支持' ?>
                    </span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    配置文件可写
                    <span class="badge bg-<?= is_writable('../') ? 'success' : 'danger' ?>">
                        <?= is_writable('../') ? '可写' : '不可写' ?>
                    </span>
                </li>
            </ul>
            <div class="d-grid">
                <a href="?step=2" class="btn btn-primary">开始安装</a>
            </div>
        </div>
        
        <?php elseif ($step == 2): ?>
        <div class="card-body">
            <h4 class="mb-4">系统配置</h4>
            <?php if(isset($errorMsg)): ?>
                <div class="alert alert-danger"><?= $errorMsg ?></div>
            <?php endif; ?>
            
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">网站地址</label>
                    <input type="url" name="webdemo" class="form-control" placeholder="http://yourdomain.com/" required>
                    <div class="form-text">请输入完整的网站地址，以斜杠结尾</div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">数据库地址</label>
                    <input type="text" name="servername" class="form-control" value="localhost" required>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">数据库用户名</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">数据库密码</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">数据库名称</label>
                    <input type="text" name="dbname" class="form-control" required>
                    <div class="form-text">请提前创建好数据库</div>
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">保存配置</button>
                </div>
            </form>
        </div>
        
        <?php elseif ($step == 3 && empty($errorMsg)): ?>
        <div class="card-body">
            <div class="alert alert-success">
                <h4>安装成功！</h4>
                <p>成功执行 <?php echo $success ?> 条SQL语句</p>
                <hr>
                <p>重要提示：</p>
                <ol>
                    <li>请立即删除install目录</li>
                    <li>后台地址：<a href="<?php echo $webdemo ?>admin_login.php" target="_blank"><?php echo $webdemo ?>admin_login.php</a></li>
                    <li>默认管理员账号密码admin/admin123</li>
                    <li>修改账号密码在admin_login.php第10行</li>
                </ol>
                <div class="d-grid gap-2">
                    <a href="<?php echo $webdemo ?>" class="btn btn-success">访问网站首页</a>
                </div>
            </div>
        </div>
        
        <?php else: ?>
        <div class="card-body">
            <div class="alert alert-danger">
                <?= $errorMsg ?? '发生未知错误' ?>
            </div>
            <div class="d-grid">
                <a href="javascript:history.back()" class="btn btn-warning">返回修改</a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
