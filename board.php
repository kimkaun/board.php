<?php
session_start(); // 세션 시작

// 로그인 여부 확인
if (!isset($_SESSION['userid'])) {
    echo "<script>alert('로그인 후 이용해주세요.');</script>";
    echo "<meta http-equiv='refresh' content='0;URL=boardlogin.html'>"; // 로그인 페이지로 리다이렉트
    exit;
}

include('./db_conn.php');

// 사용자가 입력한 값 가져오기 ($_POST)
$name = $_POST['name'];
$title = $_POST['title'];
$grade = $_POST['grade'];
$password = $_POST['password']; // 사용자가 입력한 비밀번호
$content = $_POST['content'];

// 비밀번호 확인 (로그인한 비밀번호와 일치하는지)
if ($password !== $_SESSION['password']) {
    echo "<script>alert('비밀번호가 틀렸습니다.');</script>";
    echo "<meta http-equiv='refresh' content='0;URL=board.php'>"; // 게시글 작성 페이지로 돌아가기
    exit;
}

// 휴대폰 값 검증
$valid_phones = ['SKT', 'KTF', 'LGU+']; // 유효한 값 목록
$phone = $_POST['phone'] ?? ''; // POST 데이터에서 phone 값 가져오기
if (!in_array($phone, $valid_phones)) {
    echo "<script>alert('올바른 휴대폰 값을 선택하세요.');</script>";
    echo "<meta http-equiv='refresh' content='0;URL=board.php'>"; // 게시글 작성 페이지로 돌아가기
    exit;
}

// 파일 처리
$file_name = '';
if (isset($_FILES['file']) && $_FILES['file']['error'] === 0) {
    $file_name = $_FILES['file']['name']; // 파일 이름
    $upload_dir = "uploads/";
    $upload_path = $upload_dir . $file_name;

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    if (!move_uploaded_file($_FILES['file']['tmp_name'], $upload_path)) {
        echo "<script>alert('파일 업로드에 실패했습니다.');</script>";
        echo "<meta http-equiv='refresh' content='0;URL=board.php'>"; // 게시글 작성 페이지로 돌아가기
        exit;
    }
}

// 날짜 자동입력
$now_date = date('Y-m-d'); // 작성 날짜

// SQL 쿼리 작성 (게시물 작성)
$sql = "INSERT INTO board (name, title, grade, phone, content, password, file_name, created_at)
        VALUES ('$name', '$title', '$grade', '$phone', '$content', '$password', '$file_name', '$now_date')";

// 쿼리 실행
if (mysqli_query($conn, $sql)) {
    echo "<script>alert('게시물이 작성되었습니다.');</script>";
} else {
    echo "오류: " . mysqli_error($conn);
}

// 데이터베이스 연결 종료
mysqli_close($conn);
?>
<meta http-equiv='refresh' content='0;URL=boardindex.php'>
