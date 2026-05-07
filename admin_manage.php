<?php
require 'db.php';
session_start();

// 验证登录状态
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit;
}

// 处理操作请求
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 处理生成卡密请求
    if (isset($_POST['generate'])) {
        $quantity = intval($_POST['quantity']);
        $length = intval($_POST['length']);
        $days = intval($_POST['gen_days']);
        
        $successCount = 0;
        for ($i = 0; $i < $quantity; $i++) {
            $kami = generate_kami($length);
            $stmt = $conn->prepare("INSERT INTO kamiusage (kami, days) VALUES (?, ?)");
            $stmt->bind_param("si", $kami, $days);
            if ($stmt->execute()) {
                $successCount++;
            }
            $stmt->close();
        }
        $message = "成功生成 {$successCount}/{$quantity} 个卡密";
    }
    
    // 处理删除请求
    if (isset($_POST['delete'])) {
        $stmt = $conn->prepare("DELETE FROM kamiusage WHERE id = ?");
        $stmt->bind_param("i", $_POST['id']);
        $stmt->execute();
        $stmt->close();
    }
    
    // 处理编辑请求
    if (isset($_POST['edit'])) {
        $kami = $conn->real_escape_string($_POST['kami']);
        $days = intval($_POST['days']);
        $id = intval($_POST['id']);
        
        $stmt = $conn->prepare("UPDATE kamiusage SET kami = ?, days = ? WHERE id = ?");
        $stmt->bind_param("sii", $kami, $days, $id);
        $stmt->execute();
        $stmt->close();
    }
    
    // 处理添加请求
    if (isset($_POST['add'])) {
        $kami = $conn->real_escape_string($_POST['kami']);
        $days = intval($_POST['days']);
        
        $check = $conn->query("SELECT id FROM kamiusage WHERE kami = '{$kami}'");
        if ($check->num_rows > 0) {
            $error = "卡密已存在";
        } else {
            $stmt = $conn->prepare("INSERT INTO kamiusage (kami, days) VALUES (?, ?)");
            $stmt->bind_param("si", $kami, $days);
            $stmt->execute();
            $stmt->close();
        }
    }
}

// 生成随机卡密函数
function generate_kami($length = 16) {
    $chars = 'ABCDEFGHJKMNPQRSTUVWXYZ23456789'; // 排除易混淆字符
    $kami = '';
    for ($i = 0; $i < $length; $i++) {
        $kami .= $chars[random_int(0, strlen($chars) - 1)];
    }
    return $kami;
}

// 获取卡密数据
//$sql = "SELECT * FROM kamiusage ORDER BY created_at DESC";
//$result = $conn->query($sql);
$perPage = 15; // 每页显示数量
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $perPage;

// 获取总记录数
$totalResult = $conn->query("SELECT COUNT(*) AS total FROM kamiusage");
$totalRow = $totalResult->fetch_assoc();
$totalPages = ceil($totalRow['total'] / $perPage);

// 分页查询
$sql = "SELECT * FROM kamiusage ORDER BY created_at DESC LIMIT $offset, $perPage";
$result = $conn->query($sql);
// 错误处理
if (!$result) {
    die("<div class='alert alert-danger'>数据库错误: " . $conn->error . "</div>");
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>卡密管理系统</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .kami-table { max-height: 60vh; overflow-y: auto; }
        .form-card { background: #f8f9fa; border-radius: 8px; }
        .nav-brand { font-weight: 600; letter-spacing: 1px; }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand nav-brand" href="#">
                <i class="bi bi-shield-lock"></i> 卡密管理
            </a>
            <div class="d-flex">
                <a href="key_manage.php" class="btn btn-sm btn-outline-light">
                    <i class="bi bi-box-arrow-right"></i> 企业key管理
                </a>
                <a href="?logout" class="btn btn-sm btn-outline-light">
                    <i class="bi bi-box-arrow-right"></i> 退出
                </a>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <?php if (isset($message)): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= $message ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= $error ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <!-- 生成卡密表单 -->
        <div class="card form-card mb-4">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-key"></i> 批量生成卡密</h5>
                <form method="post" class="row g-3">
                    <div class="col-md-3">生成数量:
                        <input type="number" name="quantity" class="form-control" 
                               min="1" max="100" value="1" required placeholder="生成数量">
                    </div>
                    <div class="col-md-3">卡密长度:                        <input type="number" name="length" class="form-control"
                               min="8" max="32" value="16" required placeholder="卡密长度">
                    </div>
                    <div class="col-md-3">
                        卡密天数:
                        <input type="number" name="gen_days" class="form-control"
                               min="1" max="3650" value="365" required placeholder="有效天数">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" name="generate" class="btn btn-primary w-100">
                            <i class="bi bi-gear"></i> 立即生成
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 手动添加表单 -->
        <div class="card form-card mb-4">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-plus-circle"></i> 手动添加卡密</h5>
                <form method="post" class="row g-3">
                    <div class="col-md-8">
                        <input type="text" name="kami" class="form-control" 
                               placeholder="输入卡密内容" required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="days" class="form-control"
                               min="1" value="30" required placeholder="天数">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" name="add" class="btn btn-success w-100">
                            <i class="bi bi-save"></i> 添加
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 卡密列表 -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-list"></i> 卡密列表</h5>
            </div>
            <div class="card-body p-0">
                <div class="kami-table">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="25%">卡密内容</th>
                                <th width="15%">有效天数</th>
                                <th width="20%">创建时间</th>
                                <th width="20%">首次使用</th>
                                <th width="20%">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0) : ?>
                                <?php while ($row = $result->fetch_assoc()) : ?>
                                <tr>
                                    <form method="post">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <td>
                                            <input type="text" name="kami" 
                                                   class="form-control form-control-sm" 
                                                   value="<?= htmlspecialchars($row['kami']) ?>" required>
                                        </td>
                                        <td>
                                            <input type="number" name="days" 
                                                   class="form-control form-control-sm"
                                                   value="<?= $row['days'] ?>" min="1" required>
                                        </td>
                                        <td><?= $row['created_at'] ?></td>
                                        <td><?= $row['first_used'] ?: '未使用' ?></td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <button type="submit" name="edit" 
                                                        class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-pencil">保存</i>
                                                </button>
                                                <button type="submit" name="delete" 
                                                        class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('确定删除该卡密？')">
                                                    <i class="bi bi-trash">删除</i>
                                                </button>
                                            </div>
                                        </td>
                                    </form>
                                </tr>
                                <?php endwhile; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        <i class="bi bi-database-exclamation"></i> 暂无卡密数据
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <nav aria-label="Page navigation" class="mt-4">
    <ul class="pagination justify-content-center">
        <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $page - 1 ?>">上一页</a>
        </li>
        
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
        
        <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $page + 1 ?>">下一页</a>
        </li>
    </ul>
</nav>

                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 脚本 -->
    <script src="/js/bootstrap.bundle.min.js"></script>
    <?php if (isset($_GET['logout'])) : ?>
        <?php
        session_destroy();
        header('Location: admin_login.php');
        exit;
        ?>
    <?php endif; ?>
</body>
</html>
<?php
$conn->close();
?>
