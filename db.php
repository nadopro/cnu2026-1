<?php
function connectDB() {
    // DB 접속 정보
    $dbhost = "localhost";
    $dbuser = "cnu";
    $dbpass = "1111";
    $dbname = "cnu";

    // mysqli() 함수로 연결
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    // 연결 실패 체크
    if (!$conn) {
        die("DB 연결 실패: " . mysqli_connect_error());
    }

    // 문자셋 설정
    mysqli_set_charset($conn, "utf8");

    return $conn;
}
?>