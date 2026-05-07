<?php
require 'db.php';

// 系统域名配置
//$webdemo = "http://ts9.cn/";
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>域名批量替换系统</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .domain-card { max-width: 600px; margin: 2rem auto; }
        .domain-example { font-size: 0.9em; color: #666; }
        .form-text { color: #6c757d !important; }
    </style>
</head>
<body>
    <div class="container">
        <div class="domain-card card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="bi bi-globe"></i> 域名批量替换系统</h4>
            </div>
            
            <div class="card-body">
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $oldDomain = trim($_POST['old_domain']);
                    $newDomain = trim($_POST['new_domain']);
                    
                    try {
                        // 清洗和验证输入
                        $oldDomain = sanitizeDomain($oldDomain);
                        $newDomain = sanitizeDomain($newDomain);

                        if (empty($oldDomain)) {
                            throw new InvalidArgumentException("旧域名不能为空");
                        }

                        if (empty($newDomain)) {
                            throw new InvalidArgumentException("新域名不能为空");
                        }

                        // 执行更新
                        $stmt = $conn->prepare("UPDATE keys_table SET domainname = ? WHERE domainname = ?");
                        $stmt->bind_param("ss", $newDomain, $oldDomain);
                        $stmt->execute();
                        
                        $affected = $stmt->affected_rows;
                        $stmt->close();

                        // 显示结果
                        if ($affected > 0) {
                            echo '<div class="alert alert-success">';
                            echo "<h5>更新成功！</h5>";
                            echo "已更新 <strong>{$affected}</strong> 条记录";
                            echo '<div class="mt-2">';
                            echo "<div class='text-break'>旧域名：<code>{$oldDomain}</code></div>";
                            echo "<div class='text-break'>新域名：<code>{$newDomain}</code></div>";
                            echo '</div></div>';
                        } else {
                            echo '<div class="alert alert-warning">';
                            echo "未找到域名 <code>{$oldDomain}</code> 的记录";
                            echo '<div class="mt-2">可能原因：';
                            echo '<ul class="mb-0">';
                            echo '<li>域名不存在</li>';
                            echo '<li>域名大小写不匹配</li>';
                            echo '<li>目标域名为 NULL 值</li>';
                            echo '</ul></div></div>';
                        }

                    } catch (InvalidArgumentException $e) {
                        echo '<div class="alert alert-danger">'.htmlspecialchars($e->getMessage()).'</div>';
                    } catch (Exception $e) {
                        echo '<div class="alert alert-danger">操作失败：'.htmlspecialchars($e->getMessage()).'</div>';
                    }
                }

                /** 域名清洗函数 */
                function sanitizeDomain($domain) {
                    // 去除协议和路径
                    $domain = preg_replace('/^https?:\/\//i', '', $domain);  // 清除协议头
                    $domain = explode('/', $domain)[0];    // 清除路径
                    $domain = trim($domain);               // 去除首尾空格
                    
                    // 验证域名有效性
                    if (!preg_match('/^(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z]{2,}$/i', $domain)) {
                        throw new InvalidArgumentException("非法域名格式: ".htmlspecialchars($domain));
                    }
                    
                    return strtolower($domain); // 统一转为小写
                }
                ?>

                <form method="post">
                    <div class="mb-3">
                        <label class="form-label">旧域名 <span class="text-danger">*</span></label>
                        <input type="text" name="old_domain" 
                               class="form-control" 
                               placeholder="例如：old.example.com"
                               pattern="^[a-zA-Z0-9][a-zA-Z0-9-.]{1,61}[a-zA-Z0-9]\.[a-zA-Z]{2,}$"
                               title="有效域名格式示例：example.com 或 sub.domain.cn"
                               required>
                        <div class="form-text">不需要带 http:// 或 https://</div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">新域名 <span class="text-danger">*</span></label>
                        <input type="text" name="new_domain" 
                               class="form-control" 
                               placeholder="例如：new.example.com"
                               pattern="^[a-zA-Z0-9][a-zA-Z0-9-.]{1,61}[a-zA-Z0-9]\.[a-zA-Z]{2,}$"
                               title="有效域名格式示例：example.com 或 sub.domain.cn"
                               required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 py-2">
                        <i class="bi bi-arrow-repeat"></i> 确认批量替换
                    </button>
                </form>
            </div>
        </div>

        <!-- 操作指引 -->
        <div class="alert alert-light mt-4">
            <h5>操作说明：</h5>
            <ul class="mb-0">
                <li>仅修改完全匹配的域名记录</li>
                <li>支持大小写自动转换（统一储存为小写）</li>
                <li>示例域名格式：
                    <span class="domain-example">example.com, sub.domain.cn, a.b.co.uk</span>
                </li>
            </ul>
        </div>
    </div>
</body>
</html>
