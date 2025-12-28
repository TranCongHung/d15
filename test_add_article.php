<?php
// Test API thêm bài viết từ giao diện
$data = [
    'title' => 'Bài viết test từ giao diện admin',
    'category_id' => 1,
    'body' => 'Đây là nội dung chi tiết của bài viết test từ giao diện admin. Bài viết này được tạo để kiểm tra đầy đủ chức năng thêm bài viết mới trong hệ thống quản trị.

Chức năng này bao gồm:
1. Form nhập liệu với validation phía client
2. Gửi dữ liệu qua AJAX đến API backend
3. Lưu trữ vào cơ sở dữ liệu MySQL
4. Tự động tạo slug và excerpt nếu cần thiết
5. Hiển thị trạng thái loading trong quá trình lưu

Đây là một bài viết mẫu để test tính năng hoàn chỉnh của hệ thống quản lý bài viết trong ứng dụng Laravel.',
    'excerpt' => 'Đây là tóm tắt của bài viết test từ giao diện admin, được tạo tự động để kiểm tra chức năng thêm bài viết hoàn chỉnh.'
];

$ch = curl_init('http://127.0.0.1:8000/admin/articles');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: $httpCode\n";
echo "Response: $response\n";
?>
