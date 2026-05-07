<?php
// 引入数据库连接文件
require_once 'db.php';
header('Content-Type: application/json; charset=utf-8');
// 设置上传目录
$uploadDir = 'upload/';

// 定义允许上传的图片格式
$allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

// 检查文件是否上传成功
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];

    // 检查文件是否有上传错误
    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo json_encode([
            'status' => 0,
            'msg' => '文件上传失败',
        ]);
        exit;
    }

    // 获取文件的 MIME 类型
    $fileMimeType = mime_content_type($file['tmp_name']);
    
    // 获取文件扩展名
    $fileInfo = pathinfo($file['name']);
    $fileExtension = strtolower($fileInfo['extension']);

    // 检查 MIME 类型和扩展名是否允许
    if (!in_array($fileMimeType, $allowedMimeTypes) || !in_array($fileExtension, $allowedExtensions)) {
        echo json_encode([
            'status' => 0,
            'msg' => '只允许上传图片文件',
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // 生成新的文件名，按时间戳加上4位随机数
    $timestamp = date('Y-m-d-H-i-s');
    $randomNumber = rand(1000, 9999); // 生成4位随机数
    $newFileName = $timestamp . '-' . $randomNumber . '.' . $fileExtension; // 组合文件名
    $uploadPath = $uploadDir . $newFileName;

    // 移动文件到目标目录
    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
        // 返回上传成功的响应
        echo json_encode([
            'status' => 1,
            'msg' => '上传成功',
            'url' => $webdemo . $uploadPath, // 返回相对路径
        ], JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode([
            'status' => 0,
            'msg' => '文件移动失败',
        ], JSON_UNESCAPED_UNICODE);
    }
} else {
    echo json_encode([
        'status' => 0,
        'msg' => '没有上传文件',
    ], JSON_UNESCAPED_UNICODE);
}
?>
