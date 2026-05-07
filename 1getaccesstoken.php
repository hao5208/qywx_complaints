<?php
require_once 'db.php';
session_start();
$tsurl =  $_GET['tsurl'] ?? '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $corpid = $_POST['corpid'];
    $corpsecret = $_POST['corpsecret'];
   
    
    // 获取access_token
    $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=".urlencode($corpid)."&corpsecret=".urlencode($corpsecret);
    $response = json_decode(file_get_contents($url), true);
    $token8=urlencode($response['access_token']);
    if ($response['errcode'] == 0) {
        
        // 跳转并传递token
        header("Location: seturl.php?token=".$token8."&tsurl=".$tsurl);
        exit();
        
    } else {
        $error = "获取失败：".$response['errmsg'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>获取Token - 企业微信</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container { max-width: 500px; margin-top: 50px; }
        .card { box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
<div class="container">
    <div class="card p-4">
        <h4 class="mb-4">🔑 获取Access Token</h4>
        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        
        <form method="post">
            
            
            <div class="mb-3">
                <label class="form-label">企业ID</label>
                <input type="text" name="corpid" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Secret</label>
                <input type="password" name="corpsecret" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">获取Access Token</button>
        </form>
    </div>
</div>
</body>
</html>
