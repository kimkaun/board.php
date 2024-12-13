<?php
// 디비 접속
include('./db_conn.php');

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 회원가입 처리
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userid = trim($_POST['userid']); // 공백 제거
    $passwd = trim($_POST['passwd']); // 공백 제거
    $repasswd = trim($_POST['repasswd']); // 공백 제거

    // 비밀번호 일치 여부 확인
    if ($passwd !== $repasswd) {
        echo "'<script>alert('비밀번호가 일치하지 않습니다! 다시 입력하세요!');</script>'<meta http-equiv='refresh' content='0;URL=boardJoin.html'>";
        exit;
    }

    // SQL 쿼리 준비
    $sql = "INSERT INTO boardlogin (userid, passwd) VALUES ('$userid', '$passwd')";

    // 쿼리 실행
    if ($conn->query($sql) === TRUE) {
        echo "'<script>alert('회원가입 성공!');</script>'<meta http-equiv='refresh' content='0;URL=boardlogin.html'>";
    } else {
        echo "'<script>alert('회원가입 실패...');</script>'<meta http-equiv='refresh' content='0;URL=boardJoin.html'>"; 
    }
}

$conn->close();
?>
