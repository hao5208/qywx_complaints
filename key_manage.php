<?php
require 'db.php';
session_start();

// 权限验证
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit;
}

// 处理表单提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 删除操作
    if (isset($_POST['delete'])) {
        $stmt = $conn->prepare("DELETE FROM keys_table WHERE id = ?");
        $stmt->bind_param("i", $_POST['id']);
        $stmt->execute();
    }
    // 添加/编辑操作
    else {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $random_str = substr(str_shuffle(str_repeat('ABCDEFGHJKLMNPQRSTUVWXYZ23456789', 5)), 0, 5);
        $secret_key = $conn->real_escape_string($_POST['secret_key']);
        $domainname = $conn->real_escape_string($_POST['domainname']);
        $km = $conn->real_escape_string($_POST['km']);
        $expiry = date('Y-m-d H:i:s', strtotime($_POST['expiry_date']));

        if ($id > 0) { // 编辑
            $stmt = $conn->prepare("UPDATE keys_table SET 
                                  
                                  secret_key = ?,
                                  domainname = ?,
                                  km = ?,
                                  expiry_date = ?
                                  WHERE id = ?");
            $stmt->bind_param("ssssi", $secret_key, $domainname,$km, $expiry, $id);
        } else { // 新增
            $stmt = $conn->prepare("INSERT INTO keys_table 
                                  (random_string, secret_key, domainname,km, expiry_date)
                                  VALUES (?, ?, ?,?, ?)");
            $stmt->bind_param("sssss", $random_str, $secret_key,$domainname, $km, $expiry);
        }
        $stmt->execute();
    }
}

// 获取数据
//$result = $conn->query("SELECT * FROM keys_table ORDER BY expiry_date DESC");
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$where = '';
if (!empty($search)) {
    $search = $conn->real_escape_string($search);
    $where = " WHERE secret_key LIKE '%$search%' OR km LIKE '%$search%'";
}

// 分页参数
$perPage = 15;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $perPage;

// 获取总数
$totalSql = "SELECT COUNT(*) AS total FROM keys_table $where";
$totalResult = $conn->query($totalSql);
$totalRow = $totalResult->fetch_assoc();
$totalPages = ceil($totalRow['total'] / $perPage);

// 分页查询
$sql = "SELECT * FROM keys_table $where 
        ORDER BY expiry_date DESC 
        LIMIT $offset, $perPage";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>密钥管理</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-container { max-height: 70vh; overflow-y: auto; }
        .expiry-status { font-size: 0.8rem; padding: 3px 8px; border-radius: 10px; }
        .expiry-valid { background: #d4edda; color: #155724; }
        .expiry-expired { background: #f8d7da; color: #721c24; }
        a {
text-decoration: none;
}
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-shield-lock"></i> 密钥管理系统
            </a>
            <div class="d-flex">
                <a href="admin_manage.php" class="btn btn-sm btn-outline-light mx-1">卡密管理</a>
                <a href="?logout" class="btn btn-sm btn-outline-light">退出</a>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <!-- 添加表单 -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-plus-circle"></i> 添加新密钥</h5>
                <form method="post" class="row g-3">
                    <div class="col-md-3">
                        <input type="text" name="secret_key" 
                               class="form-control" placeholder="密钥内容" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="domainname" 
                               class="form-control" placeholder="域名" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="km" 
                               class="form-control" placeholder="关联卡密" required>
                    </div>
                    <div class="col-md-3">
                        <input type="datetime-local" name="expiry_date" 
                               class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-save"></i> 添加
                        </button>
                    </div>
                </form>
            </div>
        </div>

<!-- 添加搜索表单 -->
<div class="card mb-4">
    <div class="card-body">
        <form method="get" class="row g-3">
            <div class="col-md-9">
                <input type="text" name="search" 
                       class="form-control" 
                       placeholder="输入密钥或卡密查询"
                       value="<?= htmlspecialchars($search) ?>">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search"></i> 搜索
                </button>
            </div>
        </form>
    </div>
</div>
        <!-- 数据表格 -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-list"></i> 密钥列表</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-container">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>入口id</th>
                                <th>机器人token</th>
                                <th>客户域名</th>
                                <th>关联卡密</th>
                                <th>过期时间</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): 
                                $isExpired = strtotime($row['expiry_date']) < time();
                            ?>
                            <tr>
                                <form method="post">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <td>
                                        <input type="text" name="random_string" 
                                               value="<?= $row['random_string'] ?>" 
                                               class="form-control form-control-sm" readonly>
                                    </td>
                                    <td>
                                        <input type="text" name="secret_key"
                                               value="<?= htmlspecialchars($row['secret_key']) ?>" 
                                               class="form-control form-control-sm">
                                    </td>
                                    <td>
                                        <input type="text" name="domainname"
                                               value="<?= htmlspecialchars($row['domainname']) ?>" 
                                               class="form-control form-control-sm">
                                    </td>
                                    <td>
                                        <input type="text" name="km"
                                               value="<?= htmlspecialchars($row['km']) ?>" 
                                               class="form-control form-control-sm" readonly>
                                    </td>
                                    <td>
                                        <input type="datetime-local" name="expiry_date"
                                               value="<?= date('Y-m-d\TH:i', strtotime($row['expiry_date'])) ?>" 
                                               class="form-control form-control-sm">
                                    </td>
                                    <td>
                                        <span class="expiry-status <?= $isExpired ? 'expiry-expired' : 'expiry-valid' ?>">
                                            <?= $isExpired ? '已过期' : '有效' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                                <a href="urlsel.php?ss=<?= $row['random_string'] ?>" target="_blank">查入口</a>                                            </button>
                                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil">保存更新</i>
                                            </button>
                                            <button type="submit" name="delete" 
                                                    class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('确定删除？')">
                                                <i class="bi bi-trash">删除</i>
                                            </button>
                                        </div>
                                    </td>
                                </form>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <!-- 分页导航（与admin_manage.php类似，增加search参数） -->
<nav aria-label="Page navigation" class="mt-4">
    <ul class="pagination justify-content-center">
        <?php
        $queryParams = $_GET;
        unset($queryParams['page']);
        $baseUrl = '?' . http_build_query($queryParams) . '&page=';
        ?>
        
        <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="<?= $baseUrl . ($page - 1) ?>">上一页</a>
        </li>
        
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                <a class="page-link" href="<?= $baseUrl . $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
        
        <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
            <a class="page-link" href="<?= $baseUrl . ($page + 1) ?>">下一页</a>
        </li>
    </ul>
</nav>
                </div>
            </div>
        </div>
    </div>

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
<?php $conn->close(); ?>
