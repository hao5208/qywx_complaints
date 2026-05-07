<?php
// 群机器人的 Webhook URL（需替换成你自己的）
$webhookUrl = 'https://qyapi.weixin.qq.com/cgi-bin/webhook/send?key=d7a79035-4';

// 构建消息数据（直接使用你提供的 JSON 结构）
$message = [
    "msgtype" => "template_card",
    "template_card" => [
        "card_type" => "news_notice",
        "source" => [
            "icon_url" => "https://wework.qpic.cn/wwpic/252813_jOfDHtcISzuodLa_1629280209/0",
            "desc" => "企微客诉系统",
            "desc_color" => 0
        ],
        "main_title" => [
            "title" => "您有新的投诉，请及时查看"
        ],
        "card_image" => [
            "url" => "http://kesu.669222.xyz/img/logo1.png",
            "aspect_ratio" => 2.25
        ],
        "horizontal_content_list" => [
            [
                "keyname" => "员工id",
                "value" => "a423456"
            ],
            [
                "keyname" => "投诉类别",
                "value" => "测试分类"
            ],
            [
                "keyname" => "手机号",
                "value" => "18855555555"
            ],
            [
                "keyname" => "ip地址",
                "value" => "1.1.1.1"
            ],
            [
                "keyname" => "ip属地",
                "value" => "中国广西"
            ],
            [
                "keyname" => "投诉内容",
                "value" => "阿巴阿巴阿巴阿巴阿巴"
            ]
        ],
        "jump_list" => [
            [
                "type" => 1,
                "url" => "https://work.weixin.qq.com/?from=openApi",
                "title" => "查看当前投诉"
            ],
            [
                "type" => 1,
                "url" => "https://work.weixin.qq.com/?from=openApi",
                "title" => "查看所有投诉"
            ]
        ],
        "card_action" => [
            "type" => 1,
            "url" => "https://work.weixin.qq.com/?from=openApi"
        ]
    ]
];

// 发送请求
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $webhookUrl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message, JSON_UNESCAPED_UNICODE));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
} else {
    $responseData = json_decode($response, true);
    if ($responseData['errcode'] == 0) {
        echo "消息发送成功！";
    } else {
        echo "消息发送失败，错误信息：{$responseData['errmsg']}";
    }
}
curl_close($ch);
?>
