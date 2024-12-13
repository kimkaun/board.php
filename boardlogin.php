<?php
// 디비 접속
include('./db_conn.php');

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 로그인 처리
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userid = $_POST['userid'];
    $passwd = $_POST['passwd'];

    // 비밀번호 확인 및 쿼리 실행
    if (!empty($userid) && !empty($passwd)) {
        $sql = "SELECT * FROM boardlogin WHERE userid = '$userid' AND passwd = '$passwd'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // 로그인 성공, 세션 시작 및 사용자 정보 저장
            session_start(); // 세션 시작
            $_SESSION['userid'] = $userid; // 세션에 사용자 ID 저장
            $_SESSION['password'] = $passwd; // 세션에 비밀번호 저장
            echo "<script>alert('로그인 성공!');</script>";
            echo "<meta http-equiv='refresh' content='0;URL=board.html'>"; // 로그인 후 이동할 페이지
        } else {
            // 로그인 실패
            echo "<script>alert('로그인 실패...');</script>";
            echo "<meta http-equiv='refresh' content='0;URL=boardlogin.html'>"; // 로그인 페이지로 돌아가기
        }
    }
}

$conn->close();
?>
