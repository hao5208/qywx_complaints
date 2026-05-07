<?php
/**
 * 发送企业微信图文消息（简化接口）
 * @param string $key 机器人Webhook Key
 * @param string $title 标题（不超过128字节）
 * @param string $description 描述（不超过512字节）
 * @param string $url 跳转链接
 * @param string $picurl 图片链接
 * @return array 发送结果
 */
function sendQywxNews(string $key, string $title, string $description, string $url, string $picurl): array
{
    // 构造Webhook地址
    $webhookUrl = 'https://qyapi.weixin.qq.com/cgi-bin/webhook/send?key=' . urlencode($key);

    // 构建消息体
    $message = [
        'msgtype' => 'news',
        'news'    => [
            'articles' => [
                [
                    'title'       => $title,
                    'description' => $description,
                    'url'         => $url,
                    'picurl'      => $picurl
                ]
            ]
        ]
    ];

    // 执行CURL请求
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL           => $webhookUrl,
        CURLOPT_POST          => true,
        CURLOPT_POSTFIELDS    => json_encode($message, JSON_UNESCAPED_UNICODE),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER    => ['Content-Type: application/json'],
        CURLOPT_TIMEOUT        => 5  // 添加5秒超时
    ]);

    $response = curl_exec($ch);
    
    // 错误处理
    if(curl_errno($ch)){
        $errorMsg = 'CURL Error: ' . curl_error($ch);
        curl_close($ch);
        return ['error' => true, 'code' => curl_getinfo($ch, CURLINFO_HTTP_CODE), 'message' => $errorMsg];
    }
    curl_close($ch);

    // 解析响应
    $result = json_decode($response, true);
    if(empty($result)){
        return ['error' => true, 'code' => 500, 'message' => 'Invalid API response'];
    }

    return $result['errcode'] === 0 
        ? ['error' => false, 'code' => 200, 'message' => 'success'] 
        : ['error' => true, 'code' => $result['errcode'], 'message' => $result['errmsg']];
}

