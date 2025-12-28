<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost:8000/articles/lich-su-phat-trien-cua-luc-quan-viet-nam/comments');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    '_token' => 'test',
    'content' => 'Test comment from API'
]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Cookie: laravel_session=test; XSRF-TOKEN=test'
]);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
echo 'HTTP Code: ' . $httpCode . PHP_EOL;
echo 'Response: ' . $response . PHP_EOL;
?>





