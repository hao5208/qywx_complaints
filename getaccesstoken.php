<?php
$tsurl = htmlspecialchars($_GET['tsurl'] ?? '');
?>
<!DOCTYPE html>
<html>
<head>
    <title>获取Token</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container { max-width: 500px; margin: 50px auto; }
        #loading { display: none; }
    </style>
</head>
<body>
<div class="container">
    <div class="card p-3">
        <h4 class="mb-3">🔑 获取企业微信Token</h4>
        <div id="error" class="alert alert-danger d-none"></div>
        <div id="loading" class="alert alert-info">正在验证信息...</div>
        
        <form id="authForm">
            <div class="mb-3">
                <label>企业ID</label>
                <input type="text" name="corpid" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>应用Secret</label>
                <input type="password" name="corpsecret" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">获取Access Token</button>
        </form>
    </div>
</div>
<script>
const proxyBase = 'http://proxy.669222.xyz/proxy.php';

document.getElementById('authForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const form = e.target;
    const errorDiv = document.getElementById('error');
    const loadingDiv = document.getElementById('loading');
    
    errorDiv.classList.add('d-none');
    loadingDiv.style.display = 'block';

    try {
        const params = new URLSearchParams({
            target: 'gettoken',
            corpid: form.corpid.value,
            corpsecret: form.corpsecret.value
        });
        
        const resp = await fetch(`${proxyBase}?${params}`);
        const data = await resp.json();
        
        if (data.errcode === 0) {
            window.location.href = `seturl.php?token=${encodeURIComponent(data.access_token)}&tsurl=${encodeURIComponent('<?= $tsurl ?>')}`;
        } else {
            errorDiv.textContent = `获取失败: ${data.errmsg} (${data.errcode})`;
            errorDiv.classList.remove('d-none');
        }
    } catch (error) {
        errorDiv.textContent = `请求异常: ${error.message}`;
        errorDiv.classList.remove('d-none');
    } finally {
        loadingDiv.style.display = 'none';
    }
});
</script>
</body>
</html>
