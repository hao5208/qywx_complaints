<?php
// 配置参数
$api_max_limit = 10000; // 每次请求最大数量


$access_token =  $_POST['token'] ?? '';
$name11=$_POST['name'];
$title11=$_POST['title'];
$url11=$_POST['url']."&random=";


/***************** 第二步：分页获取所有用户userid *****************/
$userListUrl = "https://qyapi.weixin.qq.com/cgi-bin/user/list_id?access_token={$access_token}";

$allUsers = []; // 存储所有userid（自动去重）
$next_cursor = ''; // 分页游标

do {
    // 构造请求数据
    $postData = json_encode([
        'cursor' => $next_cursor,
        'limit' => $api_max_limit
    ]);

    // 发送POST请求
    $ch = curl_init($userListUrl);
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postData,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json']
    ]);
    $response = curl_exec($ch);
    $data = json_decode($response, true);

    // 错误处理
    if ($data['errcode'] != 0) {
        die("获取用户列表失败：{$data['errmsg']}");
    }

    // 提取userid并去重
    foreach ($data['dept_user'] as $user) {
        $allUsers[$user['userid']] = true; // 使用关联数组去重
    }

    // 更新游标
    $next_cursor = $data['next_cursor'] ?? '';

} while (!empty($next_cursor)); // 当next_cursor为空时停止

$userids = array_keys($allUsers); // 最终用户列表

/***************** 第三步：设置用户服务选项 *****************/
foreach ($userids as $userid) {
    $updateUrl = "https://qyapi.weixin.qq.com/cgi-bin/user/update?access_token={$access_token}";
    
    $postData = json_encode([
        'userid' => $userid,
        'external_profile' => [
            'external_attr' => [[
                'type' => 1,
                'name' => $name11,
                'web' => [
                    'url' => $url11.$userid,
                    'title' => $title11
                ]
            ]]
        ]
             
    ]);

    $ch = curl_init($updateUrl);
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postData,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json']
    ]);

    $result = curl_exec($ch);
    $resultData = json_decode($result, true);
    
    // 处理结果
    if ($resultData['errcode'] == 0) {
        echo "用户 {$userid} 设置成功<br>";
    } else {
        echo "用户 {$userid} 设置失败：{$resultData['errmsg']}<br>";
    }

    curl_close($ch);
    usleep(300000); // 降低请求频率（0.3秒）
}
?>
