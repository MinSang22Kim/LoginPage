<?php
$host = "localhost"; // 호스트명
$user = "root"; // MySQL 사용자명
$password = "alstkd9031"; // MySQL 비밀번호
$dbName = "realMSDB"; // 사용할 데이터베이스명

// MySQL 데이터베이스에 접속
$connect = mysqli_connect("localhost", "root", "alstkd9031", "realMSDB");

// 접속 오류 확인
if (mysqli_connect_errno()) {
    echo "MySQL 데이터베이스 연결 실패: " . mysqli_connect_error();
    exit();
}

// 데이터베이스 연결 성공

// 필요한 기타 함수 정의 등?

?>
