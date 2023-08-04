<?php
$host = 'localhost';
$username = 'root';
$password = 'alstkd9031';
$database = 'realMSDB';

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("MySQL 연결에 실패했습니다: " . mysqli_connect_error());
}

// 연결에 대한 추가 설정 (선택 사항)
mysqli_set_charset($conn, 'utf8'); // 문자 인코딩 설정 등

// 필요한 경우 다른 초기화 또는 설정 수행

?>
