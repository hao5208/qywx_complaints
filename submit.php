<?php
require_once 'db.php';
require_once 'hook.php'; 
header('Content-Type: application/json; charset=utf-8');

$user_ip = $_SERVER['REMOTE_ADDR'];
//echo $user_ip;
// 发送 GET 请求
$ipurl = "https://ip9.com.cn/get?ip=" . $user_ip;
$ipresponse = file_get_contents($ipurl);

// 解析 JSON 响应
$ipdata = json_decode($ipresponse, true);

// 提取省、市和运营商信息
$province = $ipdata['data']['prov'];
$city = $ipdata['data']['city'];
$isp = $ipdata['data']['isp'];
//$client_ip = $_SERVER['REMOTE_ADDR'];
// 获取POST参数
$type = isset($_POST['type']) ? $_POST['type'] : '';
$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
$content = isset($_POST['content']) ? $_POST['content'] : '';
$pic = isset($_POST['pic']) ? $_POST['pic'] : '';
$spt = isset($_POST['spt']) ? $_POST['spt'] : '';
$random = isset($_POST['random']) ? $_POST['random'] : '';




// 使用预处理语句查询对应的密钥
$stmt = $conn->prepare("SELECT secret_key, km, domainname,expiry_date FROM keys_table WHERE random_string = ?");
$stmt->bind_param("s", $spt);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($secret_key, $km, $domainname,$expiry_date);
    $stmt->fetch();
    
    // 检查密钥是否过期
    $current_time = date("Y-m-d H:i:s");
    if ($current_time > $expiry_date) {
       echo json_encode([
        'status' => 0,
        'msg' => '卡密过期'
    ], JSON_UNESCAPED_UNICODE);
    } else {
       
    
   // echo "对应的密钥是: " . $secret_key;
    $toukey=$secret_key;
// 使用 explode 将字符串按逗号分隔为数组
$imageLinks = explode(',', $pic);
//$picss="";
// 循环遍历数组，输出每个图片链接到页面上
//foreach ($imageLinks as $imageLink) {
    // 使用 trim 去除可能的空格
//    $imageLink = trim($imageLink);
    // 输出图片标签
//    $picss.= '<img src="' . $imageLink . '" alt="Image" style="max-width: 100%; margin: 10px 0;"><br>';
//}

$picss = ''; // 初始化变量
foreach ($imageLinks as $imageLink) {
    $imageLink = htmlspecialchars(trim($imageLink));
    if (!empty($imageLink)) { // 跳过空链接
        $picss .= '<img src="' . $imageLink . '" alt="Descriptive Text" style="max-width: 100%; margin: 10px 0; display: block;">';
    }
}



switch ($type) {
    case 0:
        $b = "此账号可能被盗用";
        break;
    case 1:
        $b = "存在侵权行为";
        break;
    case 2:
        $b = "发布仿冒品信息";
        break;
    case 3:
        $b = "冒充他人";
        break;
    case 4:
        $b = "侵犯未成年人权益";
        break;
    case 5:
        $b = "色情";
        break;
    case 6:
        $b = "违法犯罪及违禁品";
        break;
    case 7:
        $b = "赌博";
        break;
    case 8:
        $b = "政治谣言";
        break;
    case 9:
        $b = "暴恐血腥";
        break;
    case 10:
        $b = "其他违规内容";
        break;
    case 11:
        $b = "金融诈骗（贷款/提额/代开/套现等）";
        break;
    case 12:
        $b = "网络兼职刷单诈骗";
        break;
    case 13:
        $b = "返利诈骗";
        break;
    case 14:
        $b = "网络交友诈骗";
        break;
    case 15:
        $b = "虚假投资理财诈骗";
        break;
    case 16:
        $b = "赌博诈骗";
        break;
    case 17:
        $b = "收款不发货";
        break;
    case 18:
        $b = "仿冒他人诈骗";
        break;
    case 19:
        $b = "免费送诈骗";
        break;
    case 20:
        $b = "游戏相关诈骗（代练/充值等）";
        break;
    case 21:
        $b = "其他诈骗行为";
        break;
    case 22:
        $b = "粉丝无底线追星行为";
        break;
    default:
        $b = "未知类型";
        break;
}

// 使用预处理语句防止SQL注入
$stmt = $conn->prepare("INSERT INTO complaints (
    type, phone, content, pic, spt, random, 
    user_ip, province, city, isp
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("ssssssssss", 
    $b, $phone, $content, $pic, $spt, $random,
    $user_ip, $province, $city, $isp
);

$stmt->execute();
// 生成文件名
$timestamp = date('Y-m-d-H-i-s'); // 当前时间戳
$randomNumber = mt_rand(1000, 9999); // 生成 4 位随机数
$filename = "./jl/{$timestamp}-{$randomNumber}.html"; // 文件名
$filename1 = "http://".$domainname."/jl/{$timestamp}-{$randomNumber}.html"; // 文件
$bb = '<div style="background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
<div style="margin-bottom: 15px;">
            <strong>被投诉人:</strong>
            <p style="margin: 5px 0 0; color: #555;">' . $random . '</p>
        </div>
        <div style="margin-bottom: 15px;">
            <strong>投诉原因:</strong>
            <p style="margin: 5px 0 0; color: #555;">' . $b . '</p>
        </div>
        <div style="margin-bottom: 15px;">
            <strong>投诉人号码:</strong>
            <p style="margin: 5px 0 0; color: #555;">' . $phone . '</p>
        </div>
        <div style="margin-bottom: 15px;">
            <strong>投诉人ip:</strong>
            <p style="margin: 5px 0 0; color: #555;">' . $user_ip.$province.$city.$isp . '</p>
        </div>
        <div style="margin-bottom: 15px;">
            <strong>投诉内容:</strong>
            <p style="margin: 5px 0 0; color: #555;">' . $content . '</p>
        </div>
        <div style="margin-bottom: 15px;">
            <strong>图片证据:</strong>
            <div style=" gap: 10px; margin-top: 10px;">' . $picss . '</div>
        </div>
        <div style="margin-bottom: 15px;">
            <strong>投诉时间:</strong>
            <p style="margin: 5px 0 0; color: #555;">' . date('Y-m-d H:i:s') . '</p>
        </div>
        <div style="margin-bottom: 15px;">
            <strong>投诉分享链接(长按复制):</strong>
            <p style="margin: 5px 0 0; color: #555;">' .$filename1 . '</p>
        </div>
    </div>';

// 构建完整的 HTML 内容
$fullHtmlContent = '<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>投诉详情</title>
</head>
<body>
' . $bb . '
</body>
</html>';

// 保存文件
if (!is_dir('./jl')) {
    mkdir('./jl', 0777, true); // 如果目录不存在，则创建目录
}
file_put_contents($filename, $fullHtmlContent); // 将内容写入文件

$robotKey = $toukey; // 从配置中获取
$messageData = [
    'title'       => "您有新的投诉",
    'description' => "员工号:".$random." 投诉类别:".$b,
    'url'         => $filename1,
    'picurl'      => $webdemo."img/logo1.png"
];

// 3. 调用发送函数
$result = sendQywxNews(
    $robotKey,
    $messageData['title'],
    $messageData['description'],
    $messageData['url'],
    $messageData['picurl']
);

$mm=$result['message'];
// 4. 处理返回结果
if ($result['error']) {
    // 记录日志或发送警报
  //  echo ("企业微信发送失败 [{$result['code']}]: {$result['message']}");
    //echo "消息发送失败，请联系管理员";
    echo json_encode([
        'status' => 0,
        'msg' => $mm
    ], JSON_UNESCAPED_UNICODE);
} else {
    // 成功后续操作
    echo json_encode([
        'status' => 1,
        'msg' => $mm
    ], JSON_UNESCAPED_UNICODE);
   // echo "状态报告已成功发送至企业微信！";
}

}

} else {
    //echo "未找到对应的密钥";
    echo json_encode([
        'status' => 0,
        'msg' => '用户未授权'
    ], JSON_UNESCAPED_UNICODE);
}

$stmt->close();
$conn->close();

?>
