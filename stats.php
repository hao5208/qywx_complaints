<?php
include 'db.php';

// 强制要求spt参数
if(!isset($_GET['spt']) || empty($_GET['spt'])) {
    die("必须提供spt参数");
}

// 安全过滤参数
$spt = $conn->real_escape_string($_GET['spt']);

// 统计查询（仅当前spt）
$total_sql = "SELECT COUNT(*) FROM complaints WHERE spt = '$spt'";
$today_sql = "SELECT COUNT(*) FROM complaints 
             WHERE spt = '$spt' 
             AND DATE(create_time) = CURDATE()";

$total = $conn->query($total_sql)->fetch_row()[0];
$today = $conn->query($today_sql)->fetch_row()[0];

// 获取对应spt的投诉记录
$result = $conn->query("SELECT * FROM complaints 
                       WHERE spt = '$spt'
                       ORDER BY create_time DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>投诉记录追踪</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .evidence-img { max-width: 200px; height: auto; cursor: zoom-in; }
        .time-badge { font-family: monospace; }
    </style>
</head>
<body>
<div class="container py-4">
    <!-- 统计头部 -->
    <div class="alert alert-dark mb-4">
        <h4 class="alert-heading">链接ID：<?=htmlspecialchars($spt)?></h4>
        <div class="h2">
            <span class="badge bg-primary">总投诉：<?=$total?></span>
            <span class="badge bg-success">今日投诉：<?=$today?></span>
        </div>
    </div>

    <!-- 投诉列表 -->
    <?php if($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-light">
                <div class="d-flex justify-content-between">
                    <span class="fw-bold"><?=htmlspecialchars($row['type'])?></span>
                    <span class="time-badge text-muted">
                        <?=date('Y-m-d H:i', strtotime($row['create_time']))?>
                    </span>
                </div>
            </div>
            
            <div class="card-body">
                <!-- 主体内容 -->
                <div class="row">
                    <!-- 左侧信息 -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="text-danger">投诉内容：</h6>
                            <div class="border p-3 bg-white rounded">
                                <?=nl2br(htmlspecialchars($row['content']))?>
                            </div>
                        </div>
                        
                        <?php if(!empty($row['random'])): ?>
                        <div class="mb-3">
                            <h6 class="text-warning">被投诉员工id：</h6>
                            <div class="border p-3 bg-light rounded">
                                <?=htmlspecialchars($row['random'])?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- 右侧信息 -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="text-primary">联系方式：</h6>
                            <div class="ps-3">
                                <?=htmlspecialchars($row['phone'])?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <h6 class="text-info">网络信息：</h6>
                            <div class="ps-3">
                                <div>IP地址：<?=htmlspecialchars($row['user_ip'])?></div>
                                <div>归属地：<?=htmlspecialchars($row['province'].$row['city'].' · '.$row['isp'])?></div>
                            </div>
                        </div>

                        <?php if(!empty($row['pic'])): ?>
                        <div class="mb-3">
                            <h6 class="text-success">图片证据：</h6>
                            <div class="d-flex flex-wrap">
                                <?php foreach(explode(",", $row['pic']) as $img): 
                                    $clean_img = htmlspecialchars(trim($img));
                                ?>
                                <a href="<?=$clean_img?>" target="_blank" class="m-1">
                                    <img src="<?=$clean_img?>" class="evidence-img rounded border">
                                </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="alert alert-warning">未找到对应的投诉记录</div>
    <?php endif; ?>
</div>
</body>
</html>
