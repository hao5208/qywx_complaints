<?php
$tsurl = htmlspecialchars($_GET['tsurl'] ?? '');
$access_token = htmlspecialchars($_GET['token'] ?? '');
?>
<!DOCTYPE html>
<html>
<head>
    <title>企业微信配置</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container { max-width: 600px; margin: 20px auto; }
        #result { max-height: 300px; overflow-y: auto; margin: 15px 0; }
    </style>
</head>
<body>
<div class="container">
    <div class="card p-3">
        <h4>🔄 成员信息批量设置</h4>
        
        <div class="my-3">
            <small>当前Token：</small>
            <code><?= substr($access_token, 0, 15) ?>...</code>
        </div>

        <div id="result" class="alert alert-secondary"></div>
        
        <form id="configForm">
            <input type="hidden" id="token" value="<?= $access_token ?>">
            
            <div class="mb-3">
                <label style="color: red;">链接名称(如果你设置的是反馈，那么就把下面的服务改成反馈)</label>
                <input type="text" id="linkName" class="form-control" value="服务" required>
            </div>
            
            <div class="mb-3">
                <label>URL地址</label>
                <input type="url" id="urlTemplate" class="form-control" 
                       value="<?= $tsurl ?>" required readonly="readonly">
            </div>
            
            <div class="mb-3">
                <label>链接标题</label>
                <input type="text" id="linkTitle" class="form-control" value="投诉" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">开始批量更新</button>
            <a href="getaccesstoken.php?tsurl=<?= urlencode($tsurl) ?>" 
               class="btn btn-link w-100 mt-2">重新获取</a>
        </form>
    </div>
</div>
<script>
const proxyBase = 'http://proxy.669222.xyz/proxy.php';

function showAlert(message, type = 'info') {
    const resultDiv = document.getElementById('result');
    resultDiv.innerHTML = `<div class="alert alert-${type}">${message}</div>`;
}

async function handleBatchUpdate() {
    const token = document.getElementById('token').value;
    const linkName = document.getElementById('linkName').value;
    const linkTitle = document.getElementById('linkTitle').value;
    const urlTemplate = document.getElementById('urlTemplate').value;

    showAlert('开始获取成员列表...', 'warning');

    try {
        // 获取所有成员ID
        let nextCursor = '';
        const allUserIds = [];
        
        do {
            const resp = await fetch(`${proxyBase}?target=user_list&access_token=${encodeURIComponent(token)}`, {
                method: 'POST',
                body: JSON.stringify({
                    cursor: nextCursor,
                    limit: 10000
                })
            });
            
            const data = await resp.json();
            if (data.errcode !== 0) throw new Error(data.errmsg);
            
            data.dept_user.forEach(user => {
                if (!allUserIds.includes(user.userid)) allUserIds.push(user.userid);
            });
            nextCursor = data.next_cursor || '';
        } while (nextCursor);

        // 批量更新处理
        let successCount = 0;
        const totalUsers = allUserIds.length;
        
        for (const [index, userId] of allUserIds.entries()) {
            try {
                const userUrl = `${urlTemplate}&random=${userId}`;
                const resp = await fetch(`${proxyBase}?target=user_update&access_token=${encodeURIComponent(token)}`, {
                    method: 'POST',
                    body: JSON.stringify({
                        userid: userId,
                        external_profile: {
                            external_attr: [{
                                type: 1,
                                name: linkName,
                                web: {
                                    url: userUrl,
                                    title: linkTitle
                                }
                            }]
                        }
                    })
                });
                
                const result = await resp.json();
                const progress = `${index + 1}/${totalUsers}`;
                
                if (result.errcode === 0) {
                    successCount++;
                    showAlert(`${progress} ${userId} 更新成功`, 'success');
                } else {
                    showAlert(`${progress} ${userId} 失败: ${result.errmsg}`, 'danger');
                }
                
                await new Promise(r => setTimeout(r, 300));
            } catch (error) {
                showAlert(`${userId} 请求异常: ${error.message}`, 'danger');
            }
        }
        
        showAlert(`处理完成！成功 ${successCount}/${totalUsers} 个成员`, 
                 successCount === totalUsers ? 'success' : 'warning');

    } catch (error) {
        showAlert(`系统错误: ${error.message}`, 'danger');
    }
}

document.getElementById('configForm').addEventListener('submit', function(e) {
    e.preventDefault();
    handleBatchUpdate();
});
</script>
</body>
</html>
